<?php

namespace Tests\Feature\Platform;

use App\Models\CentralErrorLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ErrorLogViewerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @param  array<string, mixed>  $overrides
     */
    private function createErrorLog(array $overrides = []): CentralErrorLog
    {
        return CentralErrorLog::query()->create(array_merge([
            'occurred_at' => now(),
            'environment' => 'testing',
            'service_name' => 'platform',
            'severity' => 'error',
            'message' => 'Test error',
            'fingerprint' => hash('sha256', uniqid('error', true)),
            'handled' => false,
        ], $overrides));
    }

    public function test_authorized_users_can_view_error_log_index(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->createErrorLog([
            'occurred_at' => now(),
            'environment' => 'staging',
            'severity' => 'error',
            'message' => 'Something went wrong',
            'exception_class' => 'RuntimeException',
            'handled' => false,
        ]);

        $this->get('/platform/error-logs')
            ->assertOk()
            ->assertSee('Error Logs')
            ->assertSee('Something went wrong')
            ->assertSee('RuntimeException');
    }

    public function test_authorized_users_can_view_filament_error_log_proof(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->createErrorLog([
            'occurred_at' => now(),
            'environment' => 'staging',
            'severity' => 'critical',
            'message' => 'Filament proof error',
            'exception_class' => 'RuntimeException',
            'handled' => false,
        ]);

        $this->get('/console/central-error-logs')
            ->assertOk()
            ->assertSee('Error Logs')
            ->assertSee('Filament proof error')
            ->assertSee('critical');
    }

    public function test_guests_are_redirected_from_filament_error_log_proof(): void
    {
        $this->get('/console/central-error-logs')
            ->assertRedirect('/console/login');
    }

    public function test_users_without_permission_cannot_access_filament_error_log_proof(): void
    {
        $user = User::factory()->create([
            'is_active' => true,
        ]);

        $this->actingAs($user)
            ->get('/console/central-error-logs')
            ->assertForbidden();
    }

    public function test_guests_are_redirected_from_error_log_index(): void
    {
        $this->get('/platform/error-logs')
            ->assertRedirect('/login');
    }

    public function test_users_without_permission_cannot_view_error_logs(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/platform/error-logs')
            ->assertForbidden();
    }

    public function test_error_log_filters_limit_results(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->createErrorLog([
            'occurred_at' => now()->subMinute(),
            'environment' => 'staging',
            'severity' => 'error',
            'message' => 'Error message',
            'handled' => false,
        ]);

        $this->createErrorLog([
            'occurred_at' => now(),
            'environment' => 'production',
            'severity' => 'warning',
            'message' => 'Warning message',
            'handled' => true,
        ]);

        $this->get('/platform/error-logs?severity=error')
            ->assertOk()
            ->assertSee('Error message')
            ->assertDontSee('Warning message');
    }

    public function test_authorized_users_can_view_error_log_detail(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $log = $this->createErrorLog([
            'occurred_at' => now(),
            'environment' => 'staging',
            'severity' => 'critical',
            'message' => 'Database connection failed',
            'exception_class' => 'PDOException',
            'stack_trace' => "#0 /app/bootstrap.php(42)\n#1 /app/index.php(1)",
            'handled' => false,
        ]);

        $this->get("/platform/error-logs/{$log->id}")
            ->assertOk()
            ->assertSee('Error Log Detail')
            ->assertSee('Database connection failed')
            ->assertSee('PDOException')
            ->assertSee('Database connection failed');
    }

    public function test_users_without_permission_cannot_view_error_log_detail(): void
    {
        $user = User::factory()->create();

        $log = $this->createErrorLog([
            'occurred_at' => now(),
            'severity' => 'error',
            'message' => 'Test',
            'handled' => true,
        ]);

        $this->actingAs($user)
            ->get("/platform/error-logs/{$log->id}")
            ->assertForbidden();
    }

    public function test_handled_filter_separates_handled_and_unhandled(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->createErrorLog([
            'occurred_at' => now()->subMinute(),
            'severity' => 'error',
            'message' => 'Handled error',
            'handled' => true,
        ]);

        $this->createErrorLog([
            'occurred_at' => now(),
            'severity' => 'error',
            'message' => 'Unhandled error',
            'handled' => false,
        ]);

        $this->get('/platform/error-logs?handled=1')
            ->assertOk()
            ->assertSee('Handled error')
            ->assertDontSee('Unhandled error');

        $this->get('/platform/error-logs?handled=0')
            ->assertOk()
            ->assertSee('Unhandled error')
            ->assertDontSee('Handled error');
    }

    public function test_invalid_handled_filter_value_is_ignored(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->createErrorLog([
            'severity' => 'error',
            'message' => 'Handled error',
            'handled' => true,
        ]);

        $this->createErrorLog([
            'severity' => 'error',
            'message' => 'Unhandled error',
            'handled' => false,
        ]);

        $this->get('/platform/error-logs?handled=yes')
            ->assertOk()
            ->assertSee('Handled error')
            ->assertSee('Unhandled error');
    }
}
