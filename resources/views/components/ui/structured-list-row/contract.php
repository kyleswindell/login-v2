<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/structured-list-row/contract.php
| Purpose: Structured List Row Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Structured List Row API that can be called
| from Blade, validated by tooling, and consumed by app layouts or Patterns.
|
| Rendered evidence pages, examples/proofs, testing status, and
| manual review state are intentionally owned outside this contract.
|
*/

return Surface::component([
    /*
    |--------------------------------------------------------------------------
    | Identity
    |--------------------------------------------------------------------------
    */

    'identity' => [
        'slug' => 'structured-list-row',
        'label' => 'Structured List Row',
        'component' => 'x-ui.structured-list-row',
        'summary' => 'Compact app-owned structured-list summary row with title, description, metadata, selected state, and disabled state.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Lifecycle
    |--------------------------------------------------------------------------
    */

    'lifecycle' => [
        'status' => 'provisional',
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Blade API
    |--------------------------------------------------------------------------
    */

    'api' => [
        'usage_context' => 'Use x-ui.structured-list-row for compact summary rows. Use x-ui.structured-list for native table-backed row/column comparison.',

        'props' => [
            ['name' => 'title', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Primary row title. If omitted, the default slot may be used.'],
            ['name' => 'description', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Supporting row description.'],
            ['name' => 'meta', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Trailing metadata text.'],
            ['name' => 'selected', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Selected row state.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disabled row state.'],
        ],

        'slots' => [
            ['name' => 'default', 'required' => false, 'description' => 'Fallback title content when title is omitted.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'structured-list-row', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-structured-list-row', 'required' => true, 'description' => 'Generated row marker.'],
            ['name' => 'data-ui-structured-list-row-summary', 'required' => true, 'description' => 'Generated summary row marker.'],
            ['name' => 'data-ui-structured-list-row-selected', 'required' => true, 'description' => 'Generated selected state marker.'],
            ['name' => 'data-ui-structured-list-row-disabled', 'required' => true, 'description' => 'Generated disabled state marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-structured-list-row',
        'required' => [
            'ui-structured-list-row',
            'ui-structured-list-row--summary',
            'ui-structured-list-row-content',
            'ui-structured-list-row-main',
        ],
        'optional' => [
            'ui-structured-list-row-selected',
            'ui-structured-list-row-disabled',
            'ui-structured-list-row-title',
            'ui-structured-list-cell-description',
            'ui-structured-list-row-meta',
        ],
        'internal' => [],
        'deprecated' => [
            'Tailwind-only structured list row markup',
            'feature-local summary row wrappers',
            'raw structured-list-row markup outside x-ui.structured-list-row',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => [], 'class' => 'ui-structured-list-row', 'description' => 'Default summary row.'],
        'with-description' => ['label' => 'With description', 'api' => ['description' => 'Description'], 'class' => 'ui-structured-list-cell-description', 'description' => 'Summary row with supporting description.'],
        'with-meta' => ['label' => 'With metadata', 'api' => ['meta' => 'Meta'], 'class' => 'ui-structured-list-row-meta', 'description' => 'Summary row with trailing metadata.'],
        'selected' => ['label' => 'Selected', 'api' => ['selected' => true], 'class' => 'ui-structured-list-row-selected', 'description' => 'Selected summary row.'],
        'disabled' => ['label' => 'Disabled', 'api' => ['disabled' => true], 'class' => 'ui-structured-list-row-disabled', 'description' => 'Disabled summary row.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default summary row state.'],
        'selected' => ['label' => 'Selected', 'required' => false, 'description' => 'Selected summary row state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled summary row state.'],
        'empty' => ['label' => 'Empty', 'required' => false, 'description' => 'No title, description, or metadata content.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-structured-list',
        ],
        'component_tokens' => [
            'structured-list-row',
            'summary-row',
        ],
        'deprecated' => [
            'Tailwind-only structured list row markup',
            'feature-local summary row wrappers',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies
    |--------------------------------------------------------------------------
    */

    'dependencies' => [
        'depends_on' => [
            'color',
            'themes',
            'spacing',
            'typography',
            'structured-list',
        ],
        'uses' => [
            'icons' => [],
            'components' => [],
            'js_initializers' => [],
        ],
        'blocks' => [
            'summary-lists',
            'review-rows',
            'compact-row-groups',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Summary row is not independently interactive.',
        ],
        'aria' => [
            'Disabled rows expose aria-disabled.',
            'Selected state must not rely on color alone when selection affects workflow meaning.',
        ],
        'focus' => [
            'Summary row itself does not receive focus unless caller adds interactivity outside this component.',
        ],
        'screen_reader' => [
            'Title and description should clearly identify the row content.',
            'Metadata should be brief and meaningful.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [],
        'classes' => [
            'Tailwind-only structured list row classes',
            'feature-local structured list summary row classes',
        ],
        'components' => [
            'ad hoc summary rows outside x-ui.structured-list-row',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Enforcement
    |--------------------------------------------------------------------------
    */

    'enforcement' => [
        'mode' => 'legacy-compatible',
        'invalid_usage' => 'warn',
    ],

    /*
    |--------------------------------------------------------------------------
    | Source
    |--------------------------------------------------------------------------
    */

    'source' => [
        'blade' => [
            'resources/views/components/ui/structured-list-row/index.blade.php',
        ],
        'css' => [
            'resources/css/components/structured-list.css',
        ],
        'contract' => [
            'resources/views/components/ui/structured-list-row/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/structured-list.md',
        ],
    ],
]);
