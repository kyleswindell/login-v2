<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Preferences/Navigation/GroupsBuilder.php
| Purpose: Builds user preference navigation from module UI metadata.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Preferences\Navigation;

use App\Core\Modules\ContributionRegistry;
use App\Core\Modules\UiAccessMode;
use App\Core\Modules\UiEntry;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Str;

final class GroupsBuilder
{
    public function __construct(
        private readonly ContributionRegistry $registry,
        private readonly Gate $gate,
    ) {
    }

    /**
     * @return list<array{key: string, label: string, sort_order: int, items: list<array{label: string, icon: string, href: string, route_name: string, current: bool}>}>
     */
    public function groups(?Authenticatable $user, ?string $currentRouteName): array
    {
        return collect($this->registry->preferencePageEntries())
            ->filter(fn (UiEntry $entry): bool => $this->canView($entry, $user))
            ->sortBy([
                ['groupSortOrder', 'asc'],
                ['sortOrder', 'asc'],
                ['label', 'asc'],
            ])
            ->groupBy(fn (UiEntry $entry): string => (string) $entry->groupKey)
            ->map(function ($entries): array {
                /** @var UiEntry $first */
                $first = $entries->first();

                return [
                    'key' => (string) $first->groupKey,
                    'label' => (string) $first->groupLabel,
                    'sort_order' => $first->groupSortOrder,
                    'items' => $entries->values()->all(),
                ];
            })
            ->sortBy('sort_order')
            ->map(fn (array $group): array => [
                'key' => $group['key'],
                'label' => $group['label'],
                'sort_order' => $group['sort_order'],
                'items' => collect($group['items'])
                    ->map(fn (UiEntry $entry): array => $this->item($entry, $currentRouteName))
                    ->values()
                    ->all(),
            ])
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
     * @return array{label: string, icon: string, href: string, route_name: string, current: bool}
     */
    private function item(UiEntry $entry, ?string $currentRouteName): array
    {
        return [
            'label' => (string) $entry->label,
            'icon' => (string) $entry->icon,
            'href' => route((string) $entry->routeName),
            'route_name' => (string) $entry->routeName,
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
