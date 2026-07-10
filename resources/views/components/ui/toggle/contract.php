<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/toggle/contract.php
| Purpose: Toggle Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Toggle API that can be called from Blade,
| validated by tooling, and consumed by app layouts or Patterns.
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
        'slug' => 'toggle',
        'label' => 'Toggle',
        'component' => 'x-ui.toggle',
        'summary' => 'Switch-style checkbox form control for immediate on/off settings.',
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
        'usage_context' => 'Use x-ui.toggle for immediate on/off settings where the state is understandable without a separate submit action.',

        'props' => [
            [
                'name' => 'name',
                'type' => 'string',
                'required' => true,
                'default' => null,
                'values' => [],
                'description' => 'Native checkbox name attribute.',
            ],
            [
                'name' => 'id',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Toggle input ID. A slugged name-based ID is used when omitted.',
            ],
            [
                'name' => 'value',
                'type' => 'string|int|float|bool',
                'required' => false,
                'default' => '1',
                'values' => [],
                'description' => 'Native checkbox value attribute.',
            ],
            [
                'name' => 'labelText',
                'type' => 'string|HtmlString|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Visible label text for the toggle.',
            ],
            [
                'name' => 'label',
                'type' => 'string|HtmlString|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Compatibility alias for labelText.',
                'compatibility' => true,
            ],
            [
                'name' => 'checked',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Checked state for the native checkbox input.',
            ],
            [
                'name' => 'defaultChecked',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Initial checked state fallback.',
            ],
            [
                'name' => 'toggled',
                'type' => 'bool|null',
                'required' => false,
                'default' => null,
                'values' => [true, false],
                'description' => 'Carbon-style checked-state alias. When provided, toggled takes precedence over checked/defaultChecked/defaultToggled.',
                'compatibility' => true,
            ],
            [
                'name' => 'defaultToggled',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Carbon-style initial checked-state alias.',
                'compatibility' => true,
            ],
            [
                'name' => 'disabled',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Disables the native checkbox input.',
            ],
            [
                'name' => 'readOnly',
                'type' => 'bool|null',
                'required' => false,
                'default' => null,
                'values' => [true, false],
                'description' => 'Read-only state. Emits aria-readonly and prevents click toggling.',
            ],
            [
                'name' => 'readonly',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Legacy alias for readOnly.',
                'compatibility' => true,
            ],
            [
                'name' => 'required',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Adds the native required attribute.',
            ],
            [
                'name' => 'helperText',
                'type' => 'string|HtmlString|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Helper text associated through aria-describedby.',
            ],
            [
                'name' => 'helper',
                'type' => 'string|HtmlString|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Compatibility alias for helperText.',
                'compatibility' => true,
            ],
            [
                'name' => 'hideLabel',
                'type' => 'bool',
                'required' => false,
                'default' => false,
                'values' => [true, false],
                'description' => 'Visually hides the label while preserving it for assistive technology.',
            ],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            [
                'name' => 'data-ui-component',
                'required' => true,
                'value' => 'toggle',
                'description' => 'Generated root component marker.',
            ],
            [
                'name' => 'data-ui-toggle-wrapper',
                'required' => true,
                'description' => 'Generated wrapper marker.',
            ],
            [
                'name' => 'data-ui-toggle-state',
                'required' => true,
                'description' => 'Generated resolved state marker: on or off.',
            ],
            [
                'name' => 'data-ui-toggle-readonly',
                'required' => false,
                'description' => 'Generated wrapper marker when readOnly is true.',
            ],
            [
                'name' => 'data-ui-toggle',
                'required' => true,
                'description' => 'Generated native input marker.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-switch',
        'required' => [
            'ui-switch',
            'ui-switch-input',
            'ui-switch-track',
            'ui-switch-thumb',
            'ui-control-label',
        ],
        'optional' => [
            'ui-control-copy',
            'ui-visually-hidden',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local toggle wrapper classes',
            'ad hoc switch markup outside x-ui.toggle',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => [
            'label' => 'Default',
            'api' => [],
            'description' => 'Standard toggle with visible label.',
        ],
        'hidden-label' => [
            'label' => 'Hidden label',
            'api' => ['hideLabel' => true],
            'class' => 'ui-visually-hidden',
            'description' => 'Visually hidden toggle label with accessible label preserved.',
        ],
        'helper-text' => [
            'label' => 'Helper text',
            'api' => ['helperText' => '...'],
            'class' => 'ui-control-copy',
            'description' => 'Toggle with helper copy associated by aria-describedby.',
        ],
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
        'off' => [
            'label' => 'Off',
            'required' => true,
            'description' => 'Unchecked switch state.',
        ],
        'on' => [
            'label' => 'On',
            'required' => true,
            'description' => 'Checked switch state.',
        ],
        'disabled' => [
            'label' => 'Disabled',
            'required' => false,
            'description' => 'Disabled switch state using native disabled attribute.',
        ],
        'read-only' => [
            'label' => 'Read-only',
            'required' => false,
            'description' => 'Read-only switch state using aria-readonly and click prevention.',
        ],
        'required' => [
            'label' => 'Required',
            'required' => false,
            'description' => 'Required switch state using native required attribute.',
        ],
        'focus-visible' => [
            'label' => 'Focus-visible',
            'required' => true,
            'description' => 'Visible keyboard focus state handled by CSS.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-switch',
            'ui-control-label',
            'ui-control-copy',
        ],
        'component_tokens' => [
            'toggle',
            'field',
            'form',
        ],
        'deprecated' => [
            'feature-local toggle colors',
            'feature-local switch geometry',
            'ad hoc switch markup outside x-ui.toggle',
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
            'motion',
        ],
        'uses' => [
            'icons' => [],
            'components' => [],
            'js_initializers' => [],
        ],
        'blocks' => [
            'forms',
            'settings',
            'preferences',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Native checkbox keyboard behavior must remain intact.',
            'Space toggles enabled switch inputs.',
        ],
        'aria' => [
            'The native checkbox input exposes role="switch".',
            'aria-checked mirrors the resolved checked state.',
            'Helper text is merged into aria-describedby.',
            'Read-only state emits aria-readonly.',
            'Track and thumb are hidden from assistive technology.',
        ],
        'focus' => [
            'Toggle inputs must show visible focus.',
            'Disabled toggle inputs are not focusable.',
        ],
        'screen_reader' => [
            'hideLabel must only be used when the hidden label still provides a meaningful accessible name.',
            'Helper text must explain the setting consequence when the label alone is not sufficient.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            [
                'name' => 'label',
                'replacement' => 'labelText',
                'description' => 'label remains accepted as a shorter compatibility alias.',
            ],
            [
                'name' => 'helper',
                'replacement' => 'helperText',
                'description' => 'helper remains accepted as a shorter compatibility alias.',
            ],
            [
                'name' => 'readonly',
                'replacement' => 'readOnly',
                'description' => 'readonly remains accepted as a legacy alias.',
            ],
            [
                'name' => 'toggled',
                'replacement' => 'checked',
                'description' => 'toggled remains accepted as a Carbon-style compatibility alias.',
            ],
            [
                'name' => 'defaultToggled',
                'replacement' => 'defaultChecked',
                'description' => 'defaultToggled remains accepted as a Carbon-style compatibility alias.',
            ],
        ],
        'classes' => [
            'feature-local toggle wrapper classes',
            'feature-local toggle color classes',
            'raw switch geometry utility clusters',
        ],
        'components' => [
            'ad hoc switch markup outside x-ui.toggle',
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
            'resources/views/components/ui/toggle/index.blade.php',
        ],
        'css' => [
            'resources/css/components/toggle.css',
        ],
        'contract' => [
            'resources/views/components/ui/toggle/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/toggle.md',
        ],
    ],
]);
