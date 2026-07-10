<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Services/RoleCatalog.php
| Purpose: Provides canonical role keys, labels, and default permission presets.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles\Services;

use App\Core\Modules\Definitions\Permission;
use Illuminate\Support\Str;

final class RoleCatalog
{
    public const SUPER_ADMIN = 'super_admin';
    public const ADMIN = 'admin';
    public const MANAGER = 'manager';
    public const USER = 'user';
    public const DEFAULT = 'default';

    public const VIEW = 'roles.view';
    public const CREATE = 'roles.create';
    public const UPDATE = 'roles.update';
    public const DELETE = 'roles.delete';
    public const PERMISSIONS_VIEW = 'roles.permissions.view';
    public const MANAGE = 'roles.manage';

    /**
     * @return array<string, string>
     */
    public function labels(): array
    {
        return [
            self::SUPER_ADMIN => 'Super Admin',
            self::ADMIN => 'Admin',
            self::MANAGER => 'Manager',
            self::USER => 'User',
            self::DEFAULT => 'Default',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function descriptions(): array
    {
        return [
            self::SUPER_ADMIN => 'Full application administration role with global authorization bypass.',
            self::ADMIN => 'Protected administrator role for standard application administration.',
            self::MANAGER => 'Operational manager role for notifications and log review.',
            self::USER => 'Standard authenticated application user role.',
            self::DEFAULT => 'Default baseline role with no explicit permissions.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function legacyMap(): array
    {
        return [
            'platform_super_admin' => self::SUPER_ADMIN,
            'platform_admin' => self::ADMIN,
            'platform_operator' => self::MANAGER,
            'platform_reviewer' => self::USER,
        ];
    }

    /**
     * @return list<string>
     */
    public function keys(): array
    {
        return array_keys($this->labels());
    }

    /**
     * @return list<string>
     */
    public function elevatedKeys(): array
    {
        return [self::SUPER_ADMIN];
    }

    public function labelFor(string $role): string
    {
        return $this->labels()[$role] ?? Str::of($role)->replace(['_', '-'], ' ')->title()->toString();
    }

    public function descriptionFor(string $role): string
    {
        return $this->descriptions()[$role] ?? '';
    }

    public function isSystem(string $role): bool
    {
        return in_array($role, $this->keys(), true);
    }

    public function isSuperAdmin(string $role): bool
    {
        return $role === self::SUPER_ADMIN;
    }

    public function sortOrder(string $role): int
    {
        return match ($role) {
            self::SUPER_ADMIN => 10,
            self::ADMIN => 20,
            self::MANAGER => 30,
            self::USER => 40,
            self::DEFAULT => 50,
            default => 999,
        };
    }

    /**
     * @param  list<Permission|string>  $permissions
     * @return array<string, list<string>>
     */
    public function permissionPresets(array $permissions): array
    {
        if ($permissions === [] || is_string($permissions[array_key_first($permissions)] ?? null)) {
            return $this->legacyPermissionPresets($permissions);
        }

        $presets = array_fill_keys($this->keys(), []);

        foreach ($permissions as $permission) {
            if (! $permission instanceof Permission) {
                continue;
            }

            $presets[self::SUPER_ADMIN][] = $permission->key;

            foreach ($permission->defaultRoles as $role) {
                if ($role === self::SUPER_ADMIN || ! array_key_exists($role, $presets)) {
                    continue;
                }

                $presets[$role][] = $permission->key;
            }
        }

        return collect($presets)
            ->map(fn (array $permissionKeys): array => collect($permissionKeys)->unique()->sort()->values()->all())
            ->all();
    }

    /**
     * @param  list<string>  $allPermissions
     * @return array<string, list<string>>
     */
    private function legacyPermissionPresets(array $allPermissions): array
    {
        $adminPermissions = collect($allPermissions)
            ->reject(fn (string $permission): bool => $permission === self::MANAGE)
            ->values()
            ->all();

        return [
            self::SUPER_ADMIN => $allPermissions,
            self::ADMIN => $adminPermissions,
            self::MANAGER => [
                'notifications.view',
                'platform.audit-logs.view',
                'platform.error-logs.view',
            ],
            self::USER => [
                'notifications.view',
            ],
            self::DEFAULT => [],
        ];
    }
}
