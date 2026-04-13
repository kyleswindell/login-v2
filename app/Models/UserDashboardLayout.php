<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDashboardLayout extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'user_id',
        'layout',
        'is_locked',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'layout' => 'array',
            'is_locked' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
