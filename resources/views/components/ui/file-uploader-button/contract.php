<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/file-uploader-button/contract.php
| Purpose: File Uploader Button Component public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public File Uploader Button API that can be called
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
        'slug' => 'file-uploader-button',
        'label' => 'File Uploader Button',
        'component' => 'x-ui.file-uploader-button',
        'summary' => 'Visible upload trigger button paired with a hidden native file input for file uploader compositions.',
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
        'usage_context' => 'Use x-ui.file-uploader-button as the button upload trigger inside file uploader flows. Use x-ui.file-uploader for the full labelled file upload control and x-ui.file-uploader-drop-container for drag/drop upload zones.',

        'props' => [
            ['name' => 'accept', 'type' => 'array|string', 'required' => false, 'default' => [], 'values' => [], 'description' => 'Accepted file types forwarded to the hidden native file input. Arrays are joined as comma-separated accept values.'],
            ['name' => 'buttonKind', 'type' => 'string', 'required' => false, 'default' => 'primary', 'values' => ['primary', 'secondary', 'danger', 'ghost', 'danger--primary', 'danger--ghost', 'danger--tertiary', 'tertiary'], 'description' => 'Visible trigger button kind.'],
            ['name' => 'class', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Optional extra class string applied to the visible trigger button.'],
            ['name' => 'disabled', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Disables the visible trigger and hidden native file input.'],
            ['name' => 'disableLabelChanges', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Prevents installed JavaScript from changing the visible trigger label after file selection.'],
            ['name' => 'id', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Hidden native file input ID. A generated ID is used when omitted.'],
            ['name' => 'labelText', 'type' => 'string', 'required' => false, 'default' => 'Add file', 'values' => [], 'description' => 'Visible trigger label and hidden input label text.'],
            ['name' => 'multiple', 'type' => 'bool', 'required' => false, 'default' => false, 'values' => [true, false], 'description' => 'Allows selecting multiple files when true.'],
            ['name' => 'name', 'type' => 'string|null', 'required' => false, 'default' => null, 'values' => [], 'description' => 'Native hidden file input name for form submission.'],
            ['name' => 'size', 'type' => 'string', 'required' => false, 'default' => 'md', 'values' => ['sm', 'small', 'field', 'md', 'lg'], 'description' => 'Visible trigger size. small maps to sm button size; field maps to md button size while preserving layout-size field marker.'],
        ],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            ['name' => 'data-ui-component', 'required' => true, 'value' => 'file-uploader-button', 'description' => 'Generated visible trigger component marker.'],
            ['name' => 'data-ui-file-uploader-button', 'required' => true, 'description' => 'Generated file uploader button marker.'],
            ['name' => 'data-ui-file-uploader-input-target', 'required' => true, 'description' => 'Generated hidden input target ID marker.'],
            ['name' => 'data-ui-file-uploader-button-kind', 'required' => true, 'description' => 'Generated resolved button kind marker.'],
            ['name' => 'data-ui-file-uploader-button-size', 'required' => true, 'description' => 'Generated resolved button size marker.'],
            ['name' => 'data-ui-file-uploader-disabled', 'required' => true, 'description' => 'Generated disabled state marker.'],
            ['name' => 'data-ui-file-uploader-multiple', 'required' => true, 'description' => 'Generated multiple state marker.'],
            ['name' => 'data-ui-file-uploader-disable-label-changes', 'required' => true, 'description' => 'Generated label-change behavior marker.'],
            ['name' => 'data-ui-file-uploader-button-label', 'required' => true, 'description' => 'Generated visible label marker.'],
            ['name' => 'data-ui-file-uploader-input', 'required' => true, 'description' => 'Generated hidden native file input marker.'],
            ['name' => 'data-ui-file-uploader-input-accept', 'required' => true, 'description' => 'Generated accept value marker on hidden input.'],
            ['name' => 'data-ui-file-uploader-input-multiple', 'required' => true, 'description' => 'Generated multiple marker on hidden input.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => 'ui-btn',
        'required' => [
            'ui-btn',
            'ui-visually-hidden',
        ],
        'optional' => [
            'ui-btn--primary',
            'ui-btn--secondary',
            'ui-btn--danger',
            'ui-btn--ghost',
            'ui-btn--danger--primary',
            'ui-btn--danger--ghost',
            'ui-btn--danger--tertiary',
            'ui-btn--tertiary',
            'ui-btn--sm',
            'ui-btn--md',
            'ui-btn--lg',
            'ui-layout--size-sm',
            'ui-layout--size-small',
            'ui-layout--size-field',
            'ui-layout--size-md',
            'ui-layout--size-lg',
            'ui-btn--disabled',
        ],
        'internal' => [],
        'deprecated' => [
            'feature-local file upload buttons',
            'ad hoc hidden file input triggers',
            'raw upload trigger markup outside x-ui.file-uploader-button',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'primary' => ['label' => 'Primary', 'api' => ['buttonKind' => 'primary'], 'class' => 'ui-btn--primary', 'description' => 'Primary upload trigger button.'],
        'secondary' => ['label' => 'Secondary', 'api' => ['buttonKind' => 'secondary'], 'class' => 'ui-btn--secondary', 'description' => 'Secondary upload trigger button.'],
        'tertiary' => ['label' => 'Tertiary', 'api' => ['buttonKind' => 'tertiary'], 'class' => 'ui-btn--tertiary', 'description' => 'Tertiary upload trigger button.'],
        'ghost' => ['label' => 'Ghost', 'api' => ['buttonKind' => 'ghost'], 'class' => 'ui-btn--ghost', 'description' => 'Ghost upload trigger button.'],
        'danger' => ['label' => 'Danger', 'api' => ['buttonKind' => 'danger'], 'class' => 'ui-btn--danger', 'description' => 'Danger upload trigger button.'],
        'multiple' => ['label' => 'Multiple', 'api' => ['multiple' => true], 'description' => 'Upload trigger paired with multiple file input.'],
        'disable-label-changes' => ['label' => 'Disable label changes', 'api' => ['disableLabelChanges' => true], 'description' => 'Upload trigger whose label should not be mutated by JavaScript.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sizes
    |--------------------------------------------------------------------------
    */

    'sizes' => [
        'sm' => ['label' => 'Small', 'api' => ['size' => 'sm'], 'class' => 'ui-btn--sm', 'description' => 'Small upload trigger.'],
        'small' => ['label' => 'Small alias', 'api' => ['size' => 'small'], 'class' => 'ui-btn--sm', 'description' => 'Compatibility alias for small upload trigger.'],
        'field' => ['label' => 'Field', 'api' => ['size' => 'field'], 'class' => 'ui-layout--size-field', 'description' => 'Field-sized layout treatment with md button size.'],
        'md' => ['label' => 'Medium', 'api' => ['size' => 'md'], 'class' => 'ui-btn--md', 'description' => 'Default upload trigger size.'],
        'lg' => ['label' => 'Large', 'api' => ['size' => 'lg'], 'class' => 'ui-btn--lg', 'description' => 'Large upload trigger.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    'states' => [
        'default' => ['label' => 'Default', 'required' => true, 'description' => 'Default enabled upload trigger state.'],
        'disabled' => ['label' => 'Disabled', 'required' => false, 'description' => 'Disabled trigger and hidden input state.'],
        'focus-visible' => ['label' => 'Focus-visible', 'required' => true, 'description' => 'Visible focus state for the visible trigger.'],
        'multiple' => ['label' => 'Multiple', 'required' => false, 'description' => 'Hidden input accepts multiple files.'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-btn',
            'ui-file',
            'ui-visually-hidden',
        ],
        'component_tokens' => [
            'file-uploader-button',
            'file-uploader',
            'button',
            'native-file-input',
        ],
        'deprecated' => [
            'feature-local upload trigger buttons',
            'ad hoc file input labels',
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
            'button',
            'forms',
            'motion',
        ],
        'uses' => [
            'icons' => [],
            'components' => [],
            'js_initializers' => [
                'file uploader behavior if installed',
            ],
        ],
        'blocks' => [
            'file-uploader',
            'file-uploader-drop-container',
            'forms',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Visible trigger must be keyboard reachable unless disabled.',
            'Hidden native file input is removed from tab order and activated through installed file uploader behavior.',
        ],
        'aria' => [
            'Hidden native file input has a visually hidden label matching the visible trigger label.',
            'Caller-provided aria-describedby may be applied to the visible trigger.',
        ],
        'focus' => [
            'Visible trigger must show visible focus.',
        ],
        'screen_reader' => [
            'labelText must clearly describe the file selection action.',
            'Accepted file type and size constraints should be described by surrounding uploader copy when relevant.',
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
            ['name' => 'size:field', 'replacement' => 'size="md" with field layout treatment', 'description' => 'field remains accepted for field-sized uploader layouts.'],
        ],
        'classes' => [
            'feature-local file upload button classes',
            'raw hidden file input utility clusters',
        ],
        'components' => [
            'ad hoc file upload triggers outside x-ui.file-uploader-button',
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
            'resources/views/components/ui/file-uploader-button/index.blade.php',
        ],
        'css' => [
            'resources/css/components/button.css',
            'resources/css/components/file-uploader.css',
        ],
        'contract' => [
            'resources/views/components/ui/file-uploader-button/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/file-uploader.md',
        ],
    ],
]);
