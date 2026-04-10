<?php

namespace App\Providers;

use App\Models\User;
use App\Platform\Settings\SettingsService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Keep the super-admin bypass centralized so feature policies can stay focused on
        // normal role/permission checks instead of duplicating privileged override logic.
        Gate::before(function (User $user, string $ability): ?bool {
            if ($user->hasRole('platform_super_admin')) {
                return true;
            }

            return null;
        });

        Gate::define('manage-platform-users', function (User $user): bool {
            return $user->can('platform.users.manage');
        });

        Gate::define('view-platform-docs', function (User $user): bool {
            if (! $user->can('platform.docs.view')) {
                return false;
            }

            $accessScope = app(SettingsService::class)->get(
                'docs',
                'access_scope',
                'all_platform_users',
            );

            if ($accessScope === 'super_admins_only') {
                return $user->hasRole('platform_super_admin');
            }

            return true;
        });

        Gate::define('view-platform-notifications', function (User $user): bool {
            return $user->can('platform.notifications.view');
        });

        Gate::define('view-platform-audit-logs', function (User $user): bool {
            return $user->can('platform.audit-logs.view');
        });

        Gate::define('view-platform-error-logs', function (User $user): bool {
            return $user->can('platform.error-logs.view');
        });

        Gate::define('manage-platform-settings', function (User $user): bool {
            return $user->can('platform.settings.manage');
        });
    }
}
