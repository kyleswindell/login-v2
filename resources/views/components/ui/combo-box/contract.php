<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/combo-box/contract.php
| Purpose: Combo Box Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Combo Box API that can be called from
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
        'slug' => 'combo-box',
        'label' => 'Combo Box',
        'component' => 'x-ui.combo-box',
        'summary' => 'Autocomplete listbox form control with editable input, option menu, selection clearing, hidden submitted value, helper text, invalid/warning states, disabled/read-only states, light treatment, sizing, direction, custom values, typeahead metadata, and decorator content.',
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
        'usage_context' => 'Use x-ui.combo-box when users can type to filter/select one item from a list, optionally allowing custom values. Use x-ui.select for non-editable selection and multi-select surfaces for multiple values.',

        'props' => [
            ['name' => 'items', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Option items. Items may be strings or arrays with value, label/text, disabled, hidden, and selected keys.'],
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Input ID. A generated ID is used when omitted.'],
            ['name' => 'name', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Hidden input name for selected value submission.'],
            ['name' => 'titleText', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Canonical field label.'],
            ['name' => 'label', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Compatibility alias for titleText.', 'compatibility' => true],
            ['name' => 'helperText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Helper text shown when invalid/warning text is not active.'],
            ['name' => 'invalid', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Invalid state. Takes precedence over warning state.'],
            ['name' => 'invalidText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Invalid message text.'],
            ['name' => 'warn', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Warning state. Suppressed when invalid is active.'],
            ['name' => 'warnText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Warning message text.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disables input, clear button, and menu trigger.'],
            ['name' => 'readOnly', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Makes input readonly and prevents menu opening.'],
            ['name' => 'hideLabel', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Visually hides the label while preserving it for assistive technology.'],
            ['name' => 'light', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Light listbox treatment.'],
            ['name' => 'size', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['xs', 'sm', 'md', 'lg'], 'description' => 'Listbox size. Null uses default CSS sizing.'],
            ['name' => 'direction', 'type' => 'string', 'required' => false, 'default' => 'bottom', 'values' => ['top', 'bottom'], 'description' => 'Preferred menu opening direction.'],
            ['name' => 'open', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Rendered open state. Disabled/read-only controls force closed rendering.'],
            ['name' => 'selectedItem', 'type' => 'array|string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Controlled selected item. May be an item array or raw value.'],
            ['name' => 'initialSelectedItem', 'type' => 'array|string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Initial selected item when selectedItem is not supplied.'],
            ['name' => 'placeholder', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Editable input placeholder.'],
            ['name' => 'ariaLabel', 'type' => 'string', 'required' => false, 'default' => 'Choose an item', 'values' => [], 'description' => 'Accessible input label fallback when no field label is rendered.'],
            ['name' => 'allowCustomValue', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Allows selected/custom value text not present in the visible item list.'],
            ['name' => 'typeahead', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Typeahead behavior marker for installed ComboBox JavaScript.'],
            ['name' => 'decorator', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional decorator rendered inside the listbox wrapper.'],
            ['name' => 'slug', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Legacy alias for decorator.', 'compatibility' => true],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'combo-box', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-combo-box-wrapper', 'required' => true, 'description' => 'Generated wrapper marker.'],
            ['name' => 'data-ui-combo-box-state', 'required' => true, 'description' => 'Generated state marker: default, invalid, or warning.'],
            ['name' => 'data-ui-combo-box-size', 'required' => false, 'description' => 'Generated resolved size marker.'],
            ['name' => 'data-ui-combo-box', 'required' => true, 'description' => 'Generated combobox/listbox control marker.'],
            ['name' => 'data-ui-combo-box-open', 'required' => true, 'description' => 'Generated open state marker.'],
            ['name' => 'data-ui-combo-box-direction', 'required' => true, 'description' => 'Generated direction marker.'],
            ['name' => 'data-ui-combo-box-allow-custom-value', 'required' => true, 'description' => 'Generated custom value marker.'],
            ['name' => 'data-ui-combo-box-typeahead', 'required' => true, 'description' => 'Generated typeahead marker.'],
            ['name' => 'data-ui-combo-box-readonly', 'required' => true, 'description' => 'Generated read-only marker.'],
            ['name' => 'data-ui-combo-box-disabled', 'required' => true, 'description' => 'Generated disabled marker.'],
            ['name' => 'data-ui-combo-box-field', 'required' => true, 'description' => 'Generated field wrapper marker.'],
            ['name' => 'data-ui-combo-box-input', 'required' => true, 'description' => 'Generated editable input marker.'],
            ['name' => 'data-ui-combo-box-input-state', 'required' => true, 'description' => 'Generated input state marker.'],
            ['name' => 'data-ui-combo-box-clear', 'required' => true, 'description' => 'Generated clear selection button marker.'],
            ['name' => 'data-ui-combo-box-trigger', 'required' => true, 'description' => 'Generated menu trigger marker.'],
            ['name' => 'data-ui-combo-box-menu', 'required' => true, 'description' => 'Generated listbox menu marker.'],
            ['name' => 'data-ui-combo-box-menu-open', 'required' => true, 'description' => 'Generated menu open state marker.'],
            ['name' => 'data-ui-combo-box-option', 'required' => false, 'description' => 'Generated option marker.'],
            ['name' => 'data-ui-combo-box-option-index', 'required' => false, 'description' => 'Generated option index marker.'],
            ['name' => 'data-ui-combo-box-option-value', 'required' => false, 'description' => 'Generated option value marker.'],
            ['name' => 'data-ui-combo-box-option-label', 'required' => false, 'description' => 'Generated option label marker.'],
            ['name' => 'data-ui-combo-box-option-selected', 'required' => false, 'description' => 'Generated option selected marker.'],
            ['name' => 'data-ui-combo-box-option-disabled', 'required' => false, 'description' => 'Generated option disabled marker.'],
            ['name' => 'data-ui-combo-box-hidden-input', 'required' => false, 'description' => 'Generated hidden submitted value input marker.'],
            ['name' => 'data-ui-combo-box-validation', 'required' => false, 'description' => 'Generated invalid/warning message marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-combo-box',
        'required' => [
            'ui-list-box__wrapper',
            'ui-combo-box',
            'ui-list-box',
            'ui-list-box__field',
            'ui-text-input',
            'ui-combo-box--input',
            'ui-list-box__menu',
        ],
        'optional' => [
            'ui-list-box__wrapper--decorator',
            'ui-label',
            'ui-label--disabled',
            'ui-visually-hidden',
            'ui-combo-box--warning',
            'ui-combo-box--readonly',
            'ui-list-box--up',
            'ui-list-box--xs',
            'ui-list-box--sm',
            'ui-list-box--md',
            'ui-list-box--lg',
            'ui-list-box--disabled',
            'ui-list-box--light',
            'ui-list-box--expanded',
            'ui-text-input--empty',
            'ui-form__helper-text',
            'ui-form__helper-text--disabled',
            'ui-list-box__invalid-icon',
            'ui-list-box__invalid-icon--warning',
            'ui-list-box__selection',
            'ui-list-box__selection-icon',
            'ui-list-box__menu-icon',
            'ui-list-box__menu-icon-svg',
            'ui-list-box__inner-wrapper--decorator',
            'ui-list-box__menu-item',
            'ui-list-box__menu-item__option',
            'ui-list-box__menu-item__selected-icon',
            'ui-form-requirement',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local combo box wrappers',
            'ad hoc autocomplete listbox markup',
            'raw listbox option markup outside x-ui.combo-box',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => [], 'class' => 'ui-combo-box', 'description' => 'Default closed combo box.'],
        'open' => ['label' => 'Open', 'api' => ['open' => true], 'class' => 'ui-list-box--expanded', 'description' => 'Combo box with menu rendered open.'],
        'top-direction' => ['label' => 'Top direction', 'api' => ['direction' => 'top'], 'class' => 'ui-list-box--up', 'description' => 'Combo box menu opening upward.'],
        'light' => ['label' => 'Light', 'api' => ['light' => true], 'class' => 'ui-list-box--light', 'description' => 'Light listbox treatment.'],
        'with-helper' => ['label' => 'With helper text', 'api' => ['helperText' => 'Helper text'], 'class' => 'ui-form__helper-text', 'description' => 'Combo box with helper text.'],
        'selected' => ['label' => 'Selected item', 'api' => ['selectedItem' => 'Option'], 'description' => 'Combo box with selected item.'],
        'allow-custom-value' => ['label' => 'Allow custom value', 'api' => ['allowCustomValue' => true], 'description' => 'Combo box that may display/custom-submit a value outside the item list.'],
        'typeahead' => ['label' => 'Typeahead', 'api' => ['typeahead' => true], 'description' => 'Combo box with typeahead behavior marker.'],
        'hidden-label' => ['label' => 'Hidden label', 'api' => ['hideLabel' => true], 'class' => 'ui-visually-hidden', 'description' => 'Combo box with visually hidden label.'],
        'with-decorator' => ['label' => 'With decorator', 'api' => ['decorator' => '#'], 'class' => 'ui-list-box__wrapper--decorator', 'description' => 'Combo box with decorator content.'],
        'with-disabled-option' => ['label' => 'Disabled option', 'api' => ['items' => [['label' => 'Option', 'disabled' => true]]], 'description' => 'Combo box with disabled option.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'xs' => ['label' => 'Extra small', 'api' => ['size' => 'xs'], 'class' => 'ui-list-box--xs', 'description' => 'Extra small combo box.'],
        'sm' => ['label' => 'Small', 'api' => ['size' => 'sm'], 'class' => 'ui-list-box--sm', 'description' => 'Small combo box.'],
        'md' => ['label' => 'Medium', 'api' => ['size' => 'md'], 'class' => 'ui-list-box--md', 'description' => 'Medium combo box.'],
        'lg' => ['label' => 'Large', 'api' => ['size' => 'lg'], 'class' => 'ui-list-box--lg', 'description' => 'Large combo box.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'closed' => ['label' => 'Closed', 'required' => true, 'description' => 'Default closed menu state.'],
        'open' => ['label' => 'Open', 'required' => false, 'description' => 'Open menu state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled combo box state.'],
        'read-only' => ['label' => 'Read-only', 'required' => false, 'description' => 'Read-only combo box state.'],
        'invalid' => ['label' => 'Invalid', 'required' => false, 'description' => 'Invalid combo box state.'],
        'warning' => ['label' => 'Warning', 'required' => false, 'description' => 'Warning combo box state.'],
        'selected' => ['label' => 'Selected', 'required' => false, 'description' => 'Selected item state.'],
        'empty' => ['label' => 'Empty', 'required' => false, 'description' => 'No selected/display value state.'],
        'option-disabled' => ['label' => 'Disabled option', 'required' => false, 'description' => 'Disabled option state.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for input, trigger, clear button, and options.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-combo-box',
            'ui-list-box',
            'ui-text-input',
            'ui-form',
        ],
        'component_tokens' => [
            'combo-box',
            'list-box',
            'form-field',
            'autocomplete',
            'validation',
        ],
        'deprecated' => [
            'feature-local autocomplete controls',
            'ad hoc listbox markup',
            'raw combobox option markup',
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
            'text-input',
            'motion',
        ],
        'uses' => [
            'icons' => [
                'warning--filled',
                'warning--alt',
                'close',
                'chevron--down',
                'checkmark',
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [
                'combo box behavior if installed',
            ],
        ],
        'blocks' => [
            'forms',
            'filters',
            'searchable-selects',
            'editable-pickers',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Editable input must retain native text entry behavior.',
            'Menu open/close, filtering, arrow navigation, selection, clearing, and typeahead behavior are owned by installed ComboBox JavaScript.',
            'Disabled and read-only states must prevent menu opening and clearing.',
        ],
        'aria' => [
            'Input renders role="combobox", aria-haspopup="listbox", aria-expanded, and aria-controls.',
            'Menu renders role="listbox".',
            'Options render role="option" and aria-selected.',
            'Disabled options expose aria-disabled.',
            'Input should be labelled by titleText/label or ariaLabel.',
            'Helper, invalid, and warning text are associated through aria-describedby when rendered.',
            'Invalid state emits aria-invalid and aria-errormessage when invalid message text exists.',
            'Read-only state emits aria-readonly.',
            'Icons are decorative and hidden from assistive technology.',
        ],
        'focus' => [
            'Input, clear button, menu trigger, and active option must show visible focus.',
            'Active descendant and focus management are owned by installed ComboBox JavaScript.',
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
            ['name' => 'label', 'replacement' => 'titleText', 'description' => 'label remains accepted as a compatibility alias for titleText.'],
            ['name' => 'slug', 'replacement' => 'decorator', 'description' => 'slug remains accepted as a compatibility alias for decorator.'],
        ],
        'classes' => [
            'feature-local combo box classes',
            'raw listbox utility clusters',
        ],
        'components' => [
            'ad hoc autocomplete controls outside x-ui.combo-box',
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
            'resources/views/components/ui/combo-box/index.blade.php',
        ],
        'css' => [
            'resources/css/components/combo-box.css',
            'resources/css/components/list-box.css',
        ],
        'contract' => [
            'resources/views/components/ui/combo-box/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/combo-box.md',
        ],
    ],
]);
