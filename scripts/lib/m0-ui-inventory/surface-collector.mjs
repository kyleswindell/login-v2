/**
 * ============================================================================
 * File: scripts/lib/m0-ui-inventory/surface-collector.mjs
 * Purpose: Group pinned UI source into material issue #30 surface observations.
 * ============================================================================
 */

import { basename, dirname } from "node:path";
import {
    compareApis,
    inspectBladeApi,
    inspectContract,
    inspectMetadata,
    isContractSource,
} from "./contract-inspector.mjs";
import {
    compilePatterns,
    makeRecordId,
    matchesAny,
    sourceFingerprint,
    uniqueSorted,
} from "./utilities.mjs";

const REUSABLE_TYPES = new Set([
    "element",
    "primitive",
    "component",
    "component_family",
    "subcomponent",
    "pattern",
    "layout",
    "shell",
    "navigation",
    "icon_system",
    "pictogram_system",
]);

const GENERIC_TEST_IDENTIFIERS = new Set([
    "index",
    "main",
    "page",
    "show",
    "edit",
    "create",
    "delete",
    "view",
    "form",
    "item",
    "list",
    "data",
    "root",
    "app",
    "debounce",
    "delay",
    "match",
    "matches",
    "throttle",
    "warning",
]);

export function collectMaterialSurfaces({ files, discovery, config }) {
    const fileByPath = new Map(files.map((file) => [file.path, file]));
    const surfaces = [];
    const claimedFiles = new Set();

    collectAssetSystems({ files, config, surfaces, claimedFiles });
    collectElementSurfaces({ files, fileByPath, surfaces, claimedFiles });
    collectComponentSurfaces({ files, surfaces, claimedFiles });
    collectUrlViews({ files, discovery, surfaces, claimedFiles });
    collectPresentationClasses({ files, surfaces, claimedFiles });
    collectUiContributions({ files, discovery, surfaces, claimedFiles });
    collectJavascriptControls({ files, surfaces, claimedFiles });
    collectCssControls({ files, config, surfaces, claimedFiles });
    collectResidualAssetGroups({ files, surfaces, claimedFiles });

    const enriched = surfaces.map((surface) =>
        enrichSurface(surface, files, fileByPath),
    );
    const referencedPaths = new Set(claimedFiles);

    for (const surface of enriched) {
        for (const path of materialPathsForSurface(surface)) {
            referencedPaths.add(path);
        }
    }

    return {
        surfaces: enriched.sort((left, right) =>
            left.record_id.localeCompare(right.record_id),
        ),
        unclaimed_material_files: files
            .filter(isPotentialMaterialFile)
            .filter((file) => !referencedPaths.has(file.path))
            .map((file) => file.path)
            .sort(),
    };
}

function collectAssetSystems({ files, config, surfaces, claimedFiles }) {
    for (const [key, patterns] of Object.entries(config.asset_group_patterns)) {
        const compiled = compilePatterns(patterns);
        const members = files.filter((file) => matchesAny(file.path, compiled));

        if (members.length === 0) {
            continue;
        }

        for (const member of members) {
            claimedFiles.add(member.path);
        }

        const contracts = members
            .filter((file) => isContractSource(file.path, file.content ?? ""))
            .map(inspectContract);
        const materialSupport = members.filter(
            (file) =>
                isContractSource(file.path, file.content ?? "") ||
                file.path.includes("/__tests__/") ||
                file.path.endsWith("/reference.php") ||
                file.path.endsWith("/index.blade.php") ||
                file.path.endsWith("/icon-list.txt") ||
                file.path.endsWith("/pictogram-list.txt"),
        );
        const implementationCandidates = members.filter(
            (file) =>
                !isContractSource(file.path, file.content ?? "") &&
                !file.path.includes("/__tests__/") &&
                !file.path.endsWith("/reference.php") &&
                !file.path.endsWith("/AGENTS.md") &&
                !file.path.endsWith(".svg"),
        );
        const type = key === "icons" ? "icon_system" : "pictogram_system";
        const memberPaths = members.map((file) => file.path).sort();

        surfaces.push(
            createBaseSurface({
                surfaceType: type,
                identity: `${key}-system`,
                currentSlug: key,
                declaredUiKey: contracts[0]?.identity.ui_key ?? null,
                bladeAliases: uniqueSorted(
                    implementationCandidates
                        .filter((file) => file.path.endsWith(".blade.php"))
                        .map((file) => deriveBladeAlias(file.path)),
                ),
                implementationEntry:
                    selectNonContractImplementation(implementationCandidates)
                        ?.path ?? "unknown",
                supportFiles: materialSupport.map((file) => file.path),
                contracts,
                ownershipCandidate: uiOwnership(),
                registrationEvidence: [
                    {
                        state: "grouped_present",
                        claim: `${members.length} ${key} source members exist at the pinned baseline.`,
                        evidence_source: patterns.map(
                            (pattern) => `path-pattern:${pattern}`,
                        ),
                    },
                ],
                assetGroupSummary: {
                    roots: patterns,
                    member_count: members.length,
                    svg_count: members.filter((file) =>
                        file.path.endsWith(".svg"),
                    ).length,
                    member_path_sha256: sourceFingerprint(memberPaths),
                    sample_paths: memberPaths.slice(0, 20),
                },
                evidenceSource: uniqueSorted([
                    ...contracts.map((contract) => `path:${contract.path}`),
                    ...patterns.map((pattern) => `path-pattern:${pattern}`),
                ]),
            }),
        );
    }
}

