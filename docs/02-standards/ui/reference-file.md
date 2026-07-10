---
title: rendered evidence.php File
slug: ui-reference-file
status: current-standard
system_maturity: current-standard
api_layer: rendered evidence governance
canonical_doc: docs/02-standards/ui/reference-file.md
related_contract_standard: docs/02-standards/ui/contract-file.md
template: docs/09-reference/ui/ui-reference-template.php
---

# rendered evidence.php File

- [1. Purpose](#1-purpose)
- [2. File Convention](#2-file-convention)
- [3. Required Shape](#3-required-shape)
- [4. Section Responsibilities](#4-section-responsibilities)
- [5. Catalog Rules](#5-catalog-rules)
  - [Inventory status values](#inventory-status-values)
  - [Catalog badges](#catalog-badges)
- [6. Tabs And Content](#6-tabs-and-content)
- [7. Examples](#7-examples)
- [8. Relations And Children](#8-relations-and-children)
- [9. Layer Examples](#9-layer-examples)
  - [Top-level Component](#top-level-component)
  - [Child Component](#child-component)
  - [Pattern](#pattern)
  - [Element](#element)
- [10. Deprecated Reference Sources](#10-deprecated-reference-sources)
- [11. Related](#11-related)

## 1. Purpose

Owner-local `reference.php` files are rendered evidence display definitions for Foundation Elements, Components, and Patterns.

`contract.php` owns callable API, lifecycle, enforcement, class contracts, dependencies, source expectations, and review requirements. `reference.php` owns rendered evidence routing, visibility, overview cards, side navigation, tabs, rendered content, curated examples, owner/child placement, and catalog disposition.

A registered contract proves that a UI surface is tracked by the UI API system. It does not automatically create a visible rendered evidence page.

Every rendered evidence resolver must treat a missing `reference.php` file, or a `reference.php` file without an explicit page mode, as `inventory-only`. Nothing defaults to visible.

Fallback records must be shaped by the source registry that discovered them:

| Discovery source            | Fallback layer                                                   | Fallback base |
| --------------------------- | ---------------------------------------------------------------- | ------------- |
| Component contract registry | `component`                                                      | `components`  |
| Element inventory           | `element`                                                        | `elements`    |
| Unknown inventory source    | source-specific when known; otherwise inventory-only diagnostics |

A registered contract proves API existence only. It does not prove rendered evidence page visibility.

## 2. File Convention

Use one owner-local file beside the owning surface source:

```text
resources/views/elements/{element}/reference.php
resources/views/components/ui/{component}/reference.php
resources/views/components/patterns/{pattern}/reference.php
```

`reference.php` may load the sibling `contract.php` for labels, summaries, statuses, props, slots, source paths, and other API data. It must not mutate contract data, infer approval, or write runtime state.

Legacy `docs.php` files are deprecated and must not be used for new Element, Component, or Pattern reference metadata.

`reference.php` is the owner-local rendered evidence display definition. Canonical documentation belongs in Markdown standards docs and should be surfaced through the owning `contract.php` source metadata.

## 3. Required Shape

Migrated `reference.php` files must return this top-level shape:

```php
return [
    'schema' => 'ui-reference.surface.v1',
    'surface' => [],
    'catalog' => [],
    'tabs' => [],
    'examples' => [],
    'relations' => [
        'children' => [],
        'owners' => [],
        'related' => [],
        'patterns' => [],
    ],
    'source' => [],
];
```

Inventory-only fallback records must emit the same outer keys. Renderers must not use missing sections as a proxy for visibility.

The required `schema` value is:

```php
'ui-reference.surface.v1'
```

The `surface.layer` value must be one of:

```php
'element'
'component'
'pattern'
```

The `catalog.base` value must be one of:

```php
'elements'
'components'
'patterns'
```

The `catalog.page.mode` value must be one of:

```php
'top-level'
'owner-tab'
'inventory-only'
'queued-gap'
'hidden'
```

## 4. Section Responsibilities

| Section     | Owns                                                                                                                                          |
| ----------- | --------------------------------------------------------------------------------------------------------------------------------------------- |
| `schema`    | rendered evidence display schema version.                                                                                                          |
| `surface`   | Display identity: layer, slug, label, summary, status, and optional local contract pointer.                                                   |
| `catalog`   | rendered evidence base, group, ordering, page mode, route slug, overview visibility, side-nav visibility, ownership, inventory labels, and badges. |
| `tabs`      | rendered evidence detail tabs, labels, default tab, enabled state, and content blocks.                                                             |
| `examples`  | Curated rendered examples, inventory-only examples, auto-discovery policy, and example ordering.                                              |
| `relations` | Child surfaces, owners, related surfaces, and pattern relationships for display.                                                              |
| `source`    | Reference-visible source paths, including Blade, CSS, JS, tokens, contract, reference, and examples.                                          |

Do not put callable API props, emitted classes, enforcement rules, lifecycle approval, or test requirements in `reference.php` when the sibling `contract.php` owns them. Reference files may point to contract fields through source strings such as `contract:api.props`.

## 5. Catalog Rules

`catalog.page.mode` is the only valid source for whether a rendered evidence page exists.

| Mode             | Meaning                                                               |
| ---------------- | --------------------------------------------------------------------- |
| `top-level`      | Own route, overview card, and optional side-nav entry.                |
| `owner-tab`      | No own route. Rendered inside an owner page from `catalog.ownership`. |
| `inventory-only` | No route. Source inventory and diagnostics only.                      |
| `queued-gap`     | No route unless explicitly promoted later. Used for planned tracking. |
| `hidden`         | Hidden from normal rendered evidence output.                               |

Overview card inclusion is controlled by:

```php
'catalog.page.overview' => true
```

Side-nav inclusion is controlled by:

```php
'catalog.page.side_nav' => true
```

Resolvers must filter visible side-nav pages with all of these conditions:

```php
data_get($record, 'catalog.base') === $currentBase
data_get($record, 'catalog.page.mode') === 'top-level'
data_get($record, 'catalog.page.side_nav') === true
```

Resolvers must filter overview cards with all of these conditions:

```php
data_get($record, 'catalog.base') === $currentBase
data_get($record, 'catalog.page.mode') === 'top-level'
data_get($record, 'catalog.page.overview') === true
```

Valid ownership roles are:

```php
'root'
'child'
'internal'
'alias'
'planned'
'unclassified'
```

Top-level records must use `catalog.ownership.role` `root`.

Owner-tab records must not use `root` and must declare:

```php
'catalog.ownership.owner_base'
'catalog.ownership.owner_slug'
'catalog.ownership.owner_tab'
```

Owner-tab records must not define standalone page navigation:

```php
'route_slug' => null,
'overview' => false,
'side_nav' => false,
```

Queued-gap records must also keep:

```php
'route_slug' => null,
'overview' => false,
'side_nav' => false,
```

### Inventory status values

`catalog.inventory.source_status` must use one of:

```php
'source present'
'source missing'
'planned'
'not implemented'
```

Use:

| Value             | Meaning                                                      |
| ----------------- | ------------------------------------------------------------ |
| `source present`  | The relevant owner source is declared and exists.            |
| `source missing`  | The relevant owner source is declared but missing.           |
| `planned`         | The source is intentionally planned but not yet available.   |
| `not implemented` | The source is intentionally not implemented for this record. |

`catalog.inventory.docs_status` must use one of:

```php
'implemented'
'missing'
'contract-derived'
```

Use:

| Value              | Meaning                                                                                   |
| ------------------ | ----------------------------------------------------------------------------------------- |
| `implemented`      | At least one path in `contract:source.docs` exists.                                       |
| `missing`          | `contract:source.docs` declares documentation paths but none exist.                       |
| `contract-derived` | No explicit documentation path is declared and the reference uses contract metadata only. |

For docs:

- Use `implemented` when at least one path in `contract:source.docs` exists.
- Use `missing` when `contract:source.docs` declares documentation paths but none exist.
- Use `contract-derived` when no explicit documentation path is declared.
- Do not read `docs.php`.

`catalog.inventory.examples_status` must use one of:

```php
'source present'
'none'
'planned'
```

Use:

| Value            | Meaning                                                           |
| ---------------- | ----------------------------------------------------------------- |
| `source present` | At least one curated rendered example exists in `examples.items`. |
| `none`           | No curated rendered examples are currently listed.                |
| `planned`        | Rendered examples are intentionally planned but not available.    |

### Catalog badges

`catalog.badges` is display metadata for compact rendered evidence labels.

Badges should be rendered by the rendered evidence renderer using the approved Tag component. Reference files must only provide badge data; they must not provide Blade, classes, colors, icons, or Tag variants directly.

Recommended badge keys:

```php
'badges' => [
    'status' => $status,
    'kind' => 'Component',
]
```

Allowed badge keys:

```php
'status'
'kind'
'maturity'
```

Allowed `kind` values:

```php
'Element'
'Component'
'Pattern API'
'Child API'
'Companion API'
```

Avoid duplicating ownership metadata as badges. For example, do not use:

```php
'badges' => [
    'role' => 'root',
]
```

Ownership belongs in:

```php
'catalog.ownership.role'
```

## 6. Tabs And Content

Tabs are rendered evidence page tabs, not component tabs.

Each tab definition must include:

```php
'label' => 'Overview',
'enabled' => true,
'default' => false,
'content' => [],
```

Exactly one enabled tab should set:

```php
'default' => true
```

For most visible pages, the `Overview` tab should be the default tab.

Owner-tab records are placed by `catalog.ownership.owner_tab`. Do not add non-standard tab routing metadata such as `target`.

Owner-tab records may use a normal tab shape:

```php
'tabs' => [
    'owner' => [
        'label' => 'API',
        'enabled' => true,
        'default' => true,
        'content' => [
            ['type' => 'summary', 'source' => 'contract:identity.summary'],
            ['type' => 'props-table', 'source' => 'contract:api.props'],
            ['type' => 'slots-table', 'source' => 'contract:api.slots'],
            ['type' => 'events-table', 'source' => 'contract:api.events'],
            ['type' => 'data-attributes-table', 'source' => 'contract:api.data_attributes'],
        ],
    ],
],
```

Content blocks must declare a `type` and a `source`. The `source` prefix must make ownership clear:

| Prefix       | Meaning                                     |
| ------------ | ------------------------------------------- |
| `contract:`  | Read from the sibling contract data.        |
| `reference:` | Read from the current reference definition. |
| `view:`      | Render a curated Blade example view.        |
| `literal:`   | Display inline text or data from the block. |

Common content block types include:

```php
'summary'
'usage-context'
'featured-examples'
'related-surfaces'
'example-grid'
'props-table'
'slots-table'
'events-table'
'data-attributes-table'
'variant-list'
'state-list'
'accessibility-notes'
'source-list'
'token-table'
'rule-list'
```

New content block types must be added to the shared renderer before a `reference.php` file may depend on them.

## 7. Examples

Rendered examples must be curated through `examples.items`. Auto-discovered files may appear in inventory, but they must not render on rendered evidence pages unless explicitly listed.

Required example policy:

```php
'examples' => [
    'directory' => 'examples',
    'auto_discover' => [
        'enabled' => true,
        'pattern' => '*.blade.php',
        'include_unlisted_in_inventory' => true,
        'show_unlisted_on_page' => false,
    ],
    'featured' => [],
    'items' => [],
],
```

Each rendered example item must declare:

```php
'label'
'file' or 'view'
'visible'
'render'
'tabs'
```

Example:

```php
'items' => [
    'basic' => [
        'label' => 'Basic',
        'description' => 'Default usage.',
        'file' => 'examples/basic.blade.php',
        'visible' => true,
        'render' => true,
        'tabs' => ['overview', 'examples'],
    ],
],
```

Every `examples.featured` item must exist in `examples.items`.

If `examples.items` is empty:

- `examples.featured` must be omitted or `[]`.
- The Examples tab must be disabled.
- Overview content must not include a `featured-examples` block.

Auto-discovered examples must not be promoted into rendered examples automatically. Reference files must not generate rendered examples by scanning `examples/*.blade.php`.

## 8. Relations And Children

Owner pages may embed child APIs in either of two supported ways:

1. Declare ordered child surfaces in `relations.children`.
2. Resolve children by scanning records where `catalog.page.mode` is `owner-tab` and `catalog.ownership.owner_*` matches the parent.

Resolver rule for owner-tab children:

```php
$ownerChildren = $records
    ->filter(fn ($record) => data_get($record, 'catalog.page.mode') === 'owner-tab')
    ->filter(fn ($record) => data_get($record, 'catalog.ownership.owner_base') === $ownerBase)
    ->filter(fn ($record) => data_get($record, 'catalog.ownership.owner_slug') === $ownerSlug);
```

Child contracts may exist as separate files. Their existence does not make them top-level pages.

Relations must use this shape:

```php
'relations' => [
    'children' => [],
    'owners' => [],
    'related' => [],
    'patterns' => [],
],
```

Do not add relation keys unless the shared reference schema and governance test are updated together.

## 9. Layer Examples

### Top-level Component

```php
return [
    'schema' => 'ui-reference.surface.v1',

    'surface' => [
        'layer' => 'component',
        'slug' => $slug,
        'label' => $label,
        'summary' => $summary,
        'status' => $status,
        'contract' => file_exists(__DIR__.'/contract.php') ? 'contract.php' : null,
    ],

    'catalog' => [
        'base' => 'components',
        'group' => 'Inputs',
        'order' => null,

        'page' => [
            'mode' => 'top-level',
            'route_slug' => $slug,
            'title' => $label,
            'overview' => true,
            'side_nav' => true,
        ],

        'ownership' => [
            'role' => 'root',
            'owner_base' => null,
            'owner_slug' => null,
            'owner_tab' => null,
        ],

        'inventory' => [
            'visible' => true,
            'label' => 'Visible catalog page',
            'source_status' => 'source present',
            'docs_status' => $docsStatus,
            'examples_status' => $exampleItems !== [] ? 'source present' : 'none',
        ],

        'badges' => [
            'status' => $status,
            'kind' => 'Component',
        ],
    ],

    'tabs' => [
        'overview' => [
            'label' => 'Overview',
            'enabled' => true,
            'default' => true,
            'content' => [
                ['type' => 'summary', 'source' => 'contract:identity.summary'],
                ['type' => 'usage-context', 'source' => 'contract:api.usage_context'],
                ['type' => 'related-surfaces', 'source' => 'reference:relations'],
            ],
        ],

        'examples' => [
            'label' => 'Examples',
            'enabled' => $exampleItems !== [],
            'default' => false,
            'content' => [
                ['type' => 'example-grid', 'source' => 'reference:examples.items'],
            ],
        ],

        'api' => [
            'label' => 'API',
            'enabled' => file_exists(__DIR__.'/contract.php'),
            'default' => false,
            'content' => [
                ['type' => 'props-table', 'source' => 'contract:api.props'],
                ['type' => 'slots-table', 'source' => 'contract:api.slots'],
                ['type' => 'events-table', 'source' => 'contract:api.events'],
                ['type' => 'data-attributes-table', 'source' => 'contract:api.data_attributes'],
            ],
        ],

        'source' => [
            'label' => 'Source',
            'enabled' => true,
            'default' => false,
            'content' => [
                ['type' => 'source-list', 'source' => 'reference:source'],
            ],
        ],
    ],

    'examples' => [
        'directory' => 'examples',
        'auto_discover' => [
            'enabled' => true,
            'pattern' => '*.blade.php',
            'include_unlisted_in_inventory' => true,
            'show_unlisted_on_page' => false,
        ],
        'featured' => [],
        'items' => [],
    ],

    'relations' => [
        'children' => [],
        'owners' => [],
        'related' => [],
        'patterns' => [],
    ],

    'source' => [
        'blade' => data_get($contract, 'source.blade', []),
        'css' => data_get($contract, 'source.css', []),
        'js' => data_get($contract, 'source.js', []),
        'tokens' => data_get($contract, 'source.tokens', []),
        'contract' => file_exists(__DIR__.'/contract.php') ? ['contract.php'] : [],
        'reference' => ['reference.php'],
        'examples' => is_dir(__DIR__.'/examples') ? ['examples'] : [],
    ],
];
```

### Child Component

Child Components keep their contracts but do not create top-level pages.

```php
'catalog' => [
    'base' => 'components',
    'group' => 'Inputs',
    'order' => null,

    'page' => [
        'mode' => 'owner-tab',
        'route_slug' => null,
        'title' => data_get($contract, 'identity.label', 'Select Item'),
        'overview' => false,
        'side_nav' => false,
    ],

    'ownership' => [
        'role' => 'child',
        'owner_base' => 'components',
        'owner_slug' => 'select',
        'owner_tab' => 'child-apis',
    ],

    'inventory' => [
        'visible' => true,
        'label' => 'Child API',
        'source_status' => 'source present',
        'docs_status' => $docsStatus,
        'examples_status' => $exampleItems !== [] ? 'source present' : 'none',
    ],

    'badges' => [
        'status' => data_get($contract, 'lifecycle.status', 'unknown'),
        'kind' => 'Child API',
    ],
],
```

### Pattern

Patterns use `surface.layer` `pattern`, `catalog.base` `patterns`, and may include a `rules` tab when the contract exposes rule groups.

```php
'surface' => [
    'layer' => 'pattern',
    'slug' => data_get($contract, 'identity.slug', basename(__DIR__)),
    'label' => data_get($contract, 'identity.label', str(basename(__DIR__))->headline()->toString()),
    'summary' => data_get($contract, 'identity.summary', ''),
    'status' => data_get($contract, 'lifecycle.status', 'unknown'),
    'contract' => file_exists(__DIR__.'/contract.php') ? 'contract.php' : null,
],

'catalog' => [
    'base' => 'patterns',
    'group' => 'Patterns',
    'order' => null,

    'page' => [
        'mode' => 'top-level',
        'route_slug' => data_get($contract, 'identity.slug', basename(__DIR__)),
        'title' => data_get($contract, 'identity.label', str(basename(__DIR__))->headline()->toString()),
        'overview' => true,
        'side_nav' => true,
    ],

    'ownership' => [
        'role' => 'root',
        'owner_base' => null,
        'owner_slug' => null,
        'owner_tab' => null,
    ],

    'inventory' => [
        'visible' => true,
        'label' => 'Pattern API',
        'source_status' => 'source present',
        'docs_status' => $docsStatus,
        'examples_status' => $exampleItems !== [] ? 'source present' : 'none',
    ],

    'badges' => [
        'status' => data_get($contract, 'lifecycle.status', 'unknown'),
        'kind' => 'Pattern API',
    ],
],

'tabs' => [
    'overview' => [
        'label' => 'Overview',
        'enabled' => true,
        'default' => true,
        'content' => [
            ['type' => 'summary', 'source' => 'contract:identity.summary'],
            ['type' => 'usage-context', 'source' => 'contract:api.usage_context'],
        ],
    ],

    'rules' => [
        'label' => 'Rules',
        'enabled' => true,
        'default' => false,
        'content' => [
            ['type' => 'rule-list', 'title' => 'Layout', 'source' => 'contract:rules.layout'],
            ['type' => 'rule-list', 'title' => 'Behavior', 'source' => 'contract:rules.behavior'],
            ['type' => 'rule-list', 'title' => 'Composition', 'source' => 'contract:rules.composition'],
        ],
    ],
],
```

### Element

Elements use `surface.layer` `element`, `catalog.base` `elements`, and usually prioritize tokens and usage.

```php
'surface' => [
    'layer' => 'element',
    'slug' => data_get($contract, 'identity.slug', basename(__DIR__)),
    'label' => data_get($contract, 'identity.label', str(basename(__DIR__))->headline()->toString()),
    'summary' => data_get($contract, 'identity.summary', ''),
    'status' => data_get($contract, 'lifecycle.status', 'unknown'),
    'contract' => file_exists(__DIR__.'/contract.php') ? 'contract.php' : null,
],

'catalog' => [
    'base' => 'elements',
    'group' => 'Foundations',
    'order' => null,

    'page' => [
        'mode' => 'top-level',
        'route_slug' => data_get($contract, 'identity.slug', basename(__DIR__)),
        'title' => data_get($contract, 'identity.label', str(basename(__DIR__))->headline()->toString()),
        'overview' => true,
        'side_nav' => true,
    ],

    'ownership' => [
        'role' => 'root',
        'owner_base' => null,
        'owner_slug' => null,
        'owner_tab' => null,
    ],

    'inventory' => [
        'visible' => true,
        'label' => 'Element reference page',
        'source_status' => 'source present',
        'docs_status' => $docsStatus,
        'examples_status' => $exampleItems !== [] ? 'source present' : 'none',
    ],

    'badges' => [
        'status' => data_get($contract, 'lifecycle.status', 'unknown'),
        'kind' => 'Element',
    ],
],

'tabs' => [
    'overview' => [
        'label' => 'Overview',
        'enabled' => true,
        'default' => true,
        'content' => [
            ['type' => 'summary', 'source' => 'contract:identity.summary'],
            ['type' => 'usage-context', 'source' => 'contract:api.usage_context'],
        ],
    ],

    'tokens' => [
        'label' => 'Tokens',
        'enabled' => true,
        'default' => false,
        'content' => [
            ['type' => 'token-table', 'source' => 'contract:tokens'],
        ],
    ],

    'usage' => [
        'label' => 'Usage',
        'enabled' => true,
        'default' => false,
        'content' => [
            ['type' => 'rule-list', 'source' => 'contract:rules.usage'],
        ],
    ],
],
```

## 10. Deprecated Reference Sources

Legacy `docs.php` files are no longer part of the rendered evidence source model.

New and migrated Element, Component, and Pattern records must use:

```php
'schema' => 'ui-reference.surface.v1'
```

Documentation status must be derived from the owning contract's `source.docs` entries.

Reference resolvers must not use `docs.php` to determine:

- page visibility
- documentation status
- tabs
- examples
- source ownership
- lifecycle
- API approval

A missing `reference.php` file, or a `reference.php` file without an explicit `catalog.page.mode`, must still resolve as `inventory-only`.

## 11. Related

- [UI Standards Index](index.md)
- [UI contract.php File](contract-file.md)
- [UI API Registry](api-registry.md)
- [UI Testing Standards](testing.md)
- [rendered evidence.php Template](../../09-reference/ui/ui-reference-template.php)
