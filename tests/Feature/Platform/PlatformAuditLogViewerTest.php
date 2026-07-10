<?php

namespace Tests\Feature\Platform;

use App\Models\PlatformAuditLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
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
            ->assertSee('auth.login.success')
            ->assertSee('aria-label="Toggle audit log filters"', false)
            ->assertSee('class="ui-icon-button"', false)
            ->assertSee('Actions')
            ->assertSee('class="ui-action ui-action-primary" data-audit-log-view', false);
    }

    public function test_authorized_users_are_redirected_from_target_audit_route_to_app_owned_audit_logs(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/operations/audit-logs')
            ->assertRedirect('/platform/audit-logs');
    }

    public function test_guests_are_redirected_from_target_audit_route(): void
    {
        $this->get('/platform/operations/audit-logs')
            ->assertRedirect('/login');
    }

    public function test_users_without_permission_cannot_access_target_audit_route(): void
    {
        $user = User::factory()->create([
            'is_active' => true,
        ]);

        $this->actingAs($user)
            ->get('/platform/operations/audit-logs')
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

        $this->get('/platform/audit-logs?result=failure&severity=warning&event_type=platform.user.updated')
            ->assertOk()
            ->assertSee('platform.user.updated')
            ->assertViewHas('logs', function (LengthAwarePaginator $logs): bool {
                return $logs->count() === 1
                    && $logs->first()?->event_type === 'platform.user.updated';
            });
    }

    public function test_actor_filter_limits_results_by_selected_actor(): void
    {
        $actor = User::factory()->create([
            'name' => 'Kyle Swindell',
            'email' => 'kyle@parasolutions.com',
        ]);

        $otherActor = User::factory()->create([
            'name' => 'Other User',
            'email' => 'other@parasolutions.com',
        ]);

        $this->actingAsPlatformSuperAdmin();

        PlatformAuditLog::query()->create([
            'occurred_at' => now(),
            'event_type' => 'platform.user.created',
            'action' => 'created',
            'actor_user_id' => $actor->id,
            'result' => 'success',
            'severity' => 'info',
        ]);

        PlatformAuditLog::query()->create([
            'occurred_at' => now()->subMinute(),
            'event_type' => 'platform.user.updated',
            'action' => 'updated',
            'actor_user_id' => $otherActor->id,
            'result' => 'success',
            'severity' => 'info',
        ]);

        $this->get('/platform/audit-logs?actor_id='.$actor->id)
            ->assertOk()
            ->assertSee('platform.user.created')
            ->assertViewHas('logs', function (LengthAwarePaginator $logs) use ($actor): bool {
                return $logs->count() === 1
                    && $logs->first()?->actor_user_id === $actor->id;
            });
    }

    public function test_authorized_users_can_view_audit_log_detail(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        $log = PlatformAuditLog::query()->create([
            'occurred_at' => now(),
            'event_type' => 'platform.user.invited',
            'action' => 'invited',
            'actor_user_id' => $user->id,
            'result' => 'success',
            'severity' => 'notice',
            'route' => 'platform.users.store',
            'method' => 'POST',
            'request_id' => (string) Str::uuid(),
            'trace_id' => (string) Str::uuid(),
            'ip_address' => '127.0.0.1',
            'subject_type' => User::class,
            'subject_id' => 42,
            'metadata' => ['invitation' => 'queued'],
        ]);

        $this->get("/platform/audit-logs/{$log->id}")
            ->assertOk()
            ->assertSee('Audit Log Detail')
            ->assertSee('platform.user.invited')
            ->assertSee((string) $log->request_id);
    }

    public function test_authorized_users_can_view_audit_log_detail_as_json(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        $log = PlatformAuditLog::query()->create([
            'occurred_at' => now(),
            'event_type' => 'auth.login.success',
            'action' => 'success',
            'actor_user_id' => $user->id,
            'result' => 'success',
            'severity' => 'info',
            'metadata' => ['guard' => 'web'],
        ]);

        $this->getJson("/platform/audit-logs/{$log->id}")
            ->assertOk()
            ->assertJsonPath('event_type', 'auth.login.success')
            ->assertJsonPath('actor_name', $user->name)
            ->assertJsonPath('metadata.guard', 'web');
    }
}
