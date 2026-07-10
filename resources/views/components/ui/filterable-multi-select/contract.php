<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/filterable-multi-select/contract.php
| Purpose: Filterable Multi Select Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Filterable Multi Select API that can be
| called from Blade, validated by tooling, and consumed by form layouts or
| Patterns.
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
        'slug' => 'filterable-multi-select',
        'label' => 'Filterable Multi Select',
        'component' => 'x-ui.filterable-multi-select',
        'summary' => 'Filterable multi-selection listbox control with text input, selected-count affordance, option checkboxes, select-all support, hidden submitted values, helper text, invalid/warning states, disabled/read-only states, inline type, light treatment, sizing, direction, selection feedback, and decorator content.',
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
        'usage_context' => 'Use x-ui.filterable-multi-select for selecting multiple values from a finite list when filtering is needed. Use x-ui.multi-select when filtering is not needed, x-ui.dropdown for single-selection listbox behavior, and x-ui.combo-box for editable single selection.',

        'props' => [
            ['name' => 'items', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Option items. Items may be strings or arrays with value, label/text, disabled, hidden, selected, and selectAll keys.'],
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Filterable multi select ID. A generated ID is used when omitted.'],
            ['name' => 'name', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Hidden input name used for submitted selected values.'],
            ['name' => 'label', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Filter input label/placeholder fallback.'],
            ['name' => 'placeholder', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Filter input placeholder. Falls back to label or Filter options.'],
            ['name' => 'titleText', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Field label text rendered above or visually hidden.'],
            ['name' => 'helperText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Helper text shown when invalid/warning text is not active.'],
            ['name' => 'invalid', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Invalid state. Takes precedence over warning state.'],
            ['name' => 'invalidText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Invalid message text.'],
            ['name' => 'warn', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Warning state. Suppressed when invalid is active.'],
            ['name' => 'warnText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Warning message text.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disables input, trigger, clearing, and option interaction.'],
            ['name' => 'readOnly', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Marks the control read-only and prevents changes through installed MultiSelect JavaScript.'],
            ['name' => 'hideLabel', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Visually hides titleText while preserving it for assistive technology.'],
            ['name' => 'light', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Light listbox/input treatment.'],
            ['name' => 'size', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['xs', 'sm', 'md', 'lg'], 'description' => 'Filterable multi select/listbox size. Null uses default CSS sizing.'],
            ['name' => 'type', 'type' => 'string', 'required' => false, 'default' => 'default', 'values' => ['default', 'inline'], 'description' => 'Filterable multi select type. inline applies inline wrapper and multi-select classes.'],
            ['name' => 'direction', 'type' => 'string', 'required' => false, 'default' => 'bottom', 'values' => ['top', 'bottom'], 'description' => 'Preferred menu opening direction.'],
            ['name' => 'open', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Rendered open state. Disabled/read-only controls force closed rendering.'],
            ['name' => 'selectedItems', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Controlled selected item values or item arrays. Takes precedence over initialSelectedItems.'],
            ['name' => 'initialSelectedItems', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Initial selected item values or item arrays.'],
            ['name' => 'selectionFeedback', 'type' => 'string', 'required' => false, 'default' => 'top-after-reopen', 'values' => ['fixed', 'top', 'top-after-reopen'], 'description' => 'Selection ordering/feedback behavior marker for installed MultiSelect JavaScript.'],
            ['name' => 'clearSelectionDescription', 'type' => 'string', 'required' => false, 'default' => 'Total items selected:', 'values' => [], 'description' => 'Assistive description prefix for selected count.'],
            ['name' => 'clearSelectionText', 'type' => 'string', 'required' => false, 'default' => 'To clear selection, press Delete or Backspace', 'values' => [], 'description' => 'Assistive instructions for clearing selected values.'],
            ['name' => 'selectAll', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Prepends a select-all option.'],
            ['name' => 'selectAllLabel', 'type' => 'string', 'required' => false, 'default' => 'Select all', 'values' => [], 'description' => 'Visible label for select-all option.'],
            ['name' => 'useTitleInItem', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Adds title attributes to option items.'],
            ['name' => 'decorator', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional decorator rendered inside the listbox wrapper.'],
            ['name' => 'slug', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Legacy alias for decorator.', 'compatibility' => true],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'filterable-multi-select', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-multi-select-wrapper', 'required' => true, 'description' => 'Generated multi select wrapper marker.'],
            ['name' => 'data-ui-filterable-multi-select-wrapper', 'required' => true, 'description' => 'Generated filterable multi select wrapper marker.'],
            ['name' => 'data-ui-multi-select-state', 'required' => true, 'description' => 'Generated state marker: default, invalid, or warning.'],
            ['name' => 'data-ui-multi-select-size', 'required' => false, 'description' => 'Generated resolved size marker.'],
            ['name' => 'data-ui-multi-select-clear-description', 'required' => true, 'description' => 'Generated clear/selected-count assistive description marker.'],
            ['name' => 'data-ui-multi-select', 'required' => true, 'description' => 'Generated multi select/listbox control marker.'],
            ['name' => 'data-ui-filterable-multi-select', 'required' => true, 'description' => 'Generated filterable multi select control marker.'],
            ['name' => 'data-ui-multi-select-open', 'required' => true, 'description' => 'Generated open state marker.'],
            ['name' => 'data-ui-multi-select-direction', 'required' => true, 'description' => 'Generated direction marker.'],
            ['name' => 'data-ui-multi-select-type', 'required' => true, 'description' => 'Generated type marker.'],
            ['name' => 'data-ui-multi-select-selection-feedback', 'required' => true, 'description' => 'Generated selection feedback marker.'],
            ['name' => 'data-ui-multi-select-readonly', 'required' => true, 'description' => 'Generated read-only marker.'],
            ['name' => 'data-ui-multi-select-disabled', 'required' => true, 'description' => 'Generated disabled marker.'],
            ['name' => 'data-ui-multi-select-selected-count', 'required' => true, 'description' => 'Generated selected count marker.'],
            ['name' => 'data-ui-multi-select-selectable-count', 'required' => true, 'description' => 'Generated selectable count marker.'],
            ['name' => 'data-ui-multi-select-select-all', 'required' => true, 'description' => 'Generated select-all enabled marker.'],
            ['name' => 'data-ui-multi-select-name', 'required' => false, 'description' => 'Generated submitted name metadata.'],
            ['name' => 'data-ui-filterable-multi-select-field', 'required' => true, 'description' => 'Generated filterable field marker.'],
            ['name' => 'data-ui-multi-select-clear', 'required' => false, 'description' => 'Generated clear button marker.'],
            ['name' => 'data-ui-multi-select-selection-count', 'required' => false, 'description' => 'Generated selected count marker on clear affordance.'],
            ['name' => 'data-ui-multi-select-input', 'required' => true, 'description' => 'Generated filter input marker.'],
            ['name' => 'data-ui-filterable-multi-select-input', 'required' => true, 'description' => 'Generated filterable input marker.'],
            ['name' => 'data-ui-filterable-multi-select-input-state', 'required' => true, 'description' => 'Generated filter input state marker.'],
            ['name' => 'data-ui-multi-select-trigger', 'required' => true, 'description' => 'Generated menu trigger marker.'],
            ['name' => 'data-ui-multi-select-menu', 'required' => true, 'description' => 'Generated listbox menu marker.'],
            ['name' => 'data-ui-multi-select-menu-open', 'required' => true, 'description' => 'Generated menu open marker.'],
            ['name' => 'data-ui-multi-select-option', 'required' => false, 'description' => 'Generated option marker.'],
            ['name' => 'data-ui-multi-select-option-index', 'required' => false, 'description' => 'Generated option index marker.'],
            ['name' => 'data-ui-multi-select-option-value', 'required' => false, 'description' => 'Generated option value marker.'],
            ['name' => 'data-ui-multi-select-option-label', 'required' => false, 'description' => 'Generated option label marker.'],
            ['name' => 'data-ui-multi-select-option-selected', 'required' => false, 'description' => 'Generated selected option marker.'],
            ['name' => 'data-ui-multi-select-option-indeterminate', 'required' => false, 'description' => 'Generated indeterminate select-all option marker.'],
            ['name' => 'data-ui-multi-select-option-select-all', 'required' => false, 'description' => 'Generated select-all option marker.'],
            ['name' => 'data-ui-multi-select-option-disabled', 'required' => false, 'description' => 'Generated disabled option marker.'],
            ['name' => 'data-ui-multi-select-checkbox', 'required' => false, 'description' => 'Generated option checkbox marker.'],
            ['name' => 'data-ui-checkbox-indeterminate', 'required' => false, 'description' => 'Generated indeterminate checkbox marker.'],
            ['name' => 'data-ui-multi-select-hidden-inputs', 'required' => false, 'description' => 'Generated hidden inputs wrapper marker.'],
            ['name' => 'data-ui-multi-select-hidden-input', 'required' => false, 'description' => 'Generated hidden selected value input marker.'],
            ['name' => 'data-ui-multi-select-clear-announcement', 'required' => true, 'description' => 'Generated clear announcement live region marker.'],
            ['name' => 'data-ui-filterable-multi-select-validation', 'required' => false, 'description' => 'Generated invalid/warning message marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-multi-select--filterable',
        'required' => [
            'ui-multi-select__wrapper',
            'ui-multi-select--filterable__wrapper',
            'ui-list-box__wrapper',
            'ui-multi-select',
            'ui-combo-box',
            'ui-list-box',
            'ui-multi-select--filterable',
            'ui-list-box__field',
            'ui-text-input',
            'ui-list-box__menu',
        ],
        'optional' => [
            'ui-multi-select__wrapper--inline',
            'ui-list-box__wrapper--inline',
            'ui-multi-select__wrapper--inline--invalid',
            'ui-list-box__wrapper--inline--invalid',
            'ui-list-box__wrapper--decorator',
            'ui-label',
            'ui-label--disabled',
            'ui-visually-hidden',
            'ui-multi-select--invalid',
            'ui-multi-select--warning',
            'ui-multi-select--open',
            'ui-multi-select--inline',
            'ui-multi-select--selected',
            'ui-multi-select--readonly',
            'ui-multi-select--selectall',
            'ui-list-box--up',
            'ui-list-box--xs',
            'ui-list-box--sm',
            'ui-list-box--md',
            'ui-list-box--lg',
            'ui-list-box--disabled',
            'ui-list-box--light',
            'ui-list-box--expanded',
            'ui-text-input--empty',
            'ui-text-input--light',
            'ui-form__helper-text',
            'ui-form__helper-text--disabled',
            'ui-list-box__invalid-icon',
            'ui-list-box__invalid-icon--warning',
            'ui-list-box__selection',
            'ui-list-box__selection-count',
            'ui-list-box__selection-icon',
            'ui-list-box__menu-icon',
            'ui-list-box__menu-icon-svg',
            'ui-list-box__inner-wrapper--decorator',
            'ui-list-box__menu-item',
            'ui-checkbox-wrapper',
            'ui-checkbox',
            'ui-checkbox-label',
            'ui-checkbox-label-text',
            'ui-form-requirement',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local filterable multi select wrappers',
            'ad hoc filterable multiselect/listbox markup',
            'raw filterable multiselect option checkbox markup outside x-ui.filterable-multi-select',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => [], 'class' => 'ui-multi-select--filterable', 'description' => 'Default closed filterable multi select.'],
        'open' => ['label' => 'Open', 'api' => ['open' => true], 'class' => 'ui-list-box--expanded', 'description' => 'Filterable multi select with menu rendered open.'],
        'inline' => ['label' => 'Inline', 'api' => ['type' => 'inline'], 'class' => 'ui-multi-select--inline', 'description' => 'Inline filterable multi select type.'],
        'top-direction' => ['label' => 'Top direction', 'api' => ['direction' => 'top'], 'class' => 'ui-list-box--up', 'description' => 'Filterable multi select menu opening upward.'],
        'light' => ['label' => 'Light', 'api' => ['light' => true], 'class' => 'ui-list-box--light', 'description' => 'Light listbox/input treatment.'],
        'hidden-label' => ['label' => 'Hidden label', 'api' => ['hideLabel' => true], 'class' => 'ui-visually-hidden', 'description' => 'Filterable multi select with visually hidden title text.'],
        'with-helper' => ['label' => 'With helper text', 'api' => ['helperText' => 'Helper text'], 'class' => 'ui-form__helper-text', 'description' => 'Filterable multi select with helper text.'],
        'selected' => ['label' => 'Selected items', 'api' => ['selectedItems' => ['a']], 'class' => 'ui-multi-select--selected', 'description' => 'Filterable multi select with selected items.'],
        'with-select-all' => ['label' => 'With select all', 'api' => ['selectAll' => true], 'class' => 'ui-multi-select--selectall', 'description' => 'Filterable multi select with select-all option.'],
        'select-all-indeterminate' => ['label' => 'Select all indeterminate', 'api' => ['selectAll' => true, 'selectedItems' => ['a']], 'description' => 'Select-all option in mixed state.'],
        'with-decorator' => ['label' => 'With decorator', 'api' => ['decorator' => '#'], 'class' => 'ui-list-box__wrapper--decorator', 'description' => 'Filterable multi select with decorator content.'],
        'with-disabled-option' => ['label' => 'Disabled option', 'api' => ['items' => [['label' => 'Option', 'disabled' => true]]], 'description' => 'Filterable multi select with disabled option.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'xs' => ['label' => 'Extra small', 'api' => ['size' => 'xs'], 'class' => 'ui-list-box--xs', 'description' => 'Extra small filterable multi select.'],
        'sm' => ['label' => 'Small', 'api' => ['size' => 'sm'], 'class' => 'ui-list-box--sm', 'description' => 'Small filterable multi select.'],
        'md' => ['label' => 'Medium', 'api' => ['size' => 'md'], 'class' => 'ui-list-box--md', 'description' => 'Medium filterable multi select.'],
        'lg' => ['label' => 'Large', 'api' => ['size' => 'lg'], 'class' => 'ui-list-box--lg', 'description' => 'Large filterable multi select.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'closed' => ['label' => 'Closed', 'required' => true, 'description' => 'Default closed menu state.'],
        'open' => ['label' => 'Open', 'required' => false, 'description' => 'Open menu state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled filterable multi select state.'],
        'read-only' => ['label' => 'Read-only', 'required' => false, 'description' => 'Read-only filterable multi select state.'],
        'invalid' => ['label' => 'Invalid', 'required' => false, 'description' => 'Invalid filterable multi select state.'],
        'warning' => ['label' => 'Warning', 'required' => false, 'description' => 'Warning filterable multi select state.'],
        'selected' => ['label' => 'Selected', 'required' => false, 'description' => 'One or more selected items.'],
        'empty' => ['label' => 'Empty', 'required' => false, 'description' => 'No selected values.'],
        'filtering' => ['label' => 'Filtering', 'required' => false, 'description' => 'Filter input has active text or filtering behavior.'],
        'select-all' => ['label' => 'Select all', 'required' => false, 'description' => 'Select-all option is present.'],
        'indeterminate' => ['label' => 'Indeterminate', 'required' => false, 'description' => 'Select-all option is in mixed state.'],
        'option-disabled' => ['label' => 'Disabled option', 'required' => false, 'description' => 'Disabled option state.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for filter input, trigger, clear button, and options.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-multi-select',
            'ui-list-box',
            'ui-combo-box',
            'ui-text-input',
            'ui-checkbox',
            'ui-form',
        ],
        'component_tokens' => [
            'filterable-multi-select',
            'multi-select',
            'list-box',
            'combo-box',
            'checkbox',
            'form-field',
            'validation',
        ],
        'deprecated' => [
            'feature-local filterable multiselect controls',
            'ad hoc filterable multiselect/listbox markup',
            'raw filterable multiselect checkbox option markup',
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
            'checkbox',
            'text-input',
            'multi-select',
            'motion',
        ],
        'uses' => [
            'icons' => [
                'warning--filled',
                'warning--alt',
                'close',
                'chevron--down',
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [
                'filterable multi select behavior if installed',
                'multi select behavior if installed',
            ],
        ],
        'blocks' => [
            'forms',
            'filters',
            'settings',
            'bulk-selection-controls',
            'searchable-filters',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Filter input must retain native text entry behavior.',
            'Menu open/close, filtering, arrow navigation, option toggling, clearing, selected count sync, and focus management are owned by installed MultiSelect JavaScript.',
            'Disabled and read-only states must prevent opening and selection changes.',
            'Checkbox inputs inside options are removed from tab order; option navigation is owned by the listbox controller.',
        ],
        'aria' => [
            'Filter input renders role="combobox", aria-haspopup="listbox", aria-expanded, and aria-controls.',
            'Menu renders role="listbox" and aria-multiselectable="true".',
            'Options render role="option" and aria-selected.',
            'Disabled options expose aria-disabled.',
            'Select-all mixed state is represented on the nested checkbox with aria-checked="mixed".',
            'Filter input is labelled by titleText or label/placeholder fallback.',
            'Helper, invalid, warning, and clear-selection instruction text are associated through aria-describedby when rendered.',
            'Invalid state emits aria-invalid and aria-errormessage when invalid message text exists.',
            'Read-only state emits aria-readonly.',
            'Icons are decorative and hidden from assistive technology.',
        ],
        'focus' => [
            'Filter input, trigger, clear button, and active option must show visible focus.',
            'Focus placement and active option management are owned by installed MultiSelect JavaScript.',
        ],
        'screen_reader' => [
            'Title text and filter label should describe the value group being selected.',
            'Option labels must be meaningful and unique enough to distinguish options.',
            'Selected count and clear instructions must stay accurate when JavaScript mutates selection.',
            'Invalid and warning messages must describe the problem or caution clearly.',
            'Placeholder must not be the only accessible label.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            ['name' => 'slug', 'replacement' => 'decorator', 'description' => 'slug remains accepted as a compatibility alias for decorator.'],
        ],
        'classes' => [
            'feature-local filterable multi select classes',
            'raw listbox/filter utility clusters',
        ],
        'components' => [
            'ad hoc filterable multiselect controls outside x-ui.filterable-multi-select',
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
            'resources/views/components/ui/filterable-multi-select/index.blade.php',
        ],
        'css' => [
            'resources/css/components/multi-select.css',
            'resources/css/components/list-box.css',
            'resources/css/components/combo-box.css',
            'resources/css/components/text-input.css',
        ],
        'contract' => [
            'resources/views/components/ui/filterable-multi-select/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/filterable-multi-select.md',
        ],
    ],
]);
