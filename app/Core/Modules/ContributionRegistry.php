<?php

/*
|--------------------------------------------------------------------------
| File: app/Core/Modules/ContributionRegistry.php
| Purpose: Syncs module contribution manifests into durable registry tables.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Core\Modules;

use App\Core\Modules\Definitions\NotificationType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

final class ContributionRegistry
{
    private const MODULE_TABLE = 'module_registry_entries';
    private const NOTIFICATION_TABLE = 'notification_registry_entries';
    private const SETTINGS_TABLE = 'settings_registry_entries';
    private const SETUP_TABLE = 'setup_registry_entries';
    private const PREFERENCE_TABLE = 'preference_registry_entries';

    public function __construct(
        private readonly Repository $modules,
    ) {
    }

    /**
     * @return array<string, int>
     */
    public function sync(): array
    {
        return [
            'modules' => $this->syncModules(),
            'notifications' => $this->syncNotificationTypes(),
            'settings' => $this->syncSettingsPages(),
            'setup' => $this->syncSetupScreens(),
            'preferences' => $this->syncPreferencePages(),
        ];
    }

    /**
     * @return list<UiEntry>
     */
    public function settingsPageEntries(): array
    {
        return $this->registryBackedUiEntries(
            self::SETTINGS_TABLE,
            UiEntryType::SettingsPage,
            UiPlacement::SettingsSidebar,
            ['group_sort_order', 'sort_order', 'label'],
        );
    }

    /**
     * @return list<UiEntry>
     */
    public function setupScreenEntries(): array
    {
        return $this->registryBackedUiEntries(
            self::SETUP_TABLE,
            UiEntryType::SetupScreen,
            UiPlacement::SetupNavigation,
            ['sort_order', 'label'],
        );
    }

    /**
     * @return list<UiEntry>
     */
    public function preferencePageEntries(): array
    {
        return $this->registryBackedUiEntries(
            self::PREFERENCE_TABLE,
            UiEntryType::PreferencePage,
            UiPlacement::PreferencesNavigation,
            ['group_sort_order', 'sort_order', 'label'],
        );
    }

    private function syncModules(): int
    {
        if (! Schema::hasTable(self::MODULE_TABLE)) {
            return 0;
        }

        $now = now();
        $activeKeys = array_keys($this->modules->all());

        $this->markStaleMissingKeys(self::MODULE_TABLE, $activeKeys, $now);

        foreach ($this->modules->all() as $module) {
            $payload = [
                'key' => $module->key,
                'name' => $module->name,
                'category' => $module->type->value,
                'default_state' => $module->defaultState->value,
                'installed_by_default' => $module->installedByDefault,
                'default_enabled' => $module->defaultEnabled,
                'disableable' => $module->disableable,
                'tenant_eligible' => $module->tenantEligible,
                'dependencies_json' => $this->json($module->dependencies),
            ];

            DB::table(self::MODULE_TABLE)->updateOrInsert(
                ['key' => $module->key],
                $this->registryValues($payload, $now),
            );
        }

        return count($activeKeys);
    }

    private function syncNotificationTypes(): int
    {
        if (! Schema::hasTable(self::NOTIFICATION_TABLE)) {
            return 0;
        }

        $now = now();
        $definitions = $this->modules->notificationDefinitions();
        $activeKeys = collect($definitions)
            ->map(fn (NotificationType $definition): string => $definition->key)
            ->all();

        $this->markStaleMissingKeys(self::NOTIFICATION_TABLE, $activeKeys, $now);

        foreach ($definitions as $definition) {
            $owner = $this->ownerForNotificationType($definition);
            $payload = [
                'key' => $definition->key,
                'module_key' => $owner?->key ?? $definition->moduleKey(),
                'label' => $definition->label,
                'description' => $definition->description,
                'category' => $definition->category,
                'default_severity' => $definition->defaultSeverity,
                'audience' => $definition->audience->value,
                'action_route' => $definition->actionRoute,
                'database_enabled' => $definition->database,
                'email_eligible' => $definition->emailEligible,
                'digest_eligible' => $definition->digestEligible,
                'grouping_key' => $definition->groupKey ?? $definition->dedupeKey,
                'dedupe_window_seconds' => null,
            ];

            DB::table(self::NOTIFICATION_TABLE)->updateOrInsert(
                ['key' => $definition->key],
                $this->registryValues($payload, $now),
            );
        }

        return count($definitions);
    }

    private function syncSettingsPages(): int
    {
        return $this->syncUiEntries(
            table: self::SETTINGS_TABLE,
            type: UiEntryType::SettingsPage,
            placement: UiPlacement::SettingsSidebar,
            extra: fn (UiEntry $entry): array => [
                'description' => null,
            ],
        );
    }

    private function syncSetupScreens(): int
    {
        return $this->syncUiEntries(
            table: self::SETUP_TABLE,
            type: UiEntryType::SetupScreen,
            placement: UiPlacement::SetupNavigation,
            extra: fn (UiEntry $entry): array => [
                'description' => null,
                'is_required' => false,
                'is_blocking' => false,
                'completion_key' => null,
            ],
        );
    }

    private function syncPreferencePages(): int
    {
        return $this->syncUiEntries(
            table: self::PREFERENCE_TABLE,
            type: UiEntryType::PreferencePage,
            placement: UiPlacement::PreferencesNavigation,
            extra: fn (UiEntry $entry): array => [
                'description' => null,
                'storage_scope' => 'user',
                'storage_table' => $this->preferenceStorageTable($entry),
            ],
        );
    }

    /**
     * @param callable(UiEntry): array<string, mixed> $extra
     */
    private function syncUiEntries(string $table, UiEntryType $type, UiPlacement $placement, callable $extra): int
    {
        if (! Schema::hasTable($table)) {
            return 0;
        }

        $now = now();
        $entries = $this->declaredUiEntries($type, $placement);
        $activeKeys = collect($entries)
            ->map(fn (UiEntry $entry): string => $entry->key)
            ->all();

        $this->markStaleMissingKeys($table, $activeKeys, $now);

        foreach ($entries as $entry) {
            $owner = $this->ownerForUiEntry($entry);
            $payload = array_merge([
                'key' => $entry->key,
                'module_key' => $owner?->key ?? $this->moduleKeyFromEntry($entry),
                'group_key' => $entry->groupKey,
                'group_label' => $entry->groupLabel,
                'label' => $entry->label,
                'route_name' => $entry->routeName,
                'view_path' => $entry->viewPath,
                'icon' => $entry->icon,
                'access_mode' => $entry->access?->value,
                'access_value' => $entry->accessValue,
                'active_route_patterns_json' => $this->json($entry->activeRoutePatterns),
                'group_sort_order' => $entry->groupSortOrder,
                'sort_order' => $entry->sortOrder,
                'tenant_eligible' => $entry->tenantEligible,
            ], $extra($entry));

            if ($type === UiEntryType::SetupScreen) {
                unset($payload['group_key'], $payload['group_label'], $payload['group_sort_order']);
            }

            DB::table($table)->updateOrInsert(
                ['key' => $entry->key],
                $this->registryValues($payload, $now),
            );
        }

        return count($entries);
    }

    /**
     * @param list<string> $orderColumns
     * @return list<UiEntry>
     */
    private function registryBackedUiEntries(
        string $table,
        UiEntryType $type,
        UiPlacement $placement,
        array $orderColumns,
    ): array {
        $declared = collect($this->declaredUiEntries($type, $placement))
            ->keyBy(fn (UiEntry $entry): string => $entry->key);

        if (! Schema::hasTable($table)) {
            return $declared->values()->all();
        }

        $hasRegistryRows = DB::table($table)->exists();

        $query = DB::table($table)
            ->where('is_active', true)
            ->where('is_stale', false);

        foreach ($orderColumns as $column) {
            $query->orderBy($column);
        }

        $rows = $query->get();

        if ($rows->isEmpty() && ! $hasRegistryRows) {
            return $declared->values()->all();
        }

        return $rows
            ->map(fn (object $row): ?UiEntry => $declared->get((string) $row->key))
            ->filter()
            ->values()
            ->all();
    }

    /**
     * @param list<string> $activeKeys
     */
    private function markStaleMissingKeys(string $table, array $activeKeys, mixed $now): void
    {
        $query = DB::table($table);

        if ($activeKeys !== []) {
            $query->whereNotIn('key', $activeKeys);
        }

        $query->update([
            'is_active' => false,
            'is_stale' => true,
            'updated_at' => $now,
        ]);
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    private function registryValues(array $payload, mixed $now): array
    {
        return array_merge($payload, [
            'is_active' => true,
            'is_stale' => false,
            'source_hash' => $this->sourceHash($payload),
            'synced_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    private function ownerForNotificationType(NotificationType $definition): ?Manifest
    {
        return collect($this->modules->ownersForNotificationType($definition->key))->first();
    }

    private function ownerForUiEntry(UiEntry $entry): ?Manifest
    {
        return collect($this->modules->ownersForUiEntryKey($entry->key))->first();
    }

    /**
     * @return list<UiEntry>
     */
    private function declaredUiEntries(UiEntryType $type, UiPlacement $placement): array
    {
        return match ($type) {
            UiEntryType::SettingsPage => $this->modules->settingsPageEntries(),
            UiEntryType::SetupScreen => $this->modules->setupScreenEntries(),
            UiEntryType::PreferencePage => $this->modules->preferencePageEntries(),
            default => $this->modules->uiEntries($type, $placement),
        };
    }

    private function moduleKeyFromEntry(UiEntry $entry): string
    {
        return str($entry->key)->before('.')->toString();
    }

    private function preferenceStorageTable(UiEntry $entry): ?string
    {
        return match ($entry->routeName) {
            'platform.account.preferences' => 'users',
            'platform.account.notifications' => 'user_notification_preferences',
            default => null,
        };
    }

    /**
     * @param array<string, mixed> $payload
     */
    private function sourceHash(array $payload): string
    {
        ksort($payload);

        return hash('sha256', (string) json_encode($payload, JSON_UNESCAPED_SLASHES));
    }

    /**
     * @param array<int, mixed> $value
     */
    private function json(array $value): string
    {
        return (string) json_encode(array_values($value), JSON_UNESCAPED_SLASHES);
    }
}
