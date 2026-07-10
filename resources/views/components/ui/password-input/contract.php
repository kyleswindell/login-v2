<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/password-input/contract.php
| Purpose: Password Input Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Password Input API that can be called from
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
        'slug' => 'password-input',
        'label' => 'Password Input',
        'component' => 'x-ui.password-input',
        'summary' => 'Password input form control extending text-input anatomy with visibility toggle, helper text, invalid/warning states, read-only/disabled states, inline layout, light treatment, and size support.',
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
        'usage_context' => 'Use x-ui.password-input for password or revealable secret text fields. Use x-ui.text-input for regular single-line text fields.',

        'props' => [
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Input ID. A generated ID is used when omitted.'],
            ['name' => 'name', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Native input name for form submission.'],
            ['name' => 'type', 'type' => 'string', 'required' => false, 'default' => 'password', 'values' => ['password', 'text'], 'description' => 'Initial native input type. text represents initially visible password state.'],
            ['name' => 'labelText', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Canonical label text.'],
            ['name' => 'label', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Compatibility alias for labelText.', 'compatibility' => true],
            ['name' => 'value', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Controlled input value. Takes precedence over defaultValue.'],
            ['name' => 'defaultValue', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Initial input value when value is not supplied.'],
            ['name' => 'placeholder', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Native placeholder text.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Native disabled state. Also disables the visibility toggle.'],
            ['name' => 'readOnly', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Native readonly state. Visibility toggle remains available unless disabled.'],
            ['name' => 'required', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Native required state.'],
            ['name' => 'helperText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Helper text shown when invalid/warning text is not active.'],
            ['name' => 'hideLabel', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Visually hides the label while preserving it for assistive technology.'],
            ['name' => 'inline', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Applies inline field layout classes.'],
            ['name' => 'invalid', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Invalid state. Takes precedence over warning state.'],
            ['name' => 'invalidText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Invalid message text.'],
            ['name' => 'warn', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Warning state. Suppressed when invalid is active.'],
            ['name' => 'warnText', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Warning message text.'],
            ['name' => 'light', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Light input treatment.'],
            ['name' => 'size', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => ['xs', 'sm', 'md', 'lg'], 'description' => 'Input size. Null uses default CSS sizing.'],
            ['name' => 'showPasswordLabel', 'type' => 'string', 'required' => false, 'default' => 'Show password', 'values' => [], 'description' => 'Accessible label when password is currently hidden.'],
            ['name' => 'hidePasswordLabel', 'type' => 'string', 'required' => false, 'default' => 'Hide password', 'values' => [], 'description' => 'Accessible label when password is currently visible.'],
            ['name' => 'tooltipPosition', 'type' => 'string', 'required' => false, 'default' => 'bottom', 'values' => ['top', 'right', 'bottom', 'left'], 'description' => 'Tooltip position class for the visibility toggle.'],
            ['name' => 'tooltipAlignment', 'type' => 'string', 'required' => false, 'default' => 'end', 'values' => ['start', 'center', 'end'], 'description' => 'Tooltip alignment class for the visibility toggle.'],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'password-input', 'description' => 'Generated form item component marker.'],
            ['name' => 'data-ui-password-input-wrapper', 'required' => true, 'description' => 'Generated password input wrapper marker.'],
            ['name' => 'data-ui-password-input-state', 'required' => true, 'description' => 'Generated resolved state marker: default, invalid, or warning.'],
            ['name' => 'data-ui-password-input-size', 'required' => false, 'description' => 'Generated resolved size marker.'],
            ['name' => 'data-ui-password-input-inline', 'required' => true, 'description' => 'Generated inline state marker.'],
            ['name' => 'data-ui-password-input-light', 'required' => true, 'description' => 'Generated light state marker.'],
            ['name' => 'data-ui-password-input-field-wrapper', 'required' => true, 'description' => 'Generated field wrapper marker.'],
            ['name' => 'data-ui-password-input', 'required' => true, 'description' => 'Generated native input marker.'],
            ['name' => 'data-toggle-password-visibility', 'required' => true, 'description' => 'Generated legacy password visibility marker.'],
            ['name' => 'data-ui-password-toggle', 'required' => true, 'description' => 'Generated visibility toggle marker.'],
            ['name' => 'data-ui-password-toggle-target', 'required' => true, 'description' => 'Generated target input ID for visibility toggle behavior.'],
            ['name' => 'data-ui-password-show-label', 'required' => true, 'description' => 'Generated show-label value for toggle JavaScript.'],
            ['name' => 'data-ui-password-hide-label', 'required' => true, 'description' => 'Generated hide-label value for toggle JavaScript.'],
            ['name' => 'data-ui-password-icon', 'required' => true, 'description' => 'Generated visibility icon marker: show or hide.'],
            ['name' => 'data-ui-password-input-validation', 'required' => false, 'description' => 'Generated invalid/warning message marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-password-input-wrapper',
        'required' => [
            'ui-form-item',
            'ui-text-input-wrapper',
            'ui-password-input-wrapper',
            'ui-text-input__field-outer-wrapper',
            'ui-text-input__field-wrapper',
            'ui-text-input',
            'ui-password-input',
            'ui-text-input__divider',
            'ui-text-input--password__visibility__toggle',
        ],
        'optional' => [
            'ui-text-input-wrapper--readonly',
            'ui-text-input-wrapper--light',
            'ui-text-input-wrapper--inline',
            'ui-text-input-wrapper--inline--invalid',
            'ui-label',
            'ui-visually-hidden',
            'ui-label--disabled',
            'ui-label--inline',
            'ui-label--inline--xs',
            'ui-label--inline--sm',
            'ui-label--inline--md',
            'ui-label--inline--lg',
            'ui-text-input--light',
            'ui-text-input--invalid',
            'ui-text-input--warning',
            'ui-text-input--xs',
            'ui-text-input--sm',
            'ui-text-input--md',
            'ui-text-input--lg',
            'ui-layout--size-xs',
            'ui-layout--size-sm',
            'ui-layout--size-md',
            'ui-layout--size-lg',
            'ui-form__helper-text',
            'ui-form__helper-text--disabled',
            'ui-form__helper-text--inline',
            'ui-text-input__field-outer-wrapper--inline',
            'ui-text-input__field-wrapper--warning',
            'ui-text-input__invalid-icon',
            'ui-text-input__invalid-icon--warning',
            'ui-btn',
            'ui-tooltip__trigger',
            'ui-tooltip--a11y',
            'ui-tooltip--top',
            'ui-tooltip--right',
            'ui-tooltip--bottom',
            'ui-tooltip--left',
            'ui-tooltip--align-start',
            'ui-tooltip--align-center',
            'ui-tooltip--align-end',
            'ui-assistive-text',
            'ui-icon-visibility-on',
            'ui-icon-visibility-off',
            'ui-form-requirement',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local password input wrappers',
            'ad hoc password visibility buttons',
            'raw password validation markup outside x-ui.password-input',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => [], 'class' => 'ui-password-input', 'description' => 'Default password input.'],
        'visible' => ['label' => 'Visible', 'api' => ['type' => 'text'], 'description' => 'Password input initially rendered as visible text.'],
        'light' => ['label' => 'Light', 'api' => ['light' => true], 'class' => 'ui-text-input--light', 'description' => 'Light password input treatment.'],
        'inline' => ['label' => 'Inline', 'api' => ['inline' => true], 'class' => 'ui-text-input-wrapper--inline', 'description' => 'Inline password input layout.'],
        'hidden-label' => ['label' => 'Hidden label', 'api' => ['hideLabel' => true], 'class' => 'ui-visually-hidden', 'description' => 'Password input with visually hidden label.'],
        'with-helper' => ['label' => 'With helper text', 'api' => ['helperText' => 'Helper text'], 'class' => 'ui-form__helper-text', 'description' => 'Password input with helper text.'],
        'toggle-top' => ['label' => 'Toggle tooltip top', 'api' => ['tooltipPosition' => 'top'], 'class' => 'ui-tooltip--top', 'description' => 'Visibility toggle with top tooltip position.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'xs' => ['label' => 'Extra small', 'api' => ['size' => 'xs'], 'class' => 'ui-text-input--xs', 'description' => 'Extra small password input.'],
        'sm' => ['label' => 'Small', 'api' => ['size' => 'sm'], 'class' => 'ui-text-input--sm', 'description' => 'Small password input.'],
        'md' => ['label' => 'Medium', 'api' => ['size' => 'md'], 'class' => 'ui-text-input--md', 'description' => 'Medium password input.'],
        'lg' => ['label' => 'Large', 'api' => ['size' => 'lg'], 'class' => 'ui-text-input--lg', 'description' => 'Large password input.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default enabled password input state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled input and disabled visibility toggle state.'],
        'read-only' => ['label' => 'Read-only', 'required' => false, 'description' => 'Read-only input state.'],
        'required' => ['label' => 'Required', 'required' => false, 'description' => 'Required input state.'],
        'invalid' => ['label' => 'Invalid', 'required' => false, 'description' => 'Invalid password input state.'],
        'warning' => ['label' => 'Warning', 'required' => false, 'description' => 'Warning password input state.'],
        'visible' => ['label' => 'Visible password', 'required' => false, 'description' => 'Password text is currently visible.'],
        'hidden' => ['label' => 'Hidden password', 'required' => true, 'description' => 'Password text is hidden.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for input and visibility toggle.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-password-input',
            'ui-text-input',
            'ui-form',
            'ui-tooltip',
        ],
        'component_tokens' => [
            'password-input',
            'text-input',
            'form-field',
            'visibility-toggle',
            'validation',
        ],
        'deprecated' => [
            'feature-local password fields',
            'ad hoc visibility toggles',
            'raw password validation markup',
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
            'tooltip',
            'motion',
        ],
        'uses' => [
            'icons' => [
                'warning--filled',
                'warning--alt',
                'view',
                'view--off',
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [
                'password input visibility behavior if installed',
            ],
        ],
        'blocks' => [
            'forms',
            'login',
            'account-security',
            'settings',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Native input keyboard behavior must remain intact.',
            'Visibility toggle must be keyboard reachable unless disabled.',
            'Disabled input and toggle must not be focusable.',
        ],
        'aria' => [
            'Password input should be labelled by a visible or visually hidden label, or by caller-provided aria-label/aria-labelledby.',
            'Helper, invalid, and warning text are associated through aria-describedby when rendered.',
            'Invalid state emits aria-invalid and aria-errormessage when invalid message text exists.',
            'Visibility toggle exposes aria-label and aria-pressed.',
            'Visibility and validation icons are decorative and hidden from assistive technology.',
        ],
        'focus' => [
            'Input and visibility toggle must show visible focus.',
        ],
        'screen_reader' => [
            'Show/hide labels must clearly describe the current action.',
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
            ['name' => 'label', 'replacement' => 'labelText', 'description' => 'label remains accepted as a compatibility alias.'],
        ],
        'classes' => [
            'feature-local password input classes',
            'raw password visibility utility clusters',
        ],
        'components' => [
            'ad hoc password fields outside x-ui.password-input',
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
            'resources/views/components/ui/password-input/index.blade.php',
        ],
        'css' => [
            'resources/css/components/text-input.css',
        ],
        'contract' => [
            'resources/views/components/ui/password-input/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/password-input.md',
        ],
    ],
]);
