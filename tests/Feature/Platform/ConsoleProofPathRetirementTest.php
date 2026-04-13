<?php

namespace Tests\Feature\Platform;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConsoleProofPathRetirementTest extends TestCase
{
    use RefreshDatabase;

    public function test_console_platform_users_path_redirects_to_app_owned_users_when_console_proof_paths_are_disabled(): void
    {
        config()->set('app.console_proof_paths_enabled', false);
        $this->actingAsPlatformSuperAdmin();

        $this->get('/console/platform-users')
            ->assertRedirect('/platform/users');
    }

    public function test_console_platform_audit_logs_path_redirects_to_app_owned_audit_logs_when_console_proof_paths_are_disabled(): void
    {
        config()->set('app.console_proof_paths_enabled', false);
        $this->actingAsPlatformSuperAdmin();

        $this->get('/console/platform-audit-logs')
            ->assertRedirect('/platform/audit-logs');
    }

    public function test_console_central_error_logs_path_redirects_to_app_owned_error_logs_when_console_proof_paths_are_disabled(): void
    {
        config()->set('app.console_proof_paths_enabled', false);
        $this->actingAsPlatformSuperAdmin();

        $this->get('/console/central-error-logs')
            ->assertRedirect('/platform/error-logs');
    }

    public function test_console_login_redirects_to_app_login_when_console_proof_paths_are_disabled(): void
    {
        config()->set('app.console_proof_paths_enabled', false);

        $this->get('/console/login')
            ->assertRedirect('/login');
    }
}
