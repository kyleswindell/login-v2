<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Account/Header/MenuDataProvider.php
| Purpose: Provides Account module data for the app header account menu.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Account\Header;

use App\Core\Modules\Repository;
use App\Core\Modules\UiAccessMode;
use App\Core\Modules\UiEntry;
use App\Core\Modules\UiEntryType;
use App\Core\Modules\UiPlacement;
use App\Models\User;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Support\Facades\Route;

final class MenuDataProvider
{
    public function __construct(
        private readonly Repository $modules,
        private readonly Gate $gate,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function forUser(?User $user): array
    {
        $themeMode = $user?->theme_preference;

        return [
            'user' => $user,
            'themeMode' => in_array($themeMode, ['system', 'dark', 'light'], true)
                ? $themeMode
                : 'system',
            'themeOptions' => [
                'light' => 'Light',
                'dark' => 'Dark',
                'system' => 'System',
            ],
            'navigation' => $this->navigationFor($user),
            'logoutRoute' => 'logout',
            'showTheme' => true,
            'showLogout' => true,
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function navigationFor(?User $user): array
    {
        return collect($this->modules->uiEntries(UiEntryType::NavigationItem, UiPlacement::AccountMenu))
            ->filter(fn (UiEntry $entry): bool => $this->canView($entry, $user))
            ->filter(fn (UiEntry $entry): bool => is_string($entry->routeName) && Route::has($entry->routeName))
            ->sortBy([
                fn (UiEntry $entry): int => $entry->sortOrder,
                fn (UiEntry $entry): string => (string) $entry->label,
            ])
            ->map(fn (UiEntry $entry): array => $this->toNavigationItem($entry))
            ->values()
            ->all();
    }

    private function canView(UiEntry $entry, ?User $user): bool
    {
        return match ($entry->access) {
            UiAccessMode::Public => true,
            UiAccessMode::Authenticated => $user !== null,
            UiAccessMode::Permission => $user !== null && $user->can((string) $entry->accessValue),
            UiAccessMode::Ability => $user !== null && $this->gate->forUser($user)->allows((string) $entry->accessValue),
            null => false,
        };
    }

    /**
     * @return array<string, mixed>
     */
    private function toNavigationItem(UiEntry $entry): array
    {
        $activeRoutePatterns = $entry->activeRoutePatterns !== []
            ? $entry->activeRoutePatterns
            : array_values(array_filter([$entry->routeName]));

        $owner = $this->modules->ownersForUiEntryKey($entry->key)[0] ?? null;

        return [
            'key' => $entry->key,
            'moduleKey' => $owner?->key,
            'label' => $entry->label,
            'routeName' => $entry->routeName,
            'href' => $this->routeHref((string) $entry->routeName),
            'current' => $activeRoutePatterns !== [] && request()->routeIs(...$activeRoutePatterns),
            'wireNavigate' => true,
            'sortOrder' => $entry->sortOrder,
        ];
    }

    private function routeHref(string $routeName): string
    {
        return Route::has($routeName) ? route($routeName) : '#';
    }
}
