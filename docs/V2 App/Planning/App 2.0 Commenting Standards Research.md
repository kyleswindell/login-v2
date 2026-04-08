# Modern Commenting Standards for Source Code and Developer Documentation

## Purpose

Preserve the deeper external research that informed the V2 commenting standard and related documentation choices.

Use this note as research context, not as the canonical source for repo rules.

## Executive summary

Modern commenting standards converge on a shared goal: maximize long-term comprehension while minimizing drift, noise, and duplicated truth. In practice, that means (a) write code that “explains itself” by structure and naming, (b) reserve comments for intent, constraints, contracts, and non-obvious rationale, and (c) treat documentation comments as a first-class API surface (because multiple ecosystems extract them into rendered docs and IDE hints). citeturn16view0turn11view0turn8view0turn12view4turn25view0

The most consistently emphasized risks are comment/code divergence (“worse than no comment”), overuse of inline comments that restate the obvious, and file headers bloated with metadata that version control already tracks. Conversely, standards strongly favor crisp summaries for public symbols, explicit documentation of tricky invariants and edge cases, and standardized TODO notes that point to a durable tracker/URL rather than a person’s memory. citeturn8view0turn11view0turn16view0turn6view6turn6view3

A practical “no-bloat” house style that fits most languages is: keep file headers minimal (license + purpose), require doc comments for public/exported APIs, comment complex logic at block boundaries (not line-by-line), and enforce conventions with linters/doc generators in CI so the standard stays consistent over time. citeturn16view0turn6view4turn25view4turn22search0turn22search7

## Principles that balance clarity and low bloat

The dominant rule across major style guides is to avoid comments that merely restate what the code plainly does. Instead, prefer self-describing code via naming and refactoring, and reserve comments for what the code cannot reliably communicate: intent (“why”), design constraints, invariants, non-obvious trade-offs, and safety/performance implications. citeturn11view0turn16view0turn8view0turn6view2

When a code location feels like it “needs a comment,” modern standards often treat that as a signal to refactor first. Examples of refactor-first guidance include: replacing “mystery boolean” parameters with enums/options objects, extracting complex expressions into named variables, and only using argument-clarifying comments as a last resort when changes to names/signatures are infeasible. citeturn11view0turn6view2turn16view0

Comment maintenance is not optional: multiple primary sources explicitly warn that stale comments are actively harmful. A maintainable standard therefore couples “write fewer comments” with “keep them correct,” expecting comment updates to ship in the same change as the code change they describe. citeturn8view0turn11view0turn6view2

Audience framing is part of modern practice. For example, Go and Google Go guidance explicitly note that doc comments are surfaced by documentation tooling and IDEs, so they should be written for anyone using the package, not just current teammates. That pushes doc comments toward complete, readable sentences and away from private shorthand. citeturn12view4turn25view0turn12view0

Where stylistic details differ across ecosystems, the recurring “meta-rule” is consistency within a codebase: if an issue is not specified, follow local convention rather than inventing new, bespoke patterns. The Google JavaScript guide explicitly calls out this approach for unspecified areas. citeturn23view0

## Comment types and recommended content

File headers, doc comments, inline comments, and documentation files serve different purposes. Modern standards tend to allocate information to the _lowest_ appropriate scope: file-level comments describe file-wide purpose and boundaries; symbol-level doc comments describe contracts; implementation comments explain tricky local reasoning. citeturn16view0turn6view4turn7view1turn5view6turn5view5

**File header comments (top-of-file)** should generally contain:

- License/notice information when required by project policy; C/C++ guidance explicitly says to start each file with license boilerplate, and Java guidance places license/copyright (if present) at the top of the file. citeturn16view0turn16view2turn6view1
- A brief “file overview” only when it truly orients a reader (e.g., the file defines multiple user-facing abstractions or has non-obvious constraints). Google C++ recommends a file comment describing the collection of abstractions and what does _not_ belong there; Google JavaScript recommends a `@fileoverview` for more complex files and notes it may include dependencies/compatibility info. citeturn16view0turn6view4turn6view2turn16view1
- Avoid author/date/“last modified” boilerplate. Google C++ explicitly discourages author lines in new files and suggests deleting legacy author lines after significant changes; Google JavaScript states that neither a copyright statement nor an author credit is required. citeturn16view0turn23view0

