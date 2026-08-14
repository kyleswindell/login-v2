<?php

/*
|--------------------------------------------------------------------------
| File: Modules/ProfileMfgPoc/Providers/Provider.php
| Purpose: Registers the temporary Profile Mfg POC configuration and loader.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\ProfileMfgPoc\Providers;

use App\Modules\ProfileMfgPoc\Services\Dataset;
use App\Platform\Shell\AppShellData;
use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View as BladeView;

final class Provider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/profile-mfg-poc.php',
            'profile-mfg-poc',
        );

        $this->app->singleton(Dataset::class);
    }

    public function boot(): void
    {
        View::composer('components.layouts.app', function (BladeView $view): void {
            if (! $this->usesProfileMfgWorkspace()) {
                return;
            }

            $appShell = app(AppShellData::class)->forUser(auth()->user());
            $appShell['headerNavigation'] = $this->headerNavigation(
                $appShell['headerNavigation'] ?? [],
            );

            $view->with([
                'appShell' => $appShell,
                'sidebar' => new HtmlString(view('profile-mfg-poc::partials.sidebar')->render()),
                'sidebarContext' => 'primary',
                'sideNavAreaTitle' => 'Profile Mfg',
                'sideNavExpanded' => false,
                'sideNavFixed' => false,
                'headerVariant' => 'workspace',
                'headerLabel' => 'Profile Mfg',
                'brandName' => 'Profile Mfg',
                'gridAlign' => 'start',
                'gridMode' => 'narrow',
            ]);
        });
    }

    private function usesProfileMfgWorkspace(): bool
    {
        return (bool) config('profile-mfg-poc.enabled', false)
            && auth()->check()
            && request()->routeIs(
                'profile-mfg.*',
                'platform.account.*',
                'settings.*',
                'platform.settings.*',
                'platform.setup.*',
                'roles.*',
            );
    }

    /**
     * @param  list<array<string, mixed>>  $existingNavigation
     * @return list<array<string, mixed>>
     */
    private function headerNavigation(array $existingNavigation): array
    {
        $setup = collect($existingNavigation)
            ->first(fn (array $item): bool => ($item['key'] ?? null) === 'setup.nav.area');

        $navigation = [
            [
                'key' => 'profile-mfg-poc.workspace.operations',
                'label' => 'Operations',
                'route' => 'profile-mfg.dashboard',
                'active' => ['profile-mfg.*'],
                'current' => request()->routeIs('profile-mfg.*'),
                'wireNavigate' => true,
            ],
            [
                'key' => 'profile-mfg-poc.workspace.accounting',
                'label' => 'Accounting · Preview',
                'disabled' => true,
                'title' => 'Accounting workspace coming soon',
            ],
            [
                'key' => 'profile-mfg-poc.workspace.sales',
                'label' => 'Sales · Preview',
                'disabled' => true,
                'title' => 'Sales workspace coming soon',
            ],
            [
                'key' => 'profile-mfg-poc.workspace.administration',
                'label' => 'Administration · Preview',
                'disabled' => true,
                'title' => 'Global administration workspace coming soon',
            ],
        ];

        if (is_array($setup)) {
            $navigation[] = $setup;
        }

        return $navigation;
    }
}
