<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/progress-step/contract.php
| Purpose: Progress Step Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Progress Step API that can be called from
| Blade, validated by tooling, and consumed by progress indicator compositions.
|
| Rendered evidence pages, examples/proofs, testing status, and
| manual review state are intentionally owned outside this contract.
|
*/

return Surface::component([
    'identity' => [
        'slug' => 'progress-step',
        'label' => 'Progress Step',
        'component' => 'x-ui.progress-step',
        'summary' => 'Single step in a progress indicator with complete, current, incomplete, invalid, disabled, secondary label, description, and optional interactive behavior.',
    ],

    'lifecycle' => [
        'status' => 'provisional',
    ],

    'api' => [
        'usage_context' => 'Use x-ui.progress-step inside x-ui.progress-indicator for process step state. Prefer x-ui.progress-indicator with array steps for standard usage.',

        'props' => [
            ['name' => 'label', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Step label.'],
            ['name' => 'state', 'type' => 'string', 'required' => false, 'default' => 'upcoming', 'values' => ['complete', 'current', 'error', 'invalid', 'upcoming', 'incomplete'], 'description' => 'Step state. upcoming maps to incomplete; error maps to invalid.'],
            ['name' => 'complete', 'type' => 'bool|null', 'required' => false, 'default' => null, 'values' => [true, false, null], 'description' => 'Boolean override for complete state.'],
            ['name' => 'current', 'type' => 'bool|null', 'required' => false, 'default' => null, 'values' => [true, false, null], 'description' => 'Boolean override for current state.'],
            ['name' => 'invalid', 'type' => 'bool|null', 'required' => false, 'default' => null, 'values' => [true, false, null], 'description' => 'Boolean override for invalid state.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disabled step state.'],
            ['name' => 'description', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Icon accessible description when the step icon needs a title/label.'],
            ['name' => 'secondaryLabel', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional secondary label.'],
            ['name' => 'index', 'type' => 'int|string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Step index supplied by progress indicator.'],
            ['name' => 'interactive', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Allows the step button to be focusable/clickable when installed behavior handles changes.'],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'progress-step', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-progress-step', 'required' => true, 'description' => 'Generated progress step marker.'],
            ['name' => 'data-ui-progress-step-state', 'required' => true, 'description' => 'Generated resolved state marker.'],
            ['name' => 'data-ui-progress-step-index', 'required' => false, 'description' => 'Generated step index marker.'],
            ['name' => 'data-ui-progress-step-disabled', 'required' => true, 'description' => 'Generated disabled state marker.'],
            ['name' => 'data-ui-progress-step-interactive', 'required' => true, 'description' => 'Generated interactive state marker.'],
            ['name' => 'data-ui-progress-step-button', 'required' => true, 'description' => 'Generated step button marker.'],
        ],
    ],

    'class_contract' => [
        'root' => 'ui-progress-step',
        'required' => [
            'ui-progress-step',
            'ui-progress-step-button',
            'ui-progress-step__icon',
            'ui-progress-text',
            'ui-progress-label',
            'ui-assistive-text',
            'ui-progress-line',
        ],
        'optional' => [
            'ui-progress-step--current',
            'ui-progress-step--complete',
            'ui-progress-step--incomplete',
            'ui-progress-step--invalid',
            'ui-progress-step--disabled',
            'ui-progress-step-button--unclickable',
            'ui-progress-optional',
        ],
        'internal' => [],
        'deprecated' => [
            'Tailwind-only progress step markup',
            'literal character state icons in progress steps',
            'raw progress step markup outside x-ui.progress-step',
        ],
    ],

    'variants' => [
        'complete' => ['label' => 'Complete', 'api' => ['state' => 'complete'], 'class' => 'ui-progress-step--complete', 'description' => 'Completed step.'],
        'current' => ['label' => 'Current', 'api' => ['state' => 'current'], 'class' => 'ui-progress-step--current', 'description' => 'Current step.'],
        'incomplete' => ['label' => 'Incomplete', 'api' => ['state' => 'incomplete'], 'class' => 'ui-progress-step--incomplete', 'description' => 'Incomplete upcoming step.'],
        'invalid' => ['label' => 'Invalid', 'api' => ['state' => 'invalid'], 'class' => 'ui-progress-step--invalid', 'description' => 'Invalid/error step.'],
        'disabled' => ['label' => 'Disabled', 'api' => ['disabled' => true], 'class' => 'ui-progress-step--disabled', 'description' => 'Disabled step.'],
        'with-secondary-label' => ['label' => 'With secondary label', 'api' => ['secondaryLabel' => 'Optional'], 'class' => 'ui-progress-optional', 'description' => 'Step with secondary label.'],
        'interactive' => ['label' => 'Interactive', 'api' => ['interactive' => true], 'description' => 'Step that can participate in change handling.'],
    ],

    'sizes' => [],

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default incomplete step state.'],
        'complete' => ['label' => 'Complete', 'required' => false, 'description' => 'Complete step state.'],
        'current' => ['label' => 'Current', 'required' => false, 'description' => 'Current step state.'],
        'incomplete' => ['label' => 'Incomplete', 'required' => false, 'description' => 'Incomplete step state.'],
        'invalid' => ['label' => 'Invalid', 'required' => false, 'description' => 'Invalid step state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled step state.'],
        'interactive' => ['label' => 'Interactive', 'required' => false, 'description' => 'Interactive/clickable step state.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state when interactive.'],
    ],

    'tokens' => [
        'class_families' => ['ui-progress'],
        'component_tokens' => ['progress-step', 'stepper', 'process-step'],
        'deprecated' => ['Tailwind-only progress steps', 'literal text progress icons'],
    ],

    'dependencies' => [
        'depends_on' => [
            'color',
            'themes',
            'spacing',
            'typography',
            'icons',
            'progress-indicator',
            'motion',
        ],
        'uses' => [
            'icons' => [
                'checkmark--outline',
                'warning',
                'incomplete',
                'circle-dash',
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [
                'progress indicator step behavior if installed',
            ],
        ],
        'blocks' => [
            'progress-indicator',
            'steppers',
            'multi-step-flows',
        ],
    ],

    'accessibility' => [
        'keyboard' => [
            'Interactive steps must be keyboard reachable unless disabled.',
            'Non-interactive steps are removed from tab order.',
        ],
        'aria' => [
            'Disabled and non-interactive steps expose aria-disabled.',
            'Assistive status text communicates complete/current/incomplete/invalid state.',
            'State icons are decorative unless description is provided.',
        ],
        'focus' => [
            'Interactive step buttons must show visible focus.',
        ],
        'screen_reader' => [
            'Label should identify the process step.',
            'Secondary label should add context without replacing the main label.',
        ],
    ],

    'deprecations' => [
        'props' => [
            ['name' => 'state:upcoming', 'replacement' => 'state="incomplete"', 'description' => 'upcoming remains accepted as a compatibility alias.'],
            ['name' => 'state:error', 'replacement' => 'state="invalid"', 'description' => 'error remains accepted as a compatibility alias.'],
        ],
        'classes' => [
            'Tailwind-only progress step classes',
            'feature-local stepper classes',
        ],
        'components' => [
            'ad hoc progress steps outside x-ui.progress-step',
        ],
    ],

    'enforcement' => [
        'mode' => 'legacy-compatible',
        'invalid_usage' => 'warn',
    ],

    'source' => [
        'blade' => [
            'resources/views/components/ui/progress-step/index.blade.php',
        ],
        'css' => [
            'resources/css/components/progress-indicator.css',
        ],
        'contract' => [
            'resources/views/components/ui/progress-step/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/progress-indicator.md',
        ],
    ],
]);
