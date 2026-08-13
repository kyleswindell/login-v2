<?php

namespace Tests\Feature\Auth;

use App\Models\PlatformAuditLog;
use App\Models\User;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_can_be_rendered(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('Log in')
            ->assertSee('Email or username')
            ->assertSee('Continue')
            ->assertSee('/storage/login-background-scaled.jpg', false)
            ->assertSee('background-size: cover', false)
            ->assertDontSee('name="password"', false);
    }

    public function test_identifier_submission_redirects_to_password_without_leaking_account_validity(): void
    {
        $user = User::factory()->create();

        $this->post('/login/identify', [
            'identifier' => $user->email,
            'timezone' => 'America/New_York',
        ])->assertRedirect('/login/password')
            ->assertSessionHas('auth.progressive_login');

        $this->get('/login/password')
            ->assertOk()
            ->assertSee($user->email)
            ->assertSee('Change')
            ->assertSee('Password');

        $this->post('/login/identify', [
            'identifier' => 'missing@example.com',
        ])->assertRedirect('/login/password')
            ->assertSessionHas('auth.progressive_login');
    }

    public function test_expired_identifier_submission_returns_to_login_with_session_expired_notice(): void
    {
        $this->withSession([]);

        $request = Request::create('/login/identify', 'POST');
        $request->setLaravelSession($this->app['session.store']);

        $response = $this->app
            ->make(ExceptionHandler::class)
            ->render($request, new TokenMismatchException());

        $this->assertSame(302, $response->getStatusCode());
        $this->assertSame(route('login'), $response->headers->get('Location'));
        $this->assertTrue(session('auth_session_expired'));
        $this->assertSame(
            'The previous sign-in session expired. Start again to continue.',
            session('auth_notice'),
        );

        $this->get('/login')
            ->assertOk()
            ->assertSee('Session expired')
            ->assertSee('The previous sign-in session expired. Start again to continue.');
    }

    public function test_password_step_requires_identifier_session(): void
    {
        $this->get('/login/password')
            ->assertRedirect('/login');
    }

    public function test_guests_are_redirected_to_login_when_visiting_dashboard(): void
    {
        $this->get('/dashboard')
            ->assertRedirect('/login');
    }

    public function test_authenticated_users_are_redirected_away_from_login_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/login')
            ->assertRedirect('/dashboard');
    }

    public function test_users_can_sign_in(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $this->post('/login/identify', [
            'identifier' => $user->email,
            'timezone' => 'America/New_York',
        ])->assertRedirect('/login/password');

        $this->post('/login/password', [
            'password' => 'password',
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);
        $this->assertNotNull($user->fresh()->last_login_at);
        $this->assertSame('America/New_York', $user->fresh()->timezone);

        $this->assertDatabaseHas('platform_audit_logs', [
            'event_type' => 'auth.login_succeeded',
            'actor_user_id' => $user->id,
            'result' => 'success',
            'is_security_event' => true,
        ]);
    }

    public function test_users_cannot_sign_in_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $this->post('/login/identify', [
            'identifier' => $user->email,
        ])->assertRedirect('/login/password');

        $this->from('/login/password')->post('/login/password', [
            'password' => 'wrong-password',
        ])->assertRedirect('/login/password')
            ->assertSessionHasErrors([
                'password' => 'These credentials do not match our records.',
            ]);

        $this->assertGuest();

        $this->assertDatabaseHas('platform_audit_logs', [
            'event_type' => 'auth.login_failed',
            'subject_type' => User::class,
            'subject_id' => (string) $user->id,
            'result' => 'failure',
            'severity' => 'warning',
            'is_security_event' => true,
        ]);
    }

    public function test_password_login_throttles_after_failed_attempts_and_allows_after_decay(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $this->post('/login/identify', [
            'identifier' => $user->email,
        ])->assertRedirect('/login/password');

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->from('/login/password')->post('/login/password', [
                'password' => 'wrong-password',
            ])->assertRedirect('/login/password')
                ->assertSessionHasErrors([
                    'password' => 'These credentials do not match our records.',
                ]);
        }

        $this->from('/login/password')->post('/login/password', [
            'password' => 'password',
        ])->assertRedirect('/login/password')
            ->assertSessionHasErrors([
                'password' => 'Too many login attempts. Please wait before trying again.',
            ]);

        $this->assertGuest();

        $log = PlatformAuditLog::query()
            ->where('event_type', 'auth.login_throttled')
            ->firstOrFail();

        $this->assertSame('failure', $log->result);
        $this->assertSame('warning', $log->severity);
        $this->assertTrue($log->is_security_event);
        $this->assertArrayHasKey('identifier_hash', $log->metadata);
        $this->assertArrayHasKey('retry_after_seconds', $log->metadata);
        $this->assertStringNotContainsString($user->email, json_encode($log->metadata));

        $this->travel(11)->minutes();

        $this->post('/login/password', [
            'password' => 'password',
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);
    }

    public function test_repeated_login_throttles_emit_suspicious_auth_detection_once(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $this->post('/login/identify', [
            'identifier' => $user->email,
        ])->assertRedirect('/login/password');

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->from('/login/password')->post('/login/password', [
                'password' => 'wrong-password',
            ])->assertRedirect('/login/password');
        }

        for ($attempt = 0; $attempt < 3; $attempt++) {
            $this->from('/login/password')->post('/login/password', [
                'password' => 'password',
            ])->assertRedirect('/login/password')
                ->assertSessionHasErrors(['password']);
        }

        $events = PlatformAuditLog::query()
            ->where('event_type', 'auth.suspicious_activity_detected')
            ->get();

        $this->assertCount(1, $events);

        $metadata = $events->firstOrFail()->metadata;

        $this->assertSame('login_throttle_repeated', $metadata['signal']);
        $this->assertSame(2, $metadata['threshold']);
        $this->assertGreaterThanOrEqual(2, $metadata['event_count']);
        $this->assertArrayHasKey('identifier_hash', $metadata);
        $this->assertArrayHasKey('ip_hash', $metadata);
        $this->assertStringNotContainsString($user->email, json_encode($metadata));
        $this->assertStringNotContainsString('password', json_encode($metadata));
    }

    public function test_password_spray_from_one_ip_emits_suspicious_auth_detection(): void
    {
        $identifiers = [];

        for ($attempt = 0; $attempt < 10; $attempt++) {
            $identifier = "spray-{$attempt}@example.com";
            $identifiers[] = $identifier;

            $this->post('/login/identify', [
                'identifier' => $identifier,
            ])->assertRedirect('/login/password');

            $this->from('/login/password')->post('/login/password', [
                'password' => 'wrong-password',
            ])->assertRedirect('/login/password');
        }

        $log = PlatformAuditLog::query()
            ->where('event_type', 'auth.suspicious_activity_detected')
            ->get()
            ->first(fn (PlatformAuditLog $log): bool => ($log->metadata['signal'] ?? null) === 'password_spray_ip');

        $this->assertInstanceOf(PlatformAuditLog::class, $log);

        $metadata = $log->metadata;

        $this->assertSame(10, $metadata['threshold']);
        $this->assertSame(10, $metadata['event_count']);
        $this->assertSame(5, $metadata['distinct_identifier_threshold']);
        $this->assertSame(10, $metadata['distinct_identifier_count']);
        $this->assertArrayHasKey('ip_hash', $metadata);

        foreach ($identifiers as $identifier) {
            $this->assertStringNotContainsString($identifier, json_encode($metadata));
        }

        $this->assertStringNotContainsString('wrong-password', json_encode($metadata));
    }

    public function test_successful_password_login_clears_identifier_attempt_limiter(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $this->post('/login/identify', [
            'identifier' => $user->email,
        ])->assertRedirect('/login/password');

        for ($attempt = 0; $attempt < 4; $attempt++) {
            $this->from('/login/password')->post('/login/password', [
                'password' => 'wrong-password',
            ])->assertRedirect('/login/password');
        }

        $this->post('/login/password', [
            'password' => 'password',
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);

        $this->post('/logout')->assertRedirect('/login');
        $this->assertGuest();

        $this->post('/login/identify', [
            'identifier' => $user->email,
        ])->assertRedirect('/login/password');

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->from('/login/password')->post('/login/password', [
                'password' => 'wrong-password',
            ])->assertRedirect('/login/password')
                ->assertSessionHasErrors([
                    'password' => 'These credentials do not match our records.',
                ]);
        }

        $this->from('/login/password')->post('/login/password', [
            'password' => 'wrong-password',
        ])->assertRedirect('/login/password')
            ->assertSessionHasErrors([
                'password' => 'Too many login attempts. Please wait before trying again.',
            ]);
    }

    public function test_inactive_users_cannot_sign_in(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
            'is_active' => false,
        ]);

        $this->post('/login/identify', [
            'identifier' => $user->email,
        ])->assertRedirect('/login/password');

        $this->from('/login/password')->post('/login/password', [
            'password' => 'password',
        ])->assertRedirect('/login/password')
            ->assertSessionHasErrors([
                'password' => 'These credentials do not match our records.',
            ]);

        $this->assertGuest();

        $this->assertDatabaseHas('platform_audit_logs', [
            'event_type' => 'auth.login_failed',
            'actor_user_id' => $user->id,
            'result' => 'failure',
            'is_security_event' => true,
        ]);
    }

    public function test_repeated_inactive_user_attempts_emit_suspicious_auth_detection(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
            'is_active' => false,
        ]);

        for ($attempt = 0; $attempt < 3; $attempt++) {
            $this->post('/login/identify', [
                'identifier' => $user->email,
            ])->assertRedirect('/login/password');

            $this->from('/login/password')->post('/login/password', [
                'password' => 'password',
            ])->assertRedirect('/login/password')
                ->assertSessionHasErrors(['password']);
        }

        $log = PlatformAuditLog::query()
            ->where('event_type', 'auth.suspicious_activity_detected')
            ->get()
            ->first(fn (PlatformAuditLog $log): bool => ($log->metadata['signal'] ?? null) === 'inactive_user_probe');

        $this->assertInstanceOf(PlatformAuditLog::class, $log);

        $this->assertSame(User::class, $log->subject_type);
        $this->assertSame((string) $user->id, $log->subject_id);

        $metadata = $log->metadata;

        $this->assertSame(3, $metadata['threshold']);
        $this->assertSame(3, $metadata['event_count']);
        $this->assertSame($user->id, $metadata['user_id']);
        $this->assertArrayHasKey('identifier_hash', $metadata);
        $this->assertArrayHasKey('ip_hash', $metadata);
        $this->assertStringNotContainsString($user->email, json_encode($metadata));
        $this->assertStringNotContainsString('password', json_encode($metadata));
    }

    public function test_legacy_login_post_still_signs_in_during_compatibility_pass(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
            'timezone' => 'America/New_York',
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);
        $this->assertSame('America/New_York', $user->fresh()->timezone);
    }

    public function test_users_can_sign_out(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/logout')
            ->assertRedirect('/login');

        $this->assertGuest();

        $this->assertDatabaseHas('platform_audit_logs', [
            'event_type' => 'auth.logout',
            'actor_user_id' => $user->id,
            'is_security_event' => true,
        ]);
    }
}
