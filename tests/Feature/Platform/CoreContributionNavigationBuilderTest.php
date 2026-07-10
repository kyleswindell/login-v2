<?php
/*
|--------------------------------------------------------------------------
| File: tests/Feature/Platform/CoreContributionNavigationBuilderTest.php
| Purpose: Verifies core contribution navigation builders.
|--------------------------------------------------------------------------
*/

namespace Tests\Feature\Platform;

use App\Models\User;
use App\Core\Modules\ContributionRegistry;
use App\Modules\Preferences\Navigation\GroupsBuilder;
use App\Modules\Settings\Navigation\SidebarBuilder;
use App\Modules\Setup\Navigation\ItemsBuilder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CoreContributionNavigationBuilderTest extends TestCase
{
    use RefreshDatabase;

    public function test_settings_navigation_builder_returns_authorized_ordered_items(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        $items = app(SidebarBuilder::class)->items($user, 'platform.settings.notifications');

        $this->assertSame([
            'Settings',
            'Notification Defaults',
        ], collect($items)->pluck('label')->all());

        $settingsItem = collect($items)->firstWhere('route_name', 'settings.index');
        $notificationItem = collect($items)->firstWhere('route_name', 'platform.settings.notifications');

        $this->assertSame('settings', $settingsItem['icon']);
        $this->assertSame(['settings.index', 'platform.settings.index'], $settingsItem['active_patterns']);
        $this->assertSame('Notification Defaults', $notificationItem['label']);
        $this->assertSame('notification', $notificationItem['icon']);
        $this->assertSame(['platform.settings.notifications'], $notificationItem['active_patterns']);
        $this->assertTrue($notificationItem['current']);
    }

    public function test_settings_navigation_builder_returns_landing_items_without_self_link(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        $items = app(SidebarBuilder::class)->landingItems($user, 'settings.index');

        $this->assertSame([
            'Notification Defaults',
        ], collect($items)->pluck('label')->all());

        $this->assertFalse(collect($items)->contains('route_name', 'settings.index'));
    }

    public function test_preferences_navigation_builder_returns_authenticated_preference_entries(): void
    {
        $user = User::factory()->create();

        $groups = app(GroupsBuilder::class)->groups($user, 'platform.account.preferences');

        $this->assertCount(1, $groups);
        $this->assertSame('account', $groups[0]['key']);
        $this->assertSame('Account', $groups[0]['label']);
        $this->assertSame(['Preferences', 'Notifications'], collect($groups[0]['items'])->pluck('label')->all());
        $this->assertSame('Preferences', $groups[0]['items'][0]['label']);
        $this->assertSame('settings', $groups[0]['items'][0]['icon']);
        $this->assertSame('platform.account.preferences', $groups[0]['items'][0]['route_name']);
        $this->assertTrue($groups[0]['items'][0]['current']);
    }

    public function test_preferences_navigation_builder_hides_entries_from_guests(): void
    {
        $groups = app(GroupsBuilder::class)->groups(null, 'platform.account.preferences');

        $this->assertSame([], $groups);
    }

    public function test_setup_navigation_builder_returns_authorized_ordered_items(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        $items = app(ItemsBuilder::class)->items($user, 'roles.index');

        $this->assertSame([
            'Setup',
            'Roles & Permissions',
            'Notifications',
        ], collect($items)->pluck('label')->all());

        $rolesSetup = collect($items)->firstWhere('route_name', 'roles.index');
        $notificationsSetup = collect($items)->firstWhere('route_name', 'platform.setup.notifications');

        $this->assertSame('user--multiple', $rolesSetup['icon']);
        $this->assertSame(['roles.*'], $rolesSetup['active_patterns']);
        $this->assertTrue($rolesSetup['current']);
        $this->assertSame('notification', $notificationsSetup['icon']);
        $this->assertSame(['platform.setup.notifications'], $notificationsSetup['active_patterns']);
    }

    public function test_setup_navigation_builder_returns_landing_items_without_self_link(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        $items = app(ItemsBuilder::class)->landingItems($user, 'platform.setup.index');

        $this->assertSame([
            'Roles & Permissions',
            'Notifications',
        ], collect($items)->pluck('label')->all());

        $this->assertFalse(collect($items)->contains('route_name', 'platform.setup.index'));
    }

    public function test_setup_navigation_builder_filters_unauthorized_entries(): void
    {
        $user = User::factory()->create();

        $items = app(ItemsBuilder::class)->items($user, 'platform.setup.index');

        $this->assertSame([], $items);
    }

    public function test_navigation_builders_hide_stale_registry_entries_after_sync(): void
    {
        app(ContributionRegistry::class)->sync();

        DB::table('settings_registry_entries')
            ->where('key', 'notifications.settings.defaults')
            ->update(['is_active' => false, 'is_stale' => true]);
        DB::table('setup_registry_entries')
            ->where('key', 'notifications.setup.index')
            ->update(['is_active' => false, 'is_stale' => true]);
        DB::table('preference_registry_entries')
            ->where('key', 'notifications.account.preferences')
            ->update(['is_active' => false, 'is_stale' => true]);

        $user = $this->actingAsPlatformSuperAdmin();

        $settingsItems = app(SidebarBuilder::class)->items($user, 'platform.settings.notifications');
        $setupItems = app(ItemsBuilder::class)->items($user, 'platform.setup.notifications');
        $preferenceGroups = app(GroupsBuilder::class)->groups($user, 'platform.account.notifications');

        $this->assertFalse(collect($settingsItems)->pluck('route_name')->contains('platform.settings.notifications'));
        $this->assertFalse(collect($setupItems)->pluck('route_name')->contains('platform.setup.notifications'));
        $this->assertFalse(collect($preferenceGroups)->flatMap(fn (array $group): array => $group['items'])->pluck('route_name')->contains('platform.account.notifications'));
    }
}
