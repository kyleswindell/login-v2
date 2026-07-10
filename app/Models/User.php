<?php

namespace App\Models;

use Database\Factories\UserFactory;
use App\Modules\Account\Models\UserContactEmail;
use App\Modules\Auth\Models\MfaRecoveryCode;
use App\Modules\Auth\Models\UserMfaMethod;
use App\Modules\Auth\Models\UserMfaPolicy;
use App\Modules\Notifications\Models\UserNotificationPreference;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
    'theme_preference',
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
     * @return HasMany<UserContactEmail, $this>
     */
    public function contactEmails(): HasMany
    {
        return $this->hasMany(UserContactEmail::class);
    }

    /**
     * @return HasOne<UserNotificationPreference, $this>
     */
    public function notificationPreference(): HasOne
    {
        return $this->hasOne(UserNotificationPreference::class);
    }

    /**
     * @return HasMany<UserMfaMethod, $this>
     */
    public function mfaMethods(): HasMany
    {
        return $this->hasMany(UserMfaMethod::class);
    }

    /**
     * @return HasOne<UserMfaMethod, $this>
     */
    public function totpMfaMethod(): HasOne
    {
        return $this->hasOne(UserMfaMethod::class)
            ->where('type', UserMfaMethod::TYPE_TOTP);
    }

    /**
     * @return HasOne<UserMfaPolicy, $this>
     */
    public function mfaPolicy(): HasOne
    {
        return $this->hasOne(UserMfaPolicy::class);
    }

    /**
     * @return HasMany<MfaRecoveryCode, $this>
     */
    public function mfaRecoveryCodes(): HasMany
    {
        return $this->hasMany(MfaRecoveryCode::class);
    }

    public function hasConfirmedTotpMfa(): bool
    {
        $method = $this->relationLoaded('totpMfaMethod')
            ? $this->totpMfaMethod
            : $this->totpMfaMethod()->first();

        return $method?->hasConfirmedSecret() ?? false;
    }

    public function hasMfaPolicyRequirement(): bool
    {
        $policy = $this->relationLoaded('mfaPolicy')
            ? $this->mfaPolicy
            : $this->mfaPolicy()->first();

        return (bool) $policy?->mfa_required;
    }

    public function requiresMfa(): bool
    {
        return $this->hasMfaPolicyRequirement() || $this->hasConfirmedTotpMfa();
    }

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
