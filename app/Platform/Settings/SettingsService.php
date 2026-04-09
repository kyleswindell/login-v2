<?php

namespace App\Platform\Settings;

use App\Models\Setting;

class SettingsService
{
    public function get(
        string $groupKey,
        string $key,
        mixed $default = null,
        string $scopeType = 'platform',
        ?string $scopeId = null,
        ?string $moduleKey = null,
    ): mixed {
        $setting = Setting::query()
            ->where('scope_type', $scopeType)
            ->where('group_key', $groupKey)
            ->where('key', $key)
            ->when($scopeId !== null, fn ($query) => $query->where('scope_id', $scopeId))
            ->when($scopeId === null, fn ($query) => $query->whereNull('scope_id'))
            ->when($moduleKey !== null, fn ($query) => $query->where('module_key', $moduleKey))
            ->when($moduleKey === null, fn ($query) => $query->whereNull('module_key'))
            ->first();

        if (! $setting) {
            return $default;
        }

        return json_decode($setting->value_jsonb ?? 'null', true);
    }

    public function put(
        string $groupKey,
        string $key,
        mixed $value,
        string $scopeType = 'platform',
        ?string $scopeId = null,
        ?string $moduleKey = null,
        string $dataType = 'json',
        bool $isEncrypted = false,
        bool $isPublic = false,
        ?int $updatedBy = null,
    ): Setting {
        // Store all values as JSON so one table can cover simple scalars now and richer
        // structured module settings later without a schema split for every feature area.
        return Setting::query()->updateOrCreate([
            'scope_type' => $scopeType,
            'scope_id' => $scopeId,
            'module_key' => $moduleKey,
            'group_key' => $groupKey,
            'key' => $key,
        ], [
            'value_jsonb' => json_encode($value, JSON_THROW_ON_ERROR),
            'data_type' => $dataType,
            'is_encrypted' => $isEncrypted,
            'is_public' => $isPublic,
            'updated_by' => $updatedBy,
        ]);
    }
}
