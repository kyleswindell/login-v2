<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/searchable-select/contract.php
| Purpose: Searchable Select Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Searchable Select API that can be called
| from Blade, validated by tooling, and consumed by form layouts or Patterns.
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
        'slug' => 'searchable-select',
        'label' => 'Searchable Select',
        'component' => 'x-ui.searchable-select',
        'summary' => 'App-owned searchable single-select composite with hidden submitted value, button trigger, searchable listbox panel, filter input, option buttons, selected checkmark, and empty state.',
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
        'usage_context' => 'Use x-ui.searchable-select for app-owned searchable single selection when the control should submit a hidden value and filter options inside a custom panel. Use x-ui.combo-box for editable combobox behavior, x-ui.dropdown for non-filterable custom selection, and x-ui.select for native select behavior.',

        'props' => [
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Hidden input/control ID. A generated ID is used when omitted.'],
            ['name' => 'name', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Hidden input name for form submission.'],
            ['name' => 'options', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Selectable options. Options may be strings or arrays with value, label, disabled, and hidden keys.'],
            ['name' => 'selected', 'type' => 'string|int|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Selected option value.'],
            ['name' => 'placeholder', 'type' => 'string', 'required' => false, 'default' => 'Select an option', 'values' => [], 'description' => 'Trigger placeholder text when no selected option is resolved.'],
            ['name' => 'label', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional field label.'],
            ['name' => 'ariaLabel', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Accessible trigger label fallback when no field label is rendered.'],
            ['name' => 'searchLabel', 'type' => 'string', 'required' => false, 'default' => 'Search available options', 'values' => [], 'description' => 'Accessible label for the internal search input.'],
            ['name' => 'searchPlaceholder', 'type' => 'string', 'required' => false, 'default' => 'Search available options', 'values' => [], 'description' => 'Placeholder for the internal search input.'],
            ['name' => 'emptyLabel', 'type' => 'string', 'required' => false, 'default' => 'No matching options', 'values' => [], 'description' => 'Empty-state text shown when filtering leaves no visible options.'],
            ['name' => 'required', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Required state marker. Custom validation is owned by caller or installed JavaScript.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disables hidden value, trigger, filter input, and options.'],
            ['name' => 'invalid', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Invalid state marker.'],
            ['name' => 'open', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Initial rendered open state. Dynamic state is owned by installed Searchable Select JavaScript.'],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'searchable-select', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-searchable-select', 'required' => true, 'description' => 'Generated searchable select root marker.'],
            ['name' => 'data-ui-searchable-select-empty-label', 'required' => true, 'description' => 'Generated empty-state label marker.'],
            ['name' => 'data-ui-searchable-select-open', 'required' => true, 'description' => 'Generated open state marker.'],
            ['name' => 'data-ui-searchable-select-disabled', 'required' => true, 'description' => 'Generated disabled state marker.'],
            ['name' => 'data-ui-searchable-select-invalid', 'required' => true, 'description' => 'Generated invalid state marker.'],
            ['name' => 'data-ui-searchable-select-required', 'required' => true, 'description' => 'Generated required state marker.'],
            ['name' => 'data-ui-searchable-select-value', 'required' => true, 'description' => 'Generated hidden submitted value marker.'],
            ['name' => 'data-ui-searchable-select-trigger', 'required' => true, 'description' => 'Generated trigger marker.'],
            ['name' => 'data-ui-searchable-select-label', 'required' => true, 'description' => 'Generated trigger placeholder label marker.'],
            ['name' => 'data-ui-searchable-select-trigger-text', 'required' => true, 'description' => 'Generated trigger text marker.'],
            ['name' => 'data-ui-searchable-select-trigger-icon', 'required' => true, 'description' => 'Generated trigger icon marker.'],
            ['name' => 'data-ui-searchable-select-panel', 'required' => true, 'description' => 'Generated searchable panel marker.'],
            ['name' => 'data-ui-searchable-select-filter', 'required' => true, 'description' => 'Generated search filter input marker.'],
            ['name' => 'data-ui-searchable-select-options', 'required' => true, 'description' => 'Generated listbox options wrapper marker.'],
            ['name' => 'data-ui-searchable-select-option', 'required' => false, 'description' => 'Generated option marker.'],
            ['name' => 'data-value', 'required' => false, 'description' => 'Generated option value marker.'],
            ['name' => 'data-label', 'required' => false, 'description' => 'Generated option label marker.'],
            ['name' => 'data-ui-searchable-select-check', 'required' => false, 'description' => 'Generated selected checkmark marker.'],
            ['name' => 'data-ui-searchable-select-empty', 'required' => true, 'description' => 'Generated empty state marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-searchable-select',
        'required' => [
            'ui-list-box-wrapper',
            'ui-searchable-select',
            'ui-list-box',
            'ui-list-box-field',
            'ui-select',
            'ui-searchable-select-trigger',
            'ui-list-box-label',
            'ui-searchable-select-trigger-text',
            'ui-list-box-menu',
            'ui-searchable-select-panel',
            'ui-searchable-select-filter-shell',
            'ui-searchable-select-filter',
            'ui-searchable-select-options',
            'ui-list-box-menu-item',
            'ui-searchable-select-option',
            'ui-list-box-menu-item-option',
            'ui-searchable-select-empty',
        ],
        'optional' => [
            'ui-searchable-select--open',
            'ui-searchable-select--disabled',
            'ui-searchable-select--invalid',
            'ui-searchable-select--selected',
            'ui-label',
            'ui-searchable-select-trigger-icon',
            'ui-searchable-select-icon',
            'ui-searchable-select-filter-icon',
            'ui-scrollbar',
            'ui-searchable-select-check',
            'hidden',
            'sr-only',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local searchable select wrappers',
            'ad hoc searchable dropdown/listbox markup',
            'raw searchable select option markup outside x-ui.searchable-select',
            'Tailwind utility icon sizing inside searchable select icons',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => [], 'class' => 'ui-searchable-select', 'description' => 'Default closed searchable select.'],
        'open' => ['label' => 'Open', 'api' => ['open' => true], 'class' => 'ui-searchable-select--open', 'description' => 'Searchable select with panel rendered open.'],
        'disabled' => ['label' => 'Disabled', 'api' => ['disabled' => true], 'class' => 'ui-searchable-select--disabled', 'description' => 'Disabled searchable select.'],
        'invalid' => ['label' => 'Invalid', 'api' => ['invalid' => true], 'class' => 'ui-searchable-select--invalid', 'description' => 'Invalid searchable select state.'],
        'required' => ['label' => 'Required', 'api' => ['required' => true], 'description' => 'Required searchable select state marker.'],
        'with-label' => ['label' => 'With label', 'api' => ['label' => 'Status'], 'class' => 'ui-label', 'description' => 'Searchable select with field label.'],
        'selected' => ['label' => 'Selected', 'api' => ['selected' => 'a'], 'class' => 'ui-searchable-select--selected', 'description' => 'Searchable select with selected option.'],
        'empty' => ['label' => 'Empty result', 'api' => ['emptyLabel' => 'No matching options'], 'class' => 'ui-searchable-select-empty', 'description' => 'Filter empty-state display.'],
        'disabled-option' => ['label' => 'Disabled option', 'api' => ['options' => [['value' => 'a', 'label' => 'A', 'disabled' => true]]], 'description' => 'Searchable select with disabled option.'],
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
        'closed' => ['label' => 'Closed', 'required' => true, 'description' => 'Default closed panel state.'],
        'open' => ['label' => 'Open', 'required' => false, 'description' => 'Open panel state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled control state.'],
        'invalid' => ['label' => 'Invalid', 'required' => false, 'description' => 'Invalid control state.'],
        'required' => ['label' => 'Required', 'required' => false, 'description' => 'Required control state.'],
        'selected' => ['label' => 'Selected', 'required' => false, 'description' => 'Selected option state.'],
        'empty' => ['label' => 'Empty', 'required' => false, 'description' => 'No selected value or no matching options depending on context.'],
        'filtering' => ['label' => 'Filtering', 'required' => false, 'description' => 'Filter input has active text or filtering behavior.'],
        'option-disabled' => ['label' => 'Disabled option', 'required' => false, 'description' => 'Disabled option state.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for trigger, filter input, and options.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-searchable-select',
            'ui-list-box',
            'ui-select',
        ],
        'component_tokens' => [
            'searchable-select',
            'list-box',
            'select',
            'search',
            'form-field',
        ],
        'deprecated' => [
            'feature-local searchable select wrappers',
            'ad hoc searchable dropdowns',
            'Tailwind utility icon sizing inside searchable select icons',
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
            'icons',
            'forms',
            'search',
            'dropdown',
            'list-box',
            'motion',
        ],
        'uses' => [
            'icons' => [
                'chevron--sort',
                'search',
                'checkmark',
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [
                'searchable select behavior if installed',
            ],
        ],
        'blocks' => [
            'forms',
            'filters',
            'settings',
            'searchable-single-select-controls',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Trigger must be keyboard reachable unless disabled.',
            'Filter input must retain native search input behavior.',
            'Open/close, filtering, arrow navigation, option selection, and focus management are owned by installed Searchable Select JavaScript.',
            'Disabled options must not be selectable.',
        ],
        'aria' => [
            'Trigger renders role="combobox", aria-haspopup="listbox", aria-expanded, and aria-controls.',
            'Filter input has an accessible label from searchLabel.',
            'Options container renders role="listbox".',
            'Options render role="option" and aria-selected.',
            'Disabled options expose aria-disabled.',
            'Required state is exposed on the trigger with aria-required.',
            'Invalid state is exposed with aria-invalid.',
            'Icons are decorative and hidden from assistive technology.',
        ],
        'focus' => [
            'Trigger, filter input, and active option must show visible focus.',
            'Focus placement and active option management are owned by installed Searchable Select JavaScript.',
        ],
        'screen_reader' => [
            'Field label or ariaLabel should describe the value being selected.',
            'Option labels must be meaningful and unique enough to distinguish options.',
            'Placeholder must not be the only accessible label when the surrounding UI does not label the control.',
            'Empty-state text should be announced when filtering removes all visible options.',
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
            'feature-local searchable select classes',
            'raw searchable listbox utility clusters',
            'Tailwind utility icon classes on x-ui.icon instances',
        ],
        'components' => [
            'ad hoc searchable select controls outside x-ui.searchable-select',
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
            'resources/views/components/ui/searchable-select/index.blade.php',
        ],
        'css' => [
            'resources/css/components/searchable-select.css',
            'resources/css/components/list-box.css',
        ],
        'js' => [
            'resources/js/ui-controls/searchable-select.js',
        ],
        'contract' => [
            'resources/views/components/ui/searchable-select/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/searchable-select.md',
        ],
    ],
]);
