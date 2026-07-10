<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Account/Support/AccountPageTabs.php
| Purpose: Builds the route-backed Account suite tab model.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Account\Support;

use App\Core\Modules\ContributionRegistry;
use App\Core\Modules\UiAccessMode;
use App\Core\Modules\UiEntry;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

final class AccountPageTabs
{
    /**
     * @return list<array{label: string, href: string, current: bool, wireNavigate: bool}>
     */
    public static function items(): array
    {
        $user = Auth::user();
        $currentRouteName = request()->route()?->getName();

        $base = collect([
            [
                'label' => 'Profile',
                'routeName' => 'platform.account.index',
                'patterns' => ['platform.account.index'],
            ],
            [
                'label' => 'Security',
                'routeName' => 'platform.account.security',
                'patterns' => ['platform.account.security'],
            ],
        ])
            ->filter(fn (array $item): bool => Route::has($item['routeName']))
            ->map(fn (array $item): array => [
                'label' => $item['label'],
                'href' => route($item['routeName']),
                'current' => self::matches($item['patterns'], $currentRouteName),
                'wireNavigate' => true,
            ]);

        $contributed = collect(app(ContributionRegistry::class)->preferencePageEntries())
            ->filter(fn (UiEntry $entry): bool => self::canView($entry, $user))
            ->filter(fn (UiEntry $entry): bool => Route::has((string) $entry->routeName))
            ->sortBy([
                ['groupSortOrder', 'asc'],
                ['sortOrder', 'asc'],
                ['label', 'asc'],
            ])
            ->map(fn (UiEntry $entry): array => [
                'label' => (string) $entry->label,
                'href' => route((string) $entry->routeName),
                'current' => self::matches(
                    $entry->activeRoutePatterns !== [] ? $entry->activeRoutePatterns : [(string) $entry->routeName],
                    $currentRouteName,
                ),
                'wireNavigate' => true,
            ]);

        return $base
            ->merge($contributed)
            ->values()
            ->all();
    }

    private static function canView(UiEntry $entry, ?Authenticatable $user): bool
    {
        return match ($entry->access) {
            UiAccessMode::Public => true,
            UiAccessMode::Authenticated => $user !== null,
            UiAccessMode::Permission => $user !== null
                && method_exists($user, 'can')
                && $user->can((string) $entry->accessValue),
            UiAccessMode::Ability => $user !== null
                && Gate::forUser($user)->allows((string) $entry->accessValue),
            null => false,
        };
    }

    /**
     * @param  list<string>  $patterns
     */
    private static function matches(array $patterns, ?string $currentRouteName): bool
    {
        if ($currentRouteName === null) {
            return false;
        }

        return collect($patterns)
            ->contains(fn (string $pattern): bool => Str::is($pattern, $currentRouteName));
    }
}
