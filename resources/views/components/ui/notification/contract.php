<?php

declare(strict_types=1);

use App\Surfaces\Contracts\Surface;

/*
|--------------------------------------------------------------------------
| File: resources/views/components/ui/notification/contract.php
| Purpose: Notification Component family public API contract.
|--------------------------------------------------------------------------
|
| This contract declares the public Notification family API that can be called
| from Blade, validated by tooling, and consumed by app layouts or Patterns.
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
        'slug' => 'notification',
        'label' => 'Notification',
        'component' => 'x-ui.notification.*',
        'summary' => 'Notification family for inline, toast, actionable, callout, static alias, icon, close button, and action button surfaces.',
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
        'usage_context' => 'Use the Notification family for status, feedback, callout, toast, and actionable message surfaces. Use the child component that matches the placement and behavior.',

        'props' => [],

        'slots' => [],

        'events' => [],

        'data_attributes' => [
            [
                'name' => 'data-ui-notification',
                'required' => false,
                'description' => 'Generated notification container marker on toast, inline, actionable, callout, and static-forwarded callout surfaces.',
            ],
            [
                'name' => 'data-ui-notification-type',
                'required' => false,
                'description' => 'Generated notification type marker: toast, inline, actionable, or callout.',
            ],
            [
                'name' => 'data-ui-notification-kind',
                'required' => false,
                'description' => 'Generated notification kind marker.',
            ],
            [
                'name' => 'data-ui-notification-icon',
                'required' => false,
                'description' => 'Generated notification icon marker.',
            ],
            [
                'name' => 'data-ui-notification-close',
                'required' => false,
                'description' => 'Generated close button marker for notification JavaScript.',
            ],
            [
                'name' => 'data-ui-notification-close-on-escape',
                'required' => false,
                'description' => 'Generated actionable notification marker for Escape close behavior.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Subcomponents
    |--------------------------------------------------------------------------
    */

    'subcomponents' => [
        'toast' => [
            'component' => 'x-ui.notification.toast',
            'description' => 'Toast notification container.',
            'props' => [
                [
                    'name' => 'kind',
                    'type' => 'string',
                    'required' => false,
                    'default' => 'error',
                    'values' => ['error', 'info', 'success', 'warning'],
                    'description' => 'Semantic notification kind.',
                ],
                [
                    'name' => 'title',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Toast title text.',
                ],
                [
                    'name' => 'subtitle',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Toast subtitle/body text.',
                ],
                [
                    'name' => 'caption',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Toast caption text.',
                ],
                [
                    'name' => 'role',
                    'type' => 'string',
                    'required' => false,
                    'default' => 'status',
                    'values' => ['status', 'alert'],
                    'description' => 'ARIA role for the notification container.',
                ],
                [
                    'name' => 'lowContrast',
                    'type' => 'bool',
                    'required' => false,
                    'default' => false,
                    'values' => [true, false],
                    'description' => 'Applies low-contrast visual treatment.',
                ],
                [
                    'name' => 'hideCloseButton',
                    'type' => 'bool',
                    'required' => false,
                    'default' => false,
                    'values' => [true, false],
                    'description' => 'Suppresses the close button.',
                ],
                [
                    'name' => 'closeLabel',
                    'type' => 'string',
                    'required' => false,
                    'default' => 'close notification',
                    'values' => [],
                    'description' => 'Accessible label and title for the close button.',
                ],
                [
                    'name' => 'statusIconDescription',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Screen-reader text for the status icon wrapper.',
                ],
            ],
            'slots' => [
                [
                    'name' => 'default',
                    'required' => false,
                    'description' => 'Custom notification body content.',
                ],
                [
                    'name' => 'icon',
                    'required' => false,
                    'description' => 'Custom status icon content.',
                ],
                [
                    'name' => 'closeIcon',
                    'required' => false,
                    'description' => 'Custom close icon content.',
                ],
            ],
        ],

        'inline' => [
            'component' => 'x-ui.notification.inline',
            'description' => 'Inline notification container.',
            'props' => [
                [
                    'name' => 'kind',
                    'type' => 'string',
                    'required' => false,
                    'default' => 'error',
                    'values' => ['error', 'info', 'success', 'warning'],
                    'description' => 'Semantic notification kind.',
                ],
                [
                    'name' => 'title',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Inline notification title text.',
                ],
                [
                    'name' => 'subtitle',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Inline notification subtitle/body text.',
                ],
                [
                    'name' => 'role',
                    'type' => 'string',
                    'required' => false,
                    'default' => 'status',
                    'values' => ['status', 'alert'],
                    'description' => 'ARIA role for the notification container.',
                ],
                [
                    'name' => 'lowContrast',
                    'type' => 'bool',
                    'required' => false,
                    'default' => false,
                    'values' => [true, false],
                    'description' => 'Applies low-contrast visual treatment.',
                ],
                [
                    'name' => 'hideCloseButton',
                    'type' => 'bool',
                    'required' => false,
                    'default' => false,
                    'values' => [true, false],
                    'description' => 'Suppresses the close button.',
                ],
                [
                    'name' => 'closeLabel',
                    'type' => 'string',
                    'required' => false,
                    'default' => 'close notification',
                    'values' => [],
                    'description' => 'Accessible label and title for the close button.',
                ],
                [
                    'name' => 'statusIconDescription',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Screen-reader text for the status icon wrapper.',
                ],
            ],
            'slots' => [
                [
                    'name' => 'default',
                    'required' => false,
                    'description' => 'Custom inline notification body content.',
                ],
                [
                    'name' => 'icon',
                    'required' => false,
                    'description' => 'Custom status icon content.',
                ],
                [
                    'name' => 'closeIcon',
                    'required' => false,
                    'description' => 'Custom close icon content.',
                ],
            ],
        ],

        'actionable' => [
            'component' => 'x-ui.notification.actionable',
            'description' => 'Actionable notification container with optional action button and close button.',
            'props' => [
                [
                    'name' => 'kind',
                    'type' => 'string',
                    'required' => false,
                    'default' => 'error',
                    'values' => ['error', 'info', 'success', 'warning'],
                    'description' => 'Semantic notification kind.',
                ],
                [
                    'name' => 'title',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Actionable notification title text.',
                ],
                [
                    'name' => 'subtitle',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Actionable notification subtitle/body text.',
                ],
                [
                    'name' => 'caption',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Actionable notification caption text.',
                ],
                [
                    'name' => 'role',
                    'type' => 'string',
                    'required' => false,
                    'default' => 'alertdialog',
                    'values' => ['alertdialog', 'alert', 'status'],
                    'description' => 'ARIA role for the actionable notification container.',
                ],
                [
                    'name' => 'inline',
                    'type' => 'bool',
                    'required' => false,
                    'default' => false,
                    'values' => [true, false],
                    'description' => 'Uses inline-style presentation when true; toast-style presentation when false.',
                ],
                [
                    'name' => 'lowContrast',
                    'type' => 'bool',
                    'required' => false,
                    'default' => false,
                    'values' => [true, false],
                    'description' => 'Applies low-contrast visual treatment.',
                ],
                [
                    'name' => 'hideCloseButton',
                    'type' => 'bool',
                    'required' => false,
                    'default' => false,
                    'values' => [true, false],
                    'description' => 'Suppresses the close button.',
                ],
                [
                    'name' => 'actionButtonLabel',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Visible action button label.',
                ],
                [
                    'name' => 'closeLabel',
                    'type' => 'string',
                    'required' => false,
                    'default' => 'close notification',
                    'values' => [],
                    'description' => 'Accessible label and title for the close button.',
                ],
                [
                    'name' => 'statusIconDescription',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Screen-reader text for the status icon wrapper.',
                ],
                [
                    'name' => 'titleId',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Optional ID for the rendered title.',
                ],
                [
                    'name' => 'subtitleId',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Optional ID for the rendered subtitle.',
                ],
            ],
            'slots' => [
                [
                    'name' => 'default',
                    'required' => false,
                    'description' => 'Custom actionable notification body content.',
                ],
                [
                    'name' => 'icon',
                    'required' => false,
                    'description' => 'Custom status icon content.',
                ],
                [
                    'name' => 'closeIcon',
                    'required' => false,
                    'description' => 'Custom close icon content.',
                ],
            ],
        ],

        'callout' => [
            'component' => 'x-ui.notification.callout',
            'description' => 'Callout notification using actionable notification classes with hidden close button.',
            'props' => [
                [
                    'name' => 'kind',
                    'type' => 'string',
                    'required' => false,
                    'default' => 'info',
                    'values' => ['error', 'info', 'success', 'warning'],
                    'description' => 'Semantic notification kind.',
                ],
                [
                    'name' => 'title',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Callout title text.',
                ],
                [
                    'name' => 'subtitle',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Callout subtitle/body text.',
                ],
                [
                    'name' => 'titleId',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Optional ID for the rendered title.',
                ],
                [
                    'name' => 'actionButtonLabel',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Visible action button label.',
                ],
                [
                    'name' => 'lowContrast',
                    'type' => 'bool',
                    'required' => false,
                    'default' => false,
                    'values' => [true, false],
                    'description' => 'Applies low-contrast visual treatment.',
                ],
                [
                    'name' => 'statusIconDescription',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Screen-reader text for the status icon wrapper.',
                ],
            ],
            'slots' => [
                [
                    'name' => 'default',
                    'required' => false,
                    'description' => 'Custom callout body content.',
                ],
                [
                    'name' => 'icon',
                    'required' => false,
                    'description' => 'Custom status icon content.',
                ],
            ],
        ],

        'static' => [
            'component' => 'x-ui.notification.static',
            'description' => 'Legacy alias that forwards to x-ui.notification.callout.',
            'props' => [
                [
                    'name' => 'kind',
                    'type' => 'string',
                    'required' => false,
                    'default' => 'info',
                    'values' => ['error', 'info', 'success', 'warning'],
                    'description' => 'Forwarded semantic notification kind.',
                ],
                [
                    'name' => 'title',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Forwarded title text.',
                ],
                [
                    'name' => 'subtitle',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Forwarded subtitle/body text.',
                ],
                [
                    'name' => 'titleId',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Forwarded title ID.',
                ],
                [
                    'name' => 'actionButtonLabel',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Forwarded action button label.',
                ],
                [
                    'name' => 'lowContrast',
                    'type' => 'bool',
                    'required' => false,
                    'default' => false,
                    'values' => [true, false],
                    'description' => 'Forwarded low-contrast treatment.',
                ],
                [
                    'name' => 'statusIconDescription',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Forwarded status icon description.',
                ],
            ],
            'slots' => [
                [
                    'name' => 'default',
                    'required' => false,
                    'description' => 'Forwarded callout body content.',
                ],
                [
                    'name' => 'icon',
                    'required' => false,
                    'description' => 'Forwarded status icon content.',
                ],
            ],
        ],

        'icon' => [
            'component' => 'x-ui.notification.icon',
            'description' => 'Notification status icon wrapper.',
            'props' => [
                [
                    'name' => 'kind',
                    'type' => 'string',
                    'required' => false,
                    'default' => 'info',
                    'values' => ['error', 'info', 'success', 'warning'],
                    'description' => 'Semantic notification kind.',
                ],
                [
                    'name' => 'notificationType',
                    'type' => 'string',
                    'required' => false,
                    'default' => 'toast',
                    'values' => ['toast', 'inline', 'actionable'],
                    'description' => 'Notification type used to generate the icon wrapper class.',
                ],
                [
                    'name' => 'description',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => [],
                    'description' => 'Visually hidden status icon description.',
                ],
            ],
            'slots' => [
                [
                    'name' => 'default',
                    'required' => true,
                    'description' => 'Status icon artwork.',
                ],
            ],
        ],

        'close-button' => [
            'component' => 'x-ui.notification.close-button',
            'description' => 'Notification close button.',
            'props' => [
                [
                    'name' => 'label',
                    'type' => 'string',
                    'required' => false,
                    'default' => 'close notification',
                    'values' => [],
                    'description' => 'Accessible label and title.',
                ],
                [
                    'name' => 'type',
                    'type' => 'string',
                    'required' => false,
                    'default' => 'button',
                    'values' => ['button', 'submit', 'reset'],
                    'description' => 'Native button type.',
                ],
                [
                    'name' => 'notificationType',
                    'type' => 'string',
                    'required' => false,
                    'default' => 'toast',
                    'values' => ['toast', 'inline', 'actionable'],
                    'description' => 'Notification type used to generate the close button class.',
                ],
            ],
            'slots' => [
                [
                    'name' => 'default',
                    'required' => false,
                    'description' => 'Optional custom close icon. Defaults to x-ui.icon close.',
                ],
            ],
        ],

        'action-button' => [
            'component' => 'x-ui.notification.action-button',
            'description' => 'Notification action button wrapper around x-ui.button.',
            'props' => [
                [
                    'name' => 'inline',
                    'type' => 'bool',
                    'required' => false,
                    'default' => false,
                    'values' => [true, false],
                    'description' => 'When true, default action kind resolves to ghost. Otherwise it resolves to tertiary.',
                ],
                [
                    'name' => 'kind',
                    'type' => 'string|null',
                    'required' => false,
                    'default' => null,
                    'values' => ['primary', 'secondary', 'tertiary', 'ghost', 'danger', 'danger--primary', 'danger--tertiary', 'danger--ghost'],
                    'description' => 'Optional x-ui.button kind override.',
                ],
                [
                    'name' => 'size',
                    'type' => 'string',
                    'required' => false,
                    'default' => 'sm',
                    'values' => ['xs', 'sm', 'md', 'lg', 'xl', '2xl'],
                    'description' => 'x-ui.button size.',
                ],
            ],
            'slots' => [
                [
                    'name' => 'default',
                    'required' => true,
                    'description' => 'Visible action button label.',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    'class_contract' => [
        'root' => null,
        'required' => [],
        'optional' => [
            'ui-toast-notification',
            'ui-toast-notification--low-contrast',
            'ui-toast-notification--error',
            'ui-toast-notification--info',
            'ui-toast-notification--success',
            'ui-toast-notification--warning',
            'ui-inline-notification',
            'ui-inline-notification--low-contrast',
            'ui-inline-notification--hide-close-button',
            'ui-inline-notification--error',
            'ui-inline-notification--info',
            'ui-inline-notification--success',
            'ui-inline-notification--warning',
            'ui-actionable-notification',
            'ui-actionable-notification--toast',
            'ui-actionable-notification--low-contrast',
            'ui-actionable-notification--hide-close-button',
            'ui-actionable-notification--error',
            'ui-actionable-notification--info',
            'ui-actionable-notification--success',
            'ui-actionable-notification--warning',
        ],
        'internal' => [
            'ui-toast-notification__details',
            'ui-toast-notification__title',
            'ui-toast-notification__subtitle',
            'ui-toast-notification__caption',
            'ui-toast-notification__icon',
            'ui-toast-notification__close-button',
            'ui-inline-notification__details',
            'ui-inline-notification__text-wrapper',
            'ui-inline-notification__title',
            'ui-inline-notification__subtitle',
            'ui-inline-notification__icon',
            'ui-inline-notification__close-button',
            'ui-actionable-notification__focus-wrapper',
            'ui-actionable-notification__details',
            'ui-actionable-notification__text-wrapper',
            'ui-actionable-notification__content',
            'ui-actionable-notification__title',
            'ui-actionable-notification__subtitle',
            'ui-actionable-notification__caption',
            'ui-actionable-notification__button-wrapper',
            'ui-actionable-notification__close-button',
            'ui-actionable-notification__action-button',
            'ui-notification-close-icon',
            'ui-visually-hidden',
        ],
        'deprecated' => [
            'feature-local notification colors',
            'feature-local alert markup',
            'legacy static notification usage when callout is available',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Variants
    |--------------------------------------------------------------------------
    */

    'variants' => [
        'toast' => [
            'label' => 'Toast',
            'api' => ['component' => 'x-ui.notification.toast'],
            'class' => 'ui-toast-notification',
            'description' => 'Toast notification surface.',
        ],
        'inline' => [
            'label' => 'Inline',
            'api' => ['component' => 'x-ui.notification.inline'],
            'class' => 'ui-inline-notification',
            'description' => 'Inline notification surface.',
        ],
        'actionable' => [
            'label' => 'Actionable',
            'api' => ['component' => 'x-ui.notification.actionable'],
            'class' => 'ui-actionable-notification',
            'description' => 'Notification with action and close button support.',
        ],
        'callout' => [
            'label' => 'Callout',
            'api' => ['component' => 'x-ui.notification.callout'],
            'class' => 'ui-actionable-notification',
            'description' => 'Callout notification surface with hidden close button.',
        ],
        'static' => [
            'label' => 'Static alias',
            'api' => ['component' => 'x-ui.notification.static'],
            'description' => 'Legacy alias forwarded to callout.',
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
        'default' => [
            'label' => 'Default',
            'required' => true,
            'description' => 'Default notification state.',
        ],
        'low-contrast' => [
            'label' => 'Low contrast',
            'required' => false,
            'description' => 'Low-contrast visual treatment.',
        ],
        'dismissible' => [
            'label' => 'Dismissible',
            'required' => false,
            'description' => 'Notification with close button.',
        ],
        'non-dismissible' => [
            'label' => 'Non-dismissible',
            'required' => false,
            'description' => 'Notification with close button hidden.',
        ],
        'actionable' => [
            'label' => 'Actionable',
            'required' => false,
            'description' => 'Notification with action button.',
        ],
        'focus-visible' => [
            'label' => 'Focus-visible',
            'required' => true,
            'description' => 'Visible focus state for close and action controls.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Public Token / Utility Surface
    |--------------------------------------------------------------------------
    */

    'tokens' => [
        'class_families' => [
            'ui-toast-notification',
            'ui-inline-notification',
            'ui-actionable-notification',
            'ui-notification-close-icon',
        ],
        'component_tokens' => [
            'notification',
            'status',
            'button',
        ],
        'deprecated' => [
            'feature-local notification colors',
            'feature-local status icon colors',
            'ad hoc alert markup outside x-ui.notification.*',
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
            'motion',
            'button',
        ],
        'uses' => [
            'icons' => [
                'close',
                'caller-provided status icon',
            ],
            'components' => [
                'ui.icon',
                'ui.button',
            ],
            'js_initializers' => [
                'notification dismissal behavior if installed',
            ],
        ],
        'blocks' => [
            'forms',
            'modals',
            'toasts',
            'feedback-patterns',
            'system-status',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Accessibility Requirements
    |--------------------------------------------------------------------------
    */

    'accessibility' => [
        'keyboard' => [
            'Close and action buttons must be keyboard reachable when rendered.',
            'Escape dismissal must only be enabled when notification JavaScript owns that behavior.',
        ],
        'aria' => [
            'Toast and inline notifications default to role="status".',
            'Actionable notifications default to role="alertdialog".',
            'Actionable notifications must not reference missing aria-labelledby IDs.',
            'Close buttons require an accessible label.',
            'Status icons include visually hidden description text.',
            'Decorative close icons are hidden from assistive technology.',
        ],
        'focus' => [
            'Close and action buttons must show visible focus.',
            'Alertdialog-style actionable notifications require focus behavior from notification JavaScript if used as blocking dialogs.',
        ],
        'screen_reader' => [
            'Notification kind color must not be the only status cue.',
            'Title, subtitle, caption, action label, and close label must communicate outcome and recovery clearly.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Deprecations / Compatibility Aliases
    |--------------------------------------------------------------------------
    */

    'deprecations' => [
        'components' => [
            [
                'name' => 'x-ui.notification.static',
                'replacement' => 'x-ui.notification.callout',
                'description' => 'Static notification is a legacy alias forwarded to Callout.',
            ],
            'ad hoc alert markup outside x-ui.notification.*',
        ],
        'classes' => [
            'feature-local notification color classes',
            'feature-local alert classes',
            'raw status color utility clusters',
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
            'resources/views/components/ui/notification/toast.blade.php',
            'resources/views/components/ui/notification/inline.blade.php',
            'resources/views/components/ui/notification/actionable.blade.php',
            'resources/views/components/ui/notification/callout.blade.php',
            'resources/views/components/ui/notification/static.blade.php',
            'resources/views/components/ui/notification/icon.blade.php',
            'resources/views/components/ui/notification/close-button.blade.php',
            'resources/views/components/ui/notification/action-button.blade.php',
        ],
        'css' => [
            'resources/css/components/notification.css',
        ],
        'contract' => [
            'resources/views/components/ui/notification/contract.php',
        ],
        'docs' => [
            'docs/02-standards/ui/components/notification.md',
        ],
    ],
]);