For licensing that avoids long headers, SPDX identifiers are a modern, widely used technique: the SPDX spec and guidance recommend a single `SPDX-License-Identifier:` line near the top of the file in a comment, designed to be concise and language-neutral. citeturn21view3turn21view4

**Doc comments for functions/methods/classes** are expected to document the _contract_:

- A concise summary first (often used in indexes/search). Javadoc specifies an initial description followed by tags, and emphasizes the first sentence as a summary; PEP 257 similarly requires a one-line summary for multi-line docstrings followed by a blank line; Google Java emphasizes a summary fragment; Go guidance strongly prefers a first-sentence summary starting with the symbol name. citeturn14view3turn7view1turn6view0turn12view0turn25view0
- Parameters/returns/exceptions where applicable. Javadoc formally defines `@param`, `@return`, and `@throws`; Google Java specifies ordering and requires non-empty descriptions; JSDoc commonly documents parameter name/type/description; Google JavaScript requires parameter and return _types_ for methods/named functions and mandates explicit annotations for overrides in particular. citeturn14view0turn6view0turn13view1turn10view3
- Non-obvious behaviors: valid ranges, nullability, ownership/lifetime, concurrency assumptions, performance implications. Google C++ explicitly lists these as “types of things to mention” in function comments, and recommends documenting synchronization assumptions at the class level. citeturn11view0

**Inline comments (end-of-line) and block comments (above a block)** should be used sparingly and focus on local rationale:

- Python explicitly says inline comments are unnecessary/distracting when they state the obvious, and suggests using them only when they explain a non-obvious adjustment; it also insists comments be kept up to date and written clearly (English for global audiences). citeturn8view0
- Google C++ similarly says “do not state the obvious,” while recommending explanatory comments before tricky/complicated blocks. citeturn11view0turn16view0
- Google JavaScript forbids using JSDoc syntax for implementation comments and documents a specific pattern (“parameter name comments”) for clarifying unclear arguments when refactoring is infeasible. citeturn6view2

**TODO/FIXME conventions** are most effective when they are searchable, durable, and contextual:

- Google C++/Java/Python converge on: `TODO` in all caps + (preferred) bug/issue URL or reference + a short explanation; also include a specific date/event if it’s time-based, and avoid TODOs that merely assign to a person/team. citeturn6view3turn9view0turn6view6
- Go doc tooling recognizes “notes” of the form `MARKER(uid): body` (e.g., `TODO(user): ...`, `BUG(user): ...`) and collects them for documentation surfaces; the Go doc comment guide documents these markers, and the `go/doc` package specifies the Note format. citeturn12view5turn25view1
- **FIXME**: a universal, language-agnostic “FIXME standard” is **unspecified** in the cited primary sources. A practical approach is to treat `FIXME` as either a `BUG(...)`/issue-linked note or to forbid `FIXME` entirely in favor of `TODO: <issue> - ...` plus severity in the tracker. (Labeling this detail as unspecified is intentional.) citeturn6view3turn6view6turn12view5turn25view1

**Tests**: modern guidance tends to make tests self-describing through naming and failure messages rather than comments:

- Google Java and Google JavaScript both discuss naming patterns for test methods (underscores allowed to separate intent components) and emphasize there is no single perfect naming scheme. citeturn17view2turn17view1
- Google JavaScript includes a `@bug` tag convention for test functions to link regression tests to bug IDs, improving discoverability. citeturn23view0
- Go tooling explicitly extracts runnable examples from `_test.go` files into documentation structures, tying tests and docs more closely than many ecosystems. citeturn25view1turn12view1
- Detailed “how to comment tests” rules are otherwise **partly unspecified** in the primary sources; applying the general “don’t state the obvious / comment the why” principles is the most evidence-aligned approach. citeturn11view0turn8view0turn23view0

**Configuration files**: comment guidance depends on the format.

- Standard JSON (RFC 8259) defines whitespace in a way that excludes comment tokens; therefore “comments in JSON” are not part of the standard grammar (this is a direct inference from the grammar/whitespace definition). citeturn19view0
- YAML explicitly supports comments beginning with `#`. citeturn21view1
- TOML examples use `#` comments and target human-readable configuration. citeturn21view2  
  Given that reality, a practical “no bloat” approach is: keep config comments short and focused on meaning and constraints, and place longer narratives in adjacent documentation (README, schema docs). The exact placement/format beyond the syntax rules is **unspecified** by the configuration specs themselves. citeturn19view0turn21view1turn21view2