function collectElementSurfaces({ files, fileByPath, surfaces, claimedFiles }) {
    const roots = new Map();

    for (const file of files) {
        const match = file.path.match(/^resources\/views\/elements\/([^/]+)\//);

        if (
            match === null ||
            ["icons", "pictograms", "__tests__"].includes(match[1])
        ) {
            continue;
        }

        const root = `resources/views/elements/${match[1]}`;
        const rootFiles = roots.get(root) ?? [];
        rootFiles.push(file);
        roots.set(root, rootFiles);
    }

    for (const [root, rootFiles] of roots) {
        rootFiles.forEach((file) => claimedFiles.add(file.path));
        const contracts = rootFiles
            .filter((file) => isContractSource(file.path, file.content ?? ""))
            .map(inspectContract);
        const externalSources = uniqueSorted(
            contracts.flatMap((contract) => contract.source_paths),
        )
            .map((path) => fileByPath.get(path))
            .filter(Boolean);
        externalSources.forEach((file) => claimedFiles.add(file.path));
        const implementationCandidates = [
            ...rootFiles,
            ...externalSources,
        ].filter(
            (file) =>
                !isContractSource(file.path, file.content ?? "") &&
                !file.path.includes("/__tests__/") &&
                !file.path.includes("/examples/") &&
                !file.path.endsWith("/reference.php") &&
                !file.path.endsWith("/AGENTS.md"),
        );
        const slug = root.split("/").at(-1);

        surfaces.push(
            createBaseSurface({
                surfaceType: "element",
                identity: root,
                currentSlug: contracts[0]?.identity.slug ?? slug,
                declaredUiKey: contracts[0]?.identity.ui_key ?? null,
                bladeAliases: uniqueSorted(
                    implementationCandidates
                        .filter((file) => file.path.endsWith(".blade.php"))
                        .map((file) => deriveBladeAlias(file.path)),
                ),
                implementationEntry:
                    selectNonContractImplementation(implementationCandidates)
                        ?.path ?? "unknown",
                supportFiles: uniqueSorted([
                    ...rootFiles.map((file) => file.path),
                    ...externalSources.map((file) => file.path),
                ]),
                contracts,
                ownershipCandidate: uiOwnership(),
                evidenceSource: compactEvidenceSources(rootFiles, contracts),
            }),
        );
    }
}

function collectComponentSurfaces({ files, surfaces, claimedFiles }) {
    const componentFiles = files.filter((file) =>
        file.path.startsWith("resources/views/components/"),
    );
    const explicitAnchors = new Set();
    const bladeCountByDirectory = new Map();

    for (const file of componentFiles) {
        if (
            file.path.startsWith("resources/views/components/icons/") ||
            file.path.startsWith("resources/views/components/pictograms/") ||
            file.path.endsWith("/AGENTS.md")
        ) {
            continue;
        }

        const directory = dirname(file.path);
        const filename = basename(file.path);

        if (file.path.endsWith(".blade.php")) {
            bladeCountByDirectory.set(
                directory,
                (bladeCountByDirectory.get(directory) ?? 0) + 1,
            );
        }

        if (
            [
                "index.blade.php",
                "contract.php",
                "contract.blade.php",
                "props.php",
                "options.php",
                "view-model.php",
                "reference.php",
            ].includes(filename)
        ) {
            explicitAnchors.add(directory);
        }
    }

    const anchors = new Set(explicitAnchors);

    for (const [directory, count] of bladeCountByDirectory) {
        const categoryRoot = /^resources\/views\/components\/[^/]+$/.test(
            directory,
        );
        const explicitAncestor = [...explicitAnchors].some((anchor) =>
            directory.startsWith(`${anchor}/`),
        );

        if (count >= 2 && !categoryRoot && !explicitAncestor) {
            anchors.add(directory);
        }
    }

    const filesByAnchor = new Map(
        [...anchors].map((directory) => [directory, []]),
    );
    const standaloneBladeFiles = [];

    for (const file of componentFiles) {
        if (
            file.path.startsWith("resources/views/components/icons/") ||
            file.path.startsWith("resources/views/components/pictograms/") ||
            file.path.endsWith("/AGENTS.md")
        ) {
            continue;
        }

        const owner = [...anchors]
            .filter((directory) => file.path.startsWith(`${directory}/`))
            .sort((left, right) => right.length - left.length)[0];

        if (owner) {
            filesByAnchor.get(owner).push(file);
        } else if (file.path.endsWith(".blade.php")) {
            standaloneBladeFiles.push(file);
        }
    }

    for (const [root, rootFiles] of filesByAnchor) {
        if (rootFiles.length === 0) {
            continue;
        }

        rootFiles.forEach((file) => claimedFiles.add(file.path));
        const contracts = rootFiles
            .filter((file) => isContractSource(file.path, file.content ?? ""))
            .map(inspectContract);
        const category = root.split("/")[3] ?? "ui";
        const surfaceType = componentSurfaceType(root, rootFiles, category);
        const relativeRoot = root.replace("resources/views/components/", "");
        const implementationEntry = selectComponentEntry(rootFiles, contracts);

        surfaces.push(
            createBaseSurface({
                surfaceType,
                identity: root,
                currentSlug:
                    contracts[0]?.identity.slug ??
                    relativeRoot.replaceAll("/", "-"),
                declaredUiKey: contracts[0]?.identity.ui_key ?? null,
                bladeAliases: aliasesForComponentRoot(
                    root,
                    rootFiles,
                    implementationEntry,
                ),
                implementationEntry,
                supportFiles: rootFiles.map((file) => file.path),
                contracts,
                ownershipCandidate: uiOwnership(),
                evidenceSource: compactEvidenceSources(rootFiles, contracts),
            }),
        );
    }

    for (const file of standaloneBladeFiles) {
        claimedFiles.add(file.path);
        const category = file.path.split("/")[3] ?? "ui";
        const type =
            category === "layouts"
                ? "layout"
                : category === "shell"
                  ? "shell"
                  : category === "patterns"
                    ? "pattern"
                    : "subcomponent";

        surfaces.push(
            createBaseSurface({
                surfaceType: type,
                identity: file.path,
                currentSlug: basename(file.path, ".blade.php"),
                declaredUiKey: null,
                bladeAliases: [deriveBladeAlias(file.path)],
                implementationEntry: file.path,
                supportFiles: [file.path],
                contracts: [],
                ownershipCandidate: uiOwnership(),
                evidenceSource: [`path:${file.path}`],
            }),
        );
    }
}

function collectUrlViews({ files, discovery, surfaces, claimedFiles }) {
    const viewFiles = files.filter(
        (file) =>
            file.path.endsWith(".blade.php") &&
            (file.path.startsWith("resources/views/platform/") ||
                /^Modules\/[^/]+\/resources\/views\//.test(file.path)),
    );
    const moduleTypeByKey = moduleTypes(discovery);

    for (const file of viewFiles) {
        if (isSupportView(file.path)) {
            continue;
        }

        claimedFiles.add(file.path);
        const supportPrefix = dirname(file.path);
        const supportFiles = viewFiles
            .filter(
                (candidate) =>
                    candidate.path !== file.path &&
                    candidate.path.startsWith(`${supportPrefix}/`) &&
                    isSupportView(candidate.path),
            )
            .map((candidate) => candidate.path);
        supportFiles.forEach((path) => claimedFiles.add(path));
        const moduleMatch = file.path.match(/^Modules\/([^/]+)\//);
        const moduleKey = moduleMatch ? snakeCase(moduleMatch[1]) : null;
        const ownership = moduleMatch
            ? ownershipForModuleView(
                  moduleKey,
                  moduleTypeByKey.get(moduleKey) ?? null,
              )
            : {
                  ownership_area: "core",
                  owner_key: inferPlatformOwner(file.path),
                  capability_key: inferPlatformOwner(file.path),
                  module_key: "not_applicable",
                  evidence: ["path-owned Core presentation candidate"],
              };
        const contributionLike = /\/header\/|\/runtime\//.test(file.path);

        surfaces.push(
            createBaseSurface({
                surfaceType: contributionLike ? "ui_contribution" : "url_view",
                identity: file.path,
                currentSlug: viewSlug(file.path),
                declaredUiKey: null,
                bladeAliases: [],
                implementationEntry: file.path,
                supportFiles: [file.path, ...supportFiles],
                contracts: [],
                ownershipCandidate: ownership,
                registrationEvidence: routeEvidenceForView(
                    file.path,
                    discovery,
                ),
                evidenceSource: [`path:${file.path}`],
            }),
        );
    }
}

function collectPresentationClasses({ files, surfaces, claimedFiles }) {
    for (const file of files) {
        if (!file.path.endsWith(".php") || file.content === null) {
            continue;
        }

        const descriptor = presentationDescriptor(file);

        if (descriptor === null) {
            continue;
        }

        claimedFiles.add(file.path);
        surfaces.push(
            createBaseSurface({
                surfaceType: descriptor.surface_type,
                identity: file.path,
                currentSlug: snakeCase(descriptor.identity).replaceAll(
                    "_",
                    "-",
                ),
                declaredUiKey: descriptor.ui_key,
                bladeAliases: [],
                implementationEntry: file.path,
                supportFiles: [file.path],
                contracts: [],
                ownershipCandidate: ownershipForPresentationClass(file.path),
                registrationEvidence: descriptor.registration_evidence,
                evidenceSource: [`path:${file.path}`],
            }),
        );
    }
}

function collectUiContributions({ files, discovery, surfaces, claimedFiles }) {
    const definitionFiles = files.filter(
        (file) =>
            file.content !== null &&
            (file.path.endsWith("/Definition.php") ||
                file.path === "app/Core/Modules/Definitions.php"),
    );

    for (const file of definitionFiles) {
        const contributions = parseUiContributions(file.content);

        if (contributions.length === 0) {
            continue;
        }

        claimedFiles.add(file.path);

        for (const contribution of contributions) {
            surfaces.push(
                createBaseSurface({
                    surfaceType:
                        contribution.kind === "navigation"
                            ? "navigation"
                            : "ui_contribution",
                    identity: `${file.path}#${contribution.key}`,
                    currentSlug: contribution.key.replaceAll(".", "-"),
                    declaredUiKey: contribution.key,
                    bladeAliases: [],
                    implementationEntry: file.path,
                    supportFiles: [file.path],
                    contracts: [],
                    ownershipCandidate: ownershipForContribution(
                        file.path,
                        contribution.key,
                    ),
                    registrationEvidence: [
                        {
                            state: "declared",
                            claim: `${contribution.kind} UI contribution ${contribution.key} is declared.`,
                            route_name: contribution.route_name,
                            view_path: contribution.view_path,
                            evidence_source: [`path:${file.path}`],
                        },
                        ...runtimeContributionEvidence(
                            contribution.key,
                            discovery,
                        ),
                    ],
                    evidenceSource: [`path:${file.path}`],
                }),
            );
        }
    }
}

function collectJavascriptControls({ files, surfaces, claimedFiles }) {
    for (const file of files) {
        if (
            !file.path.endsWith(".js") ||
            file.content === null ||
            isTestPath(file.path)
        ) {
            continue;
        }

        if (
            !/(?:export\s+)?function\s+init[A-Z]|data-ui-|CustomEvent\s*\(/.test(
                file.content,
            )
        ) {
            continue;
        }

        claimedFiles.add(file.path);
        const initializerNames = uniqueSorted(
            [
                ...file.content.matchAll(
                    /(?:export\s+)?function\s+(init[A-Za-z0-9_]+)/g,
                ),
            ].map((match) => match[1]),
        );

        surfaces.push(
            createBaseSurface({
                surfaceType: "javascript_control",
                identity: file.path,
                currentSlug: basename(file.path, ".js"),
                declaredUiKey: null,
                bladeAliases: [],
                implementationEntry: file.path,
                supportFiles: [file.path],
                contracts: [],
                ownershipCandidate: reusableAssetOwnership(file.path),
                registrationEvidence: [
                    {
                        state: "present",
                        claim: `Shared JavaScript control exposes ${initializerNames.length} initializer candidate(s).`,
                        initializer_names: initializerNames,
                        evidence_source: [`path:${file.path}`],
                    },
                ],
                evidenceSource: [`path:${file.path}`],
            }),
        );
    }
}

function collectCssControls({ files, config, surfaces, claimedFiles }) {
    const patterns = compilePatterns(config.standalone_css_patterns);

    for (const file of files) {
        if (!file.path.endsWith(".css") || !matchesAny(file.path, patterns)) {
            continue;
        }

        claimedFiles.add(file.path);
        surfaces.push(
            createBaseSurface({
                surfaceType: "css_control",
                identity: file.path,
                currentSlug: basename(file.path, ".css"),
                declaredUiKey: null,
                bladeAliases: [],
                implementationEntry: file.path,
                supportFiles: [file.path],
                contracts: [],
                ownershipCandidate: reusableAssetOwnership(file.path),
                registrationEvidence: [
                    {
                        state: "present",
                        claim: "CSS source exists; build inclusion requires import or Vite evidence.",
                        evidence_source: [`path:${file.path}`],
                    },
                ],
                evidenceSource: [`path:${file.path}`],
            }),
        );
    }
}

function collectResidualAssetGroups({ files, surfaces, claimedFiles }) {
    const groups = new Map();

    for (const file of files) {
        const extension = file.path.endsWith(".css")
            ? ".css"
            : file.path.endsWith(".js")
              ? ".js"
              : null;

        if (
            extension === null ||
            claimedFiles.has(file.path) ||
            !isPotentialMaterialFile(file)
        ) {
            continue;
        }

        const key = residualAssetGroupKey(file.path, extension);
        const group = groups.get(key) ?? { extension, files: [] };
        group.files.push(file);
        groups.set(key, group);
    }

    for (const [groupKey, group] of groups) {
        group.files.forEach((file) => claimedFiles.add(file.path));
        const first = [...group.files].sort((left, right) =>
            left.path.localeCompare(right.path),
        )[0];

        surfaces.push(
            createBaseSurface({
                surfaceType:
                    group.extension === ".css"
                        ? "css_control"
                        : "javascript_control",
                identity: `group:${groupKey}`,
                currentSlug: groupKey
                    .replace(/[^a-z0-9]+/gi, "-")
                    .toLowerCase(),
                declaredUiKey: null,
                bladeAliases: [],
                implementationEntry: first.path,
                supportFiles: group.files.map((file) => file.path),
                contracts: [],
                ownershipCandidate: reusableAssetOwnership(first.path),
                registrationEvidence: [
                    {
                        state: "grouped_present",
                        claim: `${group.files.length} residual ${group.extension} source file(s) require grouped ownership and build-registration review.`,
                        evidence_source: group.files
                            .slice(0, 10)
                            .map((file) => `path:${file.path}`),
                    },
                ],
                evidenceSource: group.files
                    .slice(0, 10)
                    .map((file) => `path:${file.path}`),
            }),
        );
    }
}

function enrichSurface(surface, files, fileByPath) {
    const surfaceFiles = uniqueSorted(surface.implementation_support_files)
        .map((path) => fileByPath.get(path))
        .filter(Boolean);
    const implementationFiles = surfaceFiles.filter(
        (file) => !isContractSource(file.path, file.content ?? ""),
    );
    const publicApi = inspectBladeApi(implementationFiles);
    const apiComparison = compareApis(publicApi, surface.contracts);
    const slugTokens = slugTokenVariants(surface.current_slug);
    const cssPaths = collectRelatedFiles(files, surface, slugTokens, ".css");
    const javascriptPaths = collectRelatedFiles(
        files,
        surface,
        slugTokens,
        ".js",
    );
    const references = surfaceFiles
        .filter((file) => basename(file.path) === "reference.php")
        .map((file) => file.path);
    const examples = surfaceFiles
        .filter((file) =>
            /\/examples?\/|\/proofs?\/|example|proof/i.test(file.path),
        )
        .map((file) => file.path);
    const standards = findStandardCandidates(
        files,
        surface.surface_type,
        surface.current_slug,
        surface.contracts.length > 0,
    );
    const tests = findTestCandidates(files, surface);
    const dependencies = collectDependencies(implementationFiles);
    const metadata = aggregateMetadata(
        surface,
        implementationFiles,
        surface.contracts,
    );
    const mismatches = generateMismatchCandidates({
        surface,
        publicApi,
        apiComparison,
        references,
        standards,
    });
    const sourceFingerprintValue = sourceFingerprint({
        record_id: surface.record_id,
        implementation_entry: surface.implementation_entry,
        paths: surfaceFiles.map((file) => ({
            path: file.path,
            object_sha: file.object_sha,
            source_sha256: file.source_sha256,
        })),
        contracts: surface.contracts.map(compactContractFingerprint),
        public_api: publicApi,
        css_paths: cssPaths,
        javascript_paths: javascriptPaths,
        tests: tests.map((test) => ({
            path: test.path,
            relationship_evidence: test.relationship_evidence,
            source_fingerprint: test.source_fingerprint,
        })),
        asset_group_summary: surface.asset_group_summary,
    });

    return {
        ...surface,
        reference_paths: uniqueSorted(references),
        example_paths: uniqueSorted(examples),
        css_paths: uniqueSorted([...surface.css_paths, ...cssPaths]),
        javascript_paths: uniqueSorted([
            ...surface.javascript_paths,
            ...javascriptPaths,
        ]),
        icon_or_asset_dependencies: uniqueAssetDependencies([
            ...surface.icon_or_asset_dependencies,
            ...dependencies.icons,
        ]),
        lower_tier_dependencies: uniqueSorted([
            ...surface.lower_tier_dependencies,
            ...dependencies.components,
        ]),
        public_api_evidence: {
            implementation_paths: implementationFiles.map((file) => file.path),
            ...publicApi,
        },
        contract_api_evidence: compactContractEvidence(
            surface.contracts,
            apiComparison,
        ),
        standard_candidates: standards,
        metadata_evidence: metadata,
        lifecycle_claim: uniqueSorted(
            surface.contracts
                .map((contract) => contract.lifecycle_status)
                .filter(Boolean),
        ),
        review_claim: surface.contracts.some(
            (contract) => contract.has_review_section,
        )
            ? "contract_contains_review_claim"
            : "review_claim_not_found_in_contract",
        accessibility_evidence:
            inspectAccessibilityEvidence(implementationFiles),
        responsive_evidence: inspectResponsiveEvidence([
            ...implementationFiles,
            ...cssPaths.map((path) => fileByPath.get(path)).filter(Boolean),
        ]),
        browser_evidence: inspectBrowserEvidence(tests),
        test_candidates: tests,
        generated_mismatches: mismatches,
        target_question:
            mismatches.length > 0
                ? `Which later owner resolves the reviewed ${surface.current_slug} mismatch evidence without changing current behavior in issue #30?`
                : null,
        source_fingerprint: sourceFingerprintValue,
    };
}

function createBaseSurface({
    surfaceType,
    identity,
    currentSlug,
    declaredUiKey,
    bladeAliases,
    implementationEntry,
    supportFiles,
    contracts,
    ownershipCandidate,
    registrationEvidence = [],
    assetGroupSummary = null,
    iconOrAssetDependencies = [],
    lowerTierDependencies = [],
    cssPaths = [],
    javascriptPaths = [],
    evidenceSource,
}) {
    return {
        record_id: makeRecordId(surfaceType, identity),
        surface_type: surfaceType,
        current_slug: currentSlug,
        declared_ui_key: declaredUiKey,
        blade_aliases: uniqueSorted(bladeAliases.filter(Boolean)),
        implementation_entry: implementationEntry,
        implementation_support_files: uniqueSorted(supportFiles),
        contracts,
        ownership_candidate: ownershipCandidate,
        registration_evidence: registrationEvidence,
        asset_group_summary: assetGroupSummary,
        reference_paths: [],
        example_paths: [],
        css_paths: cssPaths,
        javascript_paths: javascriptPaths,
        icon_or_asset_dependencies: iconOrAssetDependencies,
        lower_tier_dependencies: lowerTierDependencies,
        evidence_source: uniqueSorted(evidenceSource),
    };
}

function findTestCandidates(files, surface) {
    const tests = files.filter((file) => isTestPath(file.path));
    const root = commonSurfaceRoot(surface.implementation_support_files);
    const identifiers = strongSurfaceIdentifiers(surface, files);
    const matches = [];

    for (const file of tests) {
        const relationship = testRelationship({
            file,
            surface,
            root,
            identifiers,
        });

        if (relationship === null) {
            continue;
        }

        matches.push({
            path: file.path,
            exists: true,
            relationship_evidence: relationship,
            test_type: inferTestType(file.path, file.content ?? ""),
            contract_fields_covered: inferContractCoverage(file.content ?? ""),
            rendered_states_covered: inferRenderedStates(file.content ?? ""),
            accessibility_behavior_covered:
                /aria-|accessible|keyboard|focus|screen reader/i.test(
                    file.content ?? "",
                )
                    ? "present_claim"
                    : "not_observed",
            javascript_behavior_covered:
                /javascript|data-ui-|CustomEvent|livewire:navigated/i.test(
                    file.content ?? "",
                )
                    ? "present_claim"
                    : "not_observed",
            current_result: "not_run",
            test_authority: "unknown",
            source_fingerprint: sourceFingerprint({
                path: file.path,
                object_sha: file.object_sha,
                relationship,
            }),
            evidence_source: [`path:${file.path}`],
        });
    }

    return matches.sort((left, right) => left.path.localeCompare(right.path));
}

function testRelationship({ file, surface, root, identifiers }) {
    const content = file.content ?? "";

    if (root && file.path.startsWith(`${root}/__tests__/`)) {
        return {
            kind: "owner_local_test",
            value: root,
        };
    }

    const exactPaths = uniqueSorted([
        surface.implementation_entry,
        ...surface.implementation_support_files,
        ...surface.contracts.map((contract) => contract.path),
    ]).filter((path) => path !== "unknown");

    for (const path of exactPaths) {
        if (content.includes(path)) {
            return {
                kind: "exact_repository_path_reference",
                value: path,
            };
        }
    }

    for (const alias of surface.blade_aliases) {
        if (content.includes(alias) || content.includes(alias.slice(2))) {
            return {
                kind: "exact_blade_alias_reference",
                value: alias,
            };
        }
    }

    if (surface.declared_ui_key && content.includes(surface.declared_ui_key)) {
        return {
            kind: "exact_ui_key_reference",
            value: surface.declared_ui_key,
        };
    }

    for (const identifier of identifiers) {
        if (content.includes(identifier)) {
            return {
                kind: "exact_symbol_reference",
                value: identifier,
            };
        }
    }

    return null;
}

function strongSurfaceIdentifiers(surface, files) {
    const materialPaths = new Set([
        surface.implementation_entry,
        ...surface.implementation_support_files,
    ]);
    const identifiers = [];

    for (const file of files) {
        if (!materialPaths.has(file.path) || file.content === null) {
            continue;
        }

        if (file.path.endsWith(".php")) {
            for (const match of file.content.matchAll(
                /^\s*(?:(?:abstract|final|readonly)\s+)*(?:class|interface|trait|enum)\s+([A-Za-z][A-Za-z0-9_]*)\b/gm,
            )) {
                identifiers.push(match[1]);
            }
        }

        if (file.path.endsWith(".js")) {
            for (const match of file.content.matchAll(
                /^\s*export\s+(?:async\s+)?(?:function|class|const|let|var)\s+([A-Za-z_$][A-Za-z0-9_$]*)\b/gm,
            )) {
                identifiers.push(match[1]);
            }
        }
    }

    return uniqueSorted(
        identifiers.filter(
            (identifier) =>
                identifier.length >= 5 &&
                !GENERIC_TEST_IDENTIFIERS.has(identifier.toLowerCase()),
        ),
    );
}

function aggregateMetadata(surface, implementationFiles, contracts) {
    const implementationMetadata = implementationFiles.map((file) =>
        inspectMetadata(file.path, file.content ?? "", file.source_sha256),
    );
    const contractMetadata = contracts.map((contract) => contract.metadata);
    const keys = [
        "human_readable_header",
        "ui_key",
        "blade_alias",
        "implementation_path_reference",
        "contract_path_reference",
        "contract_schema_version",
        "public_api_version",
        "verification_commit",
        "verification_timestamp",
        "source_hash",
        "contract_hash",
        "last_updated",
    ];
    const result = {};
    const disagreements = [];

    for (const key of keys) {
        const implementation = aggregateMetadataLane(
            implementationMetadata,
            key,
        );
        const contract = aggregateMetadataLane(contractMetadata, key);
        result[key] = { implementation, contract };

        if (
            implementation.values.length > 0 &&
            contract.values.length > 0 &&
            JSON.stringify(implementation.values) !==
                JSON.stringify(contract.values)
        ) {
            disagreements.push({
                field: key,
                implementation_values: implementation.values,
                contract_values: contract.values,
            });
        }
    }

    result.known_disagreements = disagreements;
    result.evidence_source = uniqueSorted([
        ...implementationFiles.map((file) => `path:${file.path}`),
        ...contracts.map((contract) => `path:${contract.path}`),
        ...surface.evidence_source,
    ]);
    return result;
}

function aggregateMetadataLane(entries, key) {
    const values = uniqueSorted(
        entries.flatMap((entry) =>
            normalizeMetadataValues(entry?.[key]?.value),
        ),
    );
    const formats = uniqueSorted(
        entries.map((entry) => entry?.[key]?.format).filter(Boolean),
    );
    const presentPaths = uniqueSorted(
        entries
            .filter((entry) => entry?.[key]?.status === "present")
            .map((entry) => entry.path),
    );
    const statuses = entries.map((entry) => entry?.[key]?.status ?? "unknown");

    return {
        present_count: statuses.filter((status) => status === "present").length,
        absent_count: statuses.filter((status) => status === "absent").length,
        unknown_count: statuses.filter((status) => status === "unknown").length,
        not_applicable_count: statuses.filter(
            (status) => status === "not_applicable",
        ).length,
        values,
        formats,
        present_paths: presentPaths,
    };
}

function normalizeMetadataValues(value) {
    if (Array.isArray(value)) {
        return value.map(String);
    }

    if (value === null || value === undefined || value === "") {
        return [];
    }

    return [String(value)];
}

function inspectAccessibilityEvidence(files) {
    const tokens = [];
    const paths = [];

    for (const file of files) {
        const observed = uniqueSorted([
            ...[
                ...(file.content ?? "").matchAll(
                    /\b(aria-[a-z-]+|role|tabindex|autofocus)\b/gi,
                ),
            ].map((match) => match[1].toLowerCase()),
            ...[
                ...(file.content ?? "").matchAll(
                    /\b(Escape|ArrowUp|ArrowDown|Enter|Space)\b/g,
                ),
            ].map((match) => match[1]),
        ]);

        if (observed.length > 0) {
            tokens.push(...observed);
            paths.push(file.path);
        }
    }

    return {
        status: paths.length > 0 ? "observed" : "not_observed",
        observed_tokens: uniqueSorted(tokens),
        paths: uniqueSorted(paths),
    };
}

function inspectResponsiveEvidence(files) {
    const values = [];
    const paths = [];

    for (const file of files) {
        const observed = uniqueSorted([
            ...[...(file.content ?? "").matchAll(/@media\s*\(([^)]+)\)/g)].map(
                (match) => match[1],
            ),
            ...[
                ...(file.content ?? "").matchAll(/\b(sm:|md:|lg:|xl:|2xl:)/g),
            ].map((match) => match[1]),
        ]);

        if (observed.length > 0) {
            values.push(...observed);
            paths.push(file.path);
        }
    }

    return {
        status: paths.length > 0 ? "observed" : "not_observed",
        observed: uniqueSorted(values),
        paths: uniqueSorted(paths),
    };
}

function inspectBrowserEvidence(tests) {
    const paths = tests
        .filter(
            (test) =>
                test.test_type === "browser" || test.test_type === "visual",
        )
        .map((test) => test.path);

    return {
        status: paths.length > 0 ? "observed" : "not_observed",
        test_paths: uniqueSorted(paths),
    };
}

function compactContractEvidence(contracts, comparison) {
    return {
        contract_paths: contracts.map((contract) => contract.path),
        profiles: uniqueSorted(contracts.map((contract) => contract.profile)),
        schema_versions: contracts.map((contract) => contract.schema_version),
        identities: contracts.map((contract) => contract.identity),
        lifecycle_statuses: uniqueSorted(
            contracts
                .map((contract) => contract.lifecycle_status)
                .filter(Boolean),
        ),
        api: {
            props: uniqueSorted(
                contracts.flatMap((contract) => contract.api.props),
            ),
            slots: uniqueSorted(
                contracts.flatMap((contract) => contract.api.slots),
            ),
            events: uniqueSorted(
                contracts.flatMap((contract) => contract.api.events),
            ),
            data_attributes: uniqueSorted(
                contracts.flatMap((contract) => contract.api.data_attributes),
            ),
        },
        subcomponents: uniqueSorted(
            contracts.flatMap((contract) => contract.subcomponents),
        ),
        declared_source_paths: uniqueSorted(
            contracts.flatMap((contract) => contract.source_paths),
        ),
        testing_section_present: contracts.some(
            (contract) => contract.has_testing_section,
        ),
        review_section_present: contracts.some(
            (contract) => contract.has_review_section,
        ),
        parse_statuses: uniqueSorted(
            contracts.map((contract) => contract.parse_status),
        ),
        comparison,
    };
}

function compactContractFingerprint(contract) {
    return {
        path: contract.path,
        source_sha256: contract.source_sha256,
        profile: contract.profile,
        schema_version: contract.schema_version,
        identity: contract.identity,
        lifecycle_status: contract.lifecycle_status,
        api: contract.api,
        subcomponents: contract.subcomponents,
        source_paths: contract.source_paths,
    };
}

function generateMismatchCandidates({
    surface,
    publicApi,
    apiComparison,
    references,
    standards,
}) {
    const mismatches = [];

    if (surface.ownership_candidate?.ownership_area === "unknown") {
        mismatches.push("investigate");
    }

    if (
        REUSABLE_TYPES.has(surface.surface_type) &&
        surface.contracts.length === 0
    ) {
        mismatches.push("contract_missing");
    }

    if (surface.contracts.length > 1) {
        mismatches.push("duplicate_identity");
    }

    if (
        apiComparison.implementation_only_props.length > 0 ||
        apiComparison.contract_only_props.length > 0
    ) {
        mismatches.push("investigate");
    }

    if (
        REUSABLE_TYPES.has(surface.surface_type) &&
        surface.contracts.length > 0 &&
        references.length === 0
    ) {
        mismatches.push("reference_missing");
    }

    if (REUSABLE_TYPES.has(surface.surface_type) && standards.length === 0) {
        mismatches.push("investigate");
    }

    if (surface.implementation_entry === "unknown") {
        mismatches.push("investigate");
    }

    if (
        publicApi.props.length === 0 &&
        surface.contracts.some((contract) => contract.api.props.length > 0)
    ) {
        mismatches.push("investigate");
    }

    return uniqueSorted(mismatches);
}

function presentationDescriptor(file) {
    const content = file.content ?? "";
    const className = content.match(
        /^(?:<\?php\s*)?\s*(?:(?:abstract|final|readonly)\s+)*class\s+([A-Za-z][A-Za-z0-9_]*)\b/m,
    )?.[1];
    const interfaceName = content.match(
        /^(?:<\?php\s*)?\s*interface\s+([A-Za-z][A-Za-z0-9_]*)\b/m,
    )?.[1];
    const identity = className ?? interfaceName;

    if (!identity) {
        return null;
    }

    if (/Renderer$/i.test(identity)) {
        return descriptor("renderer", identity, content, file.path);
    }

    if (/(ViewModel|ViewData|DataProvider)$/i.test(identity)) {
        return descriptor("view_model", identity, content, file.path);
    }

    if (/PageData$/i.test(identity)) {
        return descriptor("page_data", identity, content, file.path);
    }

    if (
        /implements\s+[^\n{]*RendersOnDashboard/.test(content) ||
        /\binterface\s+RendersOnDashboard\b/.test(content) ||
        /function\s+getDashboardView\s*\(/.test(content)
    ) {
        return descriptor("ui_contribution", identity, content, file.path);
    }

    if (
        /class\s+WidgetRegistry\b/.test(content) ||
        /register\s*\(\s*string\s+\$key\s*,\s*string\s+\$widgetClass/.test(
            content,
        )
    ) {
        return descriptor("ui_contribution", identity, content, file.path);
    }

    if (
        /extends\s+(?:\\?Livewire\\)?Component\b/.test(content) &&
        /function\s+render\s*\(/.test(content)
    ) {
        return descriptor("renderer", identity, content, file.path);
    }

    if (
        file.path.startsWith("app/Http/Controllers/Platform/") &&
        /\breturn\s+view\s*\(/.test(content)
    ) {
        return descriptor("renderer", identity, content, file.path);
    }

    return null;
}

function descriptor(surfaceType, identity, content, path) {
    const views = uniqueSorted(
        [...content.matchAll(/\bview\s*\(\s*["']([^"']+)["']/g)].map(
            (match) => match[1],
        ),
    );
    const uiKey = firstStringMatch(content, /register\s*\(\s*["']([^"']+)["']/);

    return {
        surface_type: surfaceType,
        identity,
        ui_key: uiKey,
        registration_evidence: [
            {
                state: "implementation_present",
                claim: `${identity} provides UI presentation or contribution behavior.`,
                view_names: views,
                evidence_source: [`path:${path}`],
            },
        ],
    };
}

function materialPathsForSurface(surface) {
    return uniqueSorted([
        surface.implementation_entry,
        ...surface.implementation_support_files,
        ...surface.contracts.map((contract) => contract.path),
        ...surface.reference_paths,
        ...surface.example_paths,
        ...surface.css_paths,
        ...surface.javascript_paths,
        ...surface.standard_candidates.map((standard) => standard.path),
        ...surface.test_candidates.map((test) => test.path),
    ]).filter((path) => !["unknown", "not_applicable"].includes(path));
}

function compactEvidenceSources(files, contracts) {
    return uniqueSorted([
        ...files
            .filter((file) =>
                [
                    "index.blade.php",
                    "props.php",
                    "options.php",
                    "view-model.php",
                    "reference.php",
                ].includes(basename(file.path)),
            )
            .map((file) => `path:${file.path}`),
        ...contracts.map((contract) => `path:${contract.path}`),
    ]);
}

function selectComponentEntry(rootFiles, contracts) {
    const index = rootFiles.find(
        (file) => basename(file.path) === "index.blade.php",
    );

    if (index) {
        return index.path;
    }

    for (const sourcePath of contracts.flatMap(
        (contract) => contract.source_paths,
    )) {
        const match = rootFiles.find((file) => file.path === sourcePath);

        if (match && match.path.endsWith(".blade.php")) {
            return match.path;
        }
    }

    return (
        rootFiles.find((file) => file.path.endsWith(".blade.php"))?.path ??
        "unknown"
    );
}

function aliasesForComponentRoot(root, rootFiles, implementationEntry) {
    const aliases = [];

    if (implementationEntry !== "unknown") {
        aliases.push(deriveBladeAlias(implementationEntry));
    }

    if (!rootFiles.some((file) => basename(file.path) === "index.blade.php")) {
        for (const file of rootFiles.filter((candidate) =>
            candidate.path.endsWith(".blade.php"),
        )) {
            aliases.push(deriveBladeAlias(file.path));
        }
    }

    return uniqueSorted(aliases.filter(Boolean));
}

function deriveBladeAlias(path) {
    const prefix = "resources/views/components/";

    if (!path.startsWith(prefix) || !path.endsWith(".blade.php")) {
        return null;
    }

    let relative = path.slice(prefix.length).replace(/\.blade\.php$/, "");

    if (relative.endsWith("/index")) {
        relative = relative.slice(0, -"/index".length);
    }

    return `x-${relative.replaceAll("/", ".")}`;
}

function componentSurfaceType(root, rootFiles, category) {
    if (category === "patterns") {
        return "pattern";
    }

    if (category === "layouts") {
        return "layout";
    }

    if (category === "shell") {
        return root.includes("/nav") ? "navigation" : "shell";
    }

    const hasIndex = rootFiles.some(
        (file) => basename(file.path) === "index.blade.php",
    );
    const bladeCount = rootFiles.filter((file) =>
        file.path.endsWith(".blade.php"),
    ).length;

    return !hasIndex && bladeCount > 1 ? "component_family" : "component";
}

function selectNonContractImplementation(files) {
    return [...files].sort((left, right) => {
        const leftScore = implementationPriority(left.path);
        const rightScore = implementationPriority(right.path);
        return leftScore - rightScore || left.path.localeCompare(right.path);
    })[0];
}

function implementationPriority(path) {
    if (path.endsWith(".css") && /tokens?|theme-seed|variables/i.test(path)) {
        return 0;
    }
    if (path.endsWith(".css")) return 1;
    if (path.endsWith(".js")) return 2;
    if (path.endsWith(".blade.php")) return 3;
    return 4;
}

function collectRelatedFiles(files, surface, slugTokens, extension) {
    const paths = [];
    const contractSources = new Set(
        surface.contracts.flatMap((contract) => contract.source_paths),
    );

    for (const file of files) {
        if (!file.path.endsWith(extension)) {
            continue;
        }

        if (contractSources.has(file.path)) {
            paths.push(file.path);
            continue;
        }

        const lowerPath = file.path.toLowerCase();
        const basenameToken = basename(file.path, extension).toLowerCase();

        if (
            slugTokens.includes(basenameToken) ||
            slugTokens.some((token) => lowerPath.includes(`/${token}/`)) ||
            (file.content !== null &&
                slugTokens.some(
                    (token) =>
                        token.length >= 4 &&
                        new RegExp(
                            `(?:\\.|--|data-ui-)${escapeRegex(token)}(?:[-_\\s:{.]|$)`,
                            "i",
                        ).test(file.content),
                ))
        ) {
            paths.push(file.path);
        }
    }

    return uniqueSorted(paths);
}

function findStandardCandidates(files, surfaceType, slug, contracted) {
    const normalizedSlug = slug.replaceAll("_", "-");
    const branch =
        surfaceType === "element"
            ? "elements"
            : surfaceType === "pattern"
              ? "patterns"
              : "components";
    const paths = [`docs/02-standards/ui/${branch}/${normalizedSlug}.md`];

    if (contracted) {
        paths.push("docs/02-standards/ui/contract-file.md");
        paths.push("docs/02-standards/ui/reference-file.md");
    }

    return uniqueSorted(paths)
        .map((path) => files.find((file) => file.path === path))
        .filter(Boolean)
        .map((file) => ({
            path: file.path,
            claimed_scope: firstHeadingOrTitle(file.content),
            authority_state: documentStatus(file.content),
            evidence_source: [`path:${file.path}`],
        }));
}

function collectDependencies(files) {
    const components = [];
    const icons = [];

    for (const file of files) {
        const content = file.content ?? "";

        for (const match of content.matchAll(/<x-([a-z0-9_.:-]+)/gi)) {
            const alias = `x-${match[1]}`;

            if (alias === "x-ui.icon" || alias.startsWith("x-icons.")) {
                icons.push({ alias, evidence_source: [`path:${file.path}`] });
            } else {
                components.push(alias);
            }
        }

        for (const match of content.matchAll(
            /<x-ui\.icon\b[^>]*\bname=["']([^"']+)["']/gi,
        )) {
            icons.push({
                alias: "x-ui.icon",
                name: match[1],
                evidence_source: [`path:${file.path}`],
            });
        }
    }

    return {
        components: uniqueSorted(components),
        icons,
    };
}

function parseUiContributions(content) {
    const contributions = [];
    const patterns = [
        {
            kind: "navigation",
            regex: /self::navigation\(\s*["']([^"']+)["'][\s\S]*?["']([^"']+)["']/g,
        },
        {
            kind: "main_view",
            regex: /self::mainView\(\s*["']([^"']+)["']\s*,\s*["']([^"']+)["']\s*,\s*["']([^"']+)["']/g,
        },
    ];

    for (const pattern of patterns) {
        for (const match of content.matchAll(pattern.regex)) {
            contributions.push({
                kind: pattern.kind,
                key: match[1],
                route_name: match[2] ?? null,
                view_path: match[3] ?? null,
            });
        }
    }

    return contributions;
}

function runtimeContributionEvidence(key, discovery) {
    const modules =
        discovery?.commands?.module_list?.last_success?.payload ?? [];
    const matches = modules.filter((module) =>
        JSON.stringify(module.ui_entries ?? []).includes(key),
    );

    return matches.map((module) => ({
        state: "discovered",
        claim: `Accepted runtime Module evidence includes contribution ${key}.`,
        module_key: module.key,
        evidence_source: [
            discovery.commands.module_list.last_success.source ===
            "issue_29_accepted_runtime_evidence"
                ? "issue-29:module-list"
                : "command:php artisan platform:modules:list --json",
        ],
    }));
}

function routeEvidenceForView(path, discovery) {
    const routes = discovery?.commands?.route_list?.last_success?.payload ?? [];
    const identifiers = routeIdentifiersForView(path);
    const matches = routes.filter((route) =>
        identifiers.some((identifier) =>
            `${route.name ?? ""} ${route.uri ?? ""} ${route.action ?? ""}`
                .toLowerCase()
                .includes(identifier),
        ),
    );

    return matches.map((route) => ({
        state: "registered_route_candidate",
        claim: `Accepted route evidence may reach this view; controller/view-source review is still required.`,
        route,
        evidence_source: [
            discovery.commands.route_list.last_success.source ===
            "issue_29_accepted_runtime_evidence"
                ? "issue-29:route-list"
                : "command:php artisan route:list --json",
        ],
    }));
}

function routeIdentifiersForView(path) {
    const identifiers = [];
    const module = path.match(/^Modules\/([^/]+)\//)?.[1]?.toLowerCase();
    const basenameToken = basename(path, ".blade.php").toLowerCase();

    if (module) identifiers.push(module);
    if (!GENERIC_TEST_IDENTIFIERS.has(basenameToken))
        identifiers.push(basenameToken);
    return uniqueSorted(identifiers);
}

function moduleTypes(discovery) {
    return new Map(
        (discovery?.commands?.module_list?.last_success?.payload ?? []).map(
            (module) => [
                snakeCase(module.key ?? ""),
                String(module.type ?? "unknown"),
            ],
        ),
    );
}

function ownershipForModuleView(moduleKey, runtimeType) {
    if (runtimeType === "core") {
        return {
            ownership_area: "core",
            owner_key: moduleKey,
            capability_key: moduleKey,
            module_key: "not_applicable",
            evidence: [
                "accepted runtime Module evidence classifies package as Core",
            ],
        };
    }

    if (runtimeType === "module") {
        return {
            ownership_area: "module",
            owner_key: moduleKey,
            capability_key: moduleKey,
            module_key: moduleKey,
            evidence: [
                "accepted runtime Module evidence classifies optional Module",
            ],
        };
    }

    return {
        ownership_area: "unknown",
        owner_key: moduleKey,
        capability_key: moduleKey,
        module_key: "unknown",
        evidence: [
            "physical Modules path does not independently prove Module ownership",
        ],
    };
}

function ownershipForContribution(path, key) {
    const moduleMatch = path.match(/^Modules\/([^/]+)\//);

    if (moduleMatch) {
        const owner = snakeCase(moduleMatch[1]);
        return {
            ownership_area: "unknown",
            owner_key: owner,
            capability_key: key.split(".")[0],
            module_key: "unknown",
            evidence: [
                "current contribution definition path; runtime type review required",
            ],
        };
    }

    return {
        ownership_area: key.startsWith("ui") ? "ui" : "core",
        owner_key: key.split(".")[0],
        capability_key: key.split(".")[0],
        module_key: "not_applicable",
        evidence: ["current Core registry declaration"],
    };
}

function ownershipForPresentationClass(path) {
    if (path.startsWith("Modules/")) {
        return reusableAssetOwnership(path);
    }

    if (path.startsWith("app/Platform/")) {
        return {
            ownership_area: "unknown",
            owner_key: inferPlatformOwner(path),
            capability_key: inferPlatformOwner(path),
            module_key: "not_applicable",
            evidence: [
                "transitional app/Platform presentation path requires review",
            ],
        };
    }

    return {
        ownership_area: "core",
        owner_key: inferPlatformOwner(path),
        capability_key: inferPlatformOwner(path),
        module_key: "not_applicable",
        evidence: ["current app-owned presentation class"],
    };
}

function reusableAssetOwnership(path) {
    if (path.startsWith("Modules/")) {
        const owner = snakeCase(path.split("/")[1]);
        return {
            ownership_area: "unknown",
            owner_key: owner,
            capability_key: owner,
            module_key: "unknown",
            evidence: [
                "Module-local UI ownership must follow presented behavior",
            ],
        };
    }

    return uiOwnership();
}

function uiOwnership() {
    return {
        ownership_area: "ui",
        owner_key: "ui",
        capability_key: "not_applicable",
        module_key: "not_applicable",
        evidence: ["ADR-0005 reusable UI ownership"],
    };
}

function inferPlatformOwner(path) {
    const match = path.match(
        /(?:resources\/views\/platform|app\/(?:Platform|Livewire\/Platform)|app\/Http\/Controllers\/Platform)\/([^/]+)/,
    );
    return match ? snakeCase(match[1]) : "unknown";
}

function isSupportView(path) {
    return (
        /\/partials?\//.test(path) ||
        /\/components?\//.test(path) ||
        basename(path).startsWith("_")
    );
}

function viewSlug(path) {
    return path
        .replace(/^resources\/views\/platform\//, "")
        .replace(/^Modules\/[^/]+\/resources\/views\//, "")
        .replace(/\.blade\.php$/, "")
        .replaceAll("/", "-");
}

function commonSurfaceRoot(paths) {
    const directories = paths.map((path) => dirname(path));
    return directories.length === 0
        ? null
        : directories.sort((left, right) => left.length - right.length)[0];
}

function isTestPath(path) {
    return (
        path.includes("/__tests__/") ||
        path.startsWith("tests/") ||
        /Test\.php$/.test(path) ||
        /\.spec\.[cm]?[jt]s$/.test(path)
    );
}

function inferTestType(path, content) {
    const haystack = `${path} ${content}`;
    if (/playwright|browser/i.test(haystack)) return "browser";
    if (/visual|screenshot/i.test(haystack)) return "visual";
    if (/accessib|aria-|keyboard|focus/i.test(haystack)) return "accessibility";
    if (/javascript|data-ui-|CustomEvent|livewire:navigated/i.test(haystack)) {
        return "JavaScript behavior";
    }
    if (/schema|contract.*keys|topLevelKeys/i.test(haystack)) {
        return "contract schema";
    }
    if (/render|assertSee|assertView/i.test(haystack)) return "API rendering";
    if (/class|css/i.test(haystack)) return "class contract";
    return "unknown";
}

function inferContractCoverage(content) {
    return uniqueSorted(
        [
            ...content.matchAll(
                /["'](identity|lifecycle|api|subcomponents|class_contract|variants|sizes|states|tokens|dependencies|accessibility|deprecations|enforcement|source)["']/g,
            ),
        ].map((match) => match[1]),
    );
}

function inferRenderedStates(content) {
    return uniqueSorted(
        [
            ...content.matchAll(
                /\b(loading|disabled|readonly|invalid|error|warning|success|open|closed|expanded|selected|checked|indeterminate)\b/gi,
            ),
        ].map((match) => match[1].toLowerCase()),
    );
}

function slugTokenVariants(slug) {
    const normalized = String(slug ?? "").toLowerCase();
    return uniqueSorted([
        normalized,
        normalized.replaceAll("_", "-"),
        normalized.replaceAll("-", "_"),
        normalized.replaceAll("-", ""),
    ]).filter((value) => value && !GENERIC_TEST_IDENTIFIERS.has(value));
}

function firstHeadingOrTitle(content) {
    if (!content) return "unknown";
    return (
        content.match(/^#\s+(.+)$/m)?.[1] ??
        content.match(/^title:\s*(.+)$/m)?.[1] ??
        "unknown"
    ).trim();
}

function documentStatus(content) {
    return (
        content?.match(/^status:\s*(.+)$/m)?.[1]?.trim() ??
        content?.match(/^system_maturity:\s*(.+)$/m)?.[1]?.trim() ??
        "unknown"
    );
}

function uniqueAssetDependencies(values) {
    const seen = new Set();
    const output = [];

    for (const value of values) {
        const key = JSON.stringify(value);
        if (!seen.has(key)) {
            seen.add(key);
            output.push(value);
        }
    }
    return output;
}

function isPotentialMaterialFile(file) {
    const path = file.path;
    const content = file.content ?? "";

    if (path === "vite.config.js") return false;
    if (
        path.endsWith(".blade.php") ||
        path.endsWith("/contract.php") ||
        path.endsWith("/contract.blade.php") ||
        path.endsWith(".css") ||
        path.endsWith(".js")
    ) {
        return true;
    }

    return (
        path.endsWith(".php") &&
        (/(?:Renderer|ViewModel|PageData|ViewData|DataProvider)\.php$/.test(
            path,
        ) ||
            /implements\s+[^\n{]*RendersOnDashboard/.test(content) ||
            /\binterface\s+RendersOnDashboard\b/.test(content) ||
            /class\s+WidgetRegistry\b/.test(content) ||
            (/extends\s+(?:\\?Livewire\\)?Component\b/.test(content) &&
                /function\s+render\s*\(/.test(content)) ||
            (path.startsWith("app/Http/Controllers/Platform/") &&
                /\breturn\s+view\s*\(/.test(content)))
    );
}

function residualAssetGroupKey(path, extension) {
    const moduleMatch = path.match(
        /^Modules\/([^/]+)\/resources\/(css|js)\/(?:([^/]+)\/)?/,
    );
    if (moduleMatch) {
        return `module-${snakeCase(moduleMatch[1])}-${moduleMatch[2]}-${moduleMatch[3] ?? "root"}`;
    }
    const resourceMatch = path.match(/^resources\/(css|js)\/(?:([^/]+)\/)?/);
    if (resourceMatch) {
        return `resources-${resourceMatch[1]}-${resourceMatch[2] ?? "root"}`;
    }
    return `${extension === ".css" ? "css" : "js"}-other`;
}

function snakeCase(value) {
    return String(value)
        .replace(/([a-z0-9])([A-Z])/g, "$1_$2")
        .replace(/[^A-Za-z0-9]+/g, "_")
        .replace(/^_+|_+$/g, "")
        .toLowerCase();
}

function firstStringMatch(content, pattern) {
    return pattern.exec(content)?.[1] ?? null;
}

function escapeRegex(value) {
    return value.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
}
