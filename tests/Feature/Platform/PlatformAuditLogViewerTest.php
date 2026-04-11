<?php

namespace Tests\Feature\Platform;

use App\Models\PlatformAuditLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlatformAuditLogViewerTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_users_can_view_audit_logs(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        PlatformAuditLog::query()->create([
            'occurred_at' => now(),
            'event_type' => 'auth.login.success',
            'action' => 'success',
            'actor_user_id' => $user->id,
            'result' => 'success',
            'severity' => 'info',
        ]);

        $this->get('/platform/audit-logs')
            ->assertOk()
            ->assertSee('Audit Logs')
            ->assertSee('auth.login.success');
    }

    public function test_authorized_users_can_view_filament_audit_log_proof(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        PlatformAuditLog::query()->create([
            'occurred_at' => now('UTC'),
            'event_type' => 'auth.login.success',
            'action' => 'success',
            'actor_user_id' => $user->id,
            'result' => 'success',
            'severity' => 'info',
        ]);

        $this->get('/console/platform-audit-logs')
            ->assertOk()
            ->assertSee('Audit Logs')
            ->assertSee('auth.login.success');
    }

    public function test_guests_are_redirected_from_filament_audit_log_proof(): void
    {
        $this->get('/console/platform-audit-logs')
            ->assertRedirect('/console/login');
    }

    public function test_users_without_permission_cannot_access_filament_audit_log_proof(): void
    {
        $user = User::factory()->create([
            'is_active' => true,
        ]);

        $this->actingAs($user)
            ->get('/console/platform-audit-logs')
            ->assertForbidden();
    }

    public function test_standard_users_cannot_access_audit_logs(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/platform/audit-logs')
            ->assertForbidden();
    }

    public function test_audit_log_filters_limit_results(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        PlatformAuditLog::query()->create([
            'occurred_at' => now()->subMinute(),
            'event_type' => 'auth.login.success',
            'action' => 'success',
            'actor_user_id' => $user->id,
            'result' => 'success',
            'severity' => 'info',
        ]);

        PlatformAuditLog::query()->create([
            'occurred_at' => now(),
            'event_type' => 'platform.user.updated',
            'action' => 'updated',
            'actor_user_id' => $user->id,
            'result' => 'failure',
            'severity' => 'warning',
        ]);

        $this->get('/platform/audit-logs?result=failure&severity=warning&event_type=platform.user')
            ->assertOk()
            ->assertSee('platform.user.updated')
            ->assertDontSee('auth.login.success');
    }

    public function test_actor_filter_matches_name_and_email(): void
    {
        $user = User::factory()->create([
            'name' => 'Kyle Swindell',
            'email' => 'kyle@parasolutions.com',
        ]);

        $this->actingAsPlatformSuperAdmin();

        PlatformAuditLog::query()->create([
            'occurred_at' => now(),
            'event_type' => 'platform.user.created',
            'action' => 'created',
            'actor_user_id' => $user->id,
            'result' => 'success',
            'severity' => 'info',
        ]);

        $this->get('/platform/audit-logs?actor=kyle@parasolutions.com')
            ->assertOk()
            ->assertSee('platform.user.created');

        $this->get('/platform/audit-logs?actor=Kyle')
            ->assertOk()
            ->assertSee('platform.user.created');
    }
}
