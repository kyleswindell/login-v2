<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/multi-select/contract.php
| Purpose: Multi Select Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Multi Select API that can be called from
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
        'slug' => 'multi-select',
        'label' => 'Multi Select',
        'component' => 'x-ui.multi-select',
        'summary' => 'Custom multi-selection listbox control with trigger, selected-count affordance, option checkboxes, select-all support, hidden submitted values, helper text, invalid/warning states, disabled/read-only states, inline type, light treatment, sizing, direction, selection feedback, and decorator content.',
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
        'usage_context' => 'Use x-ui.multi-select for selecting multiple values from a finite list. Use x-ui.dropdown for single-selection listbox behavior and x-ui.combo-box when users need editable filtering or custom values.',

        'props' => [
            ['name' => 'items', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Option items. Items may be strings or arrays with value, label/text, disabled, hidden, selected, and selectAll keys.'],
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Multi select ID. A generated ID is used when omitted.'],
            ['name' => 'name', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Hidden input name used for submitted selected values.'],
            ['name' => 'label', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Trigger/display label. Falls back to selected count or Select options.'],
            ['name' => 'titleText', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Field label text rendered above or visually hidden.'],
            ['name' => 'helperText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Helper text shown when invalid/warning text is not active.'],
            ['name' => 'invalid', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Invalid state. Takes precedence over warning state.'],
            ['name' => 'invalidText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Invalid message text.'],
            ['name' => 'warn', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Warning state. Suppressed when invalid is active.'],
            ['name' => 'warnText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Warning message text.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disables trigger, clearing, and option interaction.'],
            ['name' => 'readOnly', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Marks the control read-only and prevents changes through installed MultiSelect JavaScript.'],
            ['name' => 'hideLabel', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Visually hides titleText while preserving it for assistive technology.'],
            ['name' => 'light', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Light listbox treatment.'],
            ['name' => 'size', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['xs', 'sm', 'md', 'lg'], 'description' => 'Multi select/listbox size. Null uses default CSS sizing.'],
            ['name' => 'type', 'type' => 'string', 'required' => false, 'default' => 'default', 'values' => ['default', 'inline'], 'description' => 'Multi select type. inline applies inline wrapper and multi-select classes.'],
            ['name' => 'direction', 'type' => 'string', 'required' => false, 'default' => 'bottom', 'values' => ['top', 'bottom'], 'description' => 'Preferred menu opening direction.'],
            ['name' => 'open', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Rendered open state. Disabled/read-only controls force closed rendering.'],
            ['name' => 'selectedItems', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Controlled selected item values or item arrays. Takes precedence over initialSelectedItems.'],
            ['name' => 'initialSelectedItems', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Initial selected item values or item arrays.'],
            ['name' => 'selectionFeedback', 'type' => 'string', 'required' => false, 'default' => 'top-after-reopen', 'values' => ['fixed', 'top', 'top-after-reopen'], 'description' => 'Selection ordering/feedback behavior marker for installed MultiSelect JavaScript.'],
            ['name' => 'clearSelectionDescription', 'type' => 'string', 'required' => false, 'default' => 'Total items selected:', 'values' => [], 'description' => 'Assistive description prefix for selected count.'],
            ['name' => 'clearSelectionText', 'type' => 'string', 'required' => false, 'default' => 'To clear selection, press Delete or Backspace', 'values' => [], 'description' => 'Assistive instructions for clearing selected values.'],
            ['name' => 'clearAnnouncement', 'type' => 'string', 'required' => false, 'default' => 'All items have been cleared', 'values' => [], 'description' => 'Announcement text metadata for clear behavior.'],
            ['name' => 'selectAll', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Prepends a select-all option.'],
            ['name' => 'selectAllLabel', 'type' => 'string', 'required' => false, 'default' => 'Select all', 'values' => [], 'description' => 'Visible label for select-all option.'],
            ['name' => 'useTitleInItem', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Adds title attributes to option items.'],
            ['name' => 'decorator', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional decorator rendered inside the listbox wrapper.'],
            ['name' => 'slug', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Legacy alias for decorator.', 'compatibility' => true],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'multi-select', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-multi-select-wrapper', 'required' => true, 'description' => 'Generated wrapper marker.'],
            ['name' => 'data-ui-multi-select-state', 'required' => true, 'description' => 'Generated state marker: default, invalid, or warning.'],
            ['name' => 'data-ui-multi-select-size', 'required' => false, 'description' => 'Generated resolved size marker.'],
            ['name' => 'data-ui-multi-select-clear-description', 'required' => true, 'description' => 'Generated clear/selected-count assistive description marker.'],
            ['name' => 'data-ui-multi-select', 'required' => true, 'description' => 'Generated multi select/listbox control marker.'],
            ['name' => 'data-ui-multi-select-open', 'required' => true, 'description' => 'Generated open state marker.'],
            ['name' => 'data-ui-multi-select-direction', 'required' => true, 'description' => 'Generated direction marker.'],
            ['name' => 'data-ui-multi-select-type', 'required' => true, 'description' => 'Generated type marker.'],
            ['name' => 'data-ui-multi-select-selection-feedback', 'required' => true, 'description' => 'Generated selection feedback marker.'],
            ['name' => 'data-ui-multi-select-readonly', 'required' => true, 'description' => 'Generated read-only marker.'],
            ['name' => 'data-ui-multi-select-disabled', 'required' => true, 'description' => 'Generated disabled marker.'],
            ['name' => 'data-ui-multi-select-selected-count', 'required' => true, 'description' => 'Generated selected count marker.'],
            ['name' => 'data-ui-multi-select-selectable-count', 'required' => true, 'description' => 'Generated selectable count marker.'],
            ['name' => 'data-ui-multi-select-select-all', 'required' => true, 'description' => 'Generated select-all enabled marker.'],
            ['name' => 'data-ui-multi-select-clear-announcement-text', 'required' => true, 'description' => 'Generated clear announcement text marker.'],
            ['name' => 'data-ui-multi-select-name', 'required' => false, 'description' => 'Generated submitted name metadata.'],
            ['name' => 'data-ui-multi-select-field-wrapper', 'required' => true, 'description' => 'Generated field wrapper marker.'],
            ['name' => 'data-ui-multi-select-clear', 'required' => true, 'description' => 'Generated clear button marker.'],
            ['name' => 'data-ui-multi-select-selection-count', 'required' => true, 'description' => 'Generated selected count marker on clear affordance.'],
            ['name' => 'data-ui-multi-select-trigger', 'required' => true, 'description' => 'Generated trigger button marker.'],
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
            ['name' => 'data-ui-multi-select-validation', 'required' => false, 'description' => 'Generated invalid/warning message marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-multi-select',
        'required' => [
            'ui-multi-select__wrapper',
            'ui-list-box__wrapper',
            'ui-multi-select',
            'ui-list-box',
            'ui-list-box__field--wrapper',
            'ui-list-box__field',
            'ui-list-box__label',
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
            'ui-form__helper-text',
            'ui-form__helper-text--disabled',
            'ui-list-box__invalid-icon',
            'ui-list-box__invalid-icon--warning',
            'ui-list-box__selection',
            'ui-list-box__selection-count',
            'ui-list-box__selection-icon',
            'ui-list-box__menu-icon',
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
            'feature-local multi select wrappers',
            'ad hoc multiselect/listbox markup',
            'raw multiselect option checkbox markup outside x-ui.multi-select',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => [], 'class' => 'ui-multi-select', 'description' => 'Default closed multi select.'],
        'open' => ['label' => 'Open', 'api' => ['open' => true], 'class' => 'ui-list-box--expanded', 'description' => 'Multi select with menu rendered open.'],
        'inline' => ['label' => 'Inline', 'api' => ['type' => 'inline'], 'class' => 'ui-multi-select--inline', 'description' => 'Inline multi select type.'],
        'top-direction' => ['label' => 'Top direction', 'api' => ['direction' => 'top'], 'class' => 'ui-list-box--up', 'description' => 'Multi select menu opening upward.'],
        'light' => ['label' => 'Light', 'api' => ['light' => true], 'class' => 'ui-list-box--light', 'description' => 'Light listbox treatment.'],
        'hidden-label' => ['label' => 'Hidden label', 'api' => ['hideLabel' => true], 'class' => 'ui-visually-hidden', 'description' => 'Multi select with visually hidden title text.'],
        'with-helper' => ['label' => 'With helper text', 'api' => ['helperText' => 'Helper text'], 'class' => 'ui-form__helper-text', 'description' => 'Multi select with helper text.'],
        'selected' => ['label' => 'Selected items', 'api' => ['selectedItems' => ['a']], 'class' => 'ui-multi-select--selected', 'description' => 'Multi select with selected items.'],
        'with-select-all' => ['label' => 'With select all', 'api' => ['selectAll' => true], 'class' => 'ui-multi-select--selectall', 'description' => 'Multi select with select-all option.'],
        'select-all-indeterminate' => ['label' => 'Select all indeterminate', 'api' => ['selectAll' => true, 'selectedItems' => ['a']], 'description' => 'Select-all option in mixed state.'],
        'with-decorator' => ['label' => 'With decorator', 'api' => ['decorator' => '#'], 'class' => 'ui-list-box__wrapper--decorator', 'description' => 'Multi select with decorator content.'],
        'with-disabled-option' => ['label' => 'Disabled option', 'api' => ['items' => [['label' => 'Option', 'disabled' => true]]], 'description' => 'Multi select with disabled option.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'xs' => ['label' => 'Extra small', 'api' => ['size' => 'xs'], 'class' => 'ui-list-box--xs', 'description' => 'Extra small multi select.'],
        'sm' => ['label' => 'Small', 'api' => ['size' => 'sm'], 'class' => 'ui-list-box--sm', 'description' => 'Small multi select.'],
        'md' => ['label' => 'Medium', 'api' => ['size' => 'md'], 'class' => 'ui-list-box--md', 'description' => 'Medium multi select.'],
        'lg' => ['label' => 'Large', 'api' => ['size' => 'lg'], 'class' => 'ui-list-box--lg', 'description' => 'Large multi select.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'closed' => ['label' => 'Closed', 'required' => true, 'description' => 'Default closed menu state.'],
        'open' => ['label' => 'Open', 'required' => false, 'description' => 'Open menu state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled multi select state.'],
        'read-only' => ['label' => 'Read-only', 'required' => false, 'description' => 'Read-only multi select state.'],
        'invalid' => ['label' => 'Invalid', 'required' => false, 'description' => 'Invalid multi select state.'],
        'warning' => ['label' => 'Warning', 'required' => false, 'description' => 'Warning multi select state.'],
        'selected' => ['label' => 'Selected', 'required' => false, 'description' => 'One or more selected items.'],
        'empty' => ['label' => 'Empty', 'required' => false, 'description' => 'No selected values.'],
        'select-all' => ['label' => 'Select all', 'required' => false, 'description' => 'Select-all option is present.'],
        'indeterminate' => ['label' => 'Indeterminate', 'required' => false, 'description' => 'Select-all option is in mixed state.'],
        'option-disabled' => ['label' => 'Disabled option', 'required' => false, 'description' => 'Disabled option state.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for trigger, clear button, and options.'],
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
            'ui-checkbox',
            'ui-form',
        ],
        'component_tokens' => [
            'multi-select',
            'list-box',
            'checkbox',
            'form-field',
            'validation',
        ],
        'deprecated' => [
            'feature-local multiselect controls',
            'ad hoc multiselect/listbox markup',
            'raw multiselect checkbox option markup',
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
                'multi select behavior if installed',
            ],
        ],
        'blocks' => [
            'forms',
            'filters',
            'settings',
            'bulk-selection-controls',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Multi select trigger must be keyboard reachable unless disabled.',
            'Menu open/close, arrow navigation, option toggling, clearing, selected count sync, and focus management are owned by installed MultiSelect JavaScript.',
            'Disabled and read-only states must prevent opening and selection changes.',
            'Checkbox inputs inside options are removed from tab order; option navigation is owned by the listbox controller.',
        ],
        'aria' => [
            'Trigger renders role="combobox", aria-haspopup="listbox", aria-expanded, and aria-controls.',
            'Menu renders role="listbox" and aria-multiselectable="true".',
            'Options render role="option" and aria-selected.',
            'Disabled options expose aria-disabled.',
            'Select-all mixed state is represented on the nested checkbox with aria-checked="mixed".',
            'Trigger is labelled by titleText and/or the visible trigger label.',
            'Helper, invalid, warning, and clear-selection instruction text are associated through aria-describedby when rendered.',
            'Invalid state emits aria-invalid and aria-errormessage when invalid message text exists.',
            'Read-only state emits aria-readonly and aria-disabled.',
            'Icons are decorative and hidden from assistive technology.',
        ],
        'focus' => [
            'Trigger, clear button, and active option must show visible focus.',
            'Focus placement and active option management are owned by installed MultiSelect JavaScript.',
        ],
        'screen_reader' => [
            'Title text and trigger label should describe the value group being selected.',
            'Option labels must be meaningful and unique enough to distinguish options.',
            'Selected count and clear instructions must stay accurate when JavaScript mutates selection.',
            'Invalid and warning messages must describe the problem or caution clearly.',
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
            'feature-local multi select classes',
            'raw listbox checkbox utility clusters',
        ],
        'components' => [
            'ad hoc multiselect controls outside x-ui.multi-select',
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
            'resources/views/components/ui/multi-select/index.blade.php',
        ],
        'css' => [
            'resources/css/components/multi-select.css',
            'resources/css/components/list-box.css',
        ],
        'contract' => [
            'resources/views/components/ui/multi-select/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/multi-select.md',
        ],
    ],
]);
