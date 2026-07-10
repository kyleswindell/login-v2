<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/form-group/contract.php
| Purpose: Form Group Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Form Group API that can be called from
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
        'slug' => 'form-group',
        'label' => 'Form Group',
        'component' => 'x-ui.form-group',
        'summary' => 'Native fieldset and legend wrapper for grouped form controls with disabled, invalid, and optional group message states.',
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
        'usage_context' => 'Use x-ui.form-group to group related form controls with native fieldset and legend semantics. Child controls own their individual labels, helper text, validation, and input state.',

        'props' => [
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional fieldset ID.'],
            ['name' => 'legendId', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional legend ID used for fieldset aria-labelledby. A generated ID is used when omitted.'],
            ['name' => 'legendText', 'type' => 'string|HtmlString', 'required' => true, 'default' => null, 'values' => [], 'description' => 'Legend content that labels the grouped controls.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Native disabled fieldset state.'],
            ['name' => 'invalid', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Invalid group state marker. Does not manage child control validation.'],
            ['name' => 'message', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Shows group-level message when messageText is filled.'],
            ['name' => 'messageText', 'type' => 'string', 'required' => false, 'default' => '', 'values' => [], 'description' => 'Optional group-level requirement or validation message text.'],
        ],

        'slots' => [
            ['name' => 'default', 'required' => true, 'description' => 'Grouped form controls. Child controls own their own field semantics.'],
        ],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'form-group', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-form-group', 'required' => true, 'description' => 'Generated form group marker.'],
            ['name' => 'data-ui-form-group-state', 'required' => true, 'description' => 'Generated state marker: default or invalid.'],
            ['name' => 'data-ui-form-group-disabled', 'required' => true, 'description' => 'Generated disabled state marker.'],
            ['name' => 'data-ui-form-group-message', 'required' => true, 'description' => 'Generated message presence marker.'],
            ['name' => 'data-ui-form-group-message-content', 'required' => false, 'description' => 'Generated message content marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-fieldset',
        'required' => [
            'ui-fieldset',
            'ui-label',
        ],
        'optional' => [
            'ui-fieldset--disabled',
            'ui-fieldset--invalid',
            'ui-fieldset--message',
            'ui-form__requirements',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local fieldset wrappers',
            'raw grouped form fieldsets where x-ui.form-group should be used',
            'ad hoc group-level validation wrappers',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => ['label' => 'Default', 'api' => ['legendText' => 'Group'], 'class' => 'ui-fieldset', 'description' => 'Default form group.'],
        'disabled' => ['label' => 'Disabled', 'api' => ['legendText' => 'Group', 'disabled' => true], 'class' => 'ui-fieldset--disabled', 'description' => 'Disabled fieldset group.'],
        'invalid' => ['label' => 'Invalid', 'api' => ['legendText' => 'Group', 'invalid' => true, 'message' => true, 'messageText' => 'Select an option.'], 'class' => 'ui-fieldset--invalid', 'description' => 'Invalid form group state.'],
        'with-message' => ['label' => 'With message', 'api' => ['legendText' => 'Group', 'message' => true, 'messageText' => 'Group message.'], 'class' => 'ui-form__requirements', 'description' => 'Form group with group-level message.'],
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
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default form group state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled fieldset state.'],
        'invalid' => ['label' => 'Invalid', 'required' => false, 'description' => 'Invalid group state.'],
        'with-message' => ['label' => 'With message', 'required' => false, 'description' => 'Group-level message is rendered.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-fieldset',
            'ui-form',
            'ui-label',
        ],
        'component_tokens' => [
            'form-group',
            'fieldset',
            'legend',
            'forms',
        ],
        'deprecated' => [
            'feature-local fieldset wrappers',
            'raw grouped form validation wrappers',
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
            'forms',
        ],
        'uses' => [
            'icons' => [],
            'components' => [],
            'js_initializers' => [],
        ],
        'blocks' => [
            'forms',
            'grouped-controls',
            'choice-groups',
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
            'Fieldset itself is not keyboard interactive.',
            'Disabled fieldsets disable descendant form controls by native browser behavior.',
        ],
        'aria' => [
            'Fieldset is labelled by legend through aria-labelledby.',
            'Group message is associated through aria-describedby when rendered.',
            'Invalid state emits aria-invalid and aria-errormessage when a message exists.',
            'Child controls must own their individual validation state.',
        ],
        'focus' => [
            'Focus behavior belongs to child controls.',
        ],
        'screen_reader' => [
            'Legend text should describe the relationship between grouped controls.',
            'Group-level message should describe the requirement or problem for the group as a whole.',
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
            'feature-local form group classes',
            'raw fieldset utility clusters',
        ],
        'components' => [
            'ad hoc form groups outside x-ui.form-group',
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
            'resources/views/components/ui/form-group/index.blade.php',
        ],
        'css' => [
            'resources/css/components/form.css',
        ],
        'contract' => [
            'resources/views/components/ui/form-group/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/form.md',
        ],
    ],
]);
