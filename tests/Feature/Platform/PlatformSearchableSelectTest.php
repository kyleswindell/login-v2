<?php

namespace Tests\Feature\Platform;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlatformSearchableSelectTest extends TestCase
{
    use RefreshDatabase;

    public function test_ui_reference_forms_surface_renders_shared_searchable_select_contract(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $response = $this->get('/platform/ui-reference/patterns/forms')
            ->assertOk()
            ->assertSee('data-ui-searchable-select-trigger-icon', false)
            ->assertSee('data-ui-searchable-select-check', false);

        $this->assertSame(2, substr_count($response->getContent(), 'data-ui-searchable-select-trigger-icon'));
        $this->assertSame(2, substr_count($response->getContent(), 'data-ui-searchable-select-check'));
    }

    public function test_platform_general_settings_surface_renders_shared_searchable_select_contract(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $response = $this->get('/platform/settings/general')
            ->assertOk()
            ->assertSee('data-ui-searchable-select-trigger-icon', false)
            ->assertSee('data-ui-searchable-select-check', false);

        $this->assertSame(2, substr_count($response->getContent(), 'data-ui-searchable-select-trigger-icon'));
        $this->assertSame(2, substr_count($response->getContent(), 'data-ui-searchable-select-check'));
    }

    public function test_account_preferences_surface_renders_shared_searchable_select_contract(): void
    {
        $user = User::factory()->create([
            'timezone' => 'America/New_York',
            'default_language' => 'en',
        ]);

        $this->actingAs($user);

        $response = $this->get('/account/preferences')
            ->assertOk()
            ->assertSee('data-ui-searchable-select-trigger-icon', false)
            ->assertSee('data-ui-searchable-select-check', false);

        $this->assertSame(2, substr_count($response->getContent(), 'data-ui-searchable-select-trigger-icon'));
        $this->assertSame(2, substr_count($response->getContent(), 'data-ui-searchable-select-check'));
    }
}
