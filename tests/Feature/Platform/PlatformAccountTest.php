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
            ->assertSee('Profile Summary');

        $this->get('/account/settings')
            ->assertOk()
            ->assertSee('Account Settings')
            ->assertSee('Profile Details')
            ->assertSee('Password And Security');

        $this->get('/account/preferences')
            ->assertOk()
            ->assertSee('Account Preferences')
            ->assertSee('Personal Defaults');
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
                'phone' => '555-0102',
            ])
            ->assertRedirect();

        $user->refresh();

        $this->assertSame('Updated Name', $user->name);
        $this->assertSame('updated@example.com', $user->email);
        $this->assertSame('555-0102', $user->phone);
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
}
