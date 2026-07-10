<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Definition.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Auth;

use App\Core\Modules\Category;
use App\Core\Modules\LifecycleState;
use App\Core\Modules\Manifest;
use App\Core\Modules\PackageDefinition;
use App\Modules\Auth\Notifications\Types as NotificationTypes;

final class Definition
{
    /**
     * @return array<string, mixed>
     */
    public static function definition(): array
    {
        return PackageDefinition::defaults(__DIR__, [
            'manifest' => [
                'type' => Category::Core,
                'defaultState' => LifecycleState::Enabled,
                'installedByDefault' => true,
                'defaultEnabled' => true,
                'disableable' => false,
                'tenantEligible' => true,
                'routePatterns' => ['login', 'login.*', 'logout', 'mfa.*', 'platform.account.mfa.*'],
                'permissions' => [],
                'notificationDefinitions' => NotificationTypes::all(),
                'ownedTables' => [
                    'password_reset_tokens',
                    'sessions',
                    'user_mfa_methods',
                    'user_mfa_policies',
                    'mfa_recovery_codes',
                ],
                'moduleViewPaths' => ['Modules/Auth/resources/views'],
                'auditEvents' => ['auth.*'],
            ],
            'routes' => [
                'web' => [
                    'prefix' => '',
                    'name' => '',
                    'middleware' => ['web'],
                ],
            ],
            'views' => [
                'namespace' => 'auth',
            ],
            'translations' => [
                'namespace' => 'auth',
            ],
            'providers' => [
                Providers\Provider::class,
            ],
        ]);
    }

    public static function manifest(): Manifest
    {
        return self::definition()['manifest'];
    }
}
