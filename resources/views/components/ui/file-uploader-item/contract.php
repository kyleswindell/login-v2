<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/file-uploader-item/contract.php
| Purpose: File Uploader Item Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public File Uploader Item API that can be called
| from Blade, validated by tooling, and consumed by file uploader compositions.
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
        'slug' => 'file-uploader-item',
        'label' => 'File Uploader Item',
        'component' => 'x-ui.file-uploader-item',
        'summary' => 'Selected file item row for file uploader compositions with filename display, status/delete affordance, invalid state, disabled state, size treatment, and optional error message.',
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
        'usage_context' => 'Use x-ui.file-uploader-item to render selected file rows inside file uploader compositions. Use x-ui.file-uploader for the full labelled upload control.',

        'props' => [
            ['name' => 'uuid', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Stable file item UUID used for data hooks and delete/status behavior. A generated UUID is used when omitted.'],
            ['name' => 'name', 'type' => 'string', 'required' => false, 'default' => '', 'values' => [], 'description' => 'Displayed filename.'],
            ['name' => 'status', 'type' => 'string', 'required' => false, 'default' => 'uploading', 'values' => ['uploading', 'edit', 'complete'], 'description' => 'Filename status forwarded to x-ui.filename.'],
            ['name' => 'iconDescription', 'type' => 'string', 'required' => false, 'default' => 'Remove uploaded file', 'values' => [], 'description' => 'Accessible label forwarded to the filename status/delete affordance.'],
            ['name' => 'invalid', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Invalid selected file state.'],
            ['name' => 'errorSubject', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Primary invalid file error text.'],
            ['name' => 'errorBody', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Supplemental invalid file error text.'],
            ['name' => 'size', 'type' => 'string', 'required' => false, 'default' => 'md', 'values' => ['sm', 'small', 'md', 'field'], 'description' => 'Selected file item size. small maps to sm; field maps to md.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disabled selected file item state.'],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'file-uploader-item', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-file-uploader-item', 'required' => true, 'description' => 'Generated selected file item marker.'],
            ['name' => 'data-ui-file-uploader-item-uuid', 'required' => true, 'description' => 'Generated file item UUID marker.'],
            ['name' => 'data-ui-file-uploader-item-name', 'required' => true, 'description' => 'Generated filename marker.'],
            ['name' => 'data-ui-file-uploader-item-status', 'required' => true, 'description' => 'Generated status marker.'],
            ['name' => 'data-ui-file-uploader-item-size', 'required' => true, 'description' => 'Generated size marker.'],
            ['name' => 'data-ui-file-uploader-item-invalid', 'required' => true, 'description' => 'Generated invalid state marker.'],
            ['name' => 'data-ui-file-uploader-item-disabled', 'required' => true, 'description' => 'Generated disabled state marker.'],
            ['name' => 'data-ui-file-uploader-item-error', 'required' => true, 'description' => 'Generated error-message presence marker.'],
            ['name' => 'data-ui-file-uploader-item-filename', 'required' => true, 'description' => 'Generated filename text marker.'],
            ['name' => 'data-ui-file-uploader-item-status-container', 'required' => true, 'description' => 'Generated status/delete affordance wrapper marker.'],
            ['name' => 'data-ui-file-uploader-item-error-message', 'required' => false, 'description' => 'Generated invalid file message marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-file__selected-file',
        'required' => [
            'ui-file__selected-file',
            'ui-file-filename',
            'ui-file-container-item',
            'ui-file__state-container',
        ],
        'optional' => [
            'ui-file__selected-file--invalid',
            'ui-file__selected-file--md',
            'ui-file__selected-file--sm',
            'ui-file__selected-file--disabled',
            'ui-file-filename-container-wrap',
            'ui-file-filename-container-wrap-invalid',
            'ui-form-requirement',
            'ui-form-requirement__title',
            'ui-form-requirement__supplement',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local uploaded file row markup',
            'ad hoc selected file status controls',
            'raw file uploader item markup outside x-ui.file-uploader-item',
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
            'description' => 'Selected file item in uploading status.',
        ],
        'edit' => [
            'label' => 'Edit',
            'api' => ['status' => 'edit'],
            'description' => 'Selected file item with editable/removable filename affordance.',
        ],
        'complete' => [
            'label' => 'Complete',
            'api' => ['status' => 'complete'],
            'description' => 'Selected file item in complete status.',
        ],
        'invalid' => [
            'label' => 'Invalid',
            'api' => ['invalid' => true],
            'class' => 'ui-file__selected-file--invalid',
            'description' => 'Selected file item in invalid state.',
        ],
        'disabled' => [
            'label' => 'Disabled',
            'api' => ['disabled' => true],
            'class' => 'ui-file__selected-file--disabled',
            'description' => 'Disabled selected file item.',
        ],
        'with-error' => [
            'label' => 'With error',
            'api' => ['invalid' => true, 'errorSubject' => 'File type not supported'],
            'class' => 'ui-form-requirement',
            'description' => 'Invalid selected file item with error message.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'sm' => [
            'label' => 'Small',
            'api' => ['size' => 'sm'],
            'class' => 'ui-file__selected-file--sm',
            'description' => 'Small selected file item.',
        ],
        'small' => [
            'label' => 'Small alias',
            'api' => ['size' => 'small'],
            'class' => 'ui-file__selected-file--sm',
            'description' => 'Compatibility alias for small selected file item.',
        ],
        'md' => [
            'label' => 'Medium',
            'api' => ['size' => 'md'],
            'class' => 'ui-file__selected-file--md',
            'description' => 'Default selected file item size.',
        ],
        'field' => [
            'label' => 'Field',
            'api' => ['size' => 'field'],
            'class' => 'ui-file__selected-file--md',
            'description' => 'Compatibility field size mapped to medium selected file item.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default selected file item state.'],
        'uploading' => ['label' => 'Uploading', 'required' => false, 'description' => 'Uploading status state.'],
        'edit' => ['label' => 'Edit', 'required' => false, 'description' => 'Editable/removable status state.'],
        'complete' => ['label' => 'Complete', 'required' => false, 'description' => 'Complete status state.'],
        'invalid' => ['label' => 'Invalid', 'required' => false, 'description' => 'Invalid selected file state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled selected file state.'],
        'error' => ['label' => 'Error', 'required' => false, 'description' => 'Invalid file message rendered.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for the nested status/delete affordance.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-file',
            'ui-form-requirement',
        ],
        'component_tokens' => [
            'file-uploader-item',
            'file-uploader',
            'filename',
            'validation',
        ],
        'deprecated' => [
            'feature-local uploaded file row markup',
            'ad hoc file item delete affordances',
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
            'forms',
            'file-uploader',
            'filename',
            'motion',
        ],
        'uses' => [
            'icons' => [],
            'components' => [
                'ui.filename',
            ],
            'js_initializers' => [
                'file uploader behavior if installed',
            ],
        ],
        'blocks' => [
            'file-uploader',
            'file-uploader-drop-container',
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
            'Nested status/delete affordance behavior is owned by x-ui.filename and installed file uploader JavaScript.',
            'Disabled file items must prevent destructive file actions.',
        ],
        'aria' => [
            'Invalid file messages render role="alert".',
            'Nested filename affordance receives aria-describedby when an invalid file message is rendered.',
            'Filename text should remain visible and available as title text.',
        ],
        'focus' => [
            'Nested delete/status affordance must show visible focus when focusable.',
        ],
        'screen_reader' => [
            'iconDescription must clearly describe the available file action.',
            'Invalid file messages must describe the problem and, when possible, how to fix it.',
            'Filename should be meaningful enough to identify the selected file.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            ['name' => 'size:small', 'replacement' => 'size="sm"', 'description' => 'small remains accepted as a compatibility size alias.'],
            ['name' => 'size:field', 'replacement' => 'size="md"', 'description' => 'field remains accepted as a compatibility size alias.'],
        ],
        'classes' => [
            'feature-local file item classes',
            'raw uploaded file row utility clusters',
        ],
        'components' => [
            'ad hoc selected file rows outside x-ui.file-uploader-item',
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
            'resources/views/components/ui/file-uploader-item/index.blade.php',
        ],
        'css' => [
            'resources/css/components/file-uploader.css',
        ],
        'contract' => [
            'resources/views/components/ui/file-uploader-item/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/file-uploader.md',
        ],
    ],
]);
