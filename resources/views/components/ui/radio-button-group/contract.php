<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/radio-button-group/contract.php
| Purpose: Radio Button Group Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Radio Button Group API that can be called
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
        'slug' => 'radio-button-group',
        'label' => 'Radio Button Group',
        'component' => 'x-ui.radio-button-group',
        'summary' => 'Fieldset-based radio button group with item-array rendering, slot rendering, legend, helper text, invalid/warning states, disabled/read-only/required states, label positioning, orientation, and decorator support.',
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
        'usage_context' => 'Use x-ui.radio-button-group for grouped radio choices. Use the items prop for simple generated groups, or the default slot when child radio buttons need custom markup or state.',

        'props' => [
            ['name' => 'items', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Radio button items. Items may be strings or arrays with id, value, label, labelText, checked, disabled, hideLabel, and decorator.'],
            ['name' => 'name', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Native radio name shared by generated item-array radio buttons. Required when using items for form submission.'],
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Fieldset ID. A generated ID is used when omitted.'],
            ['name' => 'legendText', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Canonical fieldset legend text.'],
            ['name' => 'legend', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Compatibility alias for legendText.', 'compatibility' => true],
            ['name' => 'helperText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Helper text shown when invalid/warning text is not active.'],
            ['name' => 'invalid', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Invalid group state. Takes precedence over warning state.'],
            ['name' => 'invalidText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Invalid message text.'],
            ['name' => 'warn', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Warning group state. Suppressed when invalid is active.'],
            ['name' => 'warnText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Warning message text.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disabled fieldset and generated radio state.'],
            ['name' => 'readOnly', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Read-only state forwarded to generated radio buttons.'],
            ['name' => 'required', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Required state forwarded to generated radio buttons.'],
            ['name' => 'labelPosition', 'type' => 'string', 'required' => false, 'default' => 'right', 'values' => ['left', 'right'], 'description' => 'Generated radio label position.'],
            ['name' => 'orientation', 'type' => 'string', 'required' => false, 'default' => 'horizontal', 'values' => ['horizontal', 'vertical'], 'description' => 'Radio group orientation.'],
            ['name' => 'defaultSelected', 'type' => 'string|int|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Default selected item value for generated items.'],
            ['name' => 'valueSelected', 'type' => 'string|int|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Controlled selected item value for generated items. Takes precedence over defaultSelected.'],
            ['name' => 'decorator', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional decorator rendered inside the legend.'],
        ],

        'slots' => [
            ['name' => 'default', 'required' => false, 'description' => 'Manual radio button children. In slot mode, caller controls child radio checked state.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'radio-button-group', 'description' => 'Generated wrapper component marker.'],
            ['name' => 'data-ui-radio-button-group-wrapper', 'required' => true, 'description' => 'Generated wrapper marker.'],
            ['name' => 'data-ui-radio-button-group', 'required' => true, 'description' => 'Generated fieldset marker.'],
            ['name' => 'data-ui-radio-button-group-orientation', 'required' => true, 'description' => 'Generated orientation marker.'],
            ['name' => 'data-ui-radio-button-group-label-position', 'required' => true, 'description' => 'Generated label position marker.'],
            ['name' => 'data-ui-radio-button-group-disabled', 'required' => true, 'description' => 'Generated disabled state marker.'],
            ['name' => 'data-ui-radio-button-group-readonly', 'required' => true, 'description' => 'Generated read-only state marker.'],
            ['name' => 'data-ui-radio-button-group-required', 'required' => true, 'description' => 'Generated required state marker.'],
            ['name' => 'data-ui-radio-button-group-state', 'required' => true, 'description' => 'Generated state marker: default, invalid, or warning.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-radio-button-group',
        'required' => [
            'ui-form-item',
            'ui-radio-button-group',
        ],
        'optional' => [
            'ui-radio-button-group--vertical',
            'ui-radio-button-group--label-left',
            'ui-radio-button-group--label-right',
            'ui-radio-button-group--readonly',
            'ui-radio-button-group--invalid',
            'ui-radio-button-group--warning',
            'ui-radio-button-group--decorator',
            'ui-label',
            'ui-radio-button-group-inner--decorator',
            'ui-radio-button__validation-msg',
            'ui-radio-button__invalid-icon',
            'ui-radio-button__invalid-icon--warning',
            'ui-form-requirement',
            'ui-form__helper-text',
            'ui-form__helper-text--disabled',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local radio group wrappers',
            'raw fieldset radio clusters without x-ui.radio-button-group',
            'ad hoc radio validation markup',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => [], 'class' => 'ui-radio-button-group', 'description' => 'Default horizontal radio button group.'],
        'horizontal' => ['label' => 'Horizontal', 'api' => ['orientation' => 'horizontal'], 'description' => 'Horizontal radio button group.'],
        'vertical' => ['label' => 'Vertical', 'api' => ['orientation' => 'vertical'], 'class' => 'ui-radio-button-group--vertical', 'description' => 'Vertical radio button group.'],
        'label-left' => ['label' => 'Label left', 'api' => ['labelPosition' => 'left'], 'class' => 'ui-radio-button-group--label-left', 'description' => 'Radio labels positioned left.'],
        'label-right' => ['label' => 'Label right', 'api' => ['labelPosition' => 'right'], 'class' => 'ui-radio-button-group--label-right', 'description' => 'Radio labels positioned right.'],
        'with-items' => ['label' => 'With items', 'api' => ['items' => [['value' => 'a', 'label' => 'A']]], 'description' => 'Array-driven radio button group.'],
        'slot-mode' => ['label' => 'Slot mode', 'api' => ['slot' => 'default'], 'description' => 'Manual slotted radio button group.'],
        'with-helper' => ['label' => 'With helper text', 'api' => ['helperText' => 'Choose one option.'], 'class' => 'ui-form__helper-text', 'description' => 'Radio button group with helper text.'],
        'with-decorator' => ['label' => 'With decorator', 'api' => ['decorator' => '*'], 'class' => 'ui-radio-button-group--decorator', 'description' => 'Radio button group with legend decorator.'],
        'invalid' => ['label' => 'Invalid', 'api' => ['invalid' => true, 'invalidText' => 'Select an option.'], 'class' => 'ui-radio-button-group--invalid', 'description' => 'Invalid radio button group.'],
        'warning' => ['label' => 'Warning', 'api' => ['warn' => true, 'warnText' => 'Review this choice.'], 'class' => 'ui-radio-button-group--warning', 'description' => 'Warning radio button group.'],
        'disabled' => ['label' => 'Disabled', 'api' => ['disabled' => true], 'description' => 'Disabled radio button group.'],
        'read-only' => ['label' => 'Read-only', 'api' => ['readOnly' => true], 'class' => 'ui-radio-button-group--readonly', 'description' => 'Read-only radio button group.'],
        'required' => ['label' => 'Required', 'api' => ['required' => true], 'description' => 'Required radio button group.'],
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
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default radio button group state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled group state.'],
        'read-only' => ['label' => 'Read-only', 'required' => false, 'description' => 'Read-only group state.'],
        'required' => ['label' => 'Required', 'required' => false, 'description' => 'Required group state.'],
        'invalid' => ['label' => 'Invalid', 'required' => false, 'description' => 'Invalid group state.'],
        'warning' => ['label' => 'Warning', 'required' => false, 'description' => 'Warning group state.'],
        'with-helper' => ['label' => 'With helper', 'required' => false, 'description' => 'Helper text is rendered.'],
        'with-selection' => ['label' => 'With selection', 'required' => false, 'description' => 'One generated item is selected.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for child radio buttons.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-radio-button',
            'ui-form',
        ],
        'component_tokens' => [
            'radio-button-group',
            'radio-button',
            'fieldset',
            'validation',
        ],
        'deprecated' => [
            'feature-local radio groups',
            'raw fieldset radio clusters',
            'ad hoc radio validation markup',
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
            'radio-button',
            'motion',
        ],
        'uses' => [
            'icons' => [
                'warning--filled',
                'warning--alt',
            ],
            'components' => [
                'ui.icon',
                'ui.radio-button',
            ],
            'js_initializers' => [],
        ],
        'blocks' => [
            'forms',
            'settings',
            'choice-groups',
            'single-choice-controls',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Child radio buttons must retain native radio keyboard behavior.',
            'Disabled groups must prevent child radio interaction.',
            'Slot mode must preserve a shared radio name across related child radios.',
        ],
        'aria' => [
            'Group uses native fieldset/legend semantics when legend text is provided.',
            'Caller may provide aria-label or aria-labelledby when no legend is rendered.',
            'Helper, invalid, and warning text are associated through aria-describedby.',
            'Invalid state emits aria-invalid and aria-errormessage when invalid message text exists.',
            'Warning and invalid icons are decorative and hidden from assistive technology.',
        ],
        'focus' => [
            'Child radio buttons must show visible focus.',
        ],
        'screen_reader' => [
            'Legend or accessible label should describe the choice being made.',
            'Each radio label should be concise and unique within the group.',
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
            ['name' => 'legend', 'replacement' => 'legendText', 'description' => 'legend remains accepted as a compatibility alias.'],
            ['name' => 'defaultSelected', 'replacement' => 'valueSelected for controlled state', 'description' => 'defaultSelected remains accepted for default item-array selection.'],
        ],
        'classes' => [
            'feature-local radio group classes',
            'raw radio fieldset utility clusters',
        ],
        'components' => [
            'ad hoc radio groups outside x-ui.radio-button-group',
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
            'resources/views/components/ui/radio-button-group/index.blade.php',
        ],
        'css' => [
            'resources/css/components/radio-button.css',
        ],
        'contract' => [
            'resources/views/components/ui/radio-button-group/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/radio-button-group.md',
        ],
    ],
]);
