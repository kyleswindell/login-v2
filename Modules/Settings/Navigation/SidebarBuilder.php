<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Settings/Navigation/SidebarBuilder.php
| Purpose: Builds Settings sidebar navigation from module UI metadata.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Settings\Navigation;

use App\Core\Modules\ContributionRegistry;
use App\Core\Modules\UiAccessMode;
use App\Core\Modules\UiEntry;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Str;

final class SidebarBuilder
{
    public function __construct(
        private readonly ContributionRegistry $registry,
        private readonly Gate $gate,
    ) {
    }

    /**
     * @return list<array{label: string, icon: string, href: string, route_name: string, active_patterns: list<string>, current: bool}>
     */
    public function items(?Authenticatable $user, ?string $currentRouteName): array
    {
        return $this->authorizedItems($user, $currentRouteName);
    }

    /**
     * @return list<array{label: string, icon: string, href: string, route_name: string, active_patterns: list<string>, current: bool}>
     */
    public function landingItems(?Authenticatable $user, ?string $currentRouteName): array
    {
        return collect($this->authorizedItems($user, $currentRouteName))
            ->reject(fn (array $item): bool => in_array($item['route_name'], ['settings.index', 'platform.settings.index'], true))
            ->values()
            ->all();
    }

    /**
     * @return list<array{label: string, icon: string, href: string, route_name: string, active_patterns: list<string>, current: bool}>
     */
    private function authorizedItems(?Authenticatable $user, ?string $currentRouteName): array
    {
        return collect($this->registry->settingsPageEntries())
            ->filter(fn (UiEntry $entry): bool => $this->canView($entry, $user))
            ->sortBy([
                ['sortOrder', 'asc'],
                ['label', 'asc'],
            ])
            ->map(fn (UiEntry $entry): array => $this->item($entry, $currentRouteName))
            ->values()
            ->all();
    }

    private function canView(UiEntry $entry, ?Authenticatable $user): bool
    {
        return match ($entry->access) {
            UiAccessMode::Public => true,
            UiAccessMode::Authenticated => $user !== null,
            UiAccessMode::Permission => $user !== null
                && method_exists($user, 'can')
                && $user->can((string) $entry->accessValue),
            UiAccessMode::Ability => $user !== null
                && $this->gate->forUser($user)->allows((string) $entry->accessValue),
            null => false,
        };
    }

    /**
     * @return array{label: string, icon: string, href: string, route_name: string, active_patterns: list<string>, current: bool}
     */
    private function item(UiEntry $entry, ?string $currentRouteName): array
    {
        $activePatterns = $entry->activeRoutePatterns !== []
            ? $entry->activeRoutePatterns
            : [(string) $entry->routeName];

        return [
            'label' => (string) $entry->label,
            'icon' => (string) $entry->icon,
            'href' => route((string) $entry->routeName),
            'route_name' => (string) $entry->routeName,
            'active_patterns' => $activePatterns,
            'current' => $this->isCurrent($entry, $currentRouteName),
        ];
    }

    private function isCurrent(UiEntry $entry, ?string $currentRouteName): bool
    {
        if ($currentRouteName === null) {
            return false;
        }

        $patterns = $entry->activeRoutePatterns !== []
            ? $entry->activeRoutePatterns
            : [$entry->routeName];

        return collect($patterns)
            ->contains(fn (string $pattern): bool => Str::is($pattern, $currentRouteName));
    }
}