**Public APIs and external documentation**: modern standards typically require doc comments on exported/public symbols and encourage generating readable docs from them:

- Python: write docstrings for public modules/functions/classes/methods; non-public methods can omit docstrings but should have an explanatory comment if needed. citeturn7view0turn8view0
- Go: every exported name should have a doc comment; package comments set expectations for the package and are rendered by tooling/IDEs. citeturn12view4turn5view6turn25view0
- Java: Javadoc is designed to be extracted into HTML API docs; the Oracle spec defines how comments/tags are parsed, and the `javadoc` tool generates documentation (with DocLint available for checking). citeturn5view5turn25view4
- JavaScript/TypeScript: JSDoc is used by tooling and doc generators; TypeScript documents supported JSDoc patterns (e.g., `@returns` with `{@link ...}`), and doc generators like TypeDoc parse doc comments into HTML. citeturn10view1turn7view6turn25view5

## Concise examples by comment type and language

The examples below are intentionally minimal and designed to prevent comment bloat while still encoding the “why/contract/boundaries” information that code alone cannot express.

### File header examples

```py
"""payments.refunds

Implements refund eligibility and idempotent execution for card payments.

Public surface:
- RefundService: high-level refund API used by the web layer.
"""
# SPDX-License-Identifier: MIT
```

```java
// SPDX-License-Identifier: Apache-2.0
package com.example.payments;

/**
 * Refund eligibility and execution utilities.
 *
 * <p>Design note: This package enforces idempotency by refundId.
 */
```

```js
/**
 * @fileoverview Refund eligibility and idempotent execution.
 * Dependencies: requires stable storage for refundId idempotency keys.
 */
// SPDX-License-Identifier: MIT
```

```cpp
// SPDX-License-Identifier: BSD-3-Clause
// This file defines refund eligibility predicates and helpers.
// Anything requiring network I/O does not belong here (see refund_client.*).
```

```go
// SPDX-License-Identifier: MIT
// Package refunds implements refund eligibility and idempotent execution.
package refunds
```

These patterns align with: module/package/file overviews as orientation (not changelogs), minimized author metadata, and SPDX for concise licensing. citeturn16view0turn16view1turn7view1turn5view6turn21view3

### Function/method doc comment examples

```py
def refund(amount_cents: int, refund_id: str) -> str:
    """Execute a refund and return the provider refund reference.

    Idempotency: multiple calls with the same refund_id must return the same
    provider reference (or the same failure category) without double-refunding.
    """
    ...
```

```java
/**
 * Executes a refund and returns the provider refund reference.
 *
 * @param amountCents amount in cents; must be positive
 * @param refundId idempotency key for refund execution
 * @return provider refund reference
 * @throws IllegalArgumentException if amountCents <= 0
 */
String refund(long amountCents, String refundId);
```

```ts
/**
 * Executes a refund and returns the provider refund reference.
 * @param amountCents amount in cents; must be positive
 * @param refundId idempotency key for refund execution
 * @returns provider refund reference
 */
export function refund(amountCents: number, refundId: string): string {
  ...
}
```

```cpp
// Executes a refund and returns the provider refund reference.
// `refund_id` must be stable across retries to guarantee idempotency.
std::string Refund(int64_t amount_cents, std::string_view refund_id);
```

```go
// Refund executes a refund and returns the provider refund reference.
// Refund is idempotent with respect to refundID.
func Refund(amountCents int64, refundID string) (string, error) { ... }
```

These examples reflect: summary-first conventions; explicit parameter/return/throws tagging in Javadoc; and Go’s “start with the name, full sentence” rule for doc comments. citeturn14view3turn14view0turn7view1turn12view0turn25view0

### Inline/block comments for complex logic

```py
# Compensate for provider rounding rules: provider rounds half-away-from-zero.
net_cents = gross_cents - fee_cents
```

```js
someCall(userId, /* shouldRetry= */ true); // Refactor to options object is infeasible here.
```

