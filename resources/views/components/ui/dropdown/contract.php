<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/dropdown/contract.php
| Purpose: Dropdown Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Dropdown API that can be called from
| Blade, validated by tooling, and consumed by form layouts or Patterns.
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
        'slug' => 'dropdown',
        'label' => 'Dropdown',
        'component' => 'x-ui.dropdown',
        'summary' => 'Custom listbox select control with button trigger, selectable options, hidden submitted value, helper text, invalid/warning states, disabled/read-only states, inline type, light treatment, sizing, direction, selected item, and decorator content.',
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
        'usage_context' => 'Use x-ui.dropdown for custom single-selection listbox controls. Use x-ui.select when native select behavior is required, x-ui.combo-box when users can type/filter, and multi-select surfaces for multiple values.',

        'props' => [
            ['name' => 'items', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Option items. Items may be strings or arrays with value, label/text, disabled, hidden, and selected keys.'],
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Dropdown ID. A generated ID is used when omitted.'],
            ['name' => 'name', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Hidden input name for selected value submission.'],
            ['name' => 'label', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Compatibility label/placeholder value. Used as field label fallback and placeholder fallback.'],
            ['name' => 'titleText', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Canonical field label text.'],
            ['name' => 'helperText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Helper text shown when invalid/warning text is not active.'],
            ['name' => 'invalid', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Invalid state. Takes precedence over warning state.'],
            ['name' => 'invalidText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Invalid message text.'],
            ['name' => 'warn', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Warning state. Suppressed when invalid is active.'],
            ['name' => 'warnText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Warning message text.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disables the trigger and prevents menu opening.'],
            ['name' => 'readOnly', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Marks the dropdown read-only and prevents menu opening through installed dropdown JavaScript.'],
            ['name' => 'hideLabel', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Visually hides the label while preserving it for assistive technology.'],
            ['name' => 'light', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Light dropdown treatment.'],
            ['name' => 'size', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['xs', 'sm', 'md', 'lg'], 'description' => 'Dropdown/listbox size. Null uses default CSS sizing.'],
            ['name' => 'type', 'type' => 'string', 'required' => false, 'default' => 'default', 'values' => ['default', 'inline'], 'description' => 'Dropdown type. inline applies inline wrapper and dropdown classes.'],
            ['name' => 'direction', 'type' => 'string', 'required' => false, 'default' => 'bottom', 'values' => ['top', 'bottom'], 'description' => 'Preferred menu opening direction.'],
            ['name' => 'open', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Rendered open state. Disabled/read-only controls force closed rendering.'],
            ['name' => 'selectedItem', 'type' => 'array|string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Controlled selected item. May be an item array or raw value.'],
            ['name' => 'initialSelectedItem', 'type' => 'array|string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Initial selected item when selectedItem is not supplied.'],
            ['name' => 'placeholder', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Display text when no item is selected. Falls back to label or Select an option.'],
            ['name' => 'ariaLabel', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Explicit accessible label for the dropdown trigger.'],
            ['name' => 'decorator', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional decorator rendered inside the listbox wrapper.'],
            ['name' => 'slug', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Legacy alias for decorator.', 'compatibility' => true],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'dropdown', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-dropdown-wrapper', 'required' => true, 'description' => 'Generated dropdown wrapper marker.'],
            ['name' => 'data-ui-dropdown-state', 'required' => true, 'description' => 'Generated state marker: default, invalid, or warning.'],
            ['name' => 'data-ui-dropdown-size', 'required' => false, 'description' => 'Generated resolved size marker.'],
            ['name' => 'data-ui-dropdown', 'required' => true, 'description' => 'Generated dropdown/listbox control marker.'],
            ['name' => 'data-ui-dropdown-open', 'required' => true, 'description' => 'Generated open state marker.'],
            ['name' => 'data-ui-dropdown-direction', 'required' => true, 'description' => 'Generated direction marker.'],
            ['name' => 'data-ui-dropdown-type', 'required' => true, 'description' => 'Generated type marker.'],
            ['name' => 'data-ui-dropdown-readonly', 'required' => true, 'description' => 'Generated read-only marker.'],
            ['name' => 'data-ui-dropdown-disabled', 'required' => true, 'description' => 'Generated disabled marker.'],
            ['name' => 'data-ui-dropdown-has-value', 'required' => true, 'description' => 'Generated selected value marker.'],
            ['name' => 'data-ui-dropdown-trigger', 'required' => true, 'description' => 'Generated dropdown trigger marker.'],
            ['name' => 'data-ui-dropdown-selected-label', 'required' => true, 'description' => 'Generated selected label marker.'],
            ['name' => 'data-ui-dropdown-menu', 'required' => true, 'description' => 'Generated listbox menu marker.'],
            ['name' => 'data-ui-dropdown-menu-open', 'required' => true, 'description' => 'Generated menu open state marker.'],
            ['name' => 'data-ui-dropdown-option', 'required' => false, 'description' => 'Generated option marker.'],
            ['name' => 'data-ui-dropdown-option-index', 'required' => false, 'description' => 'Generated option index marker.'],
            ['name' => 'data-ui-dropdown-option-value', 'required' => false, 'description' => 'Generated option value marker.'],
            ['name' => 'data-ui-dropdown-option-label', 'required' => false, 'description' => 'Generated option label marker.'],
            ['name' => 'data-ui-dropdown-option-selected', 'required' => false, 'description' => 'Generated option selected marker.'],
            ['name' => 'data-ui-dropdown-option-disabled', 'required' => false, 'description' => 'Generated disabled option marker.'],
            ['name' => 'data-ui-dropdown-hidden-input', 'required' => false, 'description' => 'Generated hidden submitted value input marker.'],
            ['name' => 'data-ui-dropdown-validation', 'required' => false, 'description' => 'Generated invalid/warning message marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-dropdown',
        'required' => [
            'ui-dropdown__wrapper',
            'ui-list-box__wrapper',
            'ui-dropdown',
            'ui-list-box',
            'ui-list-box__field',
            'ui-list-box__label',
            'ui-list-box__menu',
        ],
        'optional' => [
            'ui-dropdown__wrapper--inline',
            'ui-list-box__wrapper--inline',
            'ui-dropdown__wrapper--inline--invalid',
            'ui-list-box__wrapper--inline--invalid',
            'ui-list-box__wrapper--decorator',
            'ui-label',
            'ui-label--disabled',
            'ui-visually-hidden',
            'ui-dropdown--invalid',
            'ui-dropdown--warning',
            'ui-dropdown--open',
            'ui-dropdown--inline',
            'ui-dropdown--disabled',
            'ui-dropdown--readonly',
            'ui-dropdown--light',
            'ui-dropdown--xs',
            'ui-dropdown--sm',
            'ui-dropdown--md',
            'ui-dropdown--lg',
            'ui-list-box--xs',
            'ui-list-box--sm',
            'ui-list-box--md',
            'ui-list-box--lg',
            'ui-list-box--up',
            'ui-form__helper-text',
            'ui-form__helper-text--disabled',
            'ui-list-box__invalid-icon',
            'ui-list-box__invalid-icon--warning',
            'ui-list-box__menu-icon',
            'ui-list-box__inner-wrapper--decorator',
            'ui-list-box__menu-item',
            'ui-list-box__menu-item__option',
            'ui-list-box__menu-item__selected-icon',
            'ui-form-requirement',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local dropdown wrappers',
            'ad hoc custom select/listbox markup',
            'raw dropdown option markup outside x-ui.dropdown',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => [], 'class' => 'ui-dropdown', 'description' => 'Default closed dropdown.'],
        'open' => ['label' => 'Open', 'api' => ['open' => true], 'class' => 'ui-dropdown--open', 'description' => 'Dropdown with menu rendered open.'],
        'inline' => ['label' => 'Inline', 'api' => ['type' => 'inline'], 'class' => 'ui-dropdown--inline', 'description' => 'Inline dropdown type.'],
        'top-direction' => ['label' => 'Top direction', 'api' => ['direction' => 'top'], 'class' => 'ui-list-box--up', 'description' => 'Dropdown menu opening upward.'],
        'light' => ['label' => 'Light', 'api' => ['light' => true], 'class' => 'ui-dropdown--light', 'description' => 'Light dropdown treatment.'],
        'hidden-label' => ['label' => 'Hidden label', 'api' => ['hideLabel' => true], 'class' => 'ui-visually-hidden', 'description' => 'Dropdown with visually hidden label.'],
        'with-helper' => ['label' => 'With helper text', 'api' => ['helperText' => 'Helper text'], 'class' => 'ui-form__helper-text', 'description' => 'Dropdown with helper text.'],
        'selected' => ['label' => 'Selected item', 'api' => ['selectedItem' => 'Option'], 'description' => 'Dropdown with selected item.'],
        'with-decorator' => ['label' => 'With decorator', 'api' => ['decorator' => '#'], 'class' => 'ui-list-box__wrapper--decorator', 'description' => 'Dropdown with decorator content.'],
        'with-disabled-option' => ['label' => 'Disabled option', 'api' => ['items' => [['label' => 'Option', 'disabled' => true]]], 'description' => 'Dropdown with disabled option.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'xs' => ['label' => 'Extra small', 'api' => ['size' => 'xs'], 'class' => 'ui-dropdown--xs', 'description' => 'Extra small dropdown.'],
        'sm' => ['label' => 'Small', 'api' => ['size' => 'sm'], 'class' => 'ui-dropdown--sm', 'description' => 'Small dropdown.'],
        'md' => ['label' => 'Medium', 'api' => ['size' => 'md'], 'class' => 'ui-dropdown--md', 'description' => 'Medium dropdown.'],
        'lg' => ['label' => 'Large', 'api' => ['size' => 'lg'], 'class' => 'ui-dropdown--lg', 'description' => 'Large dropdown.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'closed' => ['label' => 'Closed', 'required' => true, 'description' => 'Default closed menu state.'],
        'open' => ['label' => 'Open', 'required' => false, 'description' => 'Open menu state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled dropdown state.'],
        'read-only' => ['label' => 'Read-only', 'required' => false, 'description' => 'Read-only dropdown state.'],
        'invalid' => ['label' => 'Invalid', 'required' => false, 'description' => 'Invalid dropdown state.'],
        'warning' => ['label' => 'Warning', 'required' => false, 'description' => 'Warning dropdown state.'],
        'selected' => ['label' => 'Selected', 'required' => false, 'description' => 'Selected item state.'],
        'empty' => ['label' => 'Empty', 'required' => false, 'description' => 'No selected value state.'],
        'option-disabled' => ['label' => 'Disabled option', 'required' => false, 'description' => 'Disabled option state.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for trigger and options.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-dropdown',
            'ui-list-box',
            'ui-form',
        ],
        'component_tokens' => [
            'dropdown',
            'list-box',
            'form-field',
            'validation',
        ],
        'deprecated' => [
            'feature-local custom select controls',
            'ad hoc dropdown/listbox markup',
            'raw dropdown option markup',
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
            'motion',
        ],
        'uses' => [
            'icons' => [
                'warning--filled',
                'warning--alt',
                'chevron--down',
                'checkmark',
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [
                'dropdown behavior if installed',
            ],
        ],
        'blocks' => [
            'forms',
            'filters',
            'settings',
            'single-select-controls',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Dropdown trigger must be keyboard reachable unless disabled.',
            'Menu open/close, arrow navigation, option selection, and focus management are owned by installed dropdown JavaScript.',
            'Disabled and read-only states must prevent menu opening and selection.',
        ],
        'aria' => [
            'Trigger renders role="combobox", aria-haspopup="listbox", aria-expanded, and aria-controls.',
            'Trigger should be labelled by titleText/label, ariaLabel, or visible selected label text.',
            'Menu renders role="listbox".',
            'Options render role="option" and aria-selected.',
            'Disabled options expose aria-disabled.',
            'Helper, invalid, and warning text are associated through aria-describedby when rendered.',
            'Invalid state emits aria-invalid and aria-errormessage when invalid message text exists.',
            'Read-only state emits aria-readonly and aria-disabled.',
            'Icons are decorative and hidden from assistive technology.',
        ],
        'focus' => [
            'Trigger and active option must show visible focus.',
            'Focus placement and active option management are owned by installed dropdown JavaScript.',
        ],
        'screen_reader' => [
            'Label should describe the value being selected.',
            'Option labels must be meaningful and unique enough to distinguish options.',
            'Invalid and warning messages must describe the problem or caution clearly.',
            'Placeholder must not be the only label.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            ['name' => 'label', 'replacement' => 'titleText plus placeholder where appropriate', 'description' => 'label remains accepted as a compatibility label/placeholder value.'],
            ['name' => 'slug', 'replacement' => 'decorator', 'description' => 'slug remains accepted as a compatibility alias for decorator.'],
        ],
        'classes' => [
            'feature-local dropdown classes',
            'raw listbox utility clusters',
        ],
        'components' => [
            'ad hoc custom select controls outside x-ui.dropdown',
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
            'resources/views/components/ui/dropdown/index.blade.php',
        ],
        'css' => [
            'resources/css/components/dropdown.css',
            'resources/css/components/list-box.css',
        ],
        'contract' => [
            'resources/views/components/ui/dropdown/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/dropdown.md',
        ],
    ],
]);
