<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/file-uploader/contract.php
| Purpose: File Uploader Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public File Uploader API that can be called from
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
        'slug' => 'file-uploader',
        'label' => 'File Uploader',
        'component' => 'x-ui.file-uploader',
        'summary' => 'Full file uploader form control with optional title/description, upload trigger, hidden file input, selected file list, accepted file type metadata, max file size metadata, multiple-file support, disabled state, and selected file status rendering.',
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
        'usage_context' => 'Use x-ui.file-uploader for a complete labelled file upload control. Use x-ui.file-uploader-button for button-only upload triggers, x-ui.file-uploader-item for selected file rows, and x-ui.file-uploader-drop-container for drag/drop upload zones.',

        'props' => [
            ['name' => 'files', 'type' => 'array', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Initial selected file list. Files may be strings or arrays with name, uuid, status, invalid, disabled, errorSubject/error_subject, and errorBody/error_body keys.'],
            ['name' => 'accept', 'type' => 'array|string', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Accepted file types forwarded to the upload button hidden input. Arrays are joined as comma-separated accept values.'],
            ['name' => 'buttonKind', 'type' => 'string', 'required' => false, 'default' => 'primary', 'values' => ['primary', 'secondary', 'danger', 'ghost', 'danger--primary', 'danger--ghost', 'danger--tertiary', 'tertiary'], 'description' => 'Upload trigger button kind forwarded to x-ui.file-uploader-button.'],
            ['name' => 'buttonLabel', 'type' => 'string', 'required' => false, 'default' => 'Add file', 'values' => [], 'description' => 'Upload trigger label text.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disables the uploader trigger and upload input.'],
            ['name' => 'filenameStatus', 'type' => 'string', 'required' => false, 'default' => 'edit', 'values' => ['uploading', 'edit', 'complete'], 'description' => 'Default status forwarded to selected file items.'],
            ['name' => 'iconDescription', 'type' => 'string', 'required' => false, 'default' => 'Remove uploaded file', 'values' => [], 'description' => 'Accessible label forwarded to file item status/delete affordances.'],
            ['name' => 'labelDescription', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional descriptive copy associated to the upload trigger.'],
            ['name' => 'labelTitle', 'type' => 'string|HtmlString|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional title heading for the uploader.'],
            ['name' => 'maxFileSize', 'type' => 'int|string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Maximum file size metadata for installed uploader validation behavior.'],
            ['name' => 'multiple', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Allows selecting multiple files when true.'],
            ['name' => 'name', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Native file input name forwarded to x-ui.file-uploader-button.'],
            ['name' => 'size', 'type' => 'string', 'required' => false, 'default' => 'md', 'values' => ['sm', 'small', 'md', 'field', 'lg'], 'description' => 'Uploader trigger and item size. small maps to small file item/button handling; field maps to field/medium treatment.'],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'file-uploader', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-file-uploader', 'required' => true, 'description' => 'Generated root file uploader marker.'],
            ['name' => 'data-ui-file-uploader-id', 'required' => true, 'description' => 'Generated uploader instance ID marker.'],
            ['name' => 'data-ui-file-uploader-multiple', 'required' => true, 'description' => 'Generated multiple state marker.'],
            ['name' => 'data-ui-file-uploader-accept', 'required' => true, 'description' => 'Generated accept value marker.'],
            ['name' => 'data-ui-file-uploader-disabled', 'required' => true, 'description' => 'Generated disabled state marker.'],
            ['name' => 'data-ui-file-uploader-size', 'required' => true, 'description' => 'Generated resolved size marker.'],
            ['name' => 'data-ui-file-uploader-filename-status', 'required' => true, 'description' => 'Generated default filename status marker.'],
            ['name' => 'data-ui-file-uploader-icon-description', 'required' => true, 'description' => 'Generated icon description marker.'],
            ['name' => 'data-ui-file-uploader-max-file-size', 'required' => false, 'description' => 'Generated max file size marker.'],
            ['name' => 'data-ui-file-uploader-file-count', 'required' => true, 'description' => 'Generated selected file count marker.'],
            ['name' => 'data-ui-file-uploader-button-control', 'required' => true, 'description' => 'Generated upload button control marker passed to x-ui.file-uploader-button.'],
            ['name' => 'data-ui-file-container', 'required' => true, 'description' => 'Generated selected file container marker.'],
            ['name' => 'data-ui-file-uploader-file-list', 'required' => true, 'description' => 'Generated selected file list marker.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-file',
        'required' => [
            'ui-form-item',
            'ui-file',
            'ui-file-container',
        ],
        'optional' => [
            'ui-file--disabled',
            'ui-file--has-files',
            'ui-file--label',
            'ui-label-description',
            'ui-label-description--disabled',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local file uploader wrappers',
            'ad hoc file upload controls',
            'raw selected file list markup outside x-ui.file-uploader',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'default' => [
            'label' => 'Default',
            'api' => [],
            'class' => 'ui-file',
            'description' => 'Default file uploader.',
        ],
        'with-title' => [
            'label' => 'With title',
            'api' => ['labelTitle' => 'Upload files'],
            'class' => 'ui-file--label',
            'description' => 'File uploader with title heading.',
        ],
        'with-description' => [
            'label' => 'With description',
            'api' => ['labelDescription' => 'Supported files only.'],
            'class' => 'ui-label-description',
            'description' => 'File uploader with description copy.',
        ],
        'multiple' => [
            'label' => 'Multiple',
            'api' => ['multiple' => true],
            'description' => 'File uploader accepting multiple files.',
        ],
        'with-accept' => [
            'label' => 'With accepted types',
            'api' => ['accept' => ['.jpg', '.png']],
            'description' => 'File uploader with accepted file type metadata.',
        ],
        'with-max-file-size' => [
            'label' => 'With max file size',
            'api' => ['maxFileSize' => 5000000],
            'description' => 'File uploader with max file size metadata.',
        ],
        'with-files' => [
            'label' => 'With files',
            'api' => ['files' => ['document.pdf']],
            'class' => 'ui-file--has-files',
            'description' => 'File uploader with pre-rendered selected files.',
        ],
        'with-invalid-file' => [
            'label' => 'With invalid file',
            'api' => ['files' => [['name' => 'bad.exe', 'invalid' => true, 'errorSubject' => 'File type not supported']]],
            'description' => 'File uploader with invalid selected file item.',
        ],
        'disabled' => [
            'label' => 'Disabled',
            'api' => ['disabled' => true],
            'class' => 'ui-file--disabled',
            'description' => 'Disabled file uploader.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'sm' => ['label' => 'Small', 'api' => ['size' => 'sm'], 'description' => 'Small file uploader trigger/items.'],
        'small' => ['label' => 'Small alias', 'api' => ['size' => 'small'], 'description' => 'Compatibility alias for small file uploader trigger/items.'],
        'md' => ['label' => 'Medium', 'api' => ['size' => 'md'], 'description' => 'Default file uploader size.'],
        'field' => ['label' => 'Field', 'api' => ['size' => 'field'], 'description' => 'Field-sized file uploader treatment.'],
        'lg' => ['label' => 'Large', 'api' => ['size' => 'lg'], 'description' => 'Large file uploader trigger treatment.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default enabled uploader state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled uploader state.'],
        'empty' => ['label' => 'Empty', 'required' => false, 'description' => 'No selected files rendered.'],
        'has-files' => ['label' => 'Has files', 'required' => false, 'description' => 'One or more selected files rendered.'],
        'uploading' => ['label' => 'Uploading', 'required' => false, 'description' => 'Selected file item uploading state.'],
        'complete' => ['label' => 'Complete', 'required' => false, 'description' => 'Selected file item complete state.'],
        'invalid-file' => ['label' => 'Invalid file', 'required' => false, 'description' => 'Selected file item invalid state.'],
        'validating' => ['label' => 'Validating', 'required' => false, 'description' => 'Validation state owned by installed file uploader JavaScript.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for upload trigger and nested file item controls.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-file',
            'ui-file-container',
            'ui-form',
            'ui-label-description',
        ],
        'component_tokens' => [
            'file-uploader',
            'file-uploader-button',
            'file-uploader-item',
            'native-file-input',
            'validation',
        ],
        'deprecated' => [
            'feature-local file uploader wrappers',
            'ad hoc file upload controls',
            'raw selected file lists',
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
            'button',
            'filename',
            'file-uploader-button',
            'file-uploader-item',
            'motion',
        ],
        'uses' => [
            'icons' => [],
            'components' => [
                'ui.file-uploader-button',
                'ui.file-uploader-item',
            ],
            'js_initializers' => [
                'file uploader behavior if installed',
            ],
        ],
        'blocks' => [
            'forms',
            'document-upload',
            'profile-upload',
            'bulk-upload',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Upload trigger must be keyboard reachable unless disabled.',
            'Nested selected file item controls must be keyboard reachable when actionable.',
            'Hidden native file input is activated through installed file uploader behavior.',
        ],
        'aria' => [
            'Label description is associated to the upload trigger through aria-describedby when rendered.',
            'Selected file item errors are announced by x-ui.file-uploader-item.',
            'Disabled state is forwarded to the upload trigger and hidden input.',
        ],
        'focus' => [
            'Upload trigger and nested file item controls must show visible focus.',
        ],
        'screen_reader' => [
            'labelTitle and labelDescription should describe accepted files, size limits, and upload expectations when relevant.',
            'buttonLabel must clearly describe the file selection action.',
            'Invalid selected file messages must identify the problem and recovery path.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'props' => [
            ['name' => 'size:small', 'replacement' => 'size="sm"', 'description' => 'small remains accepted through child uploader components as a compatibility size alias.'],
            ['name' => 'size:field', 'replacement' => 'size="md" with field layout treatment', 'description' => 'field remains accepted through child uploader components.'],
        ],
        'classes' => [
            'feature-local file uploader classes',
            'raw file input utility clusters',
        ],
        'components' => [
            'ad hoc file upload controls outside x-ui.file-uploader',
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
            'resources/views/components/ui/file-uploader/index.blade.php',
        ],
        'css' => [
            'resources/css/components/file-uploader.css',
        ],
        'contract' => [
            'resources/views/components/ui/file-uploader/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/file-uploader.md',
        ],
    ],
]);
