<?php
/*
|--------------------------------------------------------------------------
| File: app/Platform/Shell/AppShellData.php
| Purpose: Prepares shared app frame data for authenticated layouts.
|--------------------------------------------------------------------------
*/

namespace App\Platform\Shell;

use App\Models\User;
use App\Platform\Navigation\PlatformNavigation;

class AppShellData
{
    public function __construct(
        private readonly PlatformNavigation $navigation,
        private readonly AreaNavigationBuilder $areaNavigation,
        private readonly SidebarAreaResolver $sidebarAreas,
        private readonly HeaderGlobalActionsBuilder $headerGlobalActions,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function forUser(?User $user): array
    {
        $navigation = $this->navigation->forUser($user);
        $currentRouteName = request()->route()?->getName();
        $headerNavigation = $this->areaNavigation->forUser($user, request());
        $activeArea = $this->sidebarAreas->activeArea($headerNavigation, $currentRouteName);
        $sidebarNavigation = $this->sidebarAreas->navigationFor(
            $navigation,
            $activeArea['key'],
            $user,
            $currentRouteName,
        );

        $themeMode = $user?->theme_preference;
        $themeMode = in_array($themeMode, ['system', 'dark', 'light'], true)
            ? $themeMode
            : 'system';

        return [
            'user' => $user,
            'themeMode' => $themeMode,
            'navigation' => $sidebarNavigation,
            'activeArea' => $activeArea,
            'headerNavigation' => $headerNavigation,
            'headerGlobalActions' => $this->headerGlobalActions->forUser($user, request()),
        ];
    }
}
