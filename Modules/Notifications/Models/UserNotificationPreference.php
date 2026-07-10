<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Notifications/Models/UserNotificationPreference.php
| Purpose: Stores user-owned notification delivery preferences.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Notifications\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class UserNotificationPreference extends Model
{
    protected $table = 'user_notification_preferences';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'email_enabled',
        'digest_frequency',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_enabled' => 'boolean',
        ];
    }
}
