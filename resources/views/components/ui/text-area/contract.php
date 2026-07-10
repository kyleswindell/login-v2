<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/text-area/contract.php
| Purpose: Text Area Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Text Area API that can be called from
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
        'slug' => 'text-area',
        'label' => 'Text Area',
        'component' => 'x-ui.text-area',
        'summary' => 'Multiline text input with label, helper text, invalid/warning states, read-only/disabled states, counter support, light treatment, hidden label, rows/cols, and optional decorator.',
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
        'usage_context' => 'Use x-ui.text-area for multiline text entry. Use x-ui.text-input for single-line input and x-ui.search for search fields.',

        'props' => [
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Textarea ID. A generated ID is used when omitted.'],
            ['name' => 'name', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Native textarea name for form submission.'],
            ['name' => 'labelText', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Canonical label text.'],
            ['name' => 'label', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Compatibility alias for labelText.', 'compatibility' => true],
            ['name' => 'value', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Controlled textarea value. Takes precedence over defaultValue.'],
            ['name' => 'defaultValue', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Initial textarea value when value is not supplied.'],
            ['name' => 'placeholder', 'type' => 'string|null', 'required' => false, 'default' => '', 'values' => [], 'description' => 'Native placeholder text.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Native disabled state.'],
            ['name' => 'readOnly', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Native readonly state with aria-readonly.'],
            ['name' => 'required', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Native required state.'],
            ['name' => 'helperText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Helper text shown when invalid/warning text is not active.'],
            ['name' => 'hideLabel', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Visually hides the label while preserving it for assistive technology.'],
            ['name' => 'invalid', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Invalid state. Takes precedence over warning state.'],
            ['name' => 'invalidText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Invalid message text.'],
            ['name' => 'warn', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Warning state. Suppressed when invalid is active.'],
            ['name' => 'warnText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Warning message text.'],
            ['name' => 'light', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Light textarea treatment.'],
            ['name' => 'rows', 'type' => 'int|string|null', 'required' => false, 'default' => 4, 'values' => [], 'description' => 'Native textarea rows attribute.'],
            ['name' => 'cols', 'type' => 'int|string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Native textarea cols attribute.'],
            ['name' => 'enableCounter', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Enables character or word counter when maxCount is supplied.'],
            ['name' => 'maxCount', 'type' => 'int|string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Maximum count used by counter. Character mode also applies maxlength.'],
            ['name' => 'counterMode', 'type' => 'string', 'required' => false, 'default' => 'character', 'values' => ['character', 'word'], 'description' => 'Counter mode.'],
            ['name' => 'decorator', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional decorator rendered inside the textarea wrapper.'],
            ['name' => 'slug', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Legacy alias for decorator.', 'compatibility' => true],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'text-area', 'description' => 'Generated form item component marker.'],
            ['name' => 'data-ui-text-area-form-item', 'required' => true, 'description' => 'Generated form item marker.'],
            ['name' => 'data-ui-text-area-wrapper', 'required' => true, 'description' => 'Generated textarea wrapper marker.'],
            ['name' => 'data-ui-text-area-state', 'required' => true, 'description' => 'Generated state marker: default, invalid, or warning.'],
            ['name' => 'data-ui-text-area', 'required' => true, 'description' => 'Generated native textarea marker.'],
            ['name' => 'data-ui-text-area-counter', 'required' => false, 'description' => 'Generated visible counter marker.'],
            ['name' => 'data-ui-text-area-counter-input', 'required' => false, 'description' => 'Generated counter-enabled input marker.'],
            ['name' => 'data-ui-text-area-counter-mode', 'required' => false, 'description' => 'Generated counter mode marker.'],
            ['name' => 'data-ui-text-area-max-count', 'required' => false, 'description' => 'Generated max count marker.'],
            ['name' => 'data-ui-text-area-counter-alert', 'required' => false, 'description' => 'Generated live counter announcement marker.'],
            ['name' => 'data-ui-text-area-validation', 'required' => false, 'description' => 'Generated validation/warning message marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-form-item',
        'required' => [
            'ui-form-item',
            'ui-text-area__label-wrapper',
            'ui-text-area__wrapper',
            'ui-text-area',
        ],
        'optional' => [
            'ui-label',
            'ui-visually-hidden',
            'ui-label--disabled',
            'ui-text-area__label-counter',
            'ui-text-area__wrapper--cols',
            'ui-text-area__wrapper--readonly',
            'ui-text-area__wrapper--warn',
            'ui-text-area__wrapper--decorator',
            'ui-text-area--light',
            'ui-text-area--invalid',
            'ui-text-area--warn',
            'ui-form__helper-text',
            'ui-form__helper-text--disabled',
            'ui-text-area__invalid-icon',
            'ui-text-area__invalid-icon--warning',
            'ui-text-area__inner-wrapper--decorator',
            'ui-text-area__counter-alert',
            'ui-form-requirement',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local textarea wrappers',
            'ad hoc textarea validation markup',
            'raw counter markup outside x-ui.text-area',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => [], 'class' => 'ui-text-area', 'description' => 'Default textarea.'],
        'light' => ['label' => 'Light', 'api' => ['light' => true], 'class' => 'ui-text-area--light', 'description' => 'Light textarea treatment.'],
        'hidden-label' => ['label' => 'Hidden label', 'api' => ['hideLabel' => true], 'class' => 'ui-visually-hidden', 'description' => 'Textarea with visually hidden label.'],
        'with-helper' => ['label' => 'With helper text', 'api' => ['helperText' => 'Helper text'], 'class' => 'ui-form__helper-text', 'description' => 'Textarea with helper text.'],
        'with-counter' => ['label' => 'With counter', 'api' => ['enableCounter' => true, 'maxCount' => 100], 'class' => 'ui-text-area__label-counter', 'description' => 'Textarea with counter.'],
        'word-counter' => ['label' => 'Word counter', 'api' => ['enableCounter' => true, 'maxCount' => 20, 'counterMode' => 'word'], 'description' => 'Textarea with word counter mode.'],
        'with-cols' => ['label' => 'With cols', 'api' => ['cols' => 40], 'class' => 'ui-text-area__wrapper--cols', 'description' => 'Textarea with native cols attribute.'],
        'with-decorator' => ['label' => 'With decorator', 'api' => ['decorator' => '#'], 'class' => 'ui-text-area__wrapper--decorator', 'description' => 'Textarea with inner decorator.'],
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
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default enabled textarea state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled textarea state.'],
        'read-only' => ['label' => 'Read-only', 'required' => false, 'description' => 'Read-only textarea state.'],
        'required' => ['label' => 'Required', 'required' => false, 'description' => 'Required textarea state.'],
        'invalid' => ['label' => 'Invalid', 'required' => false, 'description' => 'Invalid textarea state.'],
        'warning' => ['label' => 'Warning', 'required' => false, 'description' => 'Warning textarea state.'],
        'counter' => ['label' => 'Counter', 'required' => false, 'description' => 'Counter-enabled state.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-text-area',
            'ui-form',
            'ui-label',
        ],
        'component_tokens' => [
            'text-area',
            'form-field',
            'validation',
            'counter',
        ],
        'deprecated' => [
            'feature-local textarea wrappers',
            'ad hoc validation text',
            'raw counter markup',
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
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [
                'text area counter behavior if installed',
            ],
        ],
        'blocks' => [
            'forms',
            'comments',
            'notes',
            'long-form-inputs',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Native textarea keyboard behavior must remain intact.',
            'Disabled textarea must not be focusable.',
            'Read-only textarea may remain focusable for reading/copying content.',
        ],
        'aria' => [
            'Textarea should be labelled by a visible or visually hidden label, or by caller-provided aria-label/aria-labelledby.',
            'Helper, invalid, warning, and counter description text are associated through aria-describedby when rendered.',
            'Invalid state emits aria-invalid and aria-errormessage when invalid message text exists.',
            'Read-only state emits aria-readonly.',
            'Counter live region announces count changes when counter behavior updates it.',
        ],
        'focus' => [
            'Textarea must show visible focus.',
            'Validation icons are decorative and hidden from assistive technology.',
        ],
        'screen_reader' => [
            'Invalid and warning messages must describe the problem or caution clearly.',
            'Counter description must identify the limit.',
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
            ['name' => 'label', 'replacement' => 'labelText', 'description' => 'label remains accepted as a compatibility alias.'],
            ['name' => 'slug', 'replacement' => 'decorator', 'description' => 'slug remains accepted as a compatibility alias for decorator.'],
        ],
        'classes' => [
            'feature-local textarea classes',
            'raw textarea validation utility clusters',
        ],
        'components' => [
            'ad hoc textarea fields outside x-ui.text-area',
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
            'resources/views/components/ui/text-area/index.blade.php',
        ],
        'css' => [
            'resources/css/components/text-area.css',
        ],
        'contract' => [
            'resources/views/components/ui/text-area/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/text-area.md',
        ],
    ],
]);
