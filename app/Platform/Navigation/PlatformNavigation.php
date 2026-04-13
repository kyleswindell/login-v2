<?php

namespace App\Platform\Navigation;

use App\Models\User;
use Illuminate\Contracts\Auth\Access\Gate;

class PlatformNavigation
{
    public function __construct(private readonly Gate $gate) {}

    /**
     * @return array{
     *   primary: array<int, array<string, mixed>>,
     *   logs: array<int, array<string, mixed>>,
     *   setup: array<int, array<string, mixed>>,
     *   account: array<int, array<string, mixed>>
     * }
     */
    public function forUser(?User $user): array
    {
        return [
            'primary' => $this->filterAllowed($user, [
                [
                    'label' => 'Dashboard',
                    'route' => 'dashboard',
                    'active' => ['dashboard'],
                    'icon' => 'home',
                ],
                [
                    'label' => 'Platform Users',
                    'route' => 'platform.administration.users.index',
                    'active' => [
                        'platform.administration.users.*',
                        'platform.users.*',
                        'filament.console.resources.platform-users.*',
                    ],
                    'ability' => 'manage-platform-users',
                    'icon' => 'users',
                ],
                [
                    'label' => 'Documentation Vault',
                    'route' => 'platform.docs.index',
                    'active' => ['platform.docs.index'],
                    'ability' => 'view-platform-docs',
                    'icon' => 'docs',
                ],
                [
                    'label' => 'Notifications',
                    'route' => 'platform.administration.notifications.index',
                    'active' => [
                        'platform.administration.notifications.*',
                        'platform.notifications.*',
                    ],
                    'ability' => 'view-platform-notifications',
                    'icon' => 'bell',
                ],
            ]),
            'logs' => $this->filterAllowed($user, [
                [
                    'label' => 'Audit Logs',
                    'route' => 'platform.operations.audit-logs.index',
                    'active' => [
                        'platform.operations.audit-logs.*',
                        'platform.audit-logs.*',
                        'filament.console.resources.platform-audit-logs.*',
                    ],
                    'ability' => 'view-platform-audit-logs',
                    'icon' => 'audit-log',
                ],
                [
                    'label' => 'Error Logs',
                    'route' => 'platform.operations.error-logs.index',
                    'active' => [
                        'platform.operations.error-logs.*',
                        'platform.error-logs.*',
                        'filament.console.resources.central-error-logs.*',
                    ],
                    'ability' => 'view-platform-error-logs',
                    'icon' => 'error-log',
                ],
            ]),
            'setup' => $this->filterAllowed($user, [
                [
                    'label' => 'Notifications Setup',
                    'route' => 'platform.setup.notifications',
                    'active' => ['platform.setup.notifications'],
                    'ability' => 'view-platform-notifications',
                    'icon' => 'bell',
                ],
                [
                    'label' => 'Documentation Setup',
                    'route' => 'platform.setup.docs',
                    'active' => ['platform.setup.docs'],
                    'ability' => 'view-platform-docs',
                    'icon' => 'docs',
                ],
                [
                    'label' => 'Audit Logs Setup',
                    'route' => 'platform.setup.audit-logs',
                    'active' => ['platform.setup.audit-logs'],
                    'ability' => 'view-platform-audit-logs',
                    'icon' => 'audit-log',
                ],
                [
                    'label' => 'Error Logs Setup',
                    'route' => 'platform.setup.error-logs',
                    'active' => ['platform.setup.error-logs'],
                    'ability' => 'view-platform-error-logs',
                    'icon' => 'error-log',
                ],
                [
                    'label' => 'Platform Users Setup',
                    'route' => 'platform.setup.users',
                    'active' => ['platform.setup.users'],
                    'ability' => 'manage-platform-users',
                    'icon' => 'users',
                ],
                [
                    'label' => 'Settings',
                    'route' => 'platform.administration.settings.index',
                    'active' => [
                        'platform.administration.settings.*',
                        'platform.settings.*',
                    ],
                    'ability' => 'manage-platform-settings',
                    'icon' => 'settings',
                ],
            ]),
            'account' => $this->filterAllowed($user, [
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
                [
                    'label' => 'Platform Settings',
                    'route' => 'platform.administration.settings.index',
                    'active' => [
                        'platform.administration.settings.*',
                        'platform.settings.*',
                    ],
                    'ability' => 'manage-platform-settings',
                ],
                [
                    'label' => 'Notification Inbox',
                    'route' => 'platform.administration.notifications.index',
                    'active' => [
                        'platform.administration.notifications.*',
                        'platform.notifications.*',
                    ],
                    'ability' => 'view-platform-notifications',
                ],
            ]),
        ];
    }

    /**
     * @param  array<int, array<string, mixed>>  $items
     * @return array<int, array<string, mixed>>
     */
    private function filterAllowed(?User $user, array $items): array
    {
        if (! $user) {
            return [];
        }

        return array_values(array_filter(
            $items,
            fn (array $item): bool => ! isset($item['ability']) || $this->gate->forUser($user)->allows($item['ability'])
        ));
    }
}