```cpp
// Why this lock is split:
// - phase 1 must serialize updates to avoid double-refund
// - phase 2 can run lock-free to reduce tail latency
```

These align with “use inline comments sparingly,” “don’t state the obvious,” and “comment the why / tricky parts,” plus argument-clarifying comments as a last resort. citeturn8view0turn11view0turn6view2

### TODO / BUG note conventions

```cpp
// TODO: bug 12345678 - Remove compatibility path after all clients migrate.
```

```py
# TODO: crbug.com/192795 - Investigate cpufreq optimizations.
```

```java
// TODO: https://issue-tracker.example/123 - Replace temporary fallback after rollout completes.
```

```go
// TODO(user1): refactor to use standard library context
// BUG(user2): not cleaned up
```

These patterns are directly supported by multiple style guides and, in Go, can be surfaced as structured “notes.” citeturn6view3turn6view6turn9view0turn12view5turn25view1

### Tests and configuration comments

```js
/** @bug 1234567 */
it('refund() is idempotent for the same refundId', () => { ... });
```

```yaml
refunds:
    ttl_days: 30 # Retain idempotency keys for 30 days to cover retry windows.
```

```toml
# Retain idempotency keys long enough to cover retry windows.
ttl_days = 30
```

For JSON, “inline comments” are not part of the standard grammar; prefer YAML/TOML or attach documentation externally (README/schema). citeturn23view0turn21view1turn21view2turn19view0

## Language-specific variations and edge cases

**Python** centers documentation on docstrings (module/class/function) and treats implementation comments as secondary. PEP 8 explicitly warns that contradictory comments are worse than none, requires complete sentences, and discourages inline comments that restate the obvious; it also recommends English comments for globally read code. PEP 257 adds structure rules: one-line docstrings should be a concise phrase ending in a period and should not repeat the function signature; multi-line docstrings use a summary line, blank line, then details (and class docstrings get a trailing blank line after them). citeturn8view0turn7view1

**Java** splits between implementation comments and Javadoc. The Oracle doc comment spec defines documentation comments as a main description plus block tags, recognizes them only when immediately preceding declarations (and ignores doc comments inside method bodies), and formally specifies tags like `@param`, `@return`, and `@throws`. Google Java style further defines a practical baseline: Javadoc is expected for visible classes/members (with limited exceptions), requires a summary fragment, and standardizes tag ordering and non-empty tag descriptions. citeturn5view5turn14view3turn14view0turn6view0

**JavaScript/TypeScript** ecosystems often use `/** ... */` both for human docs and for machine-readable annotations. Google JavaScript style explicitly separates these: do not use JSDoc syntax for implementation comments; use file-level `@fileoverview` when needed; use “parameter name comments” at call sites when refactoring is infeasible; and require JSDoc types for method parameters/returns (with override-specific requirements). TypeScript’s handbook documents supported JSDoc patterns (including `@returns` and `{@link ...}` usage). For generated documentation, tools like TypeDoc parse doc comments (TSDoc/JSDoc style) and pass resolved markup to Markdown rendering. citeturn6view2turn10view3turn7view6turn25view5

**C/C++** guidance tends to emphasize comments as part of the interface contract, especially in header files. Google C++ style requires license boilerplate at file start, recommends file comments only when they help future authors understand what belongs in the file, discourages author lines in new code, and provides concrete guidance on what function/class comments should cover (nullability/ownership/performance/synchronization assumptions). It also strongly discourages “state the obvious” comments and promotes refactoring alternatives before commenting argument meaning. For doc generation, Doxygen supports structured “special comment blocks,” including file-level documentation (`\file`) and function parameter/return tags (`\param`, `\returns`). citeturn16view0turn11view0turn7view5turn13view0

**Go** doc comments are unusually central: doc comments immediately preceding declarations are primary documentation, should be full sentences starting with the symbol name (and generally ending with a period), and every exported name should be documented. Package comments should introduce the package, with the first sentence beginning with “Package …”, and only one file in a multi-file package should carry the package comment. Go’s doc tooling also recognizes structured “notes” (`MARKER(uid): ...`) such as TODO/BUG markers, which can be collected and displayed. The Go doc comment guide additionally warns about formatting pitfalls (like unintended code blocks from indentation) and describes semantic linefeeds as an optional diff-friendly practice. citeturn12view4turn12view3turn5view6turn25view1turn12view5

