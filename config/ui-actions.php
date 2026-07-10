<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| File: config/ui-actions.php
| Purpose: Canonical UI action defaults.
|--------------------------------------------------------------------------
|
| Defines app-level action intent defaults. Icons must use exact canonical
| icon names from the generated UI icon manifest.
|
| This is not an icon alias map. Do not use this file to translate arbitrary
| legacy icon names. Use it only when the action intent is known.
|
*/

return [
    'actions' => [
        /*
        |--------------------------------------------------------------------------
        | Creation / modification
        |--------------------------------------------------------------------------
        */

        'new' => [
            'label' => 'New',
            'icon' => 'add',
            'semantic' => 'primary',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'add' => [
            'label' => 'Add',
            'icon' => 'add',
            'semantic' => 'primary',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'create' => [
            'label' => 'Create',
            'icon' => 'add',
            'semantic' => 'primary',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'edit' => [
            'label' => 'Edit',
            'icon' => 'edit',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'save' => [
            'label' => 'Save',
            'icon' => 'save',
            'semantic' => 'primary',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'duplicate' => [
            'label' => 'Duplicate',
            'icon' => 'copy',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        /*
        |--------------------------------------------------------------------------
        | Removal / destructive
        |--------------------------------------------------------------------------
        */

        'clear' => [
            'label' => 'Clear',
            'icon' => 'close',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'remove' => [
            'label' => 'Remove',
            'icon' => 'subtract',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'delete' => [
            'label' => 'Delete',
            'icon' => 'trash-can',
            'semantic' => 'danger',
            'danger' => true,
            'requires_confirmation' => true,
            'confirmation_level' => 'moderate',
        ],

        'archive' => [
            'label' => 'Archive',
            'icon' => 'archive',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        /*
        |--------------------------------------------------------------------------
        | Dialog / flow control
        |--------------------------------------------------------------------------
        */

        'cancel' => [
            'label' => 'Cancel',
            'icon' => null,
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'close' => [
            'label' => 'Close',
            'icon' => 'close',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'back' => [
            'label' => 'Back',
            'icon' => 'arrow--left',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'next' => [
            'label' => 'Next',
            'icon' => 'arrow--right',
            'semantic' => 'primary',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'continue' => [
            'label' => 'Continue',
            'icon' => 'arrow--right',
            'semantic' => 'primary',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'finish' => [
            'label' => 'Finish',
            'icon' => 'checkmark',
            'semantic' => 'primary',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'confirm' => [
            'label' => 'Confirm',
            'icon' => 'checkmark',
            'semantic' => 'primary',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        /*
        |--------------------------------------------------------------------------
        | Clipboard / file movement
        |--------------------------------------------------------------------------
        */

        'copy' => [
            'label' => 'Copy',
            'icon' => 'copy',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
            'success_label' => 'Copied',
        ],

        'copy-link' => [
            'label' => 'Copy link',
            'icon' => 'copy--link',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
            'success_label' => 'Copied',
        ],

        'download' => [
            'label' => 'Download',
            'icon' => 'download',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'upload' => [
            'label' => 'Upload',
            'icon' => 'upload',
            'semantic' => 'primary',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'export' => [
            'label' => 'Export',
            'icon' => 'export',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        /*
        |--------------------------------------------------------------------------
        | Search / filtering / view
        |--------------------------------------------------------------------------
        */

        'search' => [
            'label' => 'Search',
            'icon' => 'search',
            'semantic' => 'primary',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'filter' => [
            'label' => 'Filter',
            'icon' => 'filter',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'reset' => [
            'label' => 'Reset',
            'icon' => 'reset',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'refresh' => [
            'label' => 'Refresh',
            'icon' => 'renew',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'show' => [
            'label' => 'Show',
            'icon' => 'view',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'hide' => [
            'label' => 'Hide',
            'icon' => 'view--off',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        /*
        |--------------------------------------------------------------------------
        | Open / launch
        |--------------------------------------------------------------------------
        */

        'open' => [
            'label' => 'Open',
            'icon' => 'launch',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'open-external' => [
            'label' => 'Open',
            'icon' => 'new-tab',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
            'external' => true,
        ],

        'view-details' => [
            'label' => 'View details',
            'icon' => 'view',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        /*
        |--------------------------------------------------------------------------
        | Authentication / account
        |--------------------------------------------------------------------------
        */

        'sign-in' => [
            'label' => 'Sign in',
            'icon' => 'login',
            'semantic' => 'primary',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'sign-out' => [
            'label' => 'Sign out',
            'icon' => 'logout',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'lock' => [
            'label' => 'Lock',
            'icon' => 'locked',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'unlock' => [
            'label' => 'Unlock',
            'icon' => 'unlocked',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'mfa' => [
            'label' => 'Set up MFA',
            'icon' => 'two-factor-authentication',
            'semantic' => 'primary',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        /*
        |--------------------------------------------------------------------------
        | Review / approval
        |--------------------------------------------------------------------------
        */

        'approve' => [
            'label' => 'Approve',
            'icon' => 'checkmark--filled',
            'semantic' => 'primary',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'reject' => [
            'label' => 'Reject',
            'icon' => 'close--filled',
            'semantic' => 'danger',
            'danger' => true,
            'requires_confirmation' => false,
        ],

        'submit' => [
            'label' => 'Submit',
            'icon' => 'send',
            'semantic' => 'primary',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        /*
        |--------------------------------------------------------------------------
        | Platform / operations
        |--------------------------------------------------------------------------
        */

        'audit-log' => [
            'label' => 'Audit log',
            'icon' => 'report',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'error-log' => [
            'label' => 'Error log',
            'icon' => 'warning',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'settings' => [
            'label' => 'Settings',
            'icon' => 'settings',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'security' => [
            'label' => 'Security',
            'icon' => 'settings--check',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        /*
        |--------------------------------------------------------------------------
        | Notification actions
        |--------------------------------------------------------------------------
        */

        'dismiss' => [
            'label' => 'Dismiss',
            'icon' => 'close',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],

        'mark-read' => [
            'label' => 'Mark as read',
            'icon' => 'checkmark',
            'semantic' => 'ghost',
            'danger' => false,
            'requires_confirmation' => false,
        ],
    ],
];
