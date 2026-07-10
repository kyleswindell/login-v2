<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/form/contract.php
| Purpose: Form Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Form wrapper API that can be called from
| Blade, validated by tooling, and consumed by app layouts or Patterns.
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
        'slug' => 'form',
        'label' => 'Form',
        'component' => 'x-ui.form',
        'summary' => 'Native form wrapper with Laravel CSRF and HTTP method spoofing support.',
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
        'usage_context' => 'Use x-ui.form when a native form wrapper should emit the app form class, optional CSRF token, and optional Laravel method spoofing. Form Patterns own layout, grouping, validation orchestration, and action placement.',

        'props' => [
            [
                'name' => 'method',
                'type' => 'string',
                'required' => false,
                'default' => 'POST',
                'values' => [
                    'GET',
                    'POST',
                    'PUT',
                    'PATCH',
                    'DELETE',
                ],
                'description' => 'Requested form method. GET and POST render natively; PUT, PATCH, and DELETE render as POST with Laravel method spoofing.',
            ],
            [
                'name' => 'action',
                'type' => 'string|null',
                'required' => false,
                'default' => null,
                'values' => [],
                'description' => 'Native form action attribute.',
            ],
            [
                'name' => 'csrf',
                'type' => 'bool',
                'required' => false,
                'default' => true,
                'values' => [
                    true,
                    false,
                ],
                'description' => 'Controls whether a CSRF token is emitted for non-GET forms.',
            ],
        ],

        'slots' => [
            [
                'name' => 'default',
                'required' => true,
                'description' => 'Form contents. Child controls own labels, helper text, validation text, and ARIA wiring.',
            ],
        ],

        'events' => [],

        'data_attributes' => [
            [
                'name' => 'data-ui-component',
                'required' => true,
                'value' => 'form',
                'description' => 'Generated root component marker.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-form',
        'required' => [
            'ui-form',
        ],
        'optional' => [],
        'internal' => [],
        'deprecated' => [
            'feature-local form wrapper classes',
            'ad hoc form spacing classes',
            'form wrappers that bypass x-ui.form when CSRF or method spoofing is needed',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'get' => [
            'label' => 'GET form',
            'api' => [
                'method' => 'GET',
            ],
            'description' => 'Native GET form without CSRF token.',
        ],
        'post' => [
            'label' => 'POST form',
            'api' => [
                'method' => 'POST',
            ],
            'description' => 'Native POST form with CSRF token by default.',
        ],
        'spoofed-method' => [
            'label' => 'Spoofed method',
            'api' => [
                'method' => 'PATCH',
            ],
            'description' => 'PUT, PATCH, or DELETE request rendered as POST plus Laravel method spoofing.',
        ],
        'csrf-disabled' => [
            'label' => 'CSRF disabled',
            'api' => [
                'csrf' => false,
            ],
            'description' => 'Non-GET form with CSRF output intentionally disabled.',
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
        'default' => [
            'label' => 'Default',
            'required' => true,
            'description' => 'Default native form wrapper state.',
        ],
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
            'form',
        ],
        'deprecated' => [
            'feature-local form wrapper classes',
            'feature-local form spacing systems',
            'form wrapper markup that duplicates x-ui.form behavior',
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
            'typography',
        ],
        'uses' => [
            'icons' => [],
            'components' => [],
            'js_initializers' => [],
        ],
        'blocks' => [
            'form-patterns',
            'field-components',
            'submission-flows',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Native form submission behavior must remain intact.',
        ],
        'aria' => [
            'The form wrapper does not generate field-level ARIA. Child controls own labels, helper text, validation text, and described-by relationships.',
        ],
        'focus' => [
            'The form wrapper does not manage focus. Submission flows, validation recovery, and error focus are owned by the consuming Pattern or controller flow.',
        ],
        'screen_reader' => [
            'The form wrapper must not hide or replace child control semantics.',
            'Use child field components and Form Patterns for accessible grouping, labels, validation summaries, and recovery instructions.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'classes' => [
            'feature-local form wrapper classes',
            'feature-local form spacing classes',
            'raw form layout utility clusters that should be Pattern-owned',
        ],
        'components' => [
            'ad hoc form wrappers where x-ui.form should own CSRF and method spoofing behavior',
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
            'resources/views/components/ui/form/index.blade.php',
        ],
        'contract' => [
            'resources/views/components/ui/form/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/form.md',
        ],
    ],
]);
