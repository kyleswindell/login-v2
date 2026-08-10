---
name: login2-file-implementation
description: Create or materially reshape Login 2.0 source files from approved file archetypes, repository stubs, Laravel generators, or project-owned generators. Use for PHP, Laravel framework, database, test, Blade, CSS, JavaScript, and UI component-bundle files after ownership and behavior are defined. Do not use to invent architecture, schema, permissions, transactions, product behavior, or visual design.
---

# Login 2.0 File Implementation

## Purpose

Create valid Login 2.0 files from approved archetypes and source templates while preserving ownership, placeholder, commenting, testing, and generated-output standards.

This skill governs mechanical file construction.

It does not select product behavior or resolve architecture, schema, security, transaction, or visual-design decisions.

Use this skill:

- inside `login2-implementation-slice` when the broader issue requires new files
- directly when the authorized task is limited to file creation or file-shape normalization

## Use This Skill When

Use this skill for:

- creating an application action
- creating a service
- creating a query object
- creating a DTO
- creating a page-data object
- creating a value object
- creating an enum
- creating a result object
- creating an application exception
- creating Laravel framework-bound files
- creating migrations, factories, or seeders from approved contracts
- creating feature, unit, authorization, query, job, migration, or browser tests
- creating Blade, CSS, or JavaScript UI files
- creating an approved UI component bundle
- materially reshaping an existing file to an approved archetype
- testing or changing a file generator
- promoting an approved Laravel framework stub to an active override when explicitly authorized

## Do Not Use This Skill When

Do not use this skill to:

- decide the owner layer
- invent a new architecture
- choose a database schema
- choose permissions or policy rules
- design transaction boundaries
- choose retry or idempotency behavior
- design a UI
- invent component props, variants, or states
- create speculative repositories, managers, helpers, utilities, observers, or traits
- activate every published Laravel stub
- overwrite existing files without explicit authorization
- create a new template manifest without a generator consumer
- perform unrelated cleanup

Resolve those decisions in the work packet and canonical owner documents first.

## Required Inputs

Before creating files, obtain:

- issue or task identifier
- owner layer
- specific owner
- approved destination path
- file archetype
- required behavior or public contract
- applicable canonical standards
- applicable source template or generator
- placeholder values
- compatibility requirements
- required tests
- required verification
- optional files that must be omitted
- overwrite or force authorization, when applicable

For a multi-file bundle, obtain the complete path and naming map before generation.

## Canonical Sources

Read:

- repository-root and nearest applicable `AGENTS.md`
- `docs/02-standards/coding/File Building Standards.md`
- `docs/02-standards/coding/File Archetypes.md`
- `docs/02-standards/coding/Code Template And Generator Standards.md`
- `docs/02-standards/coding/Commenting Standards.md`
- `docs/02-standards/coding/PHP And Laravel Style Standards.md`
- `docs/02-standards/coding/test-implementation/index.md`
- `docs/02-standards/testing/index.md`
- `stubs/README.md`
- `stubs/AGENTS.md`

Read specialized database, security, UI, queue, transaction, query, or documentation standards when they govern the generated file.

## Procedure

### 1. Confirm The File Owner

For each file, record:

- owner layer
- specific owner
- final destination
- primary responsibility

Use the accepted owner-first model:

- Core capability → owner-specific Core placement, currently `app/Core/*`
- Module → `Modules/*`
- UI → `resources/views/components/*`, `resources/css/*`, `resources/js/*`
- Laravel integration → the applicable framework integration location
- Source templates → `stubs/*`
- Database implementation → `database/*`
- Tests → `tests/*`
- Documentation → `docs/*`

Classify the file's technical responsibility separately, such as Surface, Delivery Adapter, Registry, Action, Query, or Contract. A Surface is an owner-specific UI presentation and interaction layer, not an application owner. Existing `app/Platform/*` paths are transitional current placement only, establish no target ownership, and must not receive new canonical work unless a bounded Goal 3 decision explicitly authorizes it.

Do not generate into a future candidate directory unless the issue explicitly approves that owner.

Stop when destination ownership is unclear.

### 2. Confirm The Archetype

Classify each file using:

- `docs/02-standards/coding/File Archetypes.md`

For each archetype, confirm:

- allowed responsibility
- forbidden responsibility
- expected dependencies
- expected public shape
- expected tests
- applicable header policy

Do not choose an archetype because a stub exists.

Choose the archetype from the responsibility, then select the matching stub.

Stop when a file has multiple competing primary responsibilities.

### 3. Select The Generation Method

Use this priority:

1. approved project-owned generator
2. real Laravel generator using an explicitly active root override
3. approved categorized source template under `stubs/`
4. direct file creation when no approved template applies

