<?php

namespace App\Providers;

use App\Models\User;
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

        // Batch 2 uses explicit platform gates until the first platform-management
        // permissions are seeded, which keeps these screens locked down without
        // pretending the broader permission catalog already exists.
        Gate::define('manage-platform-users', function (User $user): bool {
            return $user->hasRole('platform_super_admin');
        });

        Gate::define('view-platform-docs', function (User $user): bool {
            return $user->hasRole('platform_super_admin');
        });
    }
}
