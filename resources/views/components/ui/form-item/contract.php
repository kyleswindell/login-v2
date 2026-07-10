<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/form-item/contract.php
| Purpose: Form Item Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Form Item API that can be called from
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
        'slug' => 'form-item',
        'label' => 'Form Item',
        'component' => 'x-ui.form-item',
        'summary' => 'Low-level form item layout wrapper that applies standard form control spacing without adding label, helper, validation, or ARIA behavior.',
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
        'usage_context' => 'Use x-ui.form-item as a low-level wrapper for custom form layouts when the child field owns its label, helper text, validation, and ARIA behavior.',

        'props' => [],

        'slots' => [
            ['name' => 'default', 'required' => true, 'description' => 'Form control or custom form layout content.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'form-item', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-form-item', 'required' => true, 'description' => 'Generated form item marker.'],
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
        ],
        'optional' => [],
        'internal' => [],
        'deprecated' => [
            'feature-local form item spacing wrappers',
            'raw form item utility clusters where x-ui.form-item should be used',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => [], 'class' => 'ui-form-item', 'description' => 'Default form item wrapper.'],
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
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default form item state.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-form',
        ],
        'component_tokens' => [
            'form-item',
            'form-layout',
        ],
        'deprecated' => [
            'feature-local form spacing wrappers',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dependencies
    |--------------------------------------------------------------------------
    */

    'dependencies' => [
        'depends_on' => [
            'spacing',
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
            'Form item itself is not keyboard interactive.',
        ],
        'aria' => [
            'Form item does not add ARIA behavior. Child controls must own their own accessible names, descriptions, and validation state.',
        ],
        'focus' => [
            'Form item does not receive focus unless caller attributes or slotted content introduce focus.',
        ],
        'screen_reader' => [
            'Do not rely on form item wrapper alone to communicate label, requirement, validation, or helper text.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [],
        'classes' => [
            'feature-local form item classes',
            'raw form item utility clusters',
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
            'resources/views/components/ui/form-item/index.blade.php',
        ],
        'css' => [
            'resources/css/components/form.css',
        ],
        'contract' => [
            'resources/views/components/ui/form-item/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/form.md',
        ],
    ],
]);
