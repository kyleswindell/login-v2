<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Setup/Providers/Provider.php
| Purpose: Boots Setup module authorization rules.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Setup\Providers;

use App\Core\Modules\Repository;
use App\Core\Modules\UiAccessMode;
use App\Core\Modules\UiEntry;
use App\Core\Modules\UiEntryType;
use App\Core\Modules\UiPlacement;
use App\Models\User;
use App\Modules\Setup\Services\SetupPermissions;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

final class Provider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define(SetupPermissions::VIEW, function (User $user): bool {
            return $this->hasPermission($user, SetupPermissions::VIEW)
                || $this->hasAccessibleSetupScreen($user);
        });

        Gate::define('view-platform-setup', function (User $user): bool {
            return Gate::forUser($user)->allows(SetupPermissions::VIEW);
        });
    }

    private function hasAccessibleSetupScreen(User $user): bool
    {
        $entries = app(Repository::class)->uiEntries(UiEntryType::SetupScreen, UiPlacement::SetupNavigation);

        return collect($entries)
            ->reject(fn (UiEntry $entry): bool => $entry->accessValue === SetupPermissions::VIEW || $entry->accessValue === 'view-platform-setup')
            ->contains(fn (UiEntry $entry): bool => $this->canView($entry, $user));
    }

    private function canView(UiEntry $entry, User $user): bool
    {
        return match ($entry->access) {
            UiAccessMode::Public, UiAccessMode::Authenticated => true,
            UiAccessMode::Permission => is_string($entry->accessValue) && $this->hasPermission($user, $entry->accessValue),
            UiAccessMode::Ability => is_string($entry->accessValue) && Gate::forUser($user)->allows($entry->accessValue),
            default => false,
        };
    }

    private function hasPermission(User $user, string $permission): bool
    {
        return $user->getAllPermissions()
            ->contains(fn (mixed $userPermission): bool => ($userPermission->name ?? null) === $permission);
    }
}
