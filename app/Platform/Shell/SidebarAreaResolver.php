<?php
/*
|--------------------------------------------------------------------------
| File: app/Platform/Shell/SidebarAreaResolver.php
| Purpose: Resolves the active app sidebar area for the current frame.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Platform\Shell;

use App\Models\User;
use App\Modules\Settings\Navigation\SidebarBuilder as SettingsSidebarBuilder;
use App\Modules\Setup\Navigation\ItemsBuilder;
use Illuminate\Support\Str;

final class SidebarAreaResolver
{
    private const DEFAULT_AREA_KEY = 'dashboard';
    private const SETTINGS_AREA_KEY = 'settings';
    private const SETUP_AREA_KEY = 'setup';

    public function __construct(
        private readonly ItemsBuilder $setupItems,
        private readonly SettingsSidebarBuilder $settingsItems,
    ) {
    }

    /**
     * @param  list<array<string, mixed>>  $areas
     * @return array{key: string, label: string}
     */
    public function activeArea(array $areas, ?string $currentRouteName = null): array
    {
        if ($this->isSettingsRoute($currentRouteName)) {
            return [
                'key' => self::SETTINGS_AREA_KEY,
                'label' => 'Settings',
            ];
        }

        if ($this->isSetupRoute($currentRouteName)) {
            return [
                'key' => self::SETUP_AREA_KEY,
                'label' => 'Setup',
            ];
        }

        $active = collect($areas)->first(fn (array $area): bool => (bool) ($area['current'] ?? false))
            ?? collect($areas)->firstWhere('areaKey', self::DEFAULT_AREA_KEY)
            ?? [];

        return [
            'key' => (string) ($active['areaKey'] ?? self::DEFAULT_AREA_KEY),
            'label' => (string) ($active['label'] ?? 'Dashboard'),
        ];
    }

    /**
     * @param  array<string, mixed>  $navigation
     * @return array<string, mixed>
     */
    public function navigationFor(
        array $navigation,
        string $areaKey,
        ?User $user = null,
        ?string $currentRouteName = null,
    ): array
    {
        if ($areaKey === self::SETTINGS_AREA_KEY) {
            return [
                ...$navigation,
                'primaryBase' => $this->settingsPrimaryNavigation($user, $currentRouteName),
                'primaryAdmin' => [],
                'logs' => [],
                'setupBase' => [],
                'setupAdmin' => [],
            ];
        }

        if ($areaKey === self::SETUP_AREA_KEY) {
            return [
                ...$navigation,
                'primaryBase' => $this->setupPrimaryNavigation($user, $currentRouteName),
                'primaryAdmin' => [],
                'logs' => [],
                'setupBase' => [],
                'setupAdmin' => [],
            ];
        }

        if ($areaKey !== self::DEFAULT_AREA_KEY) {
            return $navigation;
        }

        return [
            ...$navigation,
            'primaryBase' => $this->dashboardPrimaryNavigation($navigation['primaryBase'] ?? []),
            'primaryAdmin' => [],
            'logs' => [],
            'setupBase' => [],
            'setupAdmin' => [],
        ];
    }

    /**
     * @param  list<array<string, mixed>>  $items
     * @return list<array<string, mixed>>
     */
    private function dashboardPrimaryNavigation(array $items): array
    {
        return array_values(array_filter(
            $items,
            fn (array $item): bool => ($item['route'] ?? null) === 'dashboard',
        ));
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function setupPrimaryNavigation(?User $user, ?string $currentRouteName): array
    {
        return collect($this->setupItems->items($user, $currentRouteName))
            ->map(fn (array $item): array => [
                'label' => $item['label'],
                'route' => $item['route_name'],
                'href' => $item['href'],
                'active' => $item['active_patterns'],
                'icon' => $item['icon'],
                'wireNavigate' => true,
            ])
            ->values()
            ->all();
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function settingsPrimaryNavigation(?User $user, ?string $currentRouteName): array
    {
        return collect($this->settingsItems->items($user, $currentRouteName))
            ->map(fn (array $item): array => [
                'label' => $item['label'],
                'route' => $item['route_name'],
                'href' => $item['href'],
                'active' => $item['active_patterns'],
                'icon' => $item['icon'],
                'wireNavigate' => true,
            ])
            ->values()
            ->all();
    }

    private function isSettingsRoute(?string $currentRouteName): bool
    {
        return $currentRouteName !== null
            && Str::is(['settings.*', 'platform.settings.*', 'platform.administration.settings.index'], $currentRouteName);
    }

    private function isSetupRoute(?string $currentRouteName): bool
    {
        return $currentRouteName !== null
            && Str::is(['platform.setup.*', 'roles.*'], $currentRouteName);
    }
}
