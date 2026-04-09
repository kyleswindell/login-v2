<?php

namespace Tests\Feature\Platform;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlatformDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_shows_platform_management_links_for_super_admins(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee($user->email)
            ->assertSee('Platform Users')
            ->assertSee('Documentation Vault');
    }

    public function test_dashboard_hides_platform_management_links_for_standard_users(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertOk()
            ->assertDontSee('Platform Users')
            ->assertDontSee('Documentation Vault');
    }
}
