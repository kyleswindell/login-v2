<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Modules\Auth\Models\UserMfaMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FA\Google2FA;
use Tests\TestCase;

class MfaStepUpTest extends TestCase
{
    use RefreshDatabase;

    public function test_enrolled_user_must_complete_step_up_before_password_change(): void
    {
        $user = User::factory()->create([
            'email' => 'operator@example.com',
            'password' => Hash::make('current-password'),
        ]);

        $this->createConfirmedTotp($user);

        $this->actingAs($user)
            ->post('/account/settings', [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'current_password' => 'current-password',
                'new_password' => 'NewPassword123!',
                'new_password_confirmation' => 'NewPassword123!',
            ])->assertRedirect('/mfa/step-up');

        $this->assertTrue(Hash::check('current-password', $user->fresh()->password));
    }

    public function test_step_up_page_uses_auth_shell(): void
    {
        $user = User::factory()->create([
            'email' => 'operator@example.com',
        ]);

        $this->createConfirmedTotp($user);

        $this->actingAs($user)
            ->get('/mfa/step-up')
            ->assertOk()
            ->assertSee('data-auth-shell', false)
            ->assertSee('Verify MFA')
            ->assertSee('Authenticator code');
    }

    public function test_enrolled_user_can_change_password_after_step_up(): void
    {
        $user = User::factory()->create([
            'email' => 'operator@example.com',
            'password' => Hash::make('current-password'),
        ]);
        $secret = $this->createConfirmedTotp($user);

        $this->actingAs($user)
            ->withSession(['mfa.step_up_intended_url' => '/account/settings'])
            ->post('/mfa/step-up', [
                'code' => (new Google2FA())->getCurrentOtp($secret),
            ])->assertRedirect('/account/settings');

        $this->post('/account/settings', [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'current_password' => 'current-password',
            'new_password' => 'NewPassword123!',
            'new_password_confirmation' => 'NewPassword123!',
        ])->assertRedirect();

        $this->assertTrue(Hash::check('NewPassword123!', $user->fresh()->password));
        $this->assertDatabaseHas('platform_audit_logs', [
            'event_type' => 'auth.mfa_satisfied',
            'actor_user_id' => $user->id,
            'is_security_event' => true,
        ]);

        $this->post('/account/settings', [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'current_password' => 'NewPassword123!',
            'new_password' => 'AnotherPassword123!',
            'new_password_confirmation' => 'AnotherPassword123!',
        ])->assertRedirect('/mfa/step-up');

        $this->assertTrue(Hash::check('NewPassword123!', $user->fresh()->password));
    }

    public function test_enrolled_user_must_complete_step_up_before_email_change(): void
    {
        $user = User::factory()->create([
            'email' => 'operator@example.com',
        ]);

        $this->createConfirmedTotp($user);

        $this->actingAs($user)
            ->post('/account/settings', [
                'name' => $user->name,
                'email' => 'operator.updated@example.com',
                'phone' => $user->phone,
            ])->assertRedirect('/mfa/step-up');

        $this->assertSame('operator@example.com', $user->fresh()->email);
    }

    public function test_enrolled_user_can_change_email_after_step_up_and_step_up_is_consumed(): void
    {
        $user = User::factory()->create([
            'email' => 'operator@example.com',
        ]);
        $secret = $this->createConfirmedTotp($user);

        $this->actingAs($user)
            ->withSession(['mfa.step_up_intended_url' => '/account/settings'])
            ->post('/mfa/step-up', [
                'code' => (new Google2FA())->getCurrentOtp($secret),
            ])->assertRedirect('/account/settings');

        $this->post('/account/settings', [
            'name' => $user->name,
            'email' => 'operator.updated@example.com',
            'phone' => $user->phone,
        ])->assertRedirect();

        $this->assertSame('operator.updated@example.com', $user->fresh()->email);

        $this->post('/account/settings', [
            'name' => $user->name,
            'email' => 'operator.second@example.com',
            'phone' => $user->phone,
        ])->assertRedirect('/mfa/step-up');

        $this->assertSame('operator.updated@example.com', $user->fresh()->email);
    }

