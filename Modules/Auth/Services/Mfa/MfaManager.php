<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Services/Mfa/MfaManager.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Auth\Services\Mfa;

use App\Models\User;
use App\Modules\Auth\Models\UserMfaMethod;
use App\Platform\Logging\PlatformLogger;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FAQRCode\Google2FA;
use PragmaRX\Google2FAQRCode\QRCode\Chillerlan;

class MfaManager
{
    private const RECOVERY_CODE_COUNT = 10;
    private const RECOVERY_CODE_GROUPS = 3;
    private const RECOVERY_CODE_GROUP_LENGTH = 4;
    private const RECOVERY_CODE_ALPHABET = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    private const PENDING_SECRET_MINUTES = 15;

    private Google2FA $google2fa;

    public function __construct(
        private readonly PlatformLogger $logger,
        ?Google2FA $google2fa = null,
    ) {
        $this->google2fa = $google2fa ?? new Google2FA(new Chillerlan());
    }

    public function beginEnrollment(User $user): UserMfaMethod
    {
        /** @var UserMfaMethod $method */
        $method = $user->totpMfaMethod()->firstOrNew([
            'type' => UserMfaMethod::TYPE_TOTP,
        ]);

        if ($method->hasConfirmedSecret()) {
            return $method;
        }

        $issuedPendingSecret = false;
        $issueReason = 'new';

        if (! filled($method->pending_secret) || $this->pendingSecretExpired($method)) {
            $issueReason = filled($method->pending_secret) ? 'expired' : 'new';
            $method->pending_secret = $this->google2fa->generateSecretKey();
            $method->pending_secret_expires_at = now()->addMinutes(self::PENDING_SECRET_MINUTES);
            $issuedPendingSecret = true;
        }

        $method->reset_at = null;
        $method->reset_by_user_id = null;
        $method->save();

        if ($issuedPendingSecret) {
            $this->logger->recordEvent(
                'auth.mfa_enrollment_started',
                [
                    'user_id' => $user->id,
                    'method' => 'totp',
                    'reason' => $issueReason,
                    'expires_at' => $method->pending_secret_expires_at?->toIso8601String(),
                ],
                actorUserId: $user->id,
                subjectType: User::class,
                subjectId: (string) $user->id,
                isSecurityEvent: true,
            );
        }

        return $method->refresh();
    }

    public function pendingManualKey(UserMfaMethod $method): ?string
    {
        return $method->pending_secret;
    }

    public function renderEnrollmentQrSvg(User $user, UserMfaMethod $method): string
    {
        abort_unless(filled($method->pending_secret), 404);

        return $this->google2fa->getQRCodeInline(
            $this->issuerName(),
            $user->email,
            $method->pending_secret,
            220,
        );
    }

    public function verifyPendingTotp(User $user, string $code): bool
    {
        $method = $user->totpMfaMethod()->first();

        if (! $method instanceof UserMfaMethod || ! filled($method->pending_secret)) {
            return false;
        }

        if ($this->pendingSecretExpired($method)) {
            $method->forceFill([
                'pending_secret' => null,
                'pending_secret_expires_at' => null,
            ])->save();

            return false;
        }

        if (! $this->verifySecret($method->pending_secret, $code)) {
            return false;
        }

        $method->forceFill([
            'secret' => $method->pending_secret,
            'pending_secret' => null,
            'pending_secret_expires_at' => null,
            'confirmed_at' => now(),
            'reset_at' => null,
            'reset_by_user_id' => null,
            'last_satisfied_at' => now(),
        ])->save();

        return true;
    }

    public function verifyLoginChallenge(User $user, string $code): bool
    {
        $method = $user->totpMfaMethod()->first();

        if (! $method instanceof UserMfaMethod || ! $method->hasConfirmedSecret()) {
            return false;
        }

        $method->forceFill([
            'last_challenged_at' => now(),
        ])->save();

        if (! $this->verifySecret((string) $method->secret, $code)) {
            return false;
        }

        $method->forceFill([
            'last_satisfied_at' => now(),
        ])->save();

        return true;
    }

    /**
     * @return list<string>
     */
    public function regenerateRecoveryCodes(User $user): array
    {
        $codes = [];

        for ($i = 0; $i < self::RECOVERY_CODE_COUNT; $i++) {
            $codes[] = $this->generateRecoveryCode();
        }

        $user->mfaRecoveryCodes()->delete();

        foreach ($codes as $code) {
            $user->mfaRecoveryCodes()->create([
                'code_hash' => Hash::make($this->normalizeRecoveryCode($code)),
            ]);
        }

        return $codes;
    }

    public function verifyRecoveryCode(User $user, string $code): bool
    {
        $normalizedCode = $this->normalizeRecoveryCode($code);

        if ($normalizedCode === '') {
            return false;
        }

        $method = $user->totpMfaMethod()->first();

        if (! $method instanceof UserMfaMethod || ! $method->hasConfirmedSecret()) {
            return false;
        }

        $method->forceFill([
            'last_challenged_at' => now(),
        ])->save();

        foreach ($user->mfaRecoveryCodes()->whereNull('used_at')->get() as $recoveryCode) {
            if (! Hash::check($normalizedCode, $recoveryCode->code_hash)) {
                continue;
            }

            $recoveryCode->forceFill([
                'used_at' => now(),
            ])->save();

            $method->forceFill([
                'last_satisfied_at' => now(),
            ])->save();

            return true;
        }

        return false;
    }

    public function resetMfa(User $user, User $actor): void
    {
        /** @var UserMfaMethod $method */
        $method = $user->totpMfaMethod()->firstOrNew([
            'type' => UserMfaMethod::TYPE_TOTP,
        ]);

        $method->forceFill([
            'secret' => null,
            'pending_secret' => null,
            'pending_secret_expires_at' => null,
            'confirmed_at' => null,
            'reset_at' => now(),
            'reset_by_user_id' => $actor->id,
            'last_challenged_at' => null,
            'last_satisfied_at' => null,
        ])->save();

        $user->mfaRecoveryCodes()->delete();
    }

    private function verifySecret(string $secret, string $code): bool
    {
        return $this->google2fa->verifyKey($secret, $this->normalizeCode($code), 1);
    }

    private function pendingSecretExpired(UserMfaMethod $method): bool
    {
        return $method->pending_secret_expires_at === null
            || $method->pending_secret_expires_at->isPast();
    }

    private function normalizeCode(string $code): string
    {
        return preg_replace('/\s+/', '', $code) ?? '';
    }

    private function normalizeRecoveryCode(string $code): string
    {
        return strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $code) ?? '');
    }

    private function generateRecoveryCode(): string
    {
        $groups = [];
        $alphabetLength = strlen(self::RECOVERY_CODE_ALPHABET) - 1;

        for ($group = 0; $group < self::RECOVERY_CODE_GROUPS; $group++) {
            $value = '';

            for ($character = 0; $character < self::RECOVERY_CODE_GROUP_LENGTH; $character++) {
                $value .= self::RECOVERY_CODE_ALPHABET[random_int(0, $alphabetLength)];
            }

            $groups[] = $value;
        }

        return implode('-', $groups);
    }

    private function issuerName(): string
    {
        return (string) config('app.name', 'Login App 2.0');
    }
}
