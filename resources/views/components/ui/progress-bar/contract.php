<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/progress-bar/contract.php
| Purpose: Progress Bar Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Progress Bar API that can be called from
| Blade, validated by tooling, and consumed by app layouts or Patterns.
|
| Rendered evidence pages, examples/proofs, testing status, and
| manual review state are intentionally owned outside this contract.
|
*/

return Surface::component([
    'identity' => [
        'slug' => 'progress-bar',
        'label' => 'Progress Bar',
        'component' => 'x-ui.progress-bar',
        'summary' => 'Linear progress indicator with active, finished, error, and indeterminate states plus label, helper text, size, type, and accessible progressbar semantics.',
    ],

    'lifecycle' => [
        'status' => 'provisional',
    ],

    'api' => [
        'usage_context' => 'Use x-ui.progress-bar for linear task progress, loading progress, completion, and error progress states. Use x-ui.progress-indicator for multi-step process state.',

        'props' => [
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Progress bar root ID. A generated ID is used when omitted.'],
            ['name' => 'value', 'type' => 'int|float|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Current progress value. Null renders indeterminate state unless status is finished or error.'],
            ['name' => 'max', 'type' => 'int|float', 'required' => false, 'default' => 100, 'values' => [], 'description' => 'Maximum progress value.'],
            ['name' => 'label', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Visible or visually hidden label.'],
            ['name' => 'ariaLabel', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Accessible label fallback when label is not rendered.'],
            ['name' => 'helperText', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Helper text associated to the progressbar.'],
            ['name' => 'hideLabel', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Visually hides the label while preserving it for assistive technology.'],
            ['name' => 'status', 'type' => 'string', 'required' => false, 'default' => 'active', 'values' => ['active', 'finished', 'error', 'neutral', 'success', 'complete', 'done', 'invalid'], 'description' => 'Progress status. Compatibility aliases normalize to active, finished, or error.'],
            ['name' => 'size', 'type' => 'string', 'required' => false, 'default' => 'big', 'values' => ['small', 'big', 'sm', 'md', 'lg'], 'description' => 'Progress bar size. sm maps to small; md/lg map to big.'],
            ['name' => 'type', 'type' => 'string', 'required' => false, 'default' => 'default', 'values' => ['default', 'inline', 'indented'], 'description' => 'Progress bar alignment type.'],
            ['name' => 'showValue', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Shows computed percent text beside the label when determinate.'],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'progress-bar', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-progress-bar', 'required' => true, 'description' => 'Generated progress bar marker.'],
            ['name' => 'data-ui-progress-bar-status', 'required' => true, 'description' => 'Generated resolved status marker.'],
            ['name' => 'data-ui-progress-bar-size', 'required' => true, 'description' => 'Generated resolved size marker.'],
            ['name' => 'data-ui-progress-bar-type', 'required' => true, 'description' => 'Generated resolved type marker.'],
            ['name' => 'data-ui-progress-bar-indeterminate', 'required' => true, 'description' => 'Generated indeterminate state marker.'],
            ['name' => 'data-ui-progress-bar-track', 'required' => true, 'description' => 'Generated progressbar track marker.'],
            ['name' => 'data-ui-progress-bar-bar', 'required' => true, 'description' => 'Generated progress fill marker.'],
        ],
    ],

    'class_contract' => [
        'root' => 'ui-progress-bar',
        'required' => [
            'ui-progress-bar',
            'ui-progress-bar__track',
            'ui-progress-bar__bar',
        ],
        'optional' => [
            'ui-progress-bar--small',
            'ui-progress-bar--big',
            'ui-progress-bar--default',
            'ui-progress-bar--inline',
            'ui-progress-bar--indented',
            'ui-progress-bar--indeterminate',
            'ui-progress-bar--finished',
            'ui-progress-bar--error',
            'ui-progress-bar__label',
            'ui-progress-bar__label-text',
            'ui-progress-bar__status-icon',
            'ui-progress-bar__value-text',
            'ui-progress-bar__helper-text',
            'ui-visually-hidden',
        ],
        'internal' => [],
        'deprecated' => [
            'Tailwind-only progress bar markup',
            'feature-local progress wrappers',
            'raw progressbar markup outside x-ui.progress-bar',
        ],
    ],

    'variants' => [
        'active' => ['label' => 'Active', 'api' => ['status' => 'active'], 'description' => 'Active determinate or indeterminate progress.'],
        'finished' => ['label' => 'Finished', 'api' => ['status' => 'finished'], 'class' => 'ui-progress-bar--finished', 'description' => 'Finished progress state.'],
        'error' => ['label' => 'Error', 'api' => ['status' => 'error'], 'class' => 'ui-progress-bar--error', 'description' => 'Error progress state.'],
        'indeterminate' => ['label' => 'Indeterminate', 'api' => ['value' => null], 'class' => 'ui-progress-bar--indeterminate', 'description' => 'Indeterminate active progress state.'],
        'inline' => ['label' => 'Inline', 'api' => ['type' => 'inline'], 'class' => 'ui-progress-bar--inline', 'description' => 'Inline alignment treatment.'],
        'indented' => ['label' => 'Indented', 'api' => ['type' => 'indented'], 'class' => 'ui-progress-bar--indented', 'description' => 'Indented alignment treatment.'],
        'hidden-label' => ['label' => 'Hidden label', 'api' => ['hideLabel' => true], 'class' => 'ui-visually-hidden', 'description' => 'Progress bar with visually hidden label.'],
        'with-helper' => ['label' => 'With helper text', 'api' => ['helperText' => 'Loading files'], 'class' => 'ui-progress-bar__helper-text', 'description' => 'Progress bar with helper text.'],
        'show-value' => ['label' => 'Show value', 'api' => ['showValue' => true], 'class' => 'ui-progress-bar__value-text', 'description' => 'Progress bar with computed percent text.'],
    ],

    'sizes' => [
        'small' => ['label' => 'Small', 'api' => ['size' => 'small'], 'class' => 'ui-progress-bar--small', 'description' => 'Small progress bar.'],
        'big' => ['label' => 'Big', 'api' => ['size' => 'big'], 'class' => 'ui-progress-bar--big', 'description' => 'Default large progress bar.'],
    ],

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default progress bar state.'],
        'active' => ['label' => 'Active', 'required' => false, 'description' => 'Active progress state.'],
        'indeterminate' => ['label' => 'Indeterminate', 'required' => false, 'description' => 'No numeric value available.'],
        'finished' => ['label' => 'Finished', 'required' => false, 'description' => 'Finished state with complete icon.'],
        'error' => ['label' => 'Error', 'required' => false, 'description' => 'Error state with error icon.'],
        'with-helper' => ['label' => 'With helper', 'required' => false, 'description' => 'Helper text rendered.'],
        'hidden-label' => ['label' => 'Hidden label', 'required' => false, 'description' => 'Label visually hidden.'],
    ],

    'tokens' => [
        'class_families' => ['ui-progress-bar'],
        'component_tokens' => ['progress-bar', 'progress', 'loading', 'completion'],
        'deprecated' => ['Tailwind-only progress bars', 'raw progressbar markup'],
    ],

    'dependencies' => [
        'depends_on' => [
            'color',
            'themes',
            'spacing',
            'typography',
            'icons',
            'motion',
        ],
        'uses' => [
            'icons' => [
                'checkmark--filled',
                'error--filled',
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [],
        ],
        'blocks' => [
            'loading-progress',
            'upload-progress',
            'task-progress',
        ],
    ],

    'accessibility' => [
        'keyboard' => [
            'Progress bar itself is not keyboard interactive.',
        ],
        'aria' => [
            'Track renders role="progressbar".',
            'Determinate progress emits aria-valuemin, aria-valuemax, and aria-valuenow.',
            'Indeterminate progress omits aria-valuenow.',
            'Finished/error state controls aria-busy and aria-invalid.',
            'Label or ariaLabel must provide an accessible name.',
        ],
        'focus' => [
            'Progress bar does not receive focus.',
        ],
        'screen_reader' => [
            'Label should describe what is progressing.',
            'Helper text should clarify current activity when progress is indeterminate.',
        ],
    ],

    'deprecations' => [
        'props' => [
            ['name' => 'status:neutral', 'replacement' => 'status="active"', 'description' => 'neutral remains accepted as a compatibility alias.'],
            ['name' => 'status:success', 'replacement' => 'status="finished"', 'description' => 'success remains accepted as a compatibility alias.'],
        ],
        'classes' => [
            'Tailwind-only progress bar classes',
            'feature-local progress bar classes',
        ],
        'components' => [
            'ad hoc progressbar controls outside x-ui.progress-bar',
        ],
    ],

    'enforcement' => [
        'mode' => 'legacy-compatible',
        'invalid_usage' => 'warn',
    ],

    'source' => [
        'blade' => [
            'resources/views/components/ui/progress-bar/index.blade.php',
        ],
        'css' => [
            'resources/css/components/progress-bar.css',
        ],
        'contract' => [
            'resources/views/components/ui/progress-bar/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/progress-bar.md',
        ],
    ],
]);