#### Project-Owned Generator

Use when an approved command exists for the archetype or bundle.

Prefer dry-run or preview behavior when available.

Confirm:

- required arguments
- optional arguments
- destination
- overwrite protection
- generated file inventory

#### Laravel Generator

Use the real Artisan generator when the issue expects Laravel-generated behavior.

Confirm:

- installed Laravel version
- generator command
- expected root stub filename
- supported placeholders
- active override status

Do not assume a file under `stubs/framework/` is automatically consumed by Laravel.

#### Categorized Source Template

Files under these paths are reviewed source templates:

- `stubs/framework/`
- `stubs/archetypes/`
- `stubs/tests/`
- `stubs/ui/`

Copy or consume the selected template through an approved project mechanism.

#### Direct Creation

Create the file directly when:

- no approved stub matches
- the archetype is valid
- the final shape is established
- using an existing stub would require replacing most of it

Do not create a new repository stub unless the task explicitly includes template-system maintenance.

### 4. Inspect The Selected Stub

Before generation, confirm:

- the stub exists
- the stub matches the intended archetype
- the stub is current
- the stub contains no deprecated owner assumptions
- the stub contains no obsolete UI Reference or `reference.php` requirement
- its placeholder syntax is understood
- optional content can be safely removed
- generated imports will be valid
- generated comments will remain relevant

For Laravel stubs, inspect the installed generator when placeholder support matters.

Do not add unsupported placeholders to an active Laravel override.

### 5. Build The File Map

Before writing, list every output file.

For each file, record:

| Field           | Required Value                                  |
| --------------- | ----------------------------------------------- |
| Archetype       | Approved file category                          |
| Stub            | Source stub or generator                        |
| Destination     | Repository-relative final path                  |
| Namespace       | Final PHP namespace when applicable             |
| Class or symbol | Final class, enum, function, or initializer     |
| Owner           | Specific capability, module, component, or tool |
| Optional        | Whether the file may be omitted                 |
| Tests           | Test owner and expected coverage                |
| Docs            | Contract or documentation owner                 |

For UI bundles, align:

- component slug
- human-readable label
- Blade path
- contract path
- CSS path
- optional JavaScript path
- test path
- documentation path
- initializer name
- required classes
- required data attributes

Do not generate a JavaScript file for a non-interactive component.

### 6. Define Placeholder Values

Inventory every placeholder before generation.

Project-owned placeholders use:

    {{ placeholderName }}

Common values include:

- `{{ namespace }}`
- `{{ class }}`
- `{{ path }}`
- `{{ purpose }}`
- `{{ component }}`
- `{{ label }}`
- `{{ initializer }}`
- `{{ bladePath }}`
- `{{ cssPath }}`
- `{{ jsPath }}`
- `{{ contractPath }}`
- `{{ docsPath }}`
- `{{ usageContext }}`

Confirm:

- each required placeholder has one value
- values are consistent across a bundle
- namespaces match destinations
- component slugs use kebab case
- JavaScript initializers are valid identifiers
- paths remain inside approved repository roots
- no sensitive values are used

Do not leave placeholder replacement until after unrelated implementation begins.

### 7. Check Destination Safety

Before writing:

- inspect whether each destination exists
- inspect parent directory instructions
- confirm required directories
- confirm another task does not own the file
- confirm the worktree is safe
- confirm overwrite behavior

Do not overwrite an existing file unless:

- the task explicitly authorizes replacement
- the current file was inspected
- compatibility impact is understood
- force behavior is intentional

Stop when an existing file conflicts with the planned output.

### 8. Preview The Output

Use generator dry-run behavior when available.

For manual copying, prepare the complete replacement map before saving.

Confirm the preview will not create:

- wrong namespaces
- wrong owner paths
- empty imports
- malformed syntax
- fake optional files
- contradictory component metadata
- permissive authorization
- exposed model fields
- invented schema or business behavior

### 9. Generate Or Copy The Files

Generate only the approved file set.

Do not create:

- deferred files
- optional JavaScript for static UI
- speculative interfaces
- empty repository classes
- extra tests unrelated to the contract
- future registry files
- future database tables
- compatibility aliases not required by the issue

Report every created, skipped, or failed file when using a generator.

### 10. Complete The Generated Source

A copied stub is not a completed source file.

For every generated file:

1. replace all placeholders
2. remove non-applicable scaffold
3. remove unused imports
4. add actual native types
5. add actual dependencies
6. implement only accepted behavior
7. add explicit validation
8. add explicit authorization where required
9. add real failure behavior
10. update generated comments
11. retain required file headers
12. remove template instructions that do not belong in final source

Do not leave:

