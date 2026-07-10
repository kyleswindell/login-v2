<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/form-label/contract.php
| Purpose: Form Label Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Form Label API that can be called from
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
        'slug' => 'form-label',
        'label' => 'Form Label',
        'component' => 'x-ui.form-label',
        'summary' => 'Standalone native label primitive for custom form layouts with disabled and visually hidden label states.',
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
        'usage_context' => 'Use x-ui.form-label in custom form layouts where the field component does not own the label. Prefer field-owned labels for standard field components.',

        'props' => [
            ['name' => 'for', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Native label for target control ID.'],
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Compatibility alias for for. This is not the label element ID.', 'compatibility' => true],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disabled visual label state.'],
            ['name' => 'hideLabel', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Visually hides the label while preserving it for assistive technology.'],
        ],

        'slots' => [
            ['name' => 'default', 'required' => true, 'description' => 'Label text or trusted label content.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'form-label', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-form-label', 'required' => true, 'description' => 'Generated form label marker.'],
            ['name' => 'data-ui-form-label-for', 'required' => false, 'description' => 'Generated resolved target control marker.'],
            ['name' => 'data-ui-form-label-disabled', 'required' => true, 'description' => 'Generated disabled state marker.'],
            ['name' => 'data-ui-form-label-hidden', 'required' => true, 'description' => 'Generated hidden label state marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-label',
        'required' => [
            'ui-label',
            'ui-label--no-margin',
        ],
        'optional' => [
            'ui-label--disabled',
            'ui-visually-hidden',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local label utility clusters',
            'raw label markup where x-ui.form-label should be used',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => [], 'class' => 'ui-label', 'description' => 'Default standalone form label.'],
        'disabled' => ['label' => 'Disabled', 'api' => ['disabled' => true], 'class' => 'ui-label--disabled', 'description' => 'Disabled label state.'],
        'hidden' => ['label' => 'Hidden label', 'api' => ['hideLabel' => true], 'class' => 'ui-visually-hidden', 'description' => 'Visually hidden label.'],
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
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default label state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled label visual state.'],
        'hidden' => ['label' => 'Hidden', 'required' => false, 'description' => 'Visually hidden label state.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-label',
        ],
        'component_tokens' => [
            'form-label',
            'label',
            'forms',
        ],
        'deprecated' => [
            'feature-local label wrappers',
            'raw label utility clusters',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies
    |--------------------------------------------------------------------------
    */

    'dependencies' => [
        'depends_on' => [
            'typography',
            'forms',
        ],
        'uses' => [
            'icons' => [],
            'components' => [],
            'js_initializers' => [],
        ],
        'blocks' => [
            'forms',
            'custom-form-layouts',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Native label itself is not keyboard interactive.',
        ],
        'aria' => [
            'Native label semantics are provided by the label element and for attribute.',
            'Do not use a visually hidden label as a substitute for missing control context when a visible label is required.',
        ],
        'focus' => [
            'Clicking a native label should focus/activate its associated control when for resolves to a valid control ID.',
        ],
        'screen_reader' => [
            'Label content should clearly describe the associated control.',
            'The id prop targets the control; it does not set the label element ID.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            ['name' => 'id', 'replacement' => 'for', 'description' => 'id remains accepted as a compatibility alias for the target control ID.'],
        ],
        'classes' => [
            'feature-local label classes',
            'raw label utility clusters',
        ],
        'components' => [],
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
            'resources/views/components/ui/form-label/index.blade.php',
        ],
        'css' => [
            'resources/css/components/form.css',
        ],
        'contract' => [
            'resources/views/components/ui/form-label/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/form.md',
        ],
    ],
]);
