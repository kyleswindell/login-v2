<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Providers/Provider.php
| Purpose: Boots Roles module authorization rules.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles\Providers;

use App\Models\User;
use App\Modules\Roles\Services\RoleCatalog;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

final class Provider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::before(function (User $user, string $ability): ?bool {
            if ($user->hasRole(RoleCatalog::SUPER_ADMIN)) {
                return true;
            }

            if (
                str_starts_with($ability, 'roles.')
                && $ability !== RoleCatalog::MANAGE
                && $this->hasPermission($user, RoleCatalog::MANAGE)
            ) {
                return true;
            }

            return null;
        });

        foreach ($this->abilities() as $ability) {
            Gate::define($ability, fn (User $user): bool => $this->hasPermission($user, $ability));
        }
    }

    /**
     * @return list<string>
     */
    private function abilities(): array
    {
        return [
            RoleCatalog::VIEW,
            RoleCatalog::CREATE,
            RoleCatalog::UPDATE,
            RoleCatalog::DELETE,
            RoleCatalog::PERMISSIONS_VIEW,
            RoleCatalog::MANAGE,
        ];
    }

    private function hasPermission(User $user, string $permission): bool
    {
        return $user->getAllPermissions()
            ->contains('name', $permission);
    }
}
