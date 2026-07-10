# Stub Templates

The `stubs/` directory contains reviewed source templates for generating consistent application files.

These templates standardize mechanical structure. They do not replace design, architecture, authorization, schema, accessibility, or business decisions.

Generated output must still be implemented, reviewed, formatted, tested, and approved.

Agent-specific rules for this directory are defined in [AGENTS.md](AGENTS.md).

- [1. Canonical Standards](#1-canonical-standards)
- [2. Directory Structure](#2-directory-structure)
- [3. Consumption Models](#3-consumption-models)
  - [3.1. Reviewed Source Template](#31-reviewed-source-template)
  - [3.2. Laravel Root Override](#32-laravel-root-override)
  - [3.3. Project-Owned Generator](#33-project-owned-generator)
- [4. Placeholder Convention](#4-placeholder-convention)
- [5. Framework Templates](#5-framework-templates)
- [6. Application Archetypes](#6-application-archetypes)
- [7. Test Templates](#7-test-templates)
- [8. UI Templates](#8-ui-templates)
- [9. UI Component Bundle](#9-ui-component-bundle)
- [10. Header Policy](#10-header-policy)
  - [10.1. PHP](#101-php)
  - [10.2. Blade, CSS, And UI JavaScript](#102-blade-css-and-ui-javascript)
  - [10.3. Documentation](#103-documentation)
- [11. Manual Use](#11-manual-use)
- [12. Validation](#12-validation)
  - [12.1. PHP](#121-php)
  - [12.2. Blade, CSS, And JavaScript](#122-blade-css-and-javascript)
  - [12.3. UI Review](#123-ui-review)
- [13. Adding A Stub](#13-adding-a-stub)
- [14. Removing Or Replacing A Stub](#14-removing-or-replacing-a-stub)
- [15. Active Design Decisions](#15-active-design-decisions)


## 1. Canonical Standards

Stub files implement the project’s canonical standards. They do not redefine them.

Relevant standards include:

- [Coding Standards](../docs/02-standards/coding/Coding%20Standards.md)
- [Commenting Standards](../docs/02-standards/coding/Commenting%20Standards.md)
- [File Building Standards](../docs/02-standards/coding/File%20Building%20Standards.md)
- [File Archetypes](../docs/02-standards/coding/File%20Archetypes.md)
- [PHP And Laravel Style Standards](../docs/02-standards/coding/PHP%20And%20Laravel%20Style%20Standards.md)
- [Testing Standards](../docs/02-standards/coding/Testing%20Standards.md)

When this README conflicts with a canonical standard, the canonical standard controls.

## 2. Directory Structure

    stubs/
    ├── AGENTS.md
    ├── README.md
    ├── framework/
    ├── archetypes/
    ├── tests/
    └── ui/
        └── component-bundle/

## 3. Consumption Models

There are three ways a stub may be consumed.

### 3.1. Reviewed Source Template

Files inside categorized folders such as `framework/`, `archetypes/`, `tests/`, and `ui/` are reviewed template sources.

They may be:

- copied manually
- consumed by a future project-owned generator
- used as reference when constructing a new file
- promoted to a framework-recognized override when justified

Laravel does not automatically consume nested files such as:

    stubs/framework/controller.plain.stub

### 3.2. Laravel Root Override

Laravel generators look for exact root-level stub filenames such as:

    stubs/controller.plain.stub
    stubs/request.stub
    stubs/job.queued.stub

A root-level framework stub overrides the corresponding Laravel generator template.

No framework template should be promoted to a root override without reviewing the installed Laravel generator and testing real generated output.

### 3.3. Project-Owned Generator

Project-owned generators may consume files from categorized folders and define additional placeholders.

A custom generator must:

- define every supported placeholder
- reject missing required values
- prevent unresolved placeholders
- validate destination paths
- avoid overwriting existing files without explicit approval
- omit optional bundle files when they are not required

A machine-readable manifest is intentionally deferred until a generator or validator has a real need for one.

## 4. Placeholder Convention

Project-owned placeholders use double braces and camel-case names:

    {{ placeholderName }}

Common placeholders include:

| Placeholder          | Purpose                                   |
| -------------------- | ----------------------------------------- |
| `{{ namespace }}`    | Generated PHP namespace                   |
| `{{ class }}`        | Generated PHP class, enum, or test name   |
| `{{ path }}`         | Repository-relative generated file path   |
| `{{ purpose }}`      | Concise file or component purpose         |
| `{{ component }}`    | Kebab-case UI component slug              |
| `{{ label }}`        | Human-readable component or control label |
| `{{ initializer }}`  | Exported JavaScript initializer name      |
| `{{ bladePath }}`    | Component Blade source path               |
| `{{ cssPath }}`      | Component CSS source path                 |
| `{{ jsPath }}`       | Component JavaScript source path          |
| `{{ contractPath }}` | Component contract path                   |
| `{{ docsPath }}`     | Canonical component documentation path    |
| `{{ usageContext }}` | Public API usage boundary                 |
| `{{ feature }}`      | Browser-test feature or surface name      |
| `{{ behavior }}`     | Browser-test observable behavior          |
| `{{ route }}`        | Browser-test route                        |
| `{{ selector }}`     | Browser-test stable selector              |

Laravel framework stubs also use generator-owned placeholders. Those placeholders are specific to the corresponding Laravel command and must not be assumed to work in project-owned generators.

Generated files must not contain unresolved placeholders.

Check rendered output with:

    rg -n "\{\{[^}]+\}\}" <generated-path>

## 5. Framework Templates

The `framework/` directory contains reviewed Laravel-compatible source templates.

| Stub                         | Purpose                          |
| ---------------------------- | -------------------------------- |
| `controller.plain.stub`      | Empty thin controller            |
| `request.stub`               | Fail-closed Form Request         |
| `middleware.stub`            | Request middleware               |
| `policy.stub`                | Fail-closed model policy         |
| `event.stub`                 | Non-broadcast application event  |
| `listener.typed.stub`        | Typed synchronous event listener |
| `listener.typed.queued.stub` | Typed queued event listener      |
| `job.stub`                   | Synchronous job                  |
| `job.queued.stub`            | Queued job                       |
| `console.stub`               | Artisan command                  |
| `resource.stub`              | Closed-by-default JSON resource  |
| `model.stub`                 | Eloquent model                   |
| `factory.stub`               | Eloquent model factory           |
| `seeder.stub`                | Database seeder                  |
| `migration.stub`             | General migration                |
| `migration.create.stub`      | Table-creation migration         |
| `migration.update.stub`      | Existing-table migration         |

These files are not active Laravel overrides while they remain inside `stubs/framework/`.

## 6. Application Archetypes

The `archetypes/` directory contains project-owned PHP file shapes.

| Stub                         | Purpose                                              |
| ---------------------------- | ---------------------------------------------------- |
| `action.stub`                | One focused application operation                    |
| `service.stub`               | Cohesive reusable application or integration service |
| `query.stub`                 | Encapsulated read operation                          |
| `dto.stub`                   | Immutable data transfer object                       |
| `page-data.stub`             | Immutable display-ready page data                    |
| `value-object.stub`          | Immutable validated domain value                     |
| `enum.stub`                  | Closed set of named values                           |
| `result.stub`                | Explicit operation result                            |
| `application-exception.stub` | Application-specific runtime exception               |

These templates deliberately avoid inventing constructor parameters, dependencies, return types, persistence behavior, or business rules.

The generated file must define its actual contract before use.

## 7. Test Templates

The `tests/` directory contains project-owned test archetypes.

| Stub                        | Purpose                                      |
| --------------------------- | -------------------------------------------- |
| `feature-test.stub`         | Laravel feature behavior                     |
| `unit-test.stub`            | Framework-independent isolated behavior      |
| `authorization-test.stub`   | Authentication and authorization boundaries  |
| `query-scope-test.stub`     | Data scope, exclusion, and ordering behavior |
| `job-idempotency-test.stub` | Durable job behavior and duplicate execution |
| `migration-smoke-test.stub` | PostgreSQL migration and schema contract     |
| `browser-test.stub`         | Playwright browser behavior                  |

Test templates may contain `markTestIncomplete()` where meaningful assertions require feature-specific implementation.

A generated test is not complete until applicable incomplete tests are replaced with real assertions or removed as inapplicable.

## 8. UI Templates

The `ui/` directory contains mechanical templates for UI implementation.

| Stub                      | Purpose                                 |
| ------------------------- | --------------------------------------- |
| `blade-url-view.stub`     | Thin authenticated URL view             |
| `css-component.stub`      | Component-owned CSS file                |
| `javascript-control.stub` | Idempotent installed JavaScript control |

UI templates include required file headers and structural section comments.

They must not independently invent:

- visual hierarchy
- spacing
- component variants
- component states
- public props
- accessibility behavior
- responsive behavior
- interaction rules

Those decisions require an approved component contract, current standards, and manual review.

## 9. UI Component Bundle

The `ui/component-bundle/` directory contains coordinated templates for creating a UI component family.

| Stub                      | Generated file                              |
| ------------------------- | ------------------------------------------- |
| `index.blade.php.stub`    | Component Blade implementation              |
| `contract.php.stub`       | Durable public component contract           |
| `component.css.stub`      | Component-owned CSS                         |
| `component.js.stub`       | Optional installed JavaScript behavior      |
| `component-test.php.stub` | Server-rendered component and contract test |

A non-interactive component should not generate `component.js`.

The current bundle does not include `reference.php`. The deprecated UI Reference system is not an active template owner.

Rendered example or showcase templates should be added only after a replacement documentation or evidence system defines a current canonical structure.

## 10. Header Policy

### 10.1. PHP

Generic PHP classes, migrations, seeders, factories, and tests do not receive broad file headers by default.

They identify themselves through:

- namespace
- class or enum name
- explicit native types
- focused responsibility
- useful PHPDoc where native types are insufficient

### 10.2. Blade, CSS, And UI JavaScript

UI templates include the repository-required file header.

Headers may identify:

- generated file path
- purpose
- component or behavior owner
- paired source files
- stable implementation constraints

Headers must not contain author names, creation dates, modified dates, or changelogs.

### 10.3. Documentation

Documentation templates are owned under `docs/09-reference/templates/`, not under `stubs/`.

Canonical documentation templates use the required `DOC-META` block.

## 11. Manual Use

To create a file manually from a stub:

1. Copy the closest matching `.stub` file to the correct destination.
2. Rename the copied file to its final filename.
3. Replace every `{{ ... }}` placeholder.
4. Remove methods, imports, tests, states, or optional files that do not apply.
5. Add the actual contract, dependencies, and behavior.
6. Confirm that no unresolved placeholders remain.
7. Format and validate the generated file.
8. Run the relevant tests.
9. Perform manual review where required.

Do not edit the generated file as though the stub itself were the final implementation contract.

## 12. Validation

Stub validation must use representative rendered output because unresolved placeholders may prevent the `.stub` file itself from parsing.

### 12.1. PHP

Run the applicable checks against the generated file:

    php -l <generated-file>
    vendor/bin/pint --test <generated-file>
    php artisan test

### 12.2. Blade, CSS, And JavaScript

Run the applicable checks:

    npm run build
    php artisan test

Run the configured Playwright tests when browser interaction changes.

### 12.3. UI Review

UI output also requires applicable manual checks, including:

- light theme
- dark theme
- keyboard behavior
- visible focus
- reduced motion
- forced colors where relevant
- supported responsive sizes
- documented variants and states
- browser console errors

## 13. Adding A Stub

Before adding a new stub:

1. Confirm that an existing template cannot serve the file.
2. Confirm that the file category is an approved archetype.
3. Review a current representative implementation.
4. Keep the template minimal.
5. Render and validate a representative output.
6. Add the file to the appropriate inventory table in this README.
7. Update `AGENTS.md` only when the directory’s execution rules change.

Do not create generic templates for speculative abstractions.

## 14. Removing Or Replacing A Stub

When removing or replacing a stub:

1. Check whether a generator consumes it.
2. Check whether documentation or scripts reference it.
3. Remove or update the corresponding README inventory entry.
4. Update generator mappings in the same change.
5. Confirm that no obsolete root-level override remains.
6. Preserve migration guidance when existing generated files still require it.

## 15. Active Design Decisions

The current stub system intentionally uses these constraints:

- categorized folders contain reviewed source templates
- Laravel root overrides are opt-in
- project-owned placeholders use `{{ camelCase }}`
- generated output may not contain unresolved placeholders
- PHP source uses strict types
- access and data exposure defaults remain closed
- UI JavaScript is optional
- UI JavaScript initialization is idempotent
- UI component contracts remain separate from rendered implementation
- the deprecated UI Reference system has no active stub
- no manifest is maintained until tooling consumes one