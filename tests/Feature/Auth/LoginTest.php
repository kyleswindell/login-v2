<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_can_be_rendered(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('Sign in');
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

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);
        $this->assertNotNull($user->fresh()->last_login_at);

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

        $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])->assertRedirect('/login');

        $this->assertGuest();

        $this->assertDatabaseHas('platform_audit_logs', [
            'event_type' => 'auth.login_failed',
            'result' => 'failure',
            'severity' => 'warning',
            'is_security_event' => true,
        ]);
    }

    public function test_inactive_users_cannot_sign_in(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
            'is_active' => false,
        ]);

        $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect('/login');

        $this->assertGuest();

        $this->assertDatabaseHas('platform_audit_logs', [
            'event_type' => 'auth.login_failed',
            'actor_user_id' => $user->id,
            'result' => 'failure',
            'is_security_event' => true,
        ]);
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
