<?php
/*
|--------------------------------------------------------------------------
| File: app/Platform/Shell/AreaNavigationBuilder.php
| Purpose: Builds header area navigation from module UI metadata.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Platform\Shell;

use App\Core\Modules\Repository;
use App\Core\Modules\UiAccessMode;
use App\Core\Modules\UiEntry;
use App\Core\Modules\UiEntryType;
use App\Core\Modules\UiPlacement;
use App\Models\User;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

final class AreaNavigationBuilder
{
    /**
     * @var list<string>
     */
    private const HEADER_AREA_ENTRY_KEYS = [
        'dashboard.nav.primary',
        'setup.nav.area',
    ];

    public function __construct(
        private readonly Repository $modules,
        private readonly Gate $gate,
    ) {}

    /**
     * @return list<array<string, mixed>>
     */
    public function forUser(?User $user, Request $request): array
    {
        return collect($this->modules->uiEntries(UiEntryType::NavigationItem, UiPlacement::AreaNavigation))
            ->filter(fn (UiEntry $entry): bool => in_array($entry->key, self::HEADER_AREA_ENTRY_KEYS, true))
            ->filter(fn (UiEntry $entry): bool => $this->canView($entry, $user))
            ->filter(fn (UiEntry $entry): bool => $this->routeHref($entry->routeName) !== '#')
            ->sort(fn (UiEntry $first, UiEntry $second): int => [
                $first->sortOrder,
                (string) $first->label,
            ] <=> [
                $second->sortOrder,
                (string) $second->label,
            ])
            ->map(fn (UiEntry $entry): array => $this->toNavigationItem($entry, $request))
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
    private function toNavigationItem(UiEntry $entry, Request $request): array
    {
        $activeRoutePatterns = $entry->activeRoutePatterns !== []
            ? $entry->activeRoutePatterns
            : array_values(array_filter([$entry->routeName]));

        $owner = $this->modules->ownersForUiEntryKey($entry->key)[0] ?? null;

        return [
            'key' => $entry->key,
            'areaKey' => $owner?->key ?? $this->fallbackAreaKey($entry),
            'moduleKey' => $owner?->key,
            'label' => $entry->label,
            'icon' => $entry->icon,
            'route' => $entry->routeName,
            'href' => $this->routeHref($entry->routeName),
            'active' => $activeRoutePatterns,
            'current' => $activeRoutePatterns !== [] && $request->routeIs(...$activeRoutePatterns),
            'wireNavigate' => true,
            'sortOrder' => $entry->sortOrder,
        ];
    }

    private function routeHref(?string $routeName): string
    {
        if (! is_string($routeName) || $routeName === '' || ! Route::has($routeName)) {
            return '#';
        }

        return route($routeName);
    }

    private function fallbackAreaKey(UiEntry $entry): string
    {
        return explode('.', $entry->key)[0] ?: 'dashboard';
    }
}
