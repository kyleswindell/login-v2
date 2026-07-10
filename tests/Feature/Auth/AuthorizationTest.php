<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Modules\Roles\Services\RoleCatalog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_inherit_permissions_from_assigned_roles(): void
    {
        $permission = Permission::query()->create([
            'name' => 'platform.users.view',
            'guard_name' => 'web',
        ]);

        $role = Role::query()->create([
            'name' => RoleCatalog::ADMIN,
            'guard_name' => 'web',
        ]);

        $role->givePermissionTo($permission);

        $user = User::factory()->create();
        $user->assignRole($role);

        $this->assertTrue($user->can('platform.users.view'));
    }

    public function test_super_admin_bypasses_normal_permission_checks(): void
    {
        $user = User::factory()->create();

        Role::query()->create([
            'name' => RoleCatalog::SUPER_ADMIN,
            'guard_name' => 'web',
        ]);

        $user->assignRole(RoleCatalog::SUPER_ADMIN);

        $this->assertTrue(Gate::forUser($user)->allows('platform.anything'));
    }
}
