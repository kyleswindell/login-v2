<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Notifications/Providers/Provider.php
| Purpose: Boots Notifications module services.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Notifications\Providers;

use App\Modules\Notifications\Services\TransientToasts;
use Illuminate\Support\ServiceProvider;

final class Provider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(TransientToasts::class);
    }
}
