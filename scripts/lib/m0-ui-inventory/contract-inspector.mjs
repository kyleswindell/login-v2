/**
 * ============================================================================
 * File: scripts/lib/m0-ui-inventory/contract-inspector.mjs
 * Purpose: Inspect UI contract and Blade APIs without executing repository PHP.
 * ============================================================================
 */

import { basename } from "node:path";
import { arrayDifference, normalizePath, uniqueSorted } from "./utilities.mjs";

export function isContractSource(path, content = "") {
    const filename = basename(path);

    return (
        filename === "contract.php" ||
        filename === "contract.blade.php" ||
        /Surface::(?:component|element|pattern)\s*\(/.test(content) ||
        /['"]schema_version['"]\s*=>/.test(content)
    );
}

export function inspectContract(file) {
    const content = file.content ?? "";
    const filename = basename(file.path);
    const profile = firstMatch(
        content,
        /Surface::(component|element|pattern)\s*\(/,
    );
    const apiSection = extractArraySection(content, "api") ?? "";
    const subcomponentsSection =
        extractArraySection(content, "subcomponents") ?? "";
    const propsSection = extractArraySection(apiSection, "props");
    const slotsSection = extractArraySection(apiSection, "slots");
    const eventsSection = extractArraySection(apiSection, "events");
    const dataAttributesSection = extractArraySection(
        apiSection,
        "data_attributes",
    );
    const subcomponentProps = extractArraySections(
        subcomponentsSection,
        "props",
    ).flatMap(extractNamedEntries);
    const subcomponentSlots = extractArraySections(
        subcomponentsSection,
        "slots",
    ).flatMap(extractNamedEntries);

    return {
        path: file.path,
        object_sha: file.object_sha,
        source_sha256: file.source_sha256,
        filename,
        filename_variation: filename !== "contract.php",
        profile: profile ?? "raw_array_or_unknown",
        schema_version: numberMatch(
            content,
            /['"]schema_version['"]\s*=>\s*(\d+)/,
        ),
        identity: {
            slug: stringValue(content, "slug"),
            label: stringValue(content, "label"),
            component: stringValue(content, "component"),
            type: stringValue(content, "type"),
            group: stringValue(content, "group"),
            ui_key:
                stringValue(content, "ui_key") ??
                stringValue(content, "component_key") ??
                stringValue(content, "pattern_key") ??
                stringValue(content, "layout_key") ??
                stringValue(content, "contract_key"),
        },
        lifecycle_status: stringValue(
            extractArraySection(content, "lifecycle") ?? "",
            "status",
        ),
        api: {
            props: uniqueSorted([
                ...extractNamedEntries(propsSection),
                ...subcomponentProps,
            ]),
            slots: uniqueSorted([
                ...extractNamedEntries(slotsSection),
                ...subcomponentSlots,
            ]),
            events: extractNamedEntries(eventsSection),
            data_attributes: extractNamedEntries(dataAttributesSection),
        },
        subcomponents: uniqueSorted(
            [
                ...subcomponentsSection.matchAll(
                    /["']component["']\s*=>\s*["']([^"']+)["']/g,
                ),
            ].map((match) => match[1]),
        ),
        source_paths: extractRepositoryPaths(content),
        has_testing_section: /['"]testing['"]\s*=>/.test(content),
        has_review_section: /['"]review['"]\s*=>/.test(content),
        metadata: inspectMetadata(file.path, content, file.source_sha256),
        parse_status: content === "" ? "unavailable" : "partial_static_parse",
    };
}

export function inspectBladeApi(files) {
    const props = [];
    const slots = [];
    const events = [];
    const dataAttributes = [];

    for (const file of files) {
        const content = file.content ?? "";
        const propsBody = extractDirectiveBody(content, "@props");

        if (propsBody !== null) {
            props.push(...extractBladePropNames(propsBody));
        }

        if (basename(file.path) === "props.php") {
            props.push(...extractArrayKeys(content));
        }

        for (const match of content.matchAll(/\$([A-Za-z][A-Za-z0-9_]*)\b/g)) {
            if (match[1].endsWith("Slot")) {
                slots.push(match[1]);
            }
        }

        for (const match of content.matchAll(
            /dispatchEvent\s*\(\s*new\s+CustomEvent\s*\(\s*['"]([^'"]+)['"]/g,
        )) {
            events.push(match[1]);
        }

        for (const match of content.matchAll(/\b(data-[a-z0-9:_-]+)\b/gi)) {
            dataAttributes.push(match[1]);
        }
    }

    return {
        props: uniqueSorted(props),
        slots: uniqueSorted(slots),
        events: uniqueSorted(events),
        data_attributes: uniqueSorted(dataAttributes),
    };
}

export function compareApis(implementationApi, contracts) {
    if (contracts.length === 0) {
        return {
            implementation_only_props: implementationApi.props,
            contract_only_props: [],
            shared_props: [],
        };
    }

    const contractProps = uniqueSorted(
        contracts.flatMap((contract) => contract.api.props),
    );

    return {
        implementation_only_props: arrayDifference(
            implementationApi.props,
            contractProps,
        ),
        contract_only_props: arrayDifference(
            contractProps,
            implementationApi.props,
        ),
        shared_props: implementationApi.props.filter((prop) =>
            contractProps.includes(prop),
        ),
    };
}

export function inspectMetadata(path, content, sourceHash) {
    const headerPresent =
        /\bFile:\s*[^\r\n]+/i.test(content) &&
        /\bPurpose:\s*[^\r\n]+/i.test(content);

    return {
        implementation_or_contract_path: normalizePath(path),
        human_readable_header: {
            status: headerPresent ? "present" : "absent",
            value: headerPresent
                ? firstMatch(content, /\bFile:\s*([^\r\n]+)/i)
                : null,
            format: headerPresent ? "File/Purpose header" : null,
            disagreement: null,
            evidence_source: [`path:${normalizePath(path)}`],
        },
        ui_key: metadataValue(content, [
            "ui_key",
            "component_key",
            "pattern_key",
            "layout_key",
            "contract_key",
        ]),
        blade_alias: metadataValue(content, ["blade_alias", "component"]),
        implementation_path_reference: pathReferenceValue(
            content,
            /resources\/views\/[A-Za-z0-9_./-]+\.blade\.php/g,
        ),
        contract_path_reference: pathReferenceValue(
            content,
            /resources\/views\/[A-Za-z0-9_./-]+\/contract(?:\.blade)?\.php/g,
        ),
        contract_schema_version: metadataNumber(content, "schema_version"),
        public_api_version: metadataValue(content, [
            "public_api_version",
            "api_version",
        ]),
        verification_commit: regexMetadata(
            content,
            /(?:verification_commit|verified_commit)['"\s=>:]+([0-9a-f]{40})/i,
        ),
        verification_timestamp: regexMetadata(
            content,
            /(?:verification_timestamp|verified_at)['"\s=>:]+([0-9T:+.-]{10,35}Z?)/i,
        ),
        source_hash: {
            status: sourceHash === null ? "unknown" : "present",
            value: sourceHash,
            format: sourceHash === null ? null : "sha256",
            disagreement: null,
            evidence_source: [`path:${normalizePath(path)}`],
        },
        contract_hash: {
            status:
                basename(path).startsWith("contract") && sourceHash !== null
                    ? "present"
                    : "not_applicable",
            value: basename(path).startsWith("contract") ? sourceHash : null,
            format: basename(path).startsWith("contract") ? "sha256" : null,
            disagreement: null,
            evidence_source: [`path:${normalizePath(path)}`],
        },
        last_updated: metadataValue(content, ["last_updated", "last_reviewed"]),
        known_disagreements: [],
        evidence_source: [`path:${normalizePath(path)}`],
    };
}

function extractArraySection(content, key) {
    return extractArraySections(content, key)[0] ?? null;
}

function extractArraySections(content, key) {
    const sections = [];
    const pattern = new RegExp(`["']${escapeRegex(key)}["']\\s*=>\\s*\\[`, "g");
    let match;

    while ((match = pattern.exec(content)) !== null) {
        const section = extractArrayAt(
            content,
            content.indexOf("[", match.index),
        );

        if (section !== null) {
            sections.push(section);
            pattern.lastIndex = match.index + section.length;
        }
    }

    return sections;
}

function extractArrayAt(content, start) {
    if (start < 0) {
        return null;
    }

    let depth = 0;
    let quote = null;
    let escaped = false;

    for (let index = start; index < content.length; index += 1) {
        const character = content[index];

        if (quote !== null) {
            if (escaped) {
                escaped = false;
            } else if (character === "\\") {
                escaped = true;
            } else if (character === quote) {
                quote = null;
            }
            continue;
        }

        if (character === "'" || character === '"') {
            quote = character;
            continue;
        }

        if (character === "[") {
            depth += 1;
        } else if (character === "]") {
            depth -= 1;

            if (depth === 0) {
                return content.slice(start, index + 1);
            }
        }
    }

    return content.slice(start);
}

function extractNamedEntries(section) {
    if (section === null) {
        return [];
    }

    const names = [];

    for (const match of section.matchAll(
        /["']name["']\s*=>\s*["']([^"']+)["']/g,
    )) {
        names.push(match[1]);
    }

    if (names.length === 0) {
        for (const match of section.matchAll(
            /["']([A-Za-z][A-Za-z0-9_:-]*)["']\s*=>/g,
        )) {
            names.push(match[1]);
        }
    }

    if (names.length === 0) {
        const open = section.indexOf("[");
        const close = section.lastIndexOf("]");
        const body =
            open >= 0 && close > open
                ? section.slice(open + 1, close)
                : section;

        for (const entry of splitTopLevelEntries(body)) {
            const match = entry.match(
                /^\s*["']([A-Za-z][A-Za-z0-9_:-]*)["']\s*$/,
            );

            if (match !== null) {
                names.push(match[1]);
            }
        }
    }

    return uniqueSorted(names);
}

function extractDirectiveBody(content, directive) {
    const index = content.indexOf(directive);

    if (index < 0) {
        return null;
    }

    const open = content.indexOf("(", index + directive.length);

    if (open < 0) {
        return null;
    }

    let depth = 0;

    for (let cursor = open; cursor < content.length; cursor += 1) {
        if (content[cursor] === "(") {
            depth += 1;
        } else if (content[cursor] === ")") {
            depth -= 1;

            if (depth === 0) {
                return content.slice(open + 1, cursor);
            }
        }
    }

    return null;
}

function extractBladePropNames(body) {
    const names = [];
    const open = body.indexOf("[");
    const close = body.lastIndexOf("]");
    const arrayBody =
        open >= 0 && close > open ? body.slice(open + 1, close) : body;

    for (const entry of splitTopLevelEntries(arrayBody)) {
        const match = entry.match(
            /^\s*["']([A-Za-z][A-Za-z0-9_]*)["']\s*(?:=>[\s\S]*)?$/,
        );

        if (match !== null) {
            names.push(match[1]);
        }
    }

    return uniqueSorted(names);
}

function splitTopLevelEntries(value) {
    const entries = [];
    let start = 0;
    let depth = 0;
    let quote = null;
    let escaped = false;

    for (let index = 0; index < value.length; index += 1) {
        const character = value[index];

        if (quote !== null) {
            if (escaped) {
                escaped = false;
            } else if (character === "\\") {
                escaped = true;
            } else if (character === quote) {
                quote = null;
            }

            continue;
        }

        if (character === '"' || character === "'") {
            quote = character;
        } else if (["[", "(", "{"].includes(character)) {
            depth += 1;
        } else if (["]", ")", "}"].includes(character)) {
            depth -= 1;
        } else if (character === "," && depth === 0) {
            entries.push(value.slice(start, index));
            start = index + 1;
        }
    }

    entries.push(value.slice(start));
    return entries.filter((entry) => entry.trim() !== "");
}

function extractArrayKeys(content) {
    const names = [];

    for (const match of content.matchAll(
        /["']([A-Za-z][A-Za-z0-9_]*)["']\s*=>/g,
    )) {
        names.push(match[1]);
    }

    return uniqueSorted(names);
}

function extractRepositoryPaths(content) {
    const paths = [];

    for (const match of content.matchAll(
        /(?:app|Modules|resources|routes|config|docs|tests)\/[A-Za-z0-9_ .@/()-]+\.[A-Za-z0-9.]+/g,
    )) {
        paths.push(normalizePath(match[0].trim()));
    }

    return uniqueSorted(paths);
}

function metadataValue(content, keys) {
    for (const key of keys) {
        const value = stringValue(content, key);

        if (value !== null) {
            return {
                status: "present",
                value,
                format: "string",
                disagreement: null,
                evidence_source: [],
            };
        }
    }

    return {
        status: "absent",
        value: null,
        format: null,
        disagreement: null,
        evidence_source: [],
    };
}

function metadataNumber(content, key) {
    const value = numberMatch(
        content,
        new RegExp(`["']${escapeRegex(key)}["']\\s*=>\\s*(\\d+)`),
    );

    return {
        status: value === null ? "absent" : "present",
        value,
        format: value === null ? null : "integer",
        disagreement: null,
        evidence_source: [],
    };
}

function regexMetadata(content, pattern) {
    const value = firstMatch(content, pattern);

    return {
        status: value === null ? "absent" : "present",
        value,
        format: value === null ? null : "string",
        disagreement: null,
        evidence_source: [],
    };
}

function pathReferenceValue(content, pattern) {
    const values = uniqueSorted(
        [...content.matchAll(pattern)].map((match) => match[0]),
    );

    return {
        status: values.length === 0 ? "absent" : "present",
        value: values,
        format: values.length === 0 ? null : "repository_path_list",
        disagreement: null,
        evidence_source: [],
    };
}

function stringValue(content, key) {
    const pattern = new RegExp(
        `["']${escapeRegex(key)}["']\\s*=>\\s*["']([^"']*)["']`,
    );
    return firstMatch(content, pattern);
}

function firstMatch(content, pattern) {
    const match = pattern.exec(content);
    return match?.[1] ?? null;
}

function numberMatch(content, pattern) {
    const value = firstMatch(content, pattern);
    return value === null ? null : Number(value);
}

function escapeRegex(value) {
    return value.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
}
