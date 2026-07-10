<?php

declare(strict_types=1);

namespace App\Surfaces\Contracts;

/*
|--------------------------------------------------------------------------
| File: app/Surfaces/Contracts/Defaults.php
| Purpose: Shared defaults for normalized UI entry API contracts.
|--------------------------------------------------------------------------
|
| Defaults owns the public API contract shape. This shape intentionally excludes
| rendered evidence presentation, examples/proofs, testing requirement ownership,
| scanner output, and manual review/readiness status.
|
| Contract files describe what a UI entry exposes and what can be validated.
| Evidence files describe how that surface is documented or demonstrated.
|
*/

final class Defaults
{
    /*
    |--------------------------------------------------------------------------
    | Top-Level Keys
    |--------------------------------------------------------------------------
    */

    public static function topLevelKeys(): array
    {
        return [
            'schema_version',
            'identity',
            'lifecycle',
            'api',
            'subcomponents',
            'class_contract',
            'variants',
            'sizes',
            'states',
            'tokens',
            'dependencies',
            'accessibility',
            'deprecations',
            'enforcement',
            'source',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Base Contract Shape
    |--------------------------------------------------------------------------
    */

    public static function base(): array
    {
        return [
            'schema_version' => 1,

            /*
            |--------------------------------------------------------------------------
            | Identity
            |--------------------------------------------------------------------------
            */

            'identity' => [
                'slug' => '',
                'label' => '',
                'component' => null,
                'summary' => '',
                'group' => '',
                'type' => '',
            ],

            /*
            |--------------------------------------------------------------------------
            | Lifecycle
            |--------------------------------------------------------------------------
            |
            | Lifecycle is API posture only. It is not review status and it should
            | not be used as a generated test result.
            |
            */

            'lifecycle' => [
                'status' => 'legacy-compatible',
                'replacement' => null,
                'allowed_in_app_layouts' => true,
                'allowed_in_patterns' => true,
            ],

            /*
            |--------------------------------------------------------------------------
            | API
            |--------------------------------------------------------------------------
            */

            'api' => [
                'usage_level' => 'public',
                'usage_context' => '',
                'props' => [],
                'slots' => [],
                'events' => [],
                'data_attributes' => [],
            ],

            /*
            |--------------------------------------------------------------------------
            | Subcomponents
            |--------------------------------------------------------------------------
            */

            'subcomponents' => [],

            /*
            |--------------------------------------------------------------------------
            | CSS Class Contract
            |--------------------------------------------------------------------------
            */

            'class_contract' => [
                'root' => null,
                'required' => [],
                'optional' => [],
                'internal' => [],
                'deprecated' => [],
            ],

            /*
            |--------------------------------------------------------------------------
            | Variants / Sizes / States
            |--------------------------------------------------------------------------
            */

            'variants' => [],
            'sizes' => [],
            'states' => [],

            /*
            |--------------------------------------------------------------------------
            | Tokens / Public Utility API
            |--------------------------------------------------------------------------
            |
            | Tokens describes public token, utility, and class families exposed by
            | the surface. Token source file paths belong under source.tokens.
            |
            */

            'tokens' => [
                'css_variables' => [],
                'utility_classes' => [],
                'class_families' => [],
                'component_tokens' => [],
                'deprecated' => [],
            ],

            /*
            |--------------------------------------------------------------------------
            | Dependencies
            |--------------------------------------------------------------------------
            */

            'dependencies' => [
                'build_tier' => null,
                'depends_on' => [],
                'uses' => [
                    'icons' => [],
                    'components' => [],
                    'js_initializers' => [],
                ],
                'blocked_by' => [],
                'blocks' => [],
            ],

            /*
            |--------------------------------------------------------------------------
            | Accessibility Requirements
            |--------------------------------------------------------------------------
            |
            | Include accessibility rules that affect how the surface is called or
            | composed. Manual proof and test criteria live outside the contract.
            |
            */

            'accessibility' => [
                'keyboard' => [],
                'aria' => [],
                'focus' => [],
                'screen_reader' => [],
            ],

            /*
            |--------------------------------------------------------------------------
            | Deprecations
            |--------------------------------------------------------------------------
            */

            'deprecations' => [
                'props' => [],
                'slots' => [],
                'events' => [],
                'data_attributes' => [],
                'classes' => [],
                'variants' => [],
                'sizes' => [],
                'states' => [],
                'tokens' => [],
                'components' => [],
            ],

            /*
            |--------------------------------------------------------------------------
            | Enforcement
            |--------------------------------------------------------------------------
            */

            'enforcement' => [
                'mode' => 'legacy-compatible',
                'strict_props' => false,
                'strict_variants' => false,
                'strict_sizes' => false,
                'strict_states' => false,
                'strict_context' => false,
                'invalid_usage' => 'warn',
                'allow_unknown_attributes' => [
                    'class',
                    'id',
                    'style',
                    'aria-*',
                    'data-*',
                    'wire:*',
                    'x-*',
                    '@*',
                    ':*',
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Source Metadata
            |--------------------------------------------------------------------------
            |
            | Source is tooling metadata only. It is not rendered evidence presentation
            | and it is not scanner output.
            |
            */

            'source' => [
                'blade' => [],
                'css' => [],
                'js' => [],
                'tokens' => [],
                'contract' => [],
                'docs' => [],
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Foundation Element Defaults
    |--------------------------------------------------------------------------
    */

    public static function element(): array
    {
        return Normalizer::merge(self::base(), [
            'identity' => [
                'component' => null,
                'group' => 'Foundation Elements',
                'type' => 'element',
            ],
            'dependencies' => [
                'build_tier' => 0,
            ],
            'api' => [
                'usage_level' => 'public',
            ],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Component Defaults
    |--------------------------------------------------------------------------
    */

    public static function component(): array
    {
        return Normalizer::merge(self::base(), [
            'identity' => [
                'group' => 'Components',
                'type' => 'component',
            ],
            'dependencies' => [
                'build_tier' => 1,
            ],
            'api' => [
                'usage_level' => 'public',
            ],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Pattern Defaults
    |--------------------------------------------------------------------------
    */

    public static function pattern(): array
    {
        return Normalizer::merge(self::base(), [
            'identity' => [
                'component' => null,
                'group' => 'Patterns',
                'type' => 'pattern',
            ],
            'dependencies' => [
                'build_tier' => 6,
            ],
            'api' => [
                'usage_level' => 'pattern-only',
            ],
        ]);
    }
}
