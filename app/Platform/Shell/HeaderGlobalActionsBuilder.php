<?php
/*
|--------------------------------------------------------------------------
| File: app/Platform/Shell/HeaderGlobalActionsBuilder.php
| Purpose: Builds app header global actions from module UI metadata.
|--------------------------------------------------------------------------
*/

namespace App\Platform\Shell;

use App\Core\Modules\Repository;
use App\Core\Modules\UiAccessMode;
use App\Core\Modules\UiEntry;
use App\Core\Modules\UiEntryType;
use App\Core\Modules\UiPlacement;
use App\Models\User;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

final class HeaderGlobalActionsBuilder
{
    public function __construct(
        private readonly Repository $modules,
        private readonly Gate $gate,
        private readonly Application $app,
    ) {}

    /**
     * @return list<array<string, mixed>>
     */
    public function forUser(?User $user, Request $request): array
    {
        return collect($this->modules->uiEntries(UiEntryType::HeaderGlobalAction, UiPlacement::HeaderGlobalActions))
            ->filter(fn (UiEntry $entry): bool => $this->canView($entry, $user))
            ->sortBy([
                fn (UiEntry $entry): int => $entry->sortOrder,
                fn (UiEntry $entry): string => (string) $entry->label,
            ])
            ->map(fn (UiEntry $entry): array => $this->toAction($entry, $request, $user))
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
    private function toAction(UiEntry $entry, Request $request, ?User $user): array
    {
        $activeRoutePatterns = $entry->activeRoutePatterns !== []
            ? $entry->activeRoutePatterns
            : array_values(array_filter([$entry->routeName]));

        $owner = $this->modules->ownersForUiEntryKey($entry->key)[0] ?? null;
        $href = $this->routeHref($entry->routeName);

        return [
            'key' => $entry->key,
            'moduleKey' => $owner?->key,
            'label' => $entry->label,
            'icon' => $entry->icon,
            'routeName' => $entry->routeName,
            'href' => $href,
            'panelTarget' => $entry->panelTarget,
            'componentView' => $entry->componentView,
            'panelView' => $entry->panelView,
            'dataProvider' => $entry->dataProvider,
            'data' => $this->dataFor($entry, $user),
            'current' => $activeRoutePatterns !== [] && $request->routeIs(...$activeRoutePatterns),
            'expanded' => false,
            'wireNavigate' => $href !== '#',
            'sortOrder' => $entry->sortOrder,
            'tenantEligible' => $entry->tenantEligible,
        ];
    }

    private function routeHref(?string $routeName): string
    {
        if (! is_string($routeName) || $routeName === '' || ! Route::has($routeName)) {
            return '#';
        }

        return route($routeName);
    }

    /**
     * @return array<string, mixed>
     */
    private function dataFor(UiEntry $entry, ?User $user): array
    {
        if (! is_string($entry->dataProvider) || $entry->dataProvider === '') {
            return [];
        }

        $provider = $this->app->make($entry->dataProvider);

        if (method_exists($provider, 'forHeaderAction')) {
            return (array) $provider->forHeaderAction($entry);
        }

        if (method_exists($provider, 'forUser')) {
            return (array) $provider->forUser($user);
        }

        return [];
    }
}