    public function test_login_mfa_does_not_satisfy_account_security_step_up(): void
    {
        $user = User::factory()->create([
            'email' => 'operator@example.com',
            'password' => Hash::make('current-password'),
        ]);
        $secret = $this->createConfirmedTotp($user);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'current-password',
        ])->assertRedirect('/mfa/challenge');

        $this->post('/mfa/challenge', [
            'code' => (new Google2FA())->getCurrentOtp($secret),
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);

        $this->post('/account/settings', [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'current_password' => 'current-password',
            'new_password' => 'NewPassword123!',
            'new_password_confirmation' => 'NewPassword123!',
        ])->assertRedirect('/mfa/step-up');

        $this->assertTrue(Hash::check('current-password', $user->fresh()->password));
    }

    public function test_login_mfa_does_not_satisfy_email_change_step_up(): void
    {
        $user = User::factory()->create([
            'email' => 'operator@example.com',
            'password' => Hash::make('current-password'),
        ]);
        $secret = $this->createConfirmedTotp($user);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'current-password',
        ])->assertRedirect('/mfa/challenge');

        $this->post('/mfa/challenge', [
            'code' => (new Google2FA())->getCurrentOtp($secret),
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);

        $this->post('/account/settings', [
            'name' => $user->name,
            'email' => 'operator.updated@example.com',
            'phone' => $user->phone,
        ])->assertRedirect('/mfa/step-up');

        $this->assertSame('operator@example.com', $user->fresh()->email);
    }

    public function test_step_up_throttles_failed_attempts_and_success_clears_limiter(): void
    {
        $user = User::factory()->create([
            'email' => 'operator@example.com',
        ]);
        $secret = $this->createConfirmedTotp($user);

        $this->actingAs($user)
            ->withSession(['mfa.step_up_intended_url' => '/account/settings']);

        for ($attempt = 0; $attempt < 4; $attempt++) {
            $this->from('/mfa/step-up')
                ->post('/mfa/step-up', [
                    'code' => $this->invalidOtpCode($secret),
                ])->assertRedirect('/mfa/step-up')
                ->assertSessionHasErrors(['code']);
        }

        $this->post('/mfa/step-up', [
            'code' => (new Google2FA())->getCurrentOtp($secret),
        ])->assertRedirect('/account/settings');

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->from('/mfa/step-up')
                ->post('/mfa/step-up', [
                    'code' => $this->invalidOtpCode($secret),
                ])->assertRedirect('/mfa/step-up')
                ->assertSessionHasErrors(['code']);
        }

        $this->assertDatabaseMissing('platform_audit_logs', [
            'event_type' => 'auth.mfa_rate_limited',
            'actor_user_id' => $user->id,
        ]);

        $this->from('/mfa/step-up')
            ->post('/mfa/step-up', [
                'code' => $this->invalidOtpCode($secret),
            ])->assertRedirect('/mfa/step-up')
            ->assertSessionHasErrors(['code']);

        $this->assertDatabaseHas('platform_audit_logs', [
            'event_type' => 'auth.mfa_rate_limited',
            'actor_user_id' => $user->id,
            'result' => 'failure',
            'is_security_event' => true,
        ]);
    }

    public function test_non_enrolled_user_can_update_password_without_step_up(): void
    {
        $user = User::factory()->create([
            'email' => 'operator@example.com',
            'password' => Hash::make('current-password'),
        ]);

        $this->actingAs($user)
            ->post('/account/settings', [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'current_password' => 'current-password',
                'new_password' => 'NewPassword123!',
                'new_password_confirmation' => 'NewPassword123!',
            ])->assertRedirect();

        $this->assertTrue(Hash::check('NewPassword123!', $user->fresh()->password));
    }

    public function test_enrolled_admin_must_complete_step_up_before_mfa_reset(): void
    {
        $actor = $this->actingAsPlatformSuperAdmin();
        $actorSecret = $this->createConfirmedTotp($actor);
        $target = User::factory()->create();

        $targetMethod = UserMfaMethod::query()->create([
            'user_id' => $target->id,
            'type' => UserMfaMethod::TYPE_TOTP,
            'secret' => (new Google2FA())->generateSecretKey(),
            'confirmed_at' => now(),
        ]);

        $this->post("/platform/users/{$target->id}/mfa-reset")
            ->assertRedirect('/mfa/step-up');

        $this->assertNotNull($targetMethod->fresh()->secret);

        $this->post('/mfa/step-up', [
            'code' => (new Google2FA())->getCurrentOtp($actorSecret),
        ])->assertRedirect("/platform/users/{$target->id}/edit");

        $this->post("/platform/users/{$target->id}/mfa-reset")
            ->assertRedirect();

        $this->assertNull($targetMethod->fresh()->secret);
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
}
