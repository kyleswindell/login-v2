<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Modules\Auth\Models\UserMfaMethod;
use App\Modules\Auth\Models\UserMfaPolicy;
use App\Models\PlatformAuditLog;
use App\Modules\Auth\Notifications\Types as AuthNotificationTypes;
use App\Modules\Auth\Services\Mfa\MfaManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FA\Google2FA;
use Tests\TestCase;

class MfaLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_required_unenrolled_user_is_sent_to_mfa_enrollment_before_authentication(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        UserMfaPolicy::query()->create([
            'user_id' => $user->id,
            'mfa_required' => true,
            'required_at' => now(),
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/mfa/enroll')
            ->assertSessionHas('mfa.pending_login');

        $this->assertGuest();
        $this->assertNull($user->fresh()->last_login_at);
        $this->assertDatabaseMissing('platform_audit_logs', [
            'event_type' => 'auth.login_succeeded',
            'actor_user_id' => $user->id,
        ]);
    }

    public function test_progressive_login_routes_required_unenrolled_user_to_mfa_enrollment(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        UserMfaPolicy::query()->create([
            'user_id' => $user->id,
            'mfa_required' => true,
            'required_at' => now(),
        ]);

        $this->post('/login/identify', [
            'identifier' => $user->email,
        ])->assertRedirect('/login/password');

        $this->post('/login/password', [
            'password' => 'password',
        ])->assertRedirect('/mfa/enroll')
            ->assertSessionHas('mfa.pending_login')
            ->assertSessionMissing('auth.progressive_login');

        $this->assertGuest();
    }

    public function test_required_user_can_complete_enrollment_and_sign_in(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        UserMfaPolicy::query()->create([
            'user_id' => $user->id,
            'mfa_required' => true,
            'required_at' => now(),
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
            'timezone' => 'America/New_York',
        ])->assertRedirect('/mfa/enroll');

        $this->get('/mfa/enroll')
            ->assertOk()
            ->assertSee('Manual key');

        $method = $user->fresh()->totpMfaMethod()->firstOrFail();
        $this->assertNotNull($method->pending_secret_expires_at);

        $code = (new Google2FA())->getCurrentOtp((string) $method->pending_secret);

        $this->post('/mfa/enroll', [
            'code' => $code,
        ])->assertRedirect('/account/mfa/recovery-codes')
            ->assertSessionMissing('mfa.pending_login');

        $this->assertAuthenticatedAs($user);

        $method->refresh();

        $this->assertNotNull($method->secret);
        $this->assertNull($method->pending_secret);
        $this->assertNull($method->pending_secret_expires_at);
        $this->assertNotNull($method->confirmed_at);
        $this->assertSame('America/New_York', $user->fresh()->timezone);
        $this->assertSame(10, $user->fresh()->mfaRecoveryCodes()->count());

        $this->get('/account/mfa/recovery-codes')
            ->assertOk()
            ->assertSee('Save your recovery codes')
            ->assertSee('Each code can only be used once.')
            ->assertSee('Create New Codes')
            ->assertSee('Download')
            ->assertSee('download="mfa-recovery-codes.txt"', false)
            ->assertSee('data-mfa-recovery-codes-list', false)
            ->assertSee('data-mfa-recovery-codes-close', false)
            ->assertSee('data-mfa-recovery-codes-create', false)
            ->assertSee('data-mfa-recovery-codes-download', false);

        $this->get('/account/mfa/recovery-codes')
            ->assertRedirect('/account/settings');

        $this->assertDatabaseHas('platform_audit_logs', [
            'event_type' => 'auth.mfa_enrollment_started',
            'actor_user_id' => $user->id,
            'is_security_event' => true,
        ]);
        $this->assertDatabaseHas('platform_audit_logs', [
            'event_type' => 'auth.mfa_enrolled',
            'actor_user_id' => $user->id,
            'is_security_event' => true,
        ]);
        $this->assertDatabaseHas('notifications', [
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'auth',
            'type_key' => AuthNotificationTypes::MFA_ENROLLED,
        ]);
        $this->assertDatabaseHas('platform_audit_logs', [
            'event_type' => 'auth.login_succeeded',
            'actor_user_id' => $user->id,
            'is_security_event' => true,
        ]);
    }

    public function test_invalid_enrollment_code_leaves_user_unauthenticated_with_pending_secret(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        UserMfaPolicy::query()->create([
            'user_id' => $user->id,
            'mfa_required' => true,
            'required_at' => now(),
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/mfa/enroll');

        $this->get('/mfa/enroll')->assertOk();
        $method = $user->fresh()->totpMfaMethod()->firstOrFail();
        $this->assertNotNull($method->pending_secret_expires_at);

        $this->from('/mfa/enroll')
            ->post('/mfa/enroll', [
                'code' => $this->invalidOtpCode((string) $method->pending_secret),
            ])->assertRedirect('/mfa/enroll')
            ->assertSessionHasErrors(['code']);

        $this->assertGuest();

        $method->refresh();
        $this->assertNotNull($method->pending_secret);
        $this->assertNotNull($method->pending_secret_expires_at);
        $this->assertNull($method->secret);
        $this->assertNull($method->confirmed_at);
    }

    public function test_enrolled_user_is_sent_to_mfa_challenge_before_authentication(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $this->createConfirmedTotp($user);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/mfa/challenge')
            ->assertSessionHas('mfa.pending_login');

        $this->assertGuest();
        $this->assertNull($user->fresh()->last_login_at);

        $this->get('/mfa/challenge')
            ->assertOk()
            ->assertSee('Authentication')
            ->assertSee('Enter the 6-digit code generated by your authenticator app.')
            ->assertSee('Use a recovery code')
            ->assertSee('Contact Support')
            ->assertDontSee('data-auth-mfa-method', false);
    }

    public function test_progressive_login_routes_enrolled_user_to_mfa_challenge(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $this->createConfirmedTotp($user);

        $this->post('/login/identify', [
            'identifier' => $user->email,
        ])->assertRedirect('/login/password');

        $this->post('/login/password', [
            'password' => 'password',
        ])->assertRedirect('/mfa/challenge')
            ->assertSessionHas('mfa.pending_login')
            ->assertSessionMissing('auth.progressive_login');

        $this->assertGuest();
    }

    public function test_invalid_mfa_challenge_code_rejects_without_authentication(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $secret = $this->createConfirmedTotp($user);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/mfa/challenge');

        $this->from('/mfa/challenge')
            ->post('/mfa/challenge', [
                'code' => $this->invalidOtpCode($secret),
            ])->assertRedirect('/mfa/challenge')
            ->assertSessionHasErrors(['code']);

        $this->assertGuest();
        $this->assertNull($user->fresh()->last_login_at);
        $this->assertDatabaseHas('platform_audit_logs', [
            'event_type' => 'auth.mfa_rejected',
            'actor_user_id' => $user->id,
            'result' => 'failure',
            'is_security_event' => true,
        ]);
    }

    public function test_valid_mfa_challenge_code_authenticates_and_records_audit_events(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);
        $secret = $this->createConfirmedTotp($user);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/mfa/challenge');

        $this->post('/mfa/challenge', [
            'code' => (new Google2FA())->getCurrentOtp($secret),
        ])->assertRedirect('/dashboard')
            ->assertSessionMissing('mfa.pending_login');

        $this->assertAuthenticatedAs($user);
        $this->assertNotNull($user->fresh()->last_login_at);

        $this->assertDatabaseHas('platform_audit_logs', [
            'event_type' => 'auth.mfa_satisfied',
            'actor_user_id' => $user->id,
            'is_security_event' => true,
        ]);
        $this->assertDatabaseHas('platform_audit_logs', [
            'event_type' => 'auth.login_succeeded',
            'actor_user_id' => $user->id,
            'is_security_event' => true,
        ]);
    }

    public function test_recovery_code_can_satisfy_login_challenge_once(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);
        $this->createConfirmedTotp($user);
        $recoveryCode = app(MfaManager::class)->regenerateRecoveryCodes($user)[0];

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/mfa/challenge');

        $this->post('/mfa/challenge', [
            'mfa_method' => 'recovery_code',
            'code' => $recoveryCode,
        ])->assertRedirect('/dashboard')
            ->assertSessionMissing('mfa.pending_login');

        $this->assertAuthenticatedAs($user);
        $this->assertSame(1, $user->fresh()->mfaRecoveryCodes()->whereNotNull('used_at')->count());
        $this->assertDatabaseHas('platform_audit_logs', [
            'event_type' => 'auth.mfa_recovery_code_used',
            'actor_user_id' => $user->id,
            'is_security_event' => true,
        ]);
        $this->assertDatabaseHas('notifications', [
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'auth',
            'type_key' => AuthNotificationTypes::MFA_RECOVERY_CODE_USED,
        ]);

        $this->post('/logout');

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/mfa/challenge');

        $this->from('/mfa/challenge')
            ->post('/mfa/challenge', [
                'mfa_method' => 'recovery_code',
                'code' => $recoveryCode,
            ])->assertRedirect('/mfa/challenge')
            ->assertSessionHasErrors(['code']);

        $this->assertGuest();
    }

    public function test_totp_secrets_are_encrypted_at_rest_during_pending_and_confirmed_enrollment(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/account/mfa/enroll')
            ->assertOk();

        $method = $user->fresh()->totpMfaMethod()->firstOrFail();
        $pendingSecret = (string) $method->pending_secret;
        $rawPendingSecret = DB::table('user_mfa_methods')
            ->where('id', $method->id)
            ->value('pending_secret');

        $this->assertNotSame('', $pendingSecret);
        $this->assertNotNull($rawPendingSecret);
        $this->assertNotSame($pendingSecret, $rawPendingSecret);

        $this->post('/account/mfa/enroll', [
            'code' => (new Google2FA())->getCurrentOtp($pendingSecret),
        ])->assertRedirect('/account/mfa/recovery-codes');

        $rawMethod = DB::table('user_mfa_methods')
            ->where('id', $method->id)
            ->first(['secret', 'pending_secret']);

        $this->assertNotNull($rawMethod?->secret);
        $this->assertNotSame($pendingSecret, $rawMethod->secret);
        $this->assertNull($rawMethod->pending_secret);
    }

    public function test_recovery_codes_are_stored_as_non_reversible_hashes(): void
    {
        $user = User::factory()->create();
        $this->createConfirmedTotp($user);

        $codes = app(MfaManager::class)->regenerateRecoveryCodes($user);
        $hashes = DB::table('mfa_recovery_codes')
            ->where('user_id', $user->id)
            ->pluck('code_hash');

        $this->assertCount(10, $codes);
        $this->assertCount(10, $hashes);

        foreach ($codes as $code) {
            $normalizedCode = $this->normalizeRecoveryCode($code);

            $this->assertFalse($hashes->contains($code));
            $this->assertFalse($hashes->contains($normalizedCode));
            $this->assertTrue(
                $hashes->contains(fn (string $hash): bool => Hash::check($normalizedCode, $hash)),
                "No stored recovery-code hash verified for {$code}.",
            );
        }
    }

    public function test_login_challenge_throttles_after_failed_attempts_and_allows_after_decay(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);
        $secret = $this->createConfirmedTotp($user);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/mfa/challenge');

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->from('/mfa/challenge')
                ->post('/mfa/challenge', [
                    'code' => $this->invalidOtpCode($secret),
                ])->assertRedirect('/mfa/challenge')
                ->assertSessionHasErrors(['code']);
        }

        $this->from('/mfa/challenge')
            ->post('/mfa/challenge', [
                'code' => $this->invalidOtpCode($secret),
            ])->assertRedirect('/mfa/challenge')
            ->assertSessionHasErrors(['code']);

        $this->assertGuest();
        $this->assertDatabaseHas('platform_audit_logs', [
            'event_type' => 'auth.mfa_rate_limited',
            'actor_user_id' => $user->id,
            'result' => 'failure',
            'is_security_event' => true,
        ]);

        $this->travel(10)->minutes();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/mfa/challenge');

        $this->post('/mfa/challenge', [
            'code' => (new Google2FA())->getCurrentOtp($secret),
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);
    }

    public function test_repeated_mfa_rate_limits_emit_suspicious_auth_detection_once(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);
        $secret = $this->createConfirmedTotp($user);
        $invalidCode = $this->invalidOtpCode($secret);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/mfa/challenge');

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->from('/mfa/challenge')
                ->post('/mfa/challenge', [
                    'code' => $invalidCode,
                ])->assertRedirect('/mfa/challenge')
                ->assertSessionHasErrors(['code']);
        }

        for ($attempt = 0; $attempt < 3; $attempt++) {
            $this->from('/mfa/challenge')
                ->post('/mfa/challenge', [
                    'code' => $invalidCode,
                ])->assertRedirect('/mfa/challenge')
                ->assertSessionHasErrors(['code']);
        }

        $events = PlatformAuditLog::query()
            ->where('event_type', 'auth.suspicious_activity_detected')
            ->get();

        $this->assertCount(1, $events);

        $log = $events->firstOrFail();
        $metadata = $log->metadata;

        $this->assertSame('mfa_rate_limit_repeated', $metadata['signal']);
        $this->assertSame($user->id, $metadata['user_id']);
        $this->assertSame(2, $metadata['threshold']);
        $this->assertGreaterThanOrEqual(2, $metadata['event_count']);
        $this->assertSame(User::class, $log->subject_type);
        $this->assertSame((string) $user->id, $log->subject_id);
        $this->assertStringNotContainsString($invalidCode, json_encode($metadata));
        $this->assertStringNotContainsString($secret, json_encode($metadata));
    }

    public function test_login_enrollment_confirmation_throttles_failed_attempts(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        UserMfaPolicy::query()->create([
            'user_id' => $user->id,
            'mfa_required' => true,
            'required_at' => now(),
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/mfa/enroll');

        $this->get('/mfa/enroll')->assertOk();
        $method = $user->fresh()->totpMfaMethod()->firstOrFail();

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->from('/mfa/enroll')
                ->post('/mfa/enroll', [
                    'code' => $this->invalidOtpCode((string) $method->pending_secret),
                ])->assertRedirect('/mfa/enroll')
                ->assertSessionHasErrors(['code']);
        }

        $this->from('/mfa/enroll')
            ->post('/mfa/enroll', [
                'code' => $this->invalidOtpCode((string) $method->pending_secret),
            ])->assertRedirect('/mfa/enroll')
            ->assertSessionHasErrors(['code']);

        $this->assertDatabaseHas('platform_audit_logs', [
            'event_type' => 'auth.mfa_rate_limited',
            'actor_user_id' => $user->id,
            'result' => 'failure',
            'is_security_event' => true,
        ]);

        $this->travel(10)->minutes();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/mfa/enroll');

        $this->post('/mfa/enroll', [
            'code' => (new Google2FA())->getCurrentOtp((string) $method->pending_secret),
        ])->assertRedirect('/account/mfa/recovery-codes');

        $this->assertAuthenticatedAs($user);
    }

    public function test_pending_account_enrollment_secret_expires_and_regenerates(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/account/mfa/enroll')
            ->assertOk();

        $method = $user->fresh()->totpMfaMethod()->firstOrFail();
        $firstSecret = (string) $method->pending_secret;
        $this->assertNotNull($method->pending_secret_expires_at);

        $this->travel(16)->minutes();

        $this->actingAs($user)
            ->get('/account/mfa/enroll')
            ->assertOk();

        $method->refresh();

        $this->assertNotSame($firstSecret, (string) $method->pending_secret);
        $this->assertNotNull($method->pending_secret_expires_at);
        $this->assertTrue($method->pending_secret_expires_at->isFuture());

        $events = PlatformAuditLog::query()
            ->where('event_type', 'auth.mfa_enrollment_started')
            ->where('actor_user_id', $user->id)
            ->orderBy('id')
            ->get();

        $this->assertCount(2, $events);
        $this->assertSame('new', $events[0]->metadata['reason']);
        $this->assertSame('expired', $events[1]->metadata['reason']);
    }

    public function test_account_enrollment_confirmation_throttles_failed_attempts(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/account/mfa/enroll')
            ->assertOk();

        $method = $user->fresh()->totpMfaMethod()->firstOrFail();

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->from('/account/mfa/enroll')
                ->post('/account/mfa/enroll', [
                    'code' => $this->invalidOtpCode((string) $method->pending_secret),
                ])->assertRedirect('/account/mfa/enroll')
                ->assertSessionHasErrors(['code']);
        }

        $this->from('/account/mfa/enroll')
            ->post('/account/mfa/enroll', [
                'code' => $this->invalidOtpCode((string) $method->pending_secret),
            ])->assertRedirect('/account/mfa/enroll')
            ->assertSessionHasErrors(['code']);

        $this->assertDatabaseHas('platform_audit_logs', [
            'event_type' => 'auth.mfa_rate_limited',
            'actor_user_id' => $user->id,
            'result' => 'failure',
            'is_security_event' => true,
        ]);
    }

    public function test_expired_pending_account_enrollment_code_cannot_confirm_mfa(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/account/mfa/enroll')
            ->assertOk();

        $method = $user->fresh()->totpMfaMethod()->firstOrFail();
        $expiredSecret = (string) $method->pending_secret;

        $this->travel(16)->minutes();

        $this->from('/account/mfa/enroll')
            ->post('/account/mfa/enroll', [
                'code' => (new Google2FA())->getCurrentOtp($expiredSecret),
            ])->assertRedirect('/account/mfa/enroll')
            ->assertSessionHasErrors(['code']);

        $method->refresh();

        $this->assertNull($method->secret);
        $this->assertNull($method->pending_secret);
        $this->assertNull($method->pending_secret_expires_at);
        $this->assertNull($method->confirmed_at);
    }

    public function test_mfa_audit_metadata_does_not_store_secret_or_code_material(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);
        $secret = $this->createConfirmedTotp($user);
        $recoveryCode = app(MfaManager::class)->regenerateRecoveryCodes($user)[0];
        $invalidCode = $this->invalidOtpCode($secret);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/mfa/challenge');

        $this->from('/mfa/challenge')
            ->post('/mfa/challenge', [
                'code' => $invalidCode,
            ])->assertRedirect('/mfa/challenge')
            ->assertSessionHasErrors(['code']);

        $this->post('/mfa/challenge', [
            'code' => $recoveryCode,
        ])->assertRedirect('/dashboard');

        $this->assertMfaAuditMetadataDoesNotContain([
            $secret,
            $invalidCode,
            $recoveryCode,
            str_replace('-', '', $recoveryCode),
        ]);
    }

    public function test_pending_mfa_authentication_expires_after_ten_minutes(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);
        $secret = $this->createConfirmedTotp($user);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/mfa/challenge');

        $this->travel(11)->minutes();

        $this->post('/mfa/challenge', [
            'code' => (new Google2FA())->getCurrentOtp($secret),
        ])->assertRedirect('/login')
            ->assertSessionMissing('mfa.pending_login');

        $this->assertGuest();
    }

    private function createConfirmedTotp(User $user): string
    {
        $secret = (new Google2FA())->generateSecretKey();

        UserMfaMethod::query()->create([
            'user_id' => $user->id,
            'type' => UserMfaMethod::TYPE_TOTP,
            'secret' => $secret,
            'confirmed_at' => now(),
        ]);

        return $secret;
    }

    private function invalidOtpCode(string $secret): string
    {
        $currentCode = (new Google2FA())->getCurrentOtp($secret);

        return $currentCode === '000000' ? '111111' : '000000';
    }

    private function normalizeRecoveryCode(string $code): string
    {
        return strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $code) ?? '');
    }

    /**
     * @param list<string> $sensitiveValues
     */
    private function assertMfaAuditMetadataDoesNotContain(array $sensitiveValues): void
    {
        $metadata = PlatformAuditLog::query()
            ->where('event_type', 'like', 'auth.mfa_%')
            ->pluck('metadata')
            ->map(fn (mixed $value): string => json_encode($value) ?: '')
            ->implode("\n");

        foreach (array_filter($sensitiveValues) as $sensitiveValue) {
            $this->assertStringNotContainsString((string) $sensitiveValue, $metadata);
        }
    }
}
