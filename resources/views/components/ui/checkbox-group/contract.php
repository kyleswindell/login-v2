<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/checkbox-group/contract.php
| Purpose: Checkbox Group Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Checkbox Group API that can be called from
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
        'slug' => 'checkbox-group',
        'label' => 'Checkbox Group',
        'component' => 'x-ui.checkbox-group',
        'summary' => 'Fieldset-based checkbox group with item-array rendering, slot rendering, legend, helper text, invalid/warning states, disabled/read-only states, orientation, and decorator support.',
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
        'usage_context' => 'Use x-ui.checkbox-group for grouped checkbox choices. Use the items prop for simple generated groups, or the default slot when child checkboxes need custom markup or state.',

        'props' => [
            ['name' => 'items', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Checkbox items. Items may be strings or arrays with id, name, value, label, labelText, checked, defaultChecked/default_checked, disabled, readOnly/read_only, required, helperText/helper_text, hideLabel/hide_label, indeterminate, invalid, invalidText/invalid_text, warn, warnText/warn_text, title, and decorator.'],
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Fieldset ID. A generated ID is used when omitted.'],
            ['name' => 'name', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Default native checkbox name forwarded to generated item-array checkboxes.'],
            ['name' => 'legendText', 'type' => 'string|HtmlString', 'required' => true, 'default' => null, 'values' => [], 'description' => 'Fieldset legend text.'],
            ['name' => 'legendId', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Legend ID used for fieldset aria-labelledby. A generated ID is used when omitted.'],
            ['name' => 'helperText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Helper text shown when invalid/warning text is not active.'],
            ['name' => 'invalid', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Invalid group state. Takes precedence over warning state.'],
            ['name' => 'invalidText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Invalid group message text.'],
            ['name' => 'warn', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Warning group state. Suppressed when invalid is active.'],
            ['name' => 'warnText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Warning group message text.'],
            ['name' => 'orientation', 'type' => 'string', 'required' => false, 'default' => 'vertical', 'values' => ['horizontal', 'vertical'], 'description' => 'Checkbox group orientation.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disabled fieldset and generated checkbox state.'],
            ['name' => 'readOnly', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Read-only state forwarded to generated checkboxes and exposed as group state metadata.'],
            ['name' => 'decorator', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional decorator rendered inside the legend.'],
            ['name' => 'slug', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Legacy alias for decorator.', 'compatibility' => true],
        ],

        'slots' => [
            ['name' => 'default', 'required' => false, 'description' => 'Manual checkbox children. In slot mode, caller controls child checkbox state.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'checkbox-group', 'description' => 'Generated fieldset component marker.'],
            ['name' => 'data-ui-checkbox-group', 'required' => true, 'description' => 'Generated checkbox group marker.'],
            ['name' => 'data-ui-checkbox-group-orientation', 'required' => true, 'description' => 'Generated orientation marker.'],
            ['name' => 'data-ui-checkbox-group-disabled', 'required' => true, 'description' => 'Generated disabled state marker.'],
            ['name' => 'data-ui-checkbox-group-readonly', 'required' => true, 'description' => 'Generated read-only state marker.'],
            ['name' => 'data-ui-checkbox-group-state', 'required' => true, 'description' => 'Generated state marker: default, invalid, or warning.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-checkbox-group',
        'required' => [
            'ui-checkbox-group',
            'ui-label',
        ],
        'optional' => [
            'ui-checkbox-group--horizontal',
            'ui-checkbox-group--vertical',
            'ui-checkbox-group--readonly',
            'ui-checkbox-group--invalid',
            'ui-checkbox-group--warning',
            'ui-checkbox-group--decorator',
            'ui-checkbox-group-inner--decorator',
            'ui-checkbox-group__validation-msg',
            'ui-checkbox__invalid-icon',
            'ui-checkbox__invalid-icon--warning',
            'ui-form-requirement',
            'ui-form__helper-text',
            'ui-form__helper-text--disabled',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local checkbox group wrappers',
            'raw fieldset checkbox clusters without x-ui.checkbox-group',
            'ad hoc checkbox validation markup',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => ['legendText' => 'Options'], 'class' => 'ui-checkbox-group', 'description' => 'Default vertical checkbox group.'],
        'vertical' => ['label' => 'Vertical', 'api' => ['legendText' => 'Options', 'orientation' => 'vertical'], 'class' => 'ui-checkbox-group--vertical', 'description' => 'Vertical checkbox group.'],
        'horizontal' => ['label' => 'Horizontal', 'api' => ['legendText' => 'Options', 'orientation' => 'horizontal'], 'class' => 'ui-checkbox-group--horizontal', 'description' => 'Horizontal checkbox group.'],
        'with-items' => ['label' => 'With items', 'api' => ['legendText' => 'Options', 'items' => [['value' => 'a', 'label' => 'A']]], 'description' => 'Array-driven checkbox group.'],
        'slot-mode' => ['label' => 'Slot mode', 'api' => ['legendText' => 'Options', 'slot' => 'default'], 'description' => 'Manual slotted checkbox group.'],
        'with-helper' => ['label' => 'With helper text', 'api' => ['legendText' => 'Options', 'helperText' => 'Select all that apply.'], 'class' => 'ui-form__helper-text', 'description' => 'Checkbox group with helper text.'],
        'with-decorator' => ['label' => 'With decorator', 'api' => ['legendText' => 'Options', 'decorator' => '*'], 'class' => 'ui-checkbox-group--decorator', 'description' => 'Checkbox group with legend decorator.'],
        'invalid' => ['label' => 'Invalid', 'api' => ['legendText' => 'Options', 'invalid' => true, 'invalidText' => 'Select at least one option.'], 'class' => 'ui-checkbox-group--invalid', 'description' => 'Invalid checkbox group.'],
        'warning' => ['label' => 'Warning', 'api' => ['legendText' => 'Options', 'warn' => true, 'warnText' => 'Review these choices.'], 'class' => 'ui-checkbox-group--warning', 'description' => 'Warning checkbox group.'],
        'disabled' => ['label' => 'Disabled', 'api' => ['legendText' => 'Options', 'disabled' => true], 'description' => 'Disabled checkbox group.'],
        'read-only' => ['label' => 'Read-only', 'api' => ['legendText' => 'Options', 'readOnly' => true], 'class' => 'ui-checkbox-group--readonly', 'description' => 'Read-only checkbox group.'],
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
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default checkbox group state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled group state.'],
        'read-only' => ['label' => 'Read-only', 'required' => false, 'description' => 'Read-only group state.'],
        'invalid' => ['label' => 'Invalid', 'required' => false, 'description' => 'Invalid group state.'],
        'warning' => ['label' => 'Warning', 'required' => false, 'description' => 'Warning group state.'],
        'with-helper' => ['label' => 'With helper', 'required' => false, 'description' => 'Helper text is rendered.'],
        'with-items' => ['label' => 'With items', 'required' => false, 'description' => 'Generated item-array checkboxes are rendered.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for child checkboxes.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-checkbox',
            'ui-form',
        ],
        'component_tokens' => [
            'checkbox-group',
            'checkbox',
            'fieldset',
            'validation',
        ],
        'deprecated' => [
            'feature-local checkbox groups',
            'raw fieldset checkbox clusters',
            'ad hoc checkbox group validation markup',
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
            ],
            'components' => [
                'ui.icon',
                'ui.checkbox',
            ],
            'js_initializers' => [],
        ],
        'blocks' => [
            'forms',
            'settings',
            'choice-groups',
            'multi-choice-controls',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Child checkboxes must retain native checkbox keyboard behavior.',
            'Disabled groups must prevent child checkbox interaction through native fieldset behavior.',
            'Slot mode must preserve appropriate child checkbox names and state.',
        ],
        'aria' => [
            'Group uses native fieldset/legend semantics.',
            'Helper, invalid, and warning text are associated through aria-describedby.',
            'Invalid state emits aria-invalid and aria-errormessage when invalid message text exists.',
            'Warning and invalid icons are decorative and hidden from assistive technology.',
            'Read-only state is forwarded to generated child checkboxes and exposed through data state markers.',
        ],
        'focus' => [
            'Child checkboxes must show visible focus.',
        ],
        'screen_reader' => [
            'Legend should describe the group of choices.',
            'Each checkbox label should be concise and unique within the group.',
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
            'feature-local checkbox group classes',
            'raw checkbox fieldset utility clusters',
        ],
        'components' => [
            'ad hoc checkbox groups outside x-ui.checkbox-group',
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
            'resources/views/components/ui/checkbox-group/index.blade.php',
        ],
        'css' => [
            'resources/css/components/checkbox.css',
        ],
        'contract' => [
            'resources/views/components/ui/checkbox-group/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/checkbox-group.md',
        ],
    ],
]);
