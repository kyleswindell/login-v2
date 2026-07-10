<?php

return [
    'primaryBase' => [
        [
            'label' => 'Dashboard',
            'route' => 'dashboard',
            'active' => ['dashboard'],
            'icon' => 'apps',
        ],
    ],

    'primaryAdmin' => [
        [
            'label' => 'Documentation Vault',
            'route' => 'platform.docs.index',
            'active' => ['platform.docs.index'],
            'ability' => 'view-platform-docs',
            'icon' => 'notebook',
        ],
        [
            'label' => 'Security Checklist',
            'route' => 'platform.security.index',
            'active' => ['platform.security.*'],
            'ability' => 'view-platform-security-checklist',
            'icon' => 'settings--check',
        ],
    ],

    'logs' => [
        [
            'label' => 'Audit Logs',
            'route' => 'platform.operations.audit-logs.index',
            'active' => [
                'platform.operations.audit-logs.*',
                'platform.audit-logs.*',
            ],
            'ability' => 'view-platform-audit-logs',
            'icon' => 'report',
        ],
        [
            'label' => 'Error Logs',
            'route' => 'platform.operations.error-logs.index',
            'active' => [
                'platform.operations.error-logs.*',
                'platform.error-logs.*',
            ],
            'ability' => 'view-platform-error-logs',
            'icon' => 'warning',
        ],
    ],

    'setupBase' => [],

    'setupAdmin' => [],

    'account' => [
        [
            'label' => 'My Account',
            'route' => 'platform.account.index',
            'active' => ['platform.account.index'],
        ],
        [
            'label' => 'Account Settings',
            'route' => 'platform.account.settings',
            'active' => ['platform.account.settings'],
        ],
        [
            'label' => 'Preferences',
            'route' => 'platform.account.preferences',
            'active' => ['platform.account.preferences'],
        ],
    ],
];