Where a detail is not explicitly governed by these primary sources (for example, a universal “FIXME severity scale,” or a mandated test-comment template across all libs), it should be treated as **unspecified** and decided by local convention—preferably encoded in a short project style doc plus automation. citeturn23view0turn8view0turn11view0

## Tooling and CI practices to enforce standards

Tooling is a key part of “modern” commenting standards because it shifts documentation quality from subjective review to enforceable checks.

In **Python**, docstrings are commonly validated by dedicated tools: pydocstyle (formerly pep257) explicitly checks compliance with Python docstring conventions (supporting most of PEP 257), while Sphinx autodoc can import modules and pull documentation directly from docstrings to generate API docs (which encourages accurate docstrings because they become published output). Google’s Python style guide recommends using pylint as part of a linting baseline, which can also enforce documentation-related conventions via configuration. citeturn22search5turn22search0turn5view3turn6view5

In **Java**, the `javadoc` tool parses declarations and documentation comments to generate HTML API documentation, and includes DocLint to report common documentation problems in-source (including semantic mismatches like `@param` tags for nonexistent parameters). This supports a CI posture where doc warnings can be treated as actionable build failures for public API modules. citeturn25view4turn5view5turn14view0

In **JavaScript/TypeScript**, enforcement is typically done through ESLint rules that require or validate JSDoc presence and structure, and through doc generators (TypeDoc) that convert doc comments into rendered docs—creating a feedback loop where “bad comments” become visible artifacts. ESLint’s built-in `require-jsdoc` rule can require JSDoc for specific node types, and can be scoped to enforce docs on public/exported surfaces depending on rule configuration and plugin use (implementation details vary by ESLint/plugin and are therefore partly project-specific). citeturn22search7turn25view5

In **C/C++**, Doxygen is a primary doc generator for structured comment blocks. For enforcement of TODO conventions in Google-style codebases, clang-tidy includes a check that detects TODOs missing a username or bug number (reflecting the style guide’s requirement for contextual TODO markers). citeturn7view5turn1search20turn6view3

In **Go**, gofmt is the baseline formatter and is explicitly recommended as the default mechanical style tool; go/doc tooling extracts doc comments for IDEs and documentation sites, and recognizes note markers as structured data. CI commonly enforces `gofmt` cleanliness and (when desired) checks for missing doc comments on exported symbols using linters, but the exact selection of linters/rules is **unspecified** by the Go primary docs themselves and depends on the project’s quality bar. citeturn12view0turn12view4turn25view1turn5view6

For license headers, SPDX identifiers can be enforced via simple repository scans (e.g., grep for `SPDX-License-Identifier:`) and are explicitly designed to be concise and machine-processable across languages. citeturn21view3turn21view4

## Comparison table

