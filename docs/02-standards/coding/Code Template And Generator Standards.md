<!--
DOC-META
title: Code Template And Generator Standards
doc_type: standard
status: active
owner: architecture
canonical: true
canonical_path: docs/02-standards/coding/Code Template And Generator Standards.md
parent: docs/02-standards/coding/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines repository-owned source templates, placeholder rules, generator behavior, framework overrides, generated-output validation, and template maintenance.
-->

# Code Template And Generator Standards

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
- [3. Related Standards](#3-related-standards)
- [4. Terminology](#4-terminology)
  - [4.1. Stub](#41-stub)
  - [4.2. Reviewed Source Template](#42-reviewed-source-template)
  - [4.3. Active Framework Override](#43-active-framework-override)
  - [4.4. Project-Owned Generator](#44-project-owned-generator)
  - [4.5. Bundle](#45-bundle)
  - [4.6. Generated Output](#46-generated-output)
- [5. Source Of Truth](#5-source-of-truth)
- [6. Directory Ownership](#6-directory-ownership)
  - [6.1. `stubs/framework/`](#61-stubsframework)
  - [6.2. `stubs/archetypes/`](#62-stubsarchetypes)
  - [6.3. `stubs/tests/`](#63-stubstests)
  - [6.4. `stubs/ui/`](#64-stubsui)
  - [6.5. Documentation Templates](#65-documentation-templates)
- [7. When To Use A Stub](#7-when-to-use-a-stub)
- [8. Requirements For Every Stub](#8-requirements-for-every-stub)
- [9. Minimal Template Rule](#9-minimal-template-rule)
- [10. Placeholder Standard](#10-placeholder-standard)
  - [10.1. Syntax](#101-syntax)
  - [10.2. Required And Optional Placeholders](#102-required-and-optional-placeholders)
  - [10.3. Framework-Owned Placeholders](#103-framework-owned-placeholders)
  - [10.4. Project-Owned Placeholder Replacement](#104-project-owned-placeholder-replacement)
  - [10.5. Unresolved Placeholders](#105-unresolved-placeholders)
  - [10.6. Sensitive Values](#106-sensitive-values)
- [11. PHP Template Requirements](#11-php-template-requirements)
- [12. Safe Default Requirements](#12-safe-default-requirements)
- [13. Comment And Header Requirements](#13-comment-and-header-requirements)
  - [13.1. PHP Files](#131-php-files)
  - [13.2. Blade, CSS, And UI JavaScript](#132-blade-css-and-ui-javascript)
  - [13.3. Documentation](#133-documentation)
- [14. Test Template Requirements](#14-test-template-requirements)
- [15. UI Bundle Requirements](#15-ui-bundle-requirements)
- [16. Active Laravel Overrides](#16-active-laravel-overrides)
  - [16.1. Promotion Process](#161-promotion-process)
- [17. Custom Generator Requirements](#17-custom-generator-requirements)
- [18. File And Namespace Validation](#18-file-and-namespace-validation)
- [19. Generated Output Workflow](#19-generated-output-workflow)
- [20. Validation Requirements](#20-validation-requirements)
  - [20.1. PHP Output](#201-php-output)
  - [20.2. Blade, CSS, And JavaScript Output](#202-blade-css-and-javascript-output)
  - [20.3. Database Output](#203-database-output)
  - [20.4. UI Output](#204-ui-output)
- [21. Automated Template Testing](#21-automated-template-testing)
- [22. Maintenance](#22-maintenance)
  - [22.1. Framework Upgrades](#221-framework-upgrades)
- [23. Adding A New Stub](#23-adding-a-new-stub)
- [24. Changing A Stub](#24-changing-a-stub)
- [25. Removing Or Deprecating A Stub](#25-removing-or-deprecating-a-stub)
- [26. Prohibited Practices](#26-prohibited-practices)
- [27. Completion Criteria](#27-completion-criteria)

## 1. Purpose

This standard defines how Login 2.0 creates, owns, consumes, validates, and maintains reusable source-file templates.

Repository-owned templates exist to make repeated file creation more consistent and efficient. They provide approved mechanical structure while preserving the requirement to make deliberate architecture, security, data, accessibility, and business decisions for each generated file.

A generated file is scaffolding. Generation does not establish that the file is correctly designed, fully implemented, tested, or approved.

## 2. Scope

This standard applies to:

- files under `stubs/`
- Laravel framework stub overrides
- project-owned source templates
- custom Artisan generators
- multi-file bundle generators
- placeholder definitions and replacement
- generated source validation
- template lifecycle and maintenance
- comments and headers emitted by templates

Documentation templates under `docs/09-reference/templates/` follow the documentation standards and are not owned by `stubs/`.

## 3. Related Standards

Apply this standard together with:

- [Coding Standards](Coding%20Standards.md)
- [Commenting Standards](Commenting%20Standards.md)
- [File Building Standards](File%20Building%20Standards.md)
- [File Archetypes](File%20Archetypes.md)
- [PHP And Laravel Style Standards](PHP%20And%20Laravel%20Style%20Standards.md)
- [Application Actions Services And Data Objects Standards](Application%20Actions%20Services%20And%20Data%20Objects%20Standards.md)
- [Error And Exception Handling Standards](Error%20And%20Exception%20Handling%20Standards.md)
- [Events Jobs And Queue Standards](Events%20Jobs%20And%20Queue%20Standards.md)
- [Test Implementation Standards Index](test-implementation/index.md)
- [Agent Implementation Checklist](Agent%20Implementation%20Checklist.md)
- [Stub Templates README](../../../stubs/README.md)
- [Stub Template Agent Guidance](../../../stubs/AGENTS.md)

Specialized database, security, logging, and UI standards continue to govern generated files within those areas.

## 4. Terminology

### 4.1. Stub

A reusable text template from which a source file is created.

Stub files normally use the `.stub` extension and may contain placeholders that must be replaced before the generated file is valid.

### 4.2. Reviewed Source Template

A categorized template stored under a subdirectory such as:

    stubs/framework/
    stubs/archetypes/
    stubs/tests/
    stubs/ui/

Reviewed source templates are project-owned reference and generation sources. Laravel does not automatically consume them merely because they exist under `stubs/`.

### 4.3. Active Framework Override

A stub placed at the exact root-level path expected by an installed Laravel generator, such as:

    stubs/controller.plain.stub
    stubs/request.stub
    stubs/job.queued.stub

An active framework override changes the output of the corresponding Laravel `make:*` command.

### 4.4. Project-Owned Generator

A repository-owned command or tool that reads one or more project templates, replaces declared placeholders, and writes files to validated destinations.

### 4.5. Bundle

A coordinated group of templates that generates multiple related files for one implementation owner.

The UI component bundle is an example because a component may own Blade, contract, CSS, optional JavaScript, and test files.

### 4.6. Generated Output

The final source file produced after all placeholders are replaced and optional template sections are resolved.

Validation requirements apply to generated output, not only to the `.stub` source.

## 5. Source Of Truth

Canonical standards define the required behavior and structure of generated files.

The ownership model is:

| Source                   | Responsibility                             |
| ------------------------ | ------------------------------------------ |
| This standard            | Canonical template and generator policy    |
| Other coding standards   | Archetype-specific implementation rules    |
| `stubs/README.md`        | Current template inventory and human usage |
| `stubs/AGENTS.md`        | Scoped agent execution rules               |
| Individual `.stub` files | Template implementation                    |
| Custom generators        | Placeholder replacement and file creation  |
| Generated source files   | Final implementation responsibility        |

A README, agent file, stub, or generator must not silently redefine a canonical coding standard.

## 6. Directory Ownership

The approved template structure is:

    stubs/
    ├── AGENTS.md
    ├── README.md
    ├── framework/
    ├── archetypes/
    ├── tests/
    └── ui/
        └── component-bundle/

### 6.1. `stubs/framework/`

Contains reviewed source versions of Laravel-compatible templates.

These files may be:

- reviewed before adopting a framework override
- copied manually
- consumed by project tooling
- compared against installed Laravel defaults
- promoted to root-level overrides when justified

Files in this directory are not active Laravel overrides.

### 6.2. `stubs/archetypes/`

Contains project-owned PHP archetypes that Laravel does not generate natively.

These templates provide starting structures for approved file categories such as:

- actions
- services
- queries
- DTOs
- page-data objects
- value objects
- enums
- result objects
- application exceptions

The file responsibility determines the archetype. The existence of a stub does not make that archetype appropriate.

### 6.3. `stubs/tests/`

Contains test archetypes for repeated behavioral categories.

Test templates may establish expected coverage categories, but they must not invent passing behavior or use meaningless assertions.

### 6.4. `stubs/ui/`

Contains mechanical templates for Blade, CSS, JavaScript controls, and coordinated UI component bundles.

UI templates must not independently choose:

- visual hierarchy
- spacing
- variants
- states
- public props
- semantic elements
- accessibility behavior
- interaction rules
- responsive behavior

Those decisions must come from approved requirements, current source evidence, UI standards, and manual review.

### 6.5. Documentation Templates

Documentation templates belong under:

    docs/09-reference/templates/

Do not place canonical documentation templates under `stubs/`.

Documentation templates must follow the documentation metadata and governance standards.

## 7. When To Use A Stub

Use an approved stub when:

- the destination file has a recognized archetype
- the template reflects current project standards
- the template matches the intended responsibility
- the generated structure reduces repetitive mechanical work
- the file will be completed and reviewed after generation

Do not force an implementation into an unsuitable template.

Create a file directly when:

- no approved archetype applies
- the responsibility is novel
- the required framework shape materially differs from the available template
- using a template would require deleting or rewriting most of its structure

A repeated source shape may justify a new stub only after the responsibility and structure are understood.

## 8. Requirements For Every Stub

Every repository-owned stub must:

- have one clear generated-file responsibility
- generate syntactically valid output after replacement
- reflect an approved file archetype
- remain as small as practical
- use current project conventions
- use stable and documented placeholders
- avoid unresolved placeholder output
- avoid invented business behavior
- avoid speculative abstractions
- avoid unnecessary imports and methods
- avoid unsafe permissive defaults
- avoid comments that become inaccurate after generation
- be represented accurately in `stubs/README.md`
- be validated through at least one representative generated file

A stub must not become a catalog of every optional method or behavior that a file could eventually need.

## 9. Minimal Template Rule

Templates should establish only the structure shared by nearly every valid implementation of that archetype.

A generic stub must not prescribe feature-specific decisions such as:

- business inputs
- database columns
- tenant or workspace scope
- queue names
- retry counts
- timeout values
- backoff behavior
- authorization permissions
- event payloads
- API response fields
- UI variants
- UI state precedence
- page content
- specific dependencies

Those decisions belong in the generated implementation.

## 10. Placeholder Standard

### 10.1. Syntax

Project-owned placeholders use double braces:

    {{ placeholderName }}

Placeholder names must:

- use camel case
- describe the replacement value
- remain consistent across related templates
- avoid abbreviations unless the abbreviation is established project vocabulary

Examples include:

    {{ namespace }}
    {{ class }}
    {{ path }}
    {{ purpose }}
    {{ component }}
    {{ label }}
    {{ initializer }}
    {{ bladePath }}
    {{ cssPath }}
    {{ jsPath }}
    {{ contractPath }}
    {{ docsPath }}

### 10.2. Required And Optional Placeholders

A generator must explicitly distinguish required and optional values.

Required placeholders must cause generation to fail when a valid replacement is not supplied.

Optional values must not leave malformed code, empty imports, invalid commas, fake paths, or unresolved comments when omitted.

For bundle generation, optional files should normally be omitted rather than generated with false requirements.

For example, a non-interactive UI component must not receive a JavaScript file solely because an interactive component bundle supports one.

### 10.3. Framework-Owned Placeholders

Laravel framework placeholders are specific to their corresponding generators.

A placeholder supported by one Laravel command must not be assumed to work in another command.

Root-level active Laravel overrides may use only placeholders that the installed generator replaces.

Before modifying a framework stub:

1. inspect the installed generator
2. confirm the expected stub filename
3. confirm the supported placeholders
4. generate a representative file using the real command

### 10.4. Project-Owned Placeholder Replacement

A project-owned generator must define every placeholder it supports.

It must not rely on undocumented string replacement behavior.

Replacement must be deterministic and must not depend on unrelated environment state.

### 10.5. Unresolved Placeholders

Generated output must not contain unresolved template tokens.

Search generated paths with:

    rg -n "\{\{[^}]+\}\}" <generated-path>

Any unresolved placeholder is a generation failure.

Placeholder-like syntax intentionally required by the generated language must be escaped or handled explicitly by the generator.

### 10.6. Sensitive Values

Do not place secrets, credentials, access tokens, private keys, or environment-specific sensitive values in templates or generator arguments.

Generated source must use approved configuration access patterns.

## 11. PHP Template Requirements

Project-owned PHP stubs must begin with:

    <?php

    declare(strict_types=1);

Use native parameter, property, and return types wherever possible.

Use `final` by default when extension is not part of the contract.

Use `readonly` for immutable data objects when the complete object can validly remain readonly.

Do not use `final` when inheritance, framework proxying, or intentional extension is part of the file’s contract.

Templates must not generate:

- service-container lookups when constructor injection is appropriate
- raw request data passed directly into model mass assignment
- calls to `env()` outside configuration files
- generic mixed return values without a real need
- broad exception swallowing
- placeholder business logic
- placeholder persistence operations
- unnecessary empty constructors
- PHPDoc that merely repeats native types

PHPDoc may be generated when it expresses:

- generic collection types
- array shapes
- callback signatures
- framework-required static-analysis contracts
- behavior that cannot be expressed through native types

## 12. Safe Default Requirements

Templates must use conservative defaults where generated code controls access, exposure, or durable effects.

Examples include:

- Form Requests deny authorization until implemented.
- Policies deny actions until implemented.
- API resources expose no model fields until explicitly selected.
- Jobs do not invent retry, timeout, uniqueness, or queue behavior.
- Migrations do not invent tenancy, retention, classification, or audit columns.
- Controllers do not contain placeholder mutations.
- Events do not broadcast unless broadcasting is intentionally required.
- UI components do not expose undocumented props or arbitrary behavior.

A permissive default must be justified by the archetype’s established contract.

## 13. Comment And Header Requirements

Comments generated by stubs must follow [Commenting Standards](Commenting%20Standards.md).

Generated comments must:

- remain useful in the final file
- explain durable intent or constraints
- avoid repeating obvious syntax
- avoid placeholder instructions in completed implementations
- be removed when they do not apply
- be updated when ownership or behavior changes

### 13.1. PHP Files

Do not generate broad file headers for ordinary PHP classes, migrations, factories, seeders, or tests by default.

PHP files should identify themselves through their namespace, type name, native types, and focused responsibility.

### 13.2. Blade, CSS, And UI JavaScript

UI stubs may generate the repository-required file header.

Headers may identify:

- repository-relative file path
- file purpose
- component or behavior owner
- related implementation files
- stable implementation constraints

Do not include:

- author names
- creation dates
- modified dates
- embedded changelogs
- temporary task references
- obsolete system ownership

### 13.3. Documentation

Documentation metadata is governed by the documentation standards and templates.

Do not use UI or source-code header formats as replacements for `DOC-META`.

## 14. Test Template Requirements

Test stubs must promote observable behavior rather than scaffold-only completion.

A test template may use `markTestIncomplete()` when the final assertion cannot be meaningful until the generated file is customized.

Incomplete markers are scaffolding and do not count as coverage.

A completed generated test must not contain:

- unresolved placeholders
- required `markTestIncomplete()` calls
- `assertTrue(true)` or equivalent unconditional assertions
- undefined fixtures
- copied tests unrelated to the implementation
- broad snapshots used instead of explicit contract assertions
- database assumptions that conflict with PostgreSQL behavior

Remove scaffolded tests that do not apply.

Replace applicable incomplete tests with focused assertions.

UI component tests should generally separate:

- PHP tests for server-rendered Blade markup and contract alignment
- Playwright tests for installed browser interaction
- manual visual review for design-sensitive output

## 15. UI Bundle Requirements

A UI component bundle may generate:

    index.blade.php
    contract.php
    component.css
    component test
    component.js

The JavaScript file is optional.

A component with no installed browser behavior must not generate `component.js`.

The current UI bundle must not generate deprecated UI Reference files or `reference.php`.

Rendered evidence, examples, or showcase templates may be introduced only when a current canonical system defines their ownership and structure.

All generated bundle files must agree on:

- component slug
- component label
- public component tag
- Blade path
- contract path
- CSS path
- optional JavaScript path
- test path
- documentation path
- required classes
- required data attributes
- initializer name when JavaScript exists

A generator must fail rather than knowingly create contradictory bundle metadata.

## 16. Active Laravel Overrides

A framework source template must not become an active override merely because Laravel supports stub publishing.

Do not publish and commit every available Laravel stub by default.

Promote a reviewed framework template to the root of `stubs/` only when:

- the generator is used regularly
- the default output materially conflicts with project standards
- the override provides a recurring benefit
- the expected root filename is confirmed
- supported placeholders are confirmed
- the generated result has been validated
- the project is willing to maintain the override across framework upgrades

### 16.1. Promotion Process

Before activating a framework override:

1. Confirm the installed Laravel version.
2. Inspect the installed generator implementation.
3. Inspect the installed upstream stub.
4. Compare it with the reviewed project template.
5. Confirm the exact root-level filename.
6. Generate a representative file with the real Artisan command.
7. Validate and format the output.
8. Record the active override in `stubs/README.md`.
9. Add or update automated generator coverage when practical.

When both a reviewed source and active root override are retained, update them together and keep them equivalent unless their differing purposes are explicitly documented.

## 17. Custom Generator Requirements

Create a custom generator only when repeated manual template use has demonstrated a stable need.

A custom generator must:

- identify its template source explicitly
- define all required inputs
- define all optional inputs
- validate names and destination paths
- normalize namespaces and filenames consistently
- replace every declared placeholder
- reject unresolved placeholders
- create required directories safely
- avoid overwriting existing files by default
- require explicit force behavior for replacement
- report every created, skipped, or failed file
- omit optional files when not required
- produce deterministic output from the same inputs
- return a non-zero exit status on failure
- be covered by representative automated tests

A generator should also support a preview or dry-run mode when it creates several files or performs consequential path decisions.

Generators must not:

- infer business rules from names
- silently select permissions
- invent schema columns
- silently overwrite files
- generate inaccessible or unregistered UI behavior
- produce incomplete bundles without reporting them
- modify unrelated files without explicit scope

## 18. File And Namespace Validation

Generators must validate that:

- PHP class names are valid
- namespaces match destination ownership
- filenames match project conventions
- UI component slugs are valid kebab case
- JavaScript initializer names are valid identifiers
- generated paths stay inside approved repository roots
- relative paths do not escape the repository through traversal
- destination files do not already exist unless force behavior is explicit

Generated ownership must follow the owner-first architecture model:

- Core capability → owner-specific Core placement, currently `app/Core/*`
- Module → `Modules/*`
- UI → `resources/views/components/*`, `resources/css/*`, and `resources/js/*`
- Laravel integration → the applicable framework integration location

Generators must classify Surface, Delivery Adapter, Registry, Action, Query, Contract, and similar technical responsibilities separately beneath the selected owner. They must not target `app/Platform/*`; that path is transitional current placement only and establishes no target ownership.

A generator must not use convenience as justification for placing files in the wrong architectural owner.

## 19. Generated Output Workflow

After copying or generating a file:

1. Replace every required placeholder.
2. Remove optional sections that do not apply.
3. Add the actual dependencies and native types.
4. Add the real application or UI contract.
5. Implement authorization and validation.
6. Implement failure handling.
7. Remove scaffold-only comments.
8. Confirm no template tokens remain.
9. Format the generated files.
10. Run the applicable tests and builds.
11. Perform required manual review.
12. Update related contracts and documentation.

Do not consider a file complete merely because it parses.

## 20. Validation Requirements

Validation must be performed against representative generated output.

### 20.1. PHP Output

Run the applicable checks:

    php -l <generated-file>
    vendor/bin/pint --test <generated-file>
    php artisan test

For framework overrides, generate through the actual Artisan command rather than validating only a manually substituted copy.

### 20.2. Blade, CSS, And JavaScript Output

Run the applicable checks:

    npm run build
    php artisan test

Run Playwright coverage when installed browser behavior changes.

### 20.3. Database Output

Database-related generated files must be validated against PostgreSQL where database behavior, constraints, indexes, locking, transactions, or SQL semantics matter.

SQLite-only success does not prove PostgreSQL correctness.

### 20.4. UI Output

Design-sensitive generated output requires manual review for applicable:

- light theme behavior
- dark theme behavior
- documented variants
- documented states
- keyboard operation
- visible focus
- accessible names and relationships
- responsive layouts
- reduced motion
- forced colors
- browser console errors

Generation cannot automate visual approval.

## 21. Automated Template Testing

Custom generators should have tests that confirm:

- expected files are created
- optional files are omitted correctly
- placeholders are fully replaced
- namespaces and class names are correct
- destination paths are correct
- existing files are protected
- force behavior is explicit
- invalid input fails safely
- generated PHP parses
- generated bundles contain aligned metadata

Active Laravel overrides should be exercised through their actual framework commands when feasible.

Template tests should use temporary destinations and must not alter real application files.

## 22. Maintenance

Templates must evolve with their governing standards.

Update affected stubs in the same change when modifying:

- file archetype rules
- PHP style requirements
- comment or header policy
- authorization defaults
- event or queue conventions
- database standards
- UI contract structure
- test conventions
- framework generator behavior

Do not knowingly leave a template generating code that violates current standards.

### 22.1. Framework Upgrades

Review active and reviewed framework stubs when upgrading:

- Laravel
- PHP
- PHPUnit
- Vite
- Playwright
- related generator-owning packages

The review must check:

- upstream filename changes
- placeholder changes
- new imports or traits
- changed method signatures
- changed framework conventions
- removed or deprecated generated behavior

A framework override is project-owned maintenance once activated.

## 23. Adding A New Stub

Before adding a stub:

1. Confirm the intended file has an approved responsibility.
2. Confirm an existing template cannot serve it.
3. Review representative current project files.
4. Review relevant standards.
5. Identify stable shared structure.
6. Remove feature-specific decisions.
7. Define and document placeholders.
8. Generate a representative output.
9. Validate that output.
10. Add the stub to `stubs/README.md`.
11. Update agent guidance only when execution rules change.

Do not create generic templates for speculative repositories, managers, helpers, utilities, observers, or traits without an approved archetype and repeated need.

## 24. Changing A Stub

A stub change must consider both future output and existing generator behavior.

Before changing a stub:

- identify all generators that consume it
- identify active root overrides derived from it
- review whether the change is backward compatible
- generate representative before-and-after output
- update tests and inventory
- update paired bundle templates when shared values change

Changing a stub does not automatically require rewriting every previously generated file. Existing files should be updated when the new rule reflects a required standard, security correction, or current implementation contract.

## 25. Removing Or Deprecating A Stub

Before removing a stub:

1. identify all scripts and generators that reference it
2. identify active root overrides derived from it
3. identify documentation links
4. determine whether a replacement exists
5. update the README inventory
6. update generator mappings
7. remove obsolete tests
8. confirm no removed system still depends on it

Do not preserve a template solely for a deprecated system when no active implementation consumes it.

When a replacement is required, document the replacement path before removal.

## 26. Prohibited Practices

Do not:

- treat generated code as reviewed code
- commit unresolved placeholders
- create templates for every possible class type
- copy third-party copyright headers into project-owned stubs
- embed secrets or environment-specific credentials
- generate permissive authorization by default
- expose complete models through generic resources
- generate raw request-to-model mass assignment
- invent tenant or workspace columns
- invent queue reliability settings
- generate non-idempotent retryable operations without explicit design
- generate UI JavaScript for non-interactive components
- generate deprecated UI Reference files
- maintain duplicate template inventories in multiple standards
- activate all published Laravel stubs without review
- allow generators to overwrite files silently
- add a machine-readable manifest without a real consumer
- use `git add .` when unrelated working-tree changes exist

## 27. Completion Criteria

A template or generator change is complete only when:

- the template has a distinct approved purpose
- its archetype is correct
- placeholders are documented
- representative output contains no unresolved placeholders
- generated output parses and formats correctly
- applicable tests and builds pass
- access and exposure defaults remain safe
- comments and headers follow current standards
- optional files are handled correctly
- the README inventory is accurate
- active overrides are documented
- paired templates remain aligned
- required manual review has been completed
