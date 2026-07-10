<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/file-uploader-drop-container/contract.php
| Purpose: File Uploader Drop Container Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public File Uploader Drop Container API that can
| be called from Blade, validated by tooling, and consumed by file uploader
| compositions.
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
        'slug' => 'file-uploader-drop-container',
        'label' => 'File Uploader Drop Container',
        'component' => 'x-ui.file-uploader-drop-container',
        'summary' => 'Drag-and-drop file upload target paired with a hidden native file input and file uploader JavaScript hooks.',
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
        'usage_context' => 'Use x-ui.file-uploader-drop-container for drag-and-drop upload zones. Use x-ui.file-uploader for the full labelled upload control and x-ui.file-uploader-button for a button-only upload trigger.',

        'props' => [
            ['name' => 'accept', 'type' => 'array|string', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Accepted file types forwarded to the hidden native file input. Arrays are joined as comma-separated accept values.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disables the drop target and hidden native file input.'],
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Hidden native file input ID. A generated ID is used when omitted.'],
            ['name' => 'labelText', 'type' => 'string|HtmlString', 'required' => false, 'default' => 'Add file', 'values' => [], 'description' => 'Visible drop target label and hidden input label text.'],
            ['name' => 'maxFileSize', 'type' => 'int|string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Maximum file size metadata for installed file uploader validation behavior.'],
            ['name' => 'multiple', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Allows selecting or dropping multiple files when true.'],
            ['name' => 'name', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Native hidden file input name for form submission.'],
            ['name' => 'pattern', 'type' => 'string', 'required' => false, 'default' => '.[0-9a-z]+$', 'values' => [], 'description' => 'Accepted filename pattern metadata for installed validation behavior.'],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'file-uploader-drop-container', 'description' => 'Generated root component marker.'],
            ['name' => 'data-ui-file-drop', 'required' => true, 'description' => 'Generated root file drop marker.'],
            ['name' => 'data-ui-file-drop-input-target', 'required' => true, 'description' => 'Generated hidden input target ID marker.'],
            ['name' => 'data-ui-file-drop-disabled', 'required' => true, 'description' => 'Generated disabled state marker.'],
            ['name' => 'data-ui-file-drop-multiple', 'required' => true, 'description' => 'Generated multiple state marker.'],
            ['name' => 'data-ui-file-drop-accept', 'required' => true, 'description' => 'Generated accept value marker.'],
            ['name' => 'data-ui-file-drop-pattern', 'required' => true, 'description' => 'Generated filename pattern marker.'],
            ['name' => 'data-ui-file-drop-max-file-size', 'required' => false, 'description' => 'Generated max file size marker.'],
            ['name' => 'data-ui-file-drop-trigger', 'required' => true, 'description' => 'Generated drop target trigger marker.'],
            ['name' => 'data-ui-file-uploader-input-target', 'required' => true, 'description' => 'Generated hidden file input target marker.'],
            ['name' => 'data-ui-file-uploader-input', 'required' => true, 'description' => 'Generated hidden native file input marker.'],
            ['name' => 'data-ui-file-drop-input', 'required' => true, 'description' => 'Generated drop input marker.'],
            ['name' => 'data-ui-file-drop-input-accept', 'required' => true, 'description' => 'Generated hidden input accept marker.'],
            ['name' => 'data-ui-file-drop-input-multiple', 'required' => true, 'description' => 'Generated hidden input multiple marker.'],
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
            'ui-file',
            'ui-file__drop-container',
            'ui-file-browse-btn',
            'ui-visually-hidden',
            'ui-file-input',
        ],
        'optional' => [
            'ui-file--drop-disabled',
            'ui-file-browse-btn--disabled',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local drag-and-drop upload zones',
            'ad hoc hidden file input drop targets',
            'raw file drop markup outside x-ui.file-uploader-drop-container',
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
            'class' => 'ui-file__drop-container',
            'description' => 'Default enabled drop container.',
        ],
        'disabled' => [
            'label' => 'Disabled',
            'api' => ['disabled' => true],
            'class' => 'ui-file-browse-btn--disabled',
            'description' => 'Disabled drop container and hidden file input.',
        ],
        'multiple' => [
            'label' => 'Multiple',
            'api' => ['multiple' => true],
            'description' => 'Drop container accepting multiple files.',
        ],
        'with-accept' => [
            'label' => 'With accepted types',
            'api' => ['accept' => ['.jpg', '.png']],
            'description' => 'Drop container with accepted file type metadata.',
        ],
        'with-max-file-size' => [
            'label' => 'With max file size',
            'api' => ['maxFileSize' => 5000000],
            'description' => 'Drop container with max file size metadata.',
        ],
        'with-pattern' => [
            'label' => 'With pattern',
            'api' => ['pattern' => '.(jpg|png)$'],
            'description' => 'Drop container with filename pattern metadata.',
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
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default enabled drop container state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled drop container state.'],
        'drag-over' => ['label' => 'Drag over', 'required' => false, 'description' => 'Drag-over state owned by installed file uploader JavaScript.'],
        'drag-active' => ['label' => 'Drag active', 'required' => false, 'description' => 'Active drag state owned by installed file uploader JavaScript.'],
        'dropping' => ['label' => 'Dropping', 'required' => false, 'description' => 'Drop handling state owned by installed file uploader JavaScript.'],
        'validating' => ['label' => 'Validating', 'required' => false, 'description' => 'File validation state owned by installed file uploader JavaScript.'],
        'rejected' => ['label' => 'Rejected', 'required' => false, 'description' => 'Rejected file state owned by installed file uploader JavaScript.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for the drop target trigger.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-file',
            'ui-file-browse-btn',
            'ui-visually-hidden',
        ],
        'component_tokens' => [
            'file-uploader-drop-container',
            'file-uploader',
            'native-file-input',
            'drag-drop',
        ],
        'deprecated' => [
            'feature-local drag/drop upload zones',
            'ad hoc file drop input wrappers',
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
            'forms',
            'file-uploader',
            'motion',
        ],
        'uses' => [
            'icons' => [],
            'components' => [],
            'js_initializers' => [
                'file uploader drop behavior if installed',
                'file uploader behavior if installed',
            ],
        ],
        'blocks' => [
            'file-uploader',
            'forms',
            'bulk-upload',
            'drag-drop-upload',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Drop target trigger must be keyboard reachable unless disabled.',
            'Hidden native file input is removed from tab order and activated through installed file uploader behavior.',
            'Drag/drop behavior must have an equivalent click/keyboard file selection path.',
        ],
        'aria' => [
            'Hidden native file input has a visually hidden label matching the drop target label.',
            'Disabled state disables both the visible trigger and hidden file input.',
        ],
        'focus' => [
            'Drop target trigger must show visible focus.',
        ],
        'screen_reader' => [
            'labelText must clearly describe the file selection action.',
            'Accepted file type and size constraints should be described by surrounding uploader copy when relevant.',
            'Validation failures should be rendered through file uploader item/error messaging.',
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
            'feature-local file drop classes',
            'raw drag/drop file upload utility clusters',
        ],
        'components' => [
            'ad hoc drag/drop upload zones outside x-ui.file-uploader-drop-container',
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
            'resources/views/components/ui/file-uploader-drop-container/index.blade.php',
        ],
        'css' => [
            'resources/css/components/file-uploader.css',
        ],
        'contract' => [
            'resources/views/components/ui/file-uploader-drop-container/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/file-uploader.md',
        ],
    ],
]);
