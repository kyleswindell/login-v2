<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PlatformRolesAndPermissionsSeeder extends Seeder
{
    /**
     * @var list<string>
     */
    private array $permissions = [
        'platform.users.view',
        'platform.users.manage',
        'platform.ui-reference.view',
        'platform.docs.view',
        'platform.notifications.view',
        'platform.audit-logs.view',
        'platform.error-logs.view',
        'platform.settings.view',
        'platform.settings.manage',
    ];

    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach ($this->permissions as $permissionName) {
            Permission::query()->firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'web',
            ]);
        }

        $superAdminRole = Role::query()->firstOrCreate([
            'name' => 'platform_super_admin',
            'guard_name' => 'web',
        ]);

        // Keep the role permission catalog explicit even though the Gate bypass
        // still gives super admins unrestricted access across the platform.
        $superAdminRole->syncPermissions($this->permissions);

        $platformAdminRole = Role::query()->firstOrCreate([
            'name' => 'platform_admin',
            'guard_name' => 'web',
        ]);

        $platformAdminRole->syncPermissions($this->permissions);

        $platformOperatorRole = Role::query()->firstOrCreate([
            'name' => 'platform_operator',
            'guard_name' => 'web',
        ]);

        $platformOperatorRole->syncPermissions([
            'platform.notifications.view',
            'platform.audit-logs.view',
            'platform.error-logs.view',
        ]);

        $platformReviewerRole = Role::query()->firstOrCreate([
            'name' => 'platform_reviewer',
            'guard_name' => 'web',
        ]);

        $platformReviewerRole->syncPermissions([
            'platform.users.view',
            'platform.ui-reference.view',
            'platform.docs.view',
            'platform.notifications.view',
            'platform.audit-logs.view',
            'platform.error-logs.view',
            'platform.settings.view',
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
