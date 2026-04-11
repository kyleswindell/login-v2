<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable([
    'name',
    'first_name',
    'last_name',
    'email',
    'password',
    'is_active',
    'last_login_at',
    'timezone',
    'hourly_rate',
    'phone',
    'facebook',
    'linkedin',
    'skype',
    'default_language',
    'email_signature',
    'direction',
    'send_welcome_email',
    'is_administrator',
    'is_staff_member',
    'profile_image_path',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    protected string $guard_name = 'web';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'hourly_rate' => 'decimal:2',
            'send_welcome_email' => 'boolean',
            'is_administrator' => 'boolean',
            'is_staff_member' => 'boolean',
        ];
    }
}
