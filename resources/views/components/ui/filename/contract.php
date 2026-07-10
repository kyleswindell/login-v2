<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/filename/contract.php
| Purpose: Filename Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Filename API that can be called from Blade,
| validated by tooling, and consumed by file uploader compositions.
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
        'slug' => 'filename',
        'label' => 'Filename',
        'component' => 'x-ui.filename',
        'summary' => 'File uploader filename status renderer for uploading, edit/remove, complete, invalid, and disabled file item states.',
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
        'usage_context' => 'Use x-ui.filename inside file uploader item compositions to render upload status, remove action, complete state, or invalid file state. Use x-ui.file-uploader-item for the full selected file row.',

        'props' => [
            ['name' => 'uuid', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Stable file UUID used by installed file uploader JavaScript for remove behavior.'],
            ['name' => 'name', 'type' => 'string', 'required' => false, 'default' => '', 'values' => [], 'description' => 'Filename used in the remove button accessible label.'],
            ['name' => 'status', 'type' => 'string', 'required' => false, 'default' => 'uploading', 'values' => ['uploading', 'edit', 'complete'], 'description' => 'Filename status mode.'],
            ['name' => 'iconDescription', 'type' => 'string', 'required' => false, 'default' => 'Uploading file', 'values' => [], 'description' => 'Accessible status or remove action label.'],
            ['name' => 'invalid', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Invalid filename/file state. In edit mode, renders invalid icon before remove control.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disabled remove control state.'],
            ['name' => 'tabIndex', 'type' => 'int|string', 'required' => false, 'default' => 0, 'values' => [], 'description' => 'Remove button tab index when enabled. Disabled state forces -1.'],
            ['name' => 'ariaDescribedby', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional describedby target for invalid remove controls. Also accepts caller aria-describedby attribute.'],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'filename', 'description' => 'Generated root/status component marker.'],
            ['name' => 'data-ui-filename', 'required' => true, 'description' => 'Generated filename status marker.'],
            ['name' => 'data-ui-file-status', 'required' => true, 'description' => 'Generated file status marker: uploading, edit, invalid, or complete.'],
            ['name' => 'data-ui-file-invalid', 'required' => true, 'description' => 'Generated invalid state marker.'],
            ['name' => 'data-ui-file-disabled', 'required' => true, 'description' => 'Generated disabled state marker.'],
            ['name' => 'data-ui-file-remove', 'required' => false, 'description' => 'Generated remove button marker.'],
            ['name' => 'data-ui-file-remove-uuid', 'required' => false, 'description' => 'Generated remove target UUID marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-file-status',
        'required' => [],
        'optional' => [
            'ui-file-loading',
            'ui-spinner',
            'ui-visually-hidden',
            'ui-file-invalid',
            'ui-file-close',
            'ui-file-complete',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local filename status markup',
            'raw file remove buttons inside file uploader items',
            'ad hoc upload status icons outside x-ui.filename',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'uploading' => [
            'label' => 'Uploading',
            'api' => ['status' => 'uploading'],
            'class' => 'ui-file-loading',
            'description' => 'Uploading status with small spinner/status indicator.',
        ],
        'edit' => [
            'label' => 'Edit',
            'api' => ['status' => 'edit'],
            'class' => 'ui-file-close',
            'description' => 'Editable/removable status with remove button.',
        ],
        'complete' => [
            'label' => 'Complete',
            'api' => ['status' => 'complete'],
            'class' => 'ui-file-complete',
            'description' => 'Complete status with checkmark icon.',
        ],
        'invalid-edit' => [
            'label' => 'Invalid edit',
            'api' => ['status' => 'edit', 'invalid' => true],
            'class' => 'ui-file-invalid',
            'description' => 'Invalid file in removable/edit status.',
        ],
        'disabled-edit' => [
            'label' => 'Disabled edit',
            'api' => ['status' => 'edit', 'disabled' => true],
            'description' => 'Disabled remove action in edit status.',
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
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default filename status state.'],
        'uploading' => ['label' => 'Uploading', 'required' => false, 'description' => 'Uploading status state.'],
        'edit' => ['label' => 'Edit', 'required' => false, 'description' => 'Edit/remove status state.'],
        'complete' => ['label' => 'Complete', 'required' => false, 'description' => 'Complete status state.'],
        'invalid' => ['label' => 'Invalid', 'required' => false, 'description' => 'Invalid file state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled remove action state.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for remove button.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-file',
            'ui-spinner',
        ],
        'component_tokens' => [
            'filename',
            'file-uploader',
            'file-status',
            'file-remove',
        ],
        'deprecated' => [
            'feature-local filename status controls',
            'raw file remove controls',
            'ad hoc upload status indicators',
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
            'file-uploader',
            'motion',
        ],
        'uses' => [
            'icons' => [
                'warning--filled',
                'close',
                'checkmark--filled',
            ],
            'components' => [
                'ui.icon',
            ],
            'js_initializers' => [
                'file uploader remove behavior if installed',
            ],
        ],
        'blocks' => [
            'file-uploader-item',
            'file-uploader',
            'uploaded-file-lists',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Remove button must be keyboard reachable unless disabled.',
            'Uploading and complete states are not keyboard interactive.',
        ],
        'aria' => [
            'Uploading status exposes role="status" and an accessible label.',
            'Remove button has an accessible label including the filename.',
            'Invalid remove button may be associated to file error text through aria-describedby.',
            'Decorative status icons are hidden from assistive technology unless labelled by x-ui.icon.',
        ],
        'focus' => [
            'Remove button must show visible focus.',
        ],
        'screen_reader' => [
            'iconDescription should describe the current status or remove action clearly.',
            'Filename included in remove button label should identify the file being removed.',
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
            'feature-local filename status classes',
            'raw file remove utility clusters',
        ],
        'components' => [
            'ad hoc filename status controls outside x-ui.filename',
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
            'resources/views/components/ui/filename/index.blade.php',
        ],
        'css' => [
            'resources/css/components/file-uploader.css',
        ],
        'contract' => [
            'resources/views/components/ui/filename/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/file-uploader.md',
        ],
    ],
]);
