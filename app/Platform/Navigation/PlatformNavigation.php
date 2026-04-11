<?php

namespace App\Platform\Navigation;

use App\Models\User;
use Illuminate\Contracts\Auth\Access\Gate;

class PlatformNavigation
{
    public function __construct(private readonly Gate $gate) {}

    /**
     * @return array{primary: array<int, array<string, mixed>>, setup: array<int, array<string, mixed>>, account: array<int, array<string, mixed>>}
     */
    public function forUser(?User $user): array
    {
        return [
            'primary' => $this->filterAllowed($user, [
                [
                    'label' => 'Dashboard',
                    'route' => 'dashboard',
                    'active' => ['dashboard'],
                ],
                [
                    'label' => 'Platform Users',
                    'route' => 'platform.users.index',
                    'active' => ['platform.users.*'],
                    'ability' => 'manage-platform-users',
                ],
                [
                    'label' => 'Documentation Vault',
                    'route' => 'platform.docs.index',
                    'active' => ['platform.docs.index'],
                    'ability' => 'view-platform-docs',
                ],
                [
                    'label' => 'Notifications',
                    'route' => 'platform.notifications.index',
                    'active' => ['platform.notifications.*'],
                    'ability' => 'view-platform-notifications',
                ],
                [
                    'label' => 'Audit Logs',
                    'route' => 'platform.audit-logs.index',
                    'active' => ['platform.audit-logs.*'],
                    'ability' => 'view-platform-audit-logs',
                ],
                [
                    'label' => 'Error Logs',
                    'route' => 'platform.error-logs.index',
                    'active' => ['platform.error-logs.*'],
                    'ability' => 'view-platform-error-logs',
                ],
            ]),
            'setup' => $this->filterAllowed($user, [
                [
                    'label' => 'Notifications Setup',
                    'route' => 'platform.setup.notifications',
                    'active' => ['platform.setup.notifications'],
                    'ability' => 'view-platform-notifications',
                ],
                [
                    'label' => 'Documentation Setup',
                    'route' => 'platform.setup.docs',
                    'active' => ['platform.setup.docs'],
                    'ability' => 'view-platform-docs',
                ],
                [
                    'label' => 'Audit Logs Setup',
                    'route' => 'platform.setup.audit-logs',
                    'active' => ['platform.setup.audit-logs'],
                    'ability' => 'view-platform-audit-logs',
                ],
                [
                    'label' => 'Error Logs Setup',
                    'route' => 'platform.setup.error-logs',
                    'active' => ['platform.setup.error-logs'],
                    'ability' => 'view-platform-error-logs',
                ],
                [
                    'label' => 'Platform Users Setup',
                    'route' => 'platform.setup.users',
                    'active' => ['platform.setup.users'],
                    'ability' => 'manage-platform-users',
                ],
                [
                    'label' => 'Settings',
                    'route' => 'platform.settings.general',
                    'active' => ['platform.settings.*'],
                    'ability' => 'manage-platform-settings',
                ],
            ]),
            'account' => $this->filterAllowed($user, [
                [
                    'label' => 'Dashboard',
                    'route' => 'dashboard',
                    'active' => ['dashboard'],
                ],
                [
                    'label' => 'Platform Users',
                    'route' => 'platform.users.index',
                    'active' => ['platform.users.*'],
                    'ability' => 'manage-platform-users',
                ],
                [
                    'label' => 'Documentation Vault',
                    'route' => 'platform.docs.index',
                    'active' => ['platform.docs.index'],
                    'ability' => 'view-platform-docs',
                ],
                [
                    'label' => 'Notifications',
                    'route' => 'platform.notifications.index',
                    'active' => ['platform.notifications.*'],
                    'ability' => 'view-platform-notifications',
                ],
                [
                    'label' => 'Audit Logs',
                    'route' => 'platform.audit-logs.index',
                    'active' => ['platform.audit-logs.*'],
                    'ability' => 'view-platform-audit-logs',
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
