<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Models/UserMfaMethod.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Auth\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'type',
    'secret',
    'pending_secret',
    'pending_secret_expires_at',
    'confirmed_at',
    'reset_at',
    'reset_by_user_id',
    'last_challenged_at',
    'last_satisfied_at',
])]
class UserMfaMethod extends Model
{
    public const TYPE_TOTP = 'totp';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'secret' => 'encrypted',
            'pending_secret' => 'encrypted',
            'pending_secret_expires_at' => 'datetime',
            'confirmed_at' => 'datetime',
            'reset_at' => 'datetime',
            'last_challenged_at' => 'datetime',
            'last_satisfied_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function resetBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reset_by_user_id');
    }

    public function hasConfirmedSecret(): bool
    {
        return $this->type === self::TYPE_TOTP
            && $this->secret !== null
            && $this->confirmed_at !== null;
    }
}
