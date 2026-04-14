<?php

namespace App\Platform\Navigation;

use App\Models\User;
use Illuminate\Contracts\Auth\Access\Gate;

class PlatformNavigation
{
    public function __construct(private readonly Gate $gate) {}

    /**
     * @return array{
     *   primaryBase: array<int, array<string, mixed>>,
     *   primaryAdmin: array<int, array<string, mixed>>,
     *   logs: array<int, array<string, mixed>>,
     *   setupBase: array<int, array<string, mixed>>,
     *   setupAdmin: array<int, array<string, mixed>>,
     *   account: array<int, array<string, mixed>>
     * }
     */
    public function forUser(?User $user): array
    {
        return [
            'primaryBase' => $this->filterAllowed($user, [
                [
                    'label' => 'Dashboard',
                    'route' => 'dashboard',
                    'active' => ['dashboard'],
                    'icon' => 'home',
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
            'primaryAdmin' => $this->filterAllowed($user, [
                [
                    'label' => 'Documentation Vault',
                    'route' => 'platform.docs.index',
                    'active' => ['platform.docs.index'],
                    'ability' => 'view-platform-docs',
                    'icon' => 'docs',
                ],
                [
                    'label' => 'UI Reference',
                    'route' => 'platform.ui-reference.index',
                    'active' => ['platform.ui-reference.*'],
                    'ability' => 'view-platform-docs',
                    'role' => 'platform_super_admin',
                    'icon' => 'docs',
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
            'setupBase' => $this->filterAllowed($user, [
                [
                    'label' => 'Notifications Setup',
                    'route' => 'platform.setup.notifications',
                    'active' => ['platform.setup.notifications'],
                    'ability' => 'view-platform-notifications',
                    'icon' => 'bell',
                ],
                [
                    'label' => 'Staff Setup',
                    'route' => 'platform.setup.users',
                    'active' => ['platform.setup.users'],
                    'ability' => 'manage-platform-users',
                    'icon' => 'users',
                ],
            ]),
            'setupAdmin' => $this->filterAllowed($user, [
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
            function (array $item) use ($user): bool {
                if (isset($item['role']) && ! $user->hasRole($item['role'])) {
                    return false;
                }

                return ! isset($item['ability']) || $this->gate->forUser($user)->allows($item['ability']);
            }
        ));
    }
}
