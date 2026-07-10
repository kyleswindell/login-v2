<?php

use App\Models\User;
use App\Modules\Notifications\Services\NotificationPermissions;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function (User $user, int $id) {
    return (int) $user->id === $id
        && $user->can(NotificationPermissions::VIEW);
});