| Comment type          | Language-agnostic recommendation                                                                              | Python                                                                                      | Java                                                                                                                           | JavaScript / TypeScript                                                                                                                            | C / C++                                                                                                                                               | Go                                                                                                                               |
| --------------------- | ------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------ | -------------------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------- |
| File header           | Keep minimal: license + short purpose/overview only when it orients; avoid author/date metadata               | Prefer module docstring for purpose/exports citeturn7view1turn7view0                    | License/copyright (if present) goes first; consider package-level docs via `package-info.java` citeturn16view2              | Optional `@fileoverview`; optional author but not required; avoid bloat citeturn16view1turn23view0                                             | Start with license; file comment for collections; author line discouraged citeturn16view0                                                          | Package comment introduces package; single file should contain it citeturn12view3turn5view6                                  |
| Doc comment (API)     | Document the contract: summary first, then key constraints/edge cases; avoid repeating obvious implementation | PEP 257 structure: summary + blank line + details; don’t repeat signature citeturn7view1 | Javadoc main description + tags; tags like `@param/@return/@throws` defined by spec citeturn14view3turn14view0turn14view2 | JSDoc required for classes/methods in Google style; param/return types required; avoid using JSDoc for impl comments citeturn10view3turn6view2 | Function/class comments should cover non-obvious usage; nullability/ownership/perf; Doxygen supports `\param/\returns` citeturn11view0turn13view0 | Full-sentence doc comments starting with name; exported names documented; appears in tooling/IDEs citeturn12view0turn25view0 |
| Inline comment        | Use sparingly; explain “why” or a non-obvious adjustment, not “what”                                          | Inline comments sparingly; avoid stating obvious citeturn8view0                          | Format rules exist; content guidance largely general-purpose (impl comments vs Javadoc) citeturn9view0                      | Use `//` or `/* */`; parameter-name comments supported for unclear call args citeturn6view2                                                     | Tricky/complicated blocks should have comments; don’t state obvious citeturn11view0                                                                | Use clear sentences; avoid accidental formatting pitfalls in doc comments citeturn12view5turn5view6                          |
| Block comment         | Place before the block; keep at same indentation; complete sentences when appropriate                         | Block comments: each line `#` + space; paragraphs separated by `#` line citeturn8view0   | Multi-line `/* */` aligned `*`; boxes discouraged citeturn9view0                                                            | Multi-line `/* */` aligned `*`; boxes discouraged citeturn6view2                                                                                | `//` or `/* */` consistent; boxes discouraged citeturn11view1turn11view0                                                                          | Line comments are norm; block comments mostly for package comments citeturn5view7                                             |
| TODO / FIXME          | TODOs must be searchable and point to durable context (issue/URL); avoid person-only TODOs                    | TODO format with link + hyphen explanation (Google Python) citeturn6view6                | TODO format with link context + explanation (Google Java) citeturn9view0                                                    | TODO is last resort for unresolved warnings; deprecation docs required citeturn23view0                                                          | TODO requires bug/person/issue context; include date/event if time-based citeturn6view3                                                            | Notes like `TODO(uid): ...` and `BUG(uid): ...` recognized by tooling citeturn12view5turn25view1                             |
| Tests                 | Prefer descriptive test names and failure messages; comment only non-obvious setup/rationale                  | Test comment specifics: **unspecified** in PEPs; apply general rules citeturn8view0      | Test method naming guidance exists; comment specifics largely **unspecified** citeturn17view2                               | `@bug` tag links tests to bugs; naming patterns documented citeturn23view0turn17view1                                                          | File comments mention test files; content guidance applies generally citeturn16view0                                                               | Examples extracted from `_test.go`; “useful test failures” guidance exists citeturn25view1turn12view2                        |
| Config files          | Use comment syntax supported by the format; keep comments short; put long docs elsewhere                      | N/A (format-specific)                                                                       | N/A (format-specific)                                                                                                          | N/A (format-specific)                                                                                                                              | N/A (format-specific)                                                                                                                                 | N/A (format-specific); note JSON vs YAML/TOML differences                                                                        |
| JSON/YAML/TOML config | Prefer YAML/TOML if you need native comments; JSON comments are non-standard                                  | JSON whitespace grammar excludes comments (inference) citeturn19view0                    | Same                                                                                                                           | Same                                                                                                                                               | Same                                                                                                                                                  | Same; YAML supports `#` comments citeturn21view1; TOML uses `#` comments citeturn21view2                                   |
| Licensing             | Prefer SPDX single-line identifiers near top for concise, machine-readable license                            | `# SPDX-License-Identifier: ...`                                                            | `// SPDX-License-Identifier: ...`                                                                                              | `// SPDX-License-Identifier: ...`                                                                                                                  | `//` or `/* ... */`                                                                                                                                   | `// SPDX-License-Identifier: ...` citeturn21view3turn21view4                                                                 |

**Notes on “unspecified”:** Items marked unspecified are not concretely mandated in the cited primary sources; where needed, they should be standardized at the project level and enforced via tooling. citeturn23view0turn8view0turn11view0

## Related

* [[V2 App/Planning/Planning Index]] | [Planning Index](Planning%20Index.md)
* [[V2 App/V2 App Documentation Map]] | [V2 App Documentation Map](../V2%20App%20Documentation%20Map.md)
* [[Standards/Commenting Standards]] | [Commenting Standards](../../Standards/Commenting%20Standards.md)
* [[Documentation Standards/Modern Commenting Standards Research]] | [Modern Commenting Standards Research](../../Documentation%20Standards/Modern%20Commenting%20Standards%20Research.md)
