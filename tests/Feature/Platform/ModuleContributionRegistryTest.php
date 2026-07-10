<?php

/*
|--------------------------------------------------------------------------
| File: tests/Feature/Platform/ModuleContributionRegistryTest.php
| Purpose: Verifies module contribution registry projection sync behavior.
|--------------------------------------------------------------------------
*/

namespace Tests\Feature\Platform;

use App\Core\Modules\Category;
use App\Core\Modules\ContributionRegistry;
use App\Core\Modules\Definitions\NotificationType;
use App\Core\Modules\Manifest;
use App\Core\Modules\Repository;
use App\Core\Modules\UiEntry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Command\Command;
use Tests\TestCase;

class ModuleContributionRegistryTest extends TestCase
{
    use RefreshDatabase;

    public function test_sync_creates_module_contribution_registry_rows(): void
    {
        $result = app(ContributionRegistry::class)->sync();

        $this->assertGreaterThan(0, $result['modules']);
        $this->assertGreaterThan(0, $result['notifications']);
        $this->assertGreaterThan(0, $result['settings']);
        $this->assertGreaterThan(0, $result['setup']);
        $this->assertGreaterThan(0, $result['preferences']);

        $this->assertDatabaseHas('module_registry_entries', [
            'key' => 'notifications',
            'is_active' => true,
            'is_stale' => false,
        ]);
        $this->assertDatabaseHas('notification_registry_entries', [
            'key' => 'roles.assignments.updated',
            'module_key' => 'roles',
            'is_active' => true,
            'is_stale' => false,
        ]);
        $this->assertDatabaseHas('settings_registry_entries', [
            'key' => 'notifications.settings.defaults',
            'route_name' => 'platform.settings.notifications',
            'is_active' => true,
            'is_stale' => false,
        ]);
        $this->assertDatabaseHas('setup_registry_entries', [
            'key' => 'roles.setup.permissions',
            'route_name' => 'roles.index',
            'is_active' => true,
            'is_stale' => false,
        ]);
        $this->assertDatabaseHas('preference_registry_entries', [
            'key' => 'notifications.account.preferences',
            'storage_table' => 'user_notification_preferences',
            'is_active' => true,
            'is_stale' => false,
        ]);
    }

    public function test_sync_is_idempotent(): void
    {
        $first = app(ContributionRegistry::class)->sync();
        $counts = $this->registryCounts();

        $second = app(ContributionRegistry::class)->sync();

        $this->assertSame($first, $second);
        $this->assertSame($counts, $this->registryCounts());
    }

    public function test_missing_declarations_are_marked_stale_without_deleting_rows(): void
    {
        $registry = new ContributionRegistry(new Repository([
            new Manifest(
                key: 'example',
                name: 'Example',
                type: Category::Shared,
                notificationDefinitions: [
                    new NotificationType(
                        key: 'example.record.updated',
                        label: 'Example updated',
                        description: 'An example record was updated.',
                        category: 'example',
                    ),
                ],
            ),
        ]));
        $registry->sync();

        $emptyRegistry = new ContributionRegistry(new Repository([
            new Manifest(
                key: 'example',
                name: 'Example',
                type: Category::Shared,
            ),
        ]));
        $emptyRegistry->sync();

        $this->assertDatabaseHas('notification_registry_entries', [
            'key' => 'example.record.updated',
            'is_active' => false,
            'is_stale' => true,
        ]);
    }

    public function test_source_hash_changes_when_declaration_metadata_changes(): void
    {
        $registry = new ContributionRegistry(new Repository([
            new Manifest(
                key: 'example',
                name: 'Example',
                type: Category::Shared,
                notificationDefinitions: [
                    new NotificationType(
                        key: 'example.record.updated',
                        label: 'Example updated',
                        description: 'An example record was updated.',
                        category: 'example',
                    ),
                ],
            ),
        ]));
        $registry->sync();

        $originalHash = DB::table('notification_registry_entries')
            ->where('key', 'example.record.updated')
            ->value('source_hash');

        $changedRegistry = new ContributionRegistry(new Repository([
            new Manifest(
                key: 'example',
                name: 'Example',
                type: Category::Shared,
                notificationDefinitions: [
                    new NotificationType(
                        key: 'example.record.updated',
                        label: 'Example updated with new wording',
                        description: 'An example record was updated.',
                        category: 'example',
                    ),
                ],
            ),
        ]));
        $changedRegistry->sync();

        $changedHash = DB::table('notification_registry_entries')
            ->where('key', 'example.record.updated')
            ->value('source_hash');

        $this->assertNotSame($originalHash, $changedHash);
    }

    public function test_registry_readers_do_not_render_db_authored_entries(): void
    {
        DB::table('settings_registry_entries')->insert([
            'key' => 'db.authored.settings',
            'module_key' => 'db',
            'group_key' => 'db',
            'group_label' => 'Database',
            'label' => 'Database Authored',
            'route_name' => 'db.settings',
            'view_path' => 'resources/views/db/settings.blade.php',
            'icon' => 'settings',
            'is_active' => true,
            'is_stale' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $entries = app(ContributionRegistry::class)->settingsPageEntries();

        $this->assertFalse(collect($entries)->contains(fn (UiEntry $entry): bool => $entry->key === 'db.authored.settings'));
    }

    public function test_registry_reader_filters_stale_entries_after_sync(): void
    {
        app(ContributionRegistry::class)->sync();

        DB::table('preference_registry_entries')
            ->where('key', 'notifications.account.preferences')
            ->update([
                'is_active' => false,
                'is_stale' => true,
            ]);

        $entries = app(ContributionRegistry::class)->preferencePageEntries();

        $this->assertFalse(collect($entries)->contains(fn (UiEntry $entry): bool => $entry->key === 'notifications.account.preferences'));
        $this->assertTrue(collect($entries)->contains(fn (UiEntry $entry): bool => $entry->key === 'preferences.page.personal-defaults'));
    }

    public function test_sync_command_populates_registries(): void
    {
        $exitCode = Artisan::call('modules:sync-registries', ['--json' => true]);

        $this->assertSame(Command::SUCCESS, $exitCode);
        $this->assertDatabaseHas('module_registry_entries', ['key' => 'settings']);
        $this->assertStringContainsString('"modules"', Artisan::output());
    }

    /**
     * @return array<string, int>
     */
    private function registryCounts(): array
    {
        return [
            'modules' => DB::table('module_registry_entries')->count(),
            'notifications' => DB::table('notification_registry_entries')->count(),
            'settings' => DB::table('settings_registry_entries')->count(),
            'setup' => DB::table('setup_registry_entries')->count(),
            'preferences' => DB::table('preference_registry_entries')->count(),
        ];
    }
}
