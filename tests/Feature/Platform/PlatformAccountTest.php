<?php

namespace Tests\Feature\Platform;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PlatformAccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_users_can_view_account_surfaces(): void
    {
        $user = User::factory()->create([
            'name' => 'Alex Operator',
            'email' => 'alex@example.com',
        ]);

        $this->actingAs($user);

        $this->get('/account')
            ->assertOk()
            ->assertSee('My Account')
            ->assertSee('Profile Summary')
            ->assertSee('data-ui-pattern="identity-summary-card"', false);

        $this->get('/account/settings')
            ->assertOk()
            ->assertSee('Account Settings')
            ->assertSee('Profile Details')
            ->assertSee('Password And Security');

        $this->get('/account/preferences')
            ->assertOk()
            ->assertSee('Account Preferences')
            ->assertSee('Personal Defaults')
            ->assertSee('data-ui-component="searchable-select"', false)
            ->assertSee('data-ui-searchable-select-trigger', false);
    }

    public function test_account_settings_can_be_updated(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $this->actingAs($user)
            ->post('/account/settings', [
                'name' => 'Updated Name',
                'email' => 'updated@example.com',
                'phone' => '5555555555',
            ])
            ->assertRedirect();

        $user->refresh();

        $this->assertSame('Updated Name', $user->name);
        $this->assertSame('updated@example.com', $user->email);
        $this->assertSame('(555) 555-5555', $user->phone);
    }

    public function test_account_settings_surface_uses_shared_phone_input_baseline(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/account/settings')
            ->assertOk()
            ->assertSee('data-ui-phone-input', false)
            ->assertSee('placeholder="(555) 555-5555"', false);
    }

    public function test_account_preferences_can_be_updated(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/account/preferences', [
                'timezone' => 'America/New_York',
                'default_language' => 'en',
                'theme_preference' => 'light',
            ])
            ->assertRedirect();

        $user->refresh();

        $this->assertSame('America/New_York', $user->timezone);
        $this->assertSame('en', $user->default_language);
        $this->assertSame('light', $user->theme_preference);
    }

    public function test_account_preferences_reject_invalid_language_option(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/account/preferences', [
                'timezone' => 'America/New_York',
                'default_language' => 'invalid-language',
                'theme_preference' => 'light',
            ])
            ->assertSessionHasErrors(['default_language']);
    }
}
