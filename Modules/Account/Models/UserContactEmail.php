<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Account/Models/UserContactEmail.php
| Purpose: Represents user-owned contact-only email addresses.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Account\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class UserContactEmail extends Model
{
    protected $table = 'user_contact_emails';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'email',
        'normalized_email',
        'label',
        'verified_at',
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
            'verified_at' => 'datetime',
        ];
    }
}
