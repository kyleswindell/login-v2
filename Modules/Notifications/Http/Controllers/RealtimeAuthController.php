<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Notifications/Http/Controllers/RealtimeAuthController.php
| Purpose: Authorizes private realtime notification channels.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Notifications\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Notifications\Services\NotificationPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

final class RealtimeAuthController extends Controller
{
    public function __invoke(Request $request)
    {
        $channelName = (string) $request->input('channel_name');

        abort_unless(
            preg_match('/^private-App\.Models\.User\.(\d+)$/', $channelName, $matches) === 1,
            403,
        );

        abort_unless(auth()->user()?->can(NotificationPermissions::VIEW), 403);
        abort_unless((int) $matches[1] === (int) auth()->id(), 403);

        return Broadcast::auth($request);
    }
}
