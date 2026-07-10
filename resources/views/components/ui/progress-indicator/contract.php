<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/progress-indicator/contract.php
| Purpose: Progress Indicator Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Progress Indicator API that can be called
| from Blade, validated by tooling, and consumed by app layouts or Patterns.
|
| Rendered evidence pages, examples/proofs, testing status, and
| manual review state are intentionally owned outside this contract.
|
*/

return Surface::component([
    'identity' => [
        'slug' => 'progress-indicator',
        'label' => 'Progress Indicator',
        'component' => 'x-ui.progress-indicator',
        'summary' => 'Multi-step progress indicator that composes progress steps and supports current-index state, horizontal/vertical orientation, equal spacing, array-driven steps, and optional interactive behavior.',
    ],

    'lifecycle' => [
        'status' => 'provisional',
    ],

    'api' => [
        'usage_context' => 'Use x-ui.progress-indicator for multi-step process state. Use x-ui.progress-bar for linear task progress.',

        'props' => [
            ['name' => 'steps', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Array-driven steps. Steps may be strings or arrays with label, description, secondaryLabel/secondary_label, state, complete, current, invalid, and disabled.'],
            ['name' => 'currentIndex', 'type' => 'int|string', 'required' => false, 'default' => 0, 'values' => [], 'description' => 'Current step index used to derive complete/current/incomplete states when state is not supplied.'],
            ['name' => 'orientation', 'type' => 'string', 'required' => false, 'default' => 'horizontal', 'values' => ['horizontal', 'vertical'], 'description' => 'Progress indicator orientation.'],
            ['name' => 'vertical', 'type' => 'bool|null', 'required' => false, 'default' => null, 'values' => [true, false, null], 'description' => 'Compatibility boolean for vertical orientation. Takes precedence when supplied.'],
            ['name' => 'spaceEqually', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Splits horizontal progress steps equally. Ignored for vertical orientation.'],
            ['name' => 'interactive', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Marks step buttons interactive for installed progress indicator behavior.'],
            ['name' => 'ariaLabel', 'type' => 'string', 'required' => false, 'default' => 'Progress', 'values' => [], 'description' => 'Accessible label for the ordered progress list.'],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'progress-indicator', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-progress-indicator', 'required' => true, 'description' => 'Generated progress indicator marker.'],
            ['name' => 'data-ui-progress-indicator-orientation', 'required' => true, 'description' => 'Generated orientation marker.'],
            ['name' => 'data-ui-progress-indicator-current-index', 'required' => true, 'description' => 'Generated current index marker.'],
            ['name' => 'data-ui-progress-indicator-space-equally', 'required' => true, 'description' => 'Generated equal spacing marker.'],
            ['name' => 'data-ui-progress-indicator-interactive', 'required' => true, 'description' => 'Generated interactive marker.'],
        ],
    ],

    'class_contract' => [
        'root' => 'ui-progress',
        'required' => [
            'ui-progress',
        ],
        'optional' => [
            'ui-progress--vertical',
            'ui-progress--space-equal',
        ],
        'internal' => [],
        'deprecated' => [
            'Tailwind-only progress indicator markup',
            'feature-local stepper wrappers',
            'raw progress indicator markup outside x-ui.progress-indicator',
        ],
    ],

    'variants' => [
        'horizontal' => ['label' => 'Horizontal', 'api' => ['orientation' => 'horizontal'], 'class' => 'ui-progress', 'description' => 'Horizontal progress indicator.'],
        'vertical' => ['label' => 'Vertical', 'api' => ['orientation' => 'vertical'], 'class' => 'ui-progress--vertical', 'description' => 'Vertical progress indicator.'],
        'space-equally' => ['label' => 'Space equally', 'api' => ['spaceEqually' => true], 'class' => 'ui-progress--space-equal', 'description' => 'Horizontal progress indicator with equally spaced steps.'],
        'interactive' => ['label' => 'Interactive', 'api' => ['interactive' => true], 'description' => 'Progress indicator with interactive step buttons.'],
        'array-driven' => ['label' => 'Array driven', 'api' => ['steps' => ['Start', 'Review', 'Finish']], 'description' => 'Progress indicator generated from step array.'],
        'with-current-index' => ['label' => 'With current index', 'api' => ['currentIndex' => 1], 'description' => 'Progress indicator deriving state from current index.'],
    ],

    'sizes' => [],

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default progress indicator state.'],
        'current-step' => ['label' => 'Current step', 'required' => true, 'description' => 'One step is current.'],
        'complete-steps' => ['label' => 'Complete steps', 'required' => false, 'description' => 'Prior steps are complete.'],
        'invalid-step' => ['label' => 'Invalid step', 'required' => false, 'description' => 'A step is invalid.'],
        'disabled-step' => ['label' => 'Disabled step', 'required' => false, 'description' => 'A step is disabled.'],
        'interactive' => ['label' => 'Interactive', 'required' => false, 'description' => 'Steps participate in change behavior.'],
        'vertical' => ['label' => 'Vertical', 'required' => false, 'description' => 'Vertical orientation state.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for interactive steps.'],
    ],

    'tokens' => [
        'class_families' => ['ui-progress'],
        'component_tokens' => ['progress-indicator', 'progress-step', 'stepper'],
        'deprecated' => ['Tailwind-only steppers', 'feature-local progress indicators'],
    ],

    'dependencies' => [
        'depends_on' => [
            'color',
            'themes',
            'spacing',
            'typography',
            'icons',
            'progress-step',
            'motion',
        ],
        'uses' => [
            'icons' => [],
            'components' => [
                'ui.progress-step',
            ],
            'js_initializers' => [
                'progress indicator behavior if installed',
            ],
        ],
        'blocks' => [
            'multi-step-flows',
            'checkout-steps',
            'setup-wizards',
        ],
    ],

    'accessibility' => [
        'keyboard' => [
            'Interactive steps must be keyboard reachable unless disabled.',
            'Non-interactive step buttons are removed from tab order.',
        ],
        'aria' => [
            'Ordered list has an accessible label.',
            'Individual steps expose assistive state text.',
            'Disabled steps expose disabled/aria-disabled through x-ui.progress-step.',
        ],
        'focus' => [
            'Interactive step buttons must show visible focus.',
        ],
        'screen_reader' => [
            'ariaLabel should identify the process being tracked.',
            'Step labels should be short and sequentially meaningful.',
        ],
    ],

    'deprecations' => [
        'props' => [
            ['name' => 'vertical', 'replacement' => 'orientation="vertical"', 'description' => 'vertical remains accepted as a compatibility boolean.'],
        ],
        'classes' => [
            'Tailwind-only progress indicator classes',
            'feature-local stepper classes',
        ],
        'components' => [
            'ad hoc progress indicators outside x-ui.progress-indicator',
        ],
    ],

    'enforcement' => [
        'mode' => 'legacy-compatible',
        'invalid_usage' => 'warn',
    ],

    'source' => [
        'blade' => [
            'resources/views/components/ui/progress-indicator/index.blade.php',
        ],
        'css' => [
            'resources/css/components/progress-indicator.css',
        ],
        'contract' => [
            'resources/views/components/ui/progress-indicator/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/progress-indicator.md',
        ],
    ],
]);