- empty public methods without an intentional contract
- fake return values
- permissive policy results
- permissive Form Request authorization
- exposed generic resources
- placeholder migrations
- meaningless assertions
- required `markTestIncomplete()` calls
- speculative comments

### 11. Apply Language-Specific Rules

#### PHP

New PHP source must normally include:

    <?php

    declare(strict_types=1);

Use:

- explicit native types
- `final` when extension is not intended
- `readonly` for valid immutable data objects
- constructor injection where appropriate
- PHPDoc only when native types are insufficient

Do not add broad PHP file headers by default.

#### Blade

Use the approved Blade header.

Keep:

- queries out of views
- authorization decisions out of views
- domain mutations out of views
- attribute forwarding intentional
- native semantics intact
- public props aligned with the contract

#### CSS

Use the approved CSS header and section structure.

Keep:

- selectors within the component owner
- primitive tokens out of component files
- theme role definitions out of component files
- values token-first
- variants and states contract-approved
- reduced-motion and forced-colors behavior intentional

#### JavaScript

Use the approved JavaScript header.

Keep:

- initialization idempotent
- selectors aligned with Blade data attributes
- behavior component-owned
- authorization and business logic server-owned
- event handling bounded to the component root

#### Tests

Use explicit observable assertions.

Remove inapplicable scaffold tests.

Replace required incomplete markers before the implementation is considered complete.

### 12. Synchronize Bundled Files

For multi-file output, compare the bundle after implementation.

Confirm matching:

- names
- slugs
- paths
- classes
- data attributes
- props
- variants
- states
- JavaScript initializer
- test expectations
- source arrays
- documentation references

A bundle is invalid when one file describes a different public contract than another.

### 13. Scan For Unresolved Placeholders

Run against every generated destination:

    rg -n "\{\{[^}]+\}\}" <generated-path>

Also inspect for other known scaffold markers, including:

- `TODO`
- `FIXME`
- `markTestIncomplete`
- `Describe the`
- `Add source-proven`
- `Needs confirmation`
- empty placeholder comments
- fake example values

An unresolved template token is a generation failure.

A scaffold marker may remain only when the task explicitly creates a template rather than final application source.

### 14. Validate Generated Output

Validate rendered output, not only the `.stub` source.

Run applicable checks.

#### PHP

    php -l <generated-file>

    vendor/bin/pint --test <generated-file>

    php artisan test --filter=<target>

#### Blade, CSS, And JavaScript

    npm run build

    php artisan test --filter=<target>

Run Playwright when installed browser behavior changes.

#### Database

Use PostgreSQL-backed verification when schema, indexes, constraints, locking, transaction behavior, or SQL semantics matter.

#### Templates And Generators

Test:

- expected output paths
- placeholder replacement
- optional-file omission
- overwrite protection
- invalid input
- deterministic output
- generated PHP syntax
- bundle consistency

Do not claim validation passed unless the command ran successfully.

### 15. Inspect The Diff

Inspect:

    git status --short

Review the complete diff.

Confirm:

- only approved outputs were created
- only intended files changed
- no unrelated formatting occurred
- no placeholders remain
- no secrets are present
- no deprecated system assumptions remain
- comments match final behavior
- generated headers contain correct paths
- test files target real behavior
- optional files were omitted correctly
- bundle metadata is consistent

Do not stage, commit, push, or alter issue state unless explicitly authorized.

### 16. Report The Result

Use this report structure:

## File Implementation Result

- Issue or task:
- Owner:
- Archetypes:
- Generation method:

## File Map

- Created:
- Modified:
- Skipped:
- Replaced:

## Templates And Placeholders

- Stubs or generators used:
- Placeholder values applied:
- Optional files omitted:
- Unresolved-placeholder scan:

## Validation

- Commands run:
- Results:
- Checks not run:

## Review

- Contract alignment:
- Documentation updated:
- Manual review required:
- Specialist review required:
- Known gaps:

## Stop Conditions

Stop before writing or continuing when:

- ownership is unclear
- the archetype is unclear
- the destination is unclear
- no approved behavior contract exists
- a stub conflicts with current standards
- a Laravel placeholder is unsupported
- a required placeholder value is missing
- a destination file exists without replacement authorization
- namespace and path disagree
- bundle paths or identities conflict
- schema behavior is unresolved
- authorization behavior is unresolved
- transaction behavior is unresolved
- retry or idempotency behavior is unresolved
- sensitive-data handling is unresolved
- UI design or public API is unspecified
- the task would activate a framework override without explicit approval
- generation would require speculative files
- another writer owns the destination
- generated output cannot be validated

When stopping, report:

- affected file
- selected archetype or candidate archetypes
- exact missing or conflicting input
- canonical owner that must resolve it
- minimum information required to continue
