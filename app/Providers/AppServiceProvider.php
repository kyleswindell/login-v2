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
    }
}
