<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

class BroadcastAuthController extends Controller
{
    public function __invoke(Request $request)
    {
        $channelName = (string) $request->input('channel_name');

        abort_unless(
            preg_match('/^private-App\.Models\.User\.(\d+)$/', $channelName, $matches) === 1,
            403,
        );

        abort_unless(auth()->user()?->can('platform.notifications.view'), 403);
        abort_unless((int) $matches[1] === (int) auth()->id(), 403);

        return Broadcast::auth($request);
    }
}
