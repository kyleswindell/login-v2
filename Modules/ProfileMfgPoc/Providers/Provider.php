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

            $view->with([
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
                'platform.account.*',
                'settings.*',
                'platform.settings.*',
                'platform.setup.*',
                'roles.*',
            );
    }
}
