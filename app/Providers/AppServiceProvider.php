<?php

namespace App\Providers;

use App\Core\Modules\Definitions;
use App\Core\Modules\PackageLoader;
use App\Core\Modules\Repository;
use App\Core\Runtime\Resolver;
use App\Models\User;
use App\Modules\Notifications\Services\NotificationPermissions;
use App\Modules\Roles\Services\RoleCatalog;
use App\Modules\Settings\Services\SettingsPermissions;
use App\Modules\Settings\Services\Store;
use App\Platform\Dashboard\WidgetRegistry;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Repository::class, fn () => Definitions::repository());
        $this->app->singleton(Resolver::class, fn () => new Resolver($this->app['config']));
        $this->app->singleton(WidgetRegistry::class, fn () => new WidgetRegistry());
    }

    public function boot(): void
    {
        $this->registerModulePackages();
        $this->registerGates();
    }

    private function registerModulePackages(): void
    {
        $this->app->make(PackageLoader::class)->load(Definitions::packageDefinitions());
    }

    private function registerGates(): void
    {
        Gate::define('manage-platform-users', function (User $user): bool {
            return $user->can('platform.users.manage');
        });

        Gate::define('view-platform-users', function (User $user): bool {
            return $user->can('platform.users.view')
                || $user->can('platform.users.manage');
        });

        Gate::define('view-platform-docs', function (User $user): bool {
            if (! $user->can('platform.docs.view')) {
                return false;
            }

            $accessScope = app(Store::class)->get(
                'docs',
                'access_scope',
                'all_platform_users',
            );

            if ($accessScope === 'super_admins_only') {
                return $user->hasRole(RoleCatalog::SUPER_ADMIN);
            }

            return true;
        });

        Gate::define(NotificationPermissions::VIEW, function (User $user): bool {
            return $this->hasPermission($user, NotificationPermissions::VIEW)
                || $this->hasPermission($user, NotificationPermissions::MANAGE);
        });

        Gate::define(NotificationPermissions::SETTINGS_VIEW, function (User $user): bool {
            return $this->hasPermission($user, NotificationPermissions::SETTINGS_VIEW)
                || $this->hasPermission($user, NotificationPermissions::SETTINGS_UPDATE)
                || $this->hasPermission($user, NotificationPermissions::MANAGE);
        });

        Gate::define(NotificationPermissions::SETTINGS_UPDATE, function (User $user): bool {
            return $this->hasPermission($user, NotificationPermissions::SETTINGS_UPDATE)
                || $this->hasPermission($user, NotificationPermissions::MANAGE);
        });

        Gate::define(NotificationPermissions::MANAGE, function (User $user): bool {
            return $this->hasPermission($user, NotificationPermissions::MANAGE);
        });

        Gate::define('view-platform-notifications', function (User $user): bool {
            return Gate::forUser($user)->allows(NotificationPermissions::VIEW);
        });

        Gate::define('view-platform-audit-logs', function (User $user): bool {
            return $user->can('platform.audit-logs.view');
        });

        Gate::define('view-platform-error-logs', function (User $user): bool {
            return $user->can('platform.error-logs.view');
        });

        Gate::define(SettingsPermissions::VIEW, function (User $user): bool {
            return $this->hasPermission($user, SettingsPermissions::VIEW)
                || $this->hasPermission($user, SettingsPermissions::UPDATE)
                || $this->hasPermission($user, SettingsPermissions::MANAGE);
        });

        Gate::define(SettingsPermissions::UPDATE, function (User $user): bool {
            return $this->hasPermission($user, SettingsPermissions::UPDATE)
                || $this->hasPermission($user, SettingsPermissions::MANAGE);
        });

        Gate::define(SettingsPermissions::MANAGE, function (User $user): bool {
            return $this->hasPermission($user, SettingsPermissions::MANAGE);
        });

        Gate::define('view-platform-settings', function (User $user): bool {
            return Gate::forUser($user)->allows(SettingsPermissions::VIEW);
        });

        Gate::define('manage-platform-settings', function (User $user): bool {
            return Gate::forUser($user)->allows(SettingsPermissions::UPDATE);
        });

        Gate::define('view-platform-security-checklist', function (User $user): bool {
            return $user->can('platform.security-checklist.view')
                || $user->can('platform.security-checklist.manage');
        });

        Gate::define('manage-platform-security-checklist', function (User $user): bool {
            return $user->can('platform.security-checklist.manage');
        });
    }

    private function hasPermission(User $user, string $permission): bool
    {
        return $user->getAllPermissions()
            ->contains(fn (mixed $userPermission): bool => ($userPermission->name ?? null) === $permission);
    }
}
