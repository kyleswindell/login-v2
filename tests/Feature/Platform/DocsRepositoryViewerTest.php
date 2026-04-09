<?php

namespace Tests\Feature\Platform;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocsRepositoryViewerTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_open_the_docs_repository_viewer(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/docs')
            ->assertOk()
            ->assertSee('Documentation Vault')
            ->assertSee('Repository Tree');
    }

    public function test_super_admin_can_view_a_docs_file(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/docs?path=V2%20App/Planning/V2%20Feature%20Roadmap.md')
            ->assertOk()
            ->assertSee('V2 Feature Roadmap')
            ->assertSee('Phase 1');
    }

    public function test_standard_users_cannot_access_the_docs_repository_viewer(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/platform/docs')
            ->assertForbidden();
    }
}
