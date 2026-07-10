<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Services/RoleMetadata.php
| Purpose: Owns app UI metadata for Spatie roles.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

final class RoleMetadata
{
    public function __construct(
        private readonly RoleCatalog $roles,
    ) {
    }

    public function syncDefaults(): void
    {
        if (! Schema::hasTable('role_metadata')) {
            return;
        }

        foreach ($this->roles->labels() as $roleName => $label) {
            $role = Role::query()
                ->where('name', $roleName)
                ->where('guard_name', 'web')
                ->first();

            if (! $role instanceof Role) {
                continue;
            }

            $existing = $this->row($role);

            DB::table('role_metadata')->updateOrInsert(
                ['role_id' => $role->id],
                [
                    'label' => $label,
                    'description' => $this->roles->descriptionFor($roleName),
                    'is_system' => true,
                    'is_default' => $roleName === RoleCatalog::DEFAULT,
                    'is_protected' => true,
                    'is_deletable' => false,
                    'is_assignable' => $roleName !== RoleCatalog::DEFAULT,
                    'updated_at' => now(),
                    'created_at' => $existing['created_at'] ?? now(),
                ],
            );
        }
    }

    public function createCustom(Role $role, string $label, ?string $description, ?User $actor = null): void
    {
        $this->upsert($role, $label, $description, $actor, [
            'is_system' => false,
            'is_default' => false,
            'is_protected' => false,
            'is_deletable' => true,
            'is_assignable' => true,
        ]);
    }

    public function update(Role $role, string $label, ?string $description, ?User $actor = null): void
    {
        $existing = $this->row($role);
        $isSystem = $this->roles->isSystem($role->name);

        $this->upsert($role, $label, $description, $actor, [
            'is_system' => (bool) ($existing['is_system'] ?? $isSystem),
            'is_default' => (bool) ($existing['is_default'] ?? $role->name === RoleCatalog::DEFAULT),
            'is_protected' => (bool) ($existing['is_protected'] ?? $isSystem),
            'is_deletable' => (bool) ($existing['is_deletable'] ?? ! $isSystem),
            'is_assignable' => (bool) ($existing['is_assignable'] ?? true),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function summary(Role $role): array
    {
        $row = $this->row($role);
        $isSystem = $this->roles->isSystem($role->name);

        return [
            'label' => $row['label'] ?? $this->roles->labelFor($role->name),
            'description' => $row['description'] ?? $this->roles->descriptionFor($role->name),
            'is_system' => (bool) ($row['is_system'] ?? $isSystem),
            'is_default' => (bool) ($row['is_default'] ?? $role->name === RoleCatalog::DEFAULT),
            'is_protected' => (bool) ($row['is_protected'] ?? $isSystem),
            'is_deletable' => (bool) ($row['is_deletable'] ?? ! $isSystem),
            'is_assignable' => (bool) ($row['is_assignable'] ?? true),
        ];
    }

    /**
     * @param  array<string, mixed>  $flags
     */
    private function upsert(Role $role, string $label, ?string $description, ?User $actor, array $flags): void
    {
        if (! Schema::hasTable('role_metadata')) {
            return;
        }

        $existing = $this->row($role);
        $now = now();

        DB::table('role_metadata')->updateOrInsert(
            ['role_id' => $role->id],
            array_merge([
                'label' => $label,
                'description' => $description,
                'created_by_user_id' => $existing['created_by_user_id'] ?? $actor?->id,
                'updated_by_user_id' => $actor?->id,
                'created_at' => $existing['created_at'] ?? $now,
                'updated_at' => $now,
            ], $flags),
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function row(Role $role): array
    {
        if (! Schema::hasTable('role_metadata')) {
            return [];
        }

        $row = DB::table('role_metadata')->where('role_id', $role->id)->first();

        return $row === null ? [] : (array) $row;
    }
}
