<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Providers/Provider.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Auth\Providers;

use App\Modules\Auth\Services\Password\BreachedPasswordChecker;
use App\Modules\Auth\Services\Password\HibpBreachedPasswordChecker;
use Illuminate\Support\ServiceProvider;

final class Provider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(BreachedPasswordChecker::class, function (): BreachedPasswordChecker {
            return match ((string) config('platform.security.passwords.breached.provider', 'hibp')) {
                'hibp' => new HibpBreachedPasswordChecker(),
                default => new HibpBreachedPasswordChecker(),
            };
        });
    }
}
