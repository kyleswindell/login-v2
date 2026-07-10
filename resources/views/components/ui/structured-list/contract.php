<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/structured-list/contract.php
| Purpose: Structured List Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Structured List API that can be called from
| Blade, validated by tooling, and consumed by app layouts or Patterns.
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
        'slug' => 'structured-list',
        'label' => 'Structured List',
        'component' => 'x-ui.structured-list',
        'summary' => 'Native table-backed structured list for simple row/column comparison with optional single-row radio selection, condensed rows, hang/flush alignment, background treatment, empty state, skeleton state, and disabled rows.',
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
        'usage_context' => 'Use x-ui.structured-list for simple row/column comparison when a full data table would be excessive. Use x-ui.data-table for sorting, filtering, pagination, expansion, row actions, batch actions, or multiple row selection.',

        'props' => [
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Structured list ID prefix. A generated ID is used when omitted.'],
            ['name' => 'caption', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Accessible table caption. Rendered visually hidden.'],
            ['name' => 'columns', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Column definitions as strings or arrays with key, label, and truncate. Generated from rich row cells when omitted.'],
            ['name' => 'rows', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Rows to render. Rows support id, value, selected, disabled, cells, title, label, description, and meta keys.'],
            ['name' => 'variant', 'type' => 'string', 'required' => false, 'default' => 'default', 'values' => ['default', 'selectable'], 'description' => 'Structured list variant. selectable enables single radio selection.'],
            ['name' => 'selectable', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Enables single radio row selection. Equivalent to variant selectable.'],
            ['name' => 'name', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Radio group name for selectable rows.'],
            ['name' => 'value', 'type' => 'string|int|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Selected row value for selectable rows.'],
            ['name' => 'size', 'type' => 'string', 'required' => false, 'default' => 'default', 'values' => ['default', 'condensed'], 'description' => 'Structured list size. condensed applies condensed row treatment.'],
            ['name' => 'condensed', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Compatibility boolean for condensed size.'],
            ['name' => 'alignment', 'type' => 'string', 'required' => false, 'default' => 'hang', 'values' => ['hang', 'flush'], 'description' => 'List alignment. Selectable lists force hang alignment.'],
            ['name' => 'background', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Applies background treatment when alignment is hang.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disables selectable row inputs and marks rows disabled.'],
            ['name' => 'skeleton', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Renders skeleton rows and aria-busy state.'],
            ['name' => 'emptyText', 'type' => 'string', 'required' => false, 'default' => 'No rows available.', 'values' => [], 'description' => 'Empty state text when rows are empty.'],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'structured-list', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-structured-list', 'required' => true, 'description' => 'Generated structured list marker.'],
            ['name' => 'data-ui-structured-list-selectable', 'required' => true, 'description' => 'Generated selectable state marker.'],
            ['name' => 'data-ui-structured-list-size', 'required' => true, 'description' => 'Generated size marker.'],
            ['name' => 'data-ui-structured-list-alignment', 'required' => true, 'description' => 'Generated alignment marker.'],
            ['name' => 'data-ui-structured-list-row-count', 'required' => true, 'description' => 'Generated row count marker.'],
            ['name' => 'data-ui-structured-list-column-count', 'required' => true, 'description' => 'Generated column count marker.'],
            ['name' => 'data-ui-structured-list-background', 'required' => false, 'description' => 'Generated background treatment marker.'],
            ['name' => 'data-ui-structured-list-disabled', 'required' => false, 'description' => 'Generated disabled state marker.'],
            ['name' => 'data-ui-structured-list-header-truncate', 'required' => false, 'description' => 'Generated truncated header marker.'],
            ['name' => 'data-ui-structured-list-skeleton-row', 'required' => false, 'description' => 'Generated skeleton row marker.'],
            ['name' => 'data-ui-structured-list-empty-row', 'required' => false, 'description' => 'Generated empty row marker.'],
            ['name' => 'data-ui-structured-list-row', 'required' => false, 'description' => 'Generated body row marker.'],
            ['name' => 'data-ui-structured-list-row-selected', 'required' => false, 'description' => 'Generated selected row marker.'],
            ['name' => 'data-ui-structured-list-row-disabled', 'required' => false, 'description' => 'Generated disabled row marker.'],
            ['name' => 'data-ui-structured-list-selectable-row', 'required' => false, 'description' => 'Generated selectable row marker.'],
            ['name' => 'data-ui-structured-list-radio', 'required' => false, 'description' => 'Generated selectable row radio marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-structured-list',
        'required' => [
            'ui-structured-list-shell',
            'ui-structured-list',
            'ui-structured-list-head',
            'ui-structured-list-body',
            'ui-structured-list-row',
            'ui-structured-list-header',
            'ui-structured-list-cell',
            'ui-structured-list-row-header',
        ],
        'optional' => [
            'ui-structured-list-hang',
            'ui-structured-list-flush',
            'ui-structured-list-condensed',
            'ui-structured-list-selectable',
            'ui-structured-list-background',
            'ui-structured-list-skeleton',
            'ui-structured-list-selection-cell',
            'ui-structured-list-radio',
            'ui-structured-list-radio-placeholder',
            'ui-structured-list-row-selected',
            'ui-structured-list-row-disabled',
            'ui-structured-list-cell-description',
            'ui-structured-list-empty',
            'ui-structured-list-skeleton-line',
            'sr-only',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local comparison tables',
            'ad hoc structured list tables',
            'multiple row selection in structured list',
            'sorting/filtering/pagination behavior inside structured list',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => [], 'class' => 'ui-structured-list', 'description' => 'Default native table-backed structured list.'],
        'selectable' => ['label' => 'Selectable', 'api' => ['variant' => 'selectable'], 'class' => 'ui-structured-list-selectable', 'description' => 'Single-selection structured list with radio controls.'],
        'condensed' => ['label' => 'Condensed', 'api' => ['size' => 'condensed'], 'class' => 'ui-structured-list-condensed', 'description' => 'Condensed row density.'],
        'hang' => ['label' => 'Hang alignment', 'api' => ['alignment' => 'hang'], 'class' => 'ui-structured-list-hang', 'description' => 'Hang alignment.'],
        'flush' => ['label' => 'Flush alignment', 'api' => ['alignment' => 'flush'], 'class' => 'ui-structured-list-flush', 'description' => 'Flush alignment. Not applied to selectable lists.'],
        'background' => ['label' => 'Background', 'api' => ['background' => true], 'class' => 'ui-structured-list-background', 'description' => 'Background treatment for hang-aligned lists.'],
        'disabled' => ['label' => 'Disabled', 'api' => ['disabled' => true], 'description' => 'Disabled selectable inputs and row treatment.'],
        'empty' => ['label' => 'Empty', 'api' => ['rows' => []], 'class' => 'ui-structured-list-empty', 'description' => 'Empty state row.'],
        'skeleton' => ['label' => 'Skeleton', 'api' => ['skeleton' => true], 'class' => 'ui-structured-list-skeleton', 'description' => 'Skeleton loading state.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'default' => ['label' => 'Default', 'api' => ['size' => 'default'], 'description' => 'Default structured list size.'],
        'condensed' => ['label' => 'Condensed', 'api' => ['size' => 'condensed'], 'class' => 'ui-structured-list-condensed', 'description' => 'Condensed structured list size.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default structured list state.'],
        'selectable' => ['label' => 'Selectable', 'required' => false, 'description' => 'Selectable single-radio row state.'],
        'selected-row' => ['label' => 'Selected row', 'required' => false, 'description' => 'A row is selected.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled list or row state.'],
        'empty' => ['label' => 'Empty', 'required' => false, 'description' => 'No rows state.'],
        'skeleton' => ['label' => 'Skeleton', 'required' => false, 'description' => 'Loading skeleton state.'],
        'truncated-header' => ['label' => 'Truncated header', 'required' => false, 'description' => 'Column header truncation marker state.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for selectable row radio controls.'],
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
            'structured-list',
            'native-table',
            'single-selection',
            'comparison-list',
        ],
        'deprecated' => [
            'feature-local comparison tables',
            'ad hoc selected row tables',
            'sorting/filtering/pagination inside structured list',
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
            'forms',
            'radio-button',
            'motion',
        ],
        'uses' => [
            'icons' => [],
            'components' => [],
            'js_initializers' => [
                'structured list selection behavior if installed',
            ],
        ],
        'blocks' => [
            'comparison-lists',
            'review-summaries',
            'settings-comparison',
            'single-choice-row-selection',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Native table structure must remain intact.',
            'Selectable row radio controls must be keyboard reachable unless disabled.',
            'Do not add sorting, filtering, pagination, row expansion, or multi-selection behavior to Structured List.',
        ],
        'aria' => [
            'Table should have caption, aria-label, or aria-labelledby supplied by the caller/context.',
            'Column headers use th scope="col".',
            'First body cell uses th scope="row".',
            'Selectable row radios are labelled by the row header cell.',
            'Skeleton state emits aria-busy on the shell.',
            'Disabled rows expose aria-disabled and disable selectable controls.',
        ],
        'focus' => [
            'Selectable radio controls must show visible focus.',
            'Non-selectable rows are not independently focusable.',
        ],
        'screen_reader' => [
            'Caption should describe the comparison being made.',
            'Column headers and row headers must be short and meaningful.',
            'Empty state text must explain that no rows are available.',
            'Selection meaning must be clear from surrounding form or group context.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            ['name' => 'condensed', 'replacement' => 'size="condensed"', 'description' => 'condensed remains accepted as a compatibility boolean.'],
            ['name' => 'variant="selectable"', 'replacement' => 'selectable=true', 'description' => 'variant selectable remains accepted for convenience.'],
        ],
        'classes' => [
            'feature-local structured list classes',
            'raw comparison table utility clusters',
        ],
        'components' => [
            'ad hoc comparison tables outside x-ui.structured-list',
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
            'resources/views/components/ui/structured-list/index.blade.php',
        ],
        'css' => [
            'resources/css/components/structured-list.css',
        ],
        'contract' => [
            'resources/views/components/ui/structured-list/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/structured-list.md',
        ],
    ],
]);
