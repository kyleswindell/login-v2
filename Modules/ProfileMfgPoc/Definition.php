<?php

/*
|--------------------------------------------------------------------------
| File: Modules/ProfileMfgPoc/Definition.php
| Purpose: Declares the temporary Profile Mfg static POC module package.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\ProfileMfgPoc;

use App\Core\Modules\Category;
use App\Core\Modules\LifecycleState;
use App\Core\Modules\Manifest;
use App\Core\Modules\PackageDefinition;
use App\Modules\ProfileMfgPoc\Providers\Provider;

final class Definition
{
    /**
     * @return array<string, mixed>
     */
    public static function definition(): array
    {
        return PackageDefinition::defaults(__DIR__, [
            'manifest' => [
                'name' => 'Profile Mfg POC',
                'type' => Category::Shared,
                'defaultState' => LifecycleState::Enabled,
                'installedByDefault' => true,
                'defaultEnabled' => true,
                'disableable' => true,
                'tenantEligible' => true,
                'dependencies' => ['auth', 'dashboard'],
                'routePatterns' => ['profile-mfg.*'],
                'permissions' => [],
                'navigationRoutes' => [],
                'moduleViewPaths' => ['Modules/ProfileMfgPoc/resources/views'],
            ],
            'routes' => [
                'web' => [
                    'prefix' => 'profile-mfg',
                    'name' => 'profile-mfg.',
                    'middleware' => ['web', 'auth'],
                ],
            ],
            'views' => [
                'namespace' => 'profile-mfg-poc',
            ],
            'providers' => [
                Provider::class,
            ],
        ]);
    }

    public static function manifest(): Manifest
    {
        return self::definition()['manifest'];
    }
}
