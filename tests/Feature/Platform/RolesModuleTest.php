<?php
/*
|--------------------------------------------------------------------------
| File: tests/Feature/Platform/RolesModuleTest.php
| Purpose: Verifies Roles module permissions, metadata, and mutation guardrails.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace Tests\Feature\Platform;

use App\Models\User;
use App\Modules\Notifications\Services\NotificationPermissions;
use App\Modules\Roles\Services\AssignmentGuard;
use App\Modules\Roles\Services\PermissionCatalog;
use App\Modules\Roles\Services\RoleCatalog;
use App\Modules\Roles\Services\RoleMutationPreview;
use App\Modules\Roles\Services\RolePermissionResolver;
use App\Modules\Roles\Services\Writer;
use App\Modules\Settings\Services\SettingsPermissions;
use Database\Seeders\PlatformRolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

final class RolesModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_permission_catalog_declares_canonical_roles_permissions(): void
    {
        $definitions = collect(app(PermissionCatalog::class)->definitions())->keyBy('key');
        $groups = app(PermissionCatalog::class)->grouped();

        $this->assertFalse($definitions->has('platform.roles.view'));
        $this->assertFalse($definitions->has('platform.roles.manage'));
        $this->assertFalse($definitions->has('platform.notifications.view'));
        $this->assertFalse($definitions->has('platform.settings.view'));
        $this->assertFalse($definitions->has('platform.settings.manage'));

        foreach ([
            RoleCatalog::VIEW,
            RoleCatalog::CREATE,
            RoleCatalog::UPDATE,
            RoleCatalog::DELETE,
            RoleCatalog::PERMISSIONS_VIEW,
            RoleCatalog::MANAGE,
        ] as $permission) {
            $this->assertTrue($definitions->has($permission), "Missing Roles permission [{$permission}].");
            $this->assertSame('Roles', $definitions->get($permission)->groupLabel);
        }

        $this->assertSame('view', $definitions->get(RoleCatalog::VIEW)->action());
        $this->assertSame('create', $definitions->get(RoleCatalog::CREATE)->action());
        $this->assertSame('update', $definitions->get(RoleCatalog::UPDATE)->action());
        $this->assertSame('delete', $definitions->get(RoleCatalog::DELETE)->action());
        $this->assertSame('manage', $definitions->get(RoleCatalog::MANAGE)->action());
        $this->assertTrue($definitions->get(RoleCatalog::DELETE)->destructive);
        $this->assertTrue($definitions->get(RoleCatalog::MANAGE)->elevated);
        $this->assertSame([RoleCatalog::SUPER_ADMIN], $definitions->get(RoleCatalog::MANAGE)->defaultRoles);

        $this->assertArrayHasKey('notifications', $groups);
        $this->assertSame('Notifications', $groups['notifications']['label']);
    }

    public function test_canonical_roles_are_seeded_with_registry_and_metadata(): void
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        foreach (app(RoleCatalog::class)->keys() as $role) {
            $this->assertDatabaseHas('roles', [
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }

        $this->assertTrue(Role::findByName(RoleCatalog::SUPER_ADMIN)->hasPermissionTo(RoleCatalog::MANAGE));
        $this->assertFalse(Role::findByName(RoleCatalog::ADMIN)->hasPermissionTo(RoleCatalog::MANAGE));
        $this->assertTrue(Role::findByName(RoleCatalog::ADMIN)->hasPermissionTo(RoleCatalog::VIEW));
        $this->assertTrue(Role::findByName(RoleCatalog::ADMIN)->hasPermissionTo(RoleCatalog::PERMISSIONS_VIEW));

        $this->assertDatabaseHas('permission_registry_entries', [
            'key' => RoleCatalog::VIEW,
            'module_key' => 'roles',
            'is_active' => true,
            'is_stale' => false,
        ]);

        $admin = Role::findByName(RoleCatalog::ADMIN);

        $this->assertDatabaseHas('role_metadata', [
            'role_id' => $admin->id,
            'label' => 'Admin',
            'is_system' => true,
            'is_deletable' => false,
        ]);
    }

    public function test_legacy_platform_permissions_migrate_to_canonical_assignments(): void
    {
        $legacyView = Permission::query()->create(['name' => 'platform.roles.view', 'guard_name' => 'web']);
        $legacyManage = Permission::query()->create(['name' => 'platform.roles.manage', 'guard_name' => 'web']);
        $legacyNotifications = Permission::query()->create(['name' => 'platform.notifications.view', 'guard_name' => 'web']);
        $legacySettingsView = Permission::query()->create(['name' => 'platform.settings.view', 'guard_name' => 'web']);
        $legacySettingsManage = Permission::query()->create(['name' => 'platform.settings.manage', 'guard_name' => 'web']);

        $role = Role::query()->create(['name' => 'legacy_role_owner', 'guard_name' => 'web']);
        $role->givePermissionTo($legacyView, $legacyNotifications, $legacySettingsView);

        $user = User::factory()->create();
        $user->givePermissionTo($legacyManage, $legacySettingsManage);

        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $role->refresh();
        $user->refresh();

        $this->assertTrue($role->hasPermissionTo(RoleCatalog::VIEW));
        $this->assertTrue($role->hasPermissionTo(RoleCatalog::PERMISSIONS_VIEW));
        $this->assertTrue($role->hasPermissionTo(NotificationPermissions::VIEW));
        $this->assertTrue($role->hasPermissionTo(SettingsPermissions::VIEW));
        $this->assertTrue($user->hasPermissionTo(RoleCatalog::MANAGE));
        $this->assertTrue($user->hasPermissionTo(SettingsPermissions::MANAGE));

        $this->assertDatabaseMissing('permissions', ['name' => 'platform.roles.view']);
        $this->assertDatabaseMissing('permissions', ['name' => 'platform.roles.manage']);
        $this->assertDatabaseMissing('permissions', ['name' => 'platform.notifications.view']);
        $this->assertDatabaseMissing('permissions', ['name' => 'platform.settings.view']);
        $this->assertDatabaseMissing('permissions', ['name' => 'platform.settings.manage']);
    }

    public function test_legacy_role_assignments_are_merged_into_canonical_roles_idempotently(): void
    {
        Role::query()->create(['name' => 'platform_operator', 'guard_name' => 'web']);
        Role::query()->create(['name' => RoleCatalog::MANAGER, 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->assignRole('platform_operator');

        $this->seed(PlatformRolesAndPermissionsSeeder::class);
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $user->unsetRelation('roles');

        $this->assertTrue($user->hasRole(RoleCatalog::MANAGER));
        $this->assertDatabaseMissing('roles', [
            'name' => 'platform_operator',
            'guard_name' => 'web',
        ]);
    }

    public function test_roles_manage_satisfies_all_roles_abilities(): void
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $user = User::factory()->create();
        $user->givePermissionTo(RoleCatalog::MANAGE);

        foreach ([
            RoleCatalog::VIEW,
            RoleCatalog::CREATE,
            RoleCatalog::UPDATE,
            RoleCatalog::DELETE,
            RoleCatalog::PERMISSIONS_VIEW,
            RoleCatalog::MANAGE,
        ] as $ability) {
            $this->assertTrue(Gate::forUser($user)->allows($ability), "Ability [{$ability}] should be allowed.");
        }
    }

    public function test_super_admin_bypass_still_allows_unknown_abilities(): void
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $user = User::factory()->create();
        $user->assignRole(RoleCatalog::SUPER_ADMIN);

        $this->assertTrue(Gate::forUser($user)->allows('platform.anything'));
    }

    public function test_roles_index_and_permission_catalog_are_split_by_permission(): void
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $this->actingAs(User::factory()->create())
            ->get('/platform/roles')
            ->assertForbidden();

        $user = User::factory()->create();
        $user->givePermissionTo(RoleCatalog::VIEW);

        $this->actingAs($user)
            ->get('/platform/roles')
            ->assertOk()
            ->assertSee('Roles &amp; Permissions', false)
            ->assertSee(RoleCatalog::SUPER_ADMIN)
            ->assertSee(RoleCatalog::DEFAULT)
            ->assertDontSee('View notifications');

        $this->actingAs($user)
            ->get('/platform/roles/permissions')
            ->assertForbidden();

        $user->givePermissionTo(RoleCatalog::PERMISSIONS_VIEW);

        $this->actingAs($user)
            ->get('/platform/roles/permissions')
            ->assertOk()
            ->assertSee('Permission catalog')
            ->assertSee('roles.view')
            ->assertSee('View notifications');
    }

    public function test_super_admin_can_create_custom_role_with_locked_key_metadata_and_permissions(): void
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $actor = $this->superAdmin();

        $this->actingAs($actor)
            ->get('/platform/roles/create')
            ->assertOk()
            ->assertSee('data-roles-action-review-modal', false)
            ->assertSee('data-roles-action-review-operation="create"', false)
            ->assertSee('Review and create role')
            ->assertSee('data-roles-review-impact-summary', false);

        $this->actingAs($actor)
            ->post('/platform/roles', [
                'key' => 'support_lead',
                'label' => 'Support Lead',
                'description' => 'Handles support notifications.',
                'permissions' => [NotificationPermissions::VIEW],
            ])
            ->assertRedirect();

        $role = Role::findByName('support_lead');

        $this->assertTrue($role->hasPermissionTo(NotificationPermissions::VIEW));
        $this->assertDatabaseHas('role_metadata', [
            'role_id' => $role->id,
            'label' => 'Support Lead',
            'description' => 'Handles support notifications.',
            'is_system' => false,
            'is_deletable' => true,
        ]);
    }

    public function test_custom_role_key_is_locked_and_stale_assignments_are_preserved_on_update(): void
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        Permission::query()->create(['name' => 'external.legacy', 'guard_name' => 'web']);

        $actor = $this->superAdmin();
        $role = Role::query()->create(['name' => 'support_lead', 'guard_name' => 'web']);
        $role->givePermissionTo(NotificationPermissions::VIEW, 'external.legacy');

        $this->actingAs($actor)
            ->patch("/platform/roles/{$role->id}", [
                'label' => 'Support Manager',
                'description' => 'Updated support role.',
                'permissions' => ['platform.audit-logs.view'],
            ])
            ->assertRedirect();

        $role->refresh();

        $this->assertSame('support_lead', $role->name);
        $this->assertTrue($role->hasPermissionTo('platform.audit-logs.view'));
        $this->assertTrue($role->hasPermissionTo('external.legacy'));
        $this->assertFalse($role->hasPermissionTo(NotificationPermissions::VIEW));
        $this->assertDatabaseHas('role_metadata', [
            'role_id' => $role->id,
            'label' => 'Support Manager',
            'description' => 'Updated support role.',
        ]);

        $this->actingAs($actor)
            ->patch("/platform/roles/{$role->id}", [
                'key' => 'support_manager',
                'label' => 'Support Manager',
                'permissions' => ['platform.audit-logs.view'],
            ])
            ->assertSessionHasErrors('key');
    }

    public function test_create_preview_returns_table_ready_enabled_permission_rows(): void
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $preview = app(RoleMutationPreview::class)->forCreate(
            $this->superAdmin(),
            'security_lead',
            'Security Lead',
            'Reviews access changes.',
            [RoleCatalog::MANAGE, RoleCatalog::DELETE, NotificationPermissions::VIEW],
        );

        $rows = collect($preview['permissionChangeRows'])->keyBy('key');

        $this->assertSame('create', $preview['operation']);
        $this->assertSame('confirmation', $preview['variant']);
        $this->assertSame('warning', $preview['status']);
        $this->assertSame(3, $preview['subject']['permissionCountAfter']);
        $this->assertTrue($preview['subject']['isElevated']);
        $this->assertSame('enabled', $rows[RoleCatalog::MANAGE]['change']);
        $this->assertSame('Elevated', $rows[RoleCatalog::MANAGE]['accessLevel']);
        $this->assertSame('Destructive', $rows[RoleCatalog::DELETE]['accessLevel']);
        $this->assertSame('notifications', $rows[NotificationPermissions::VIEW]['moduleKey']);
        $this->assertSame('Added to role', $rows[NotificationPermissions::VIEW]['result']);
    }

    public function test_update_preview_matches_writer_permission_resolution_for_added_removed_and_stale_permissions(): void
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        Permission::query()->create(['name' => 'external.legacy', 'guard_name' => 'web']);

        $actor = $this->superAdmin();
        $role = Role::query()->create(['name' => 'support_lead', 'guard_name' => 'web']);
        $role->givePermissionTo(NotificationPermissions::VIEW, 'external.legacy');

        $requested = ['platform.audit-logs.view'];
        $resolved = app(RolePermissionResolver::class)->forUpdate($actor, $role, $requested);

        $preview = app(RoleMutationPreview::class)->forUpdate(
            $actor,
            $role,
            'Support Manager',
            'Updated support role.',
            $requested,
        );

        $rows = collect($preview['permissionChangeRows'])->keyBy('key');
        $impacts = collect($preview['impactRows'])->keyBy('impact');

        $this->assertSame('update', $preview['operation']);
        $this->assertSame('warning', $preview['status']);
        $this->assertSame('enabled', $rows['platform.audit-logs.view']['change']);
        $this->assertSame('disabled', $rows[NotificationPermissions::VIEW]['change']);
        $this->assertSame('stale', $rows['external.legacy']['change']);
        $this->assertSame('Stale', $rows['external.legacy']['accessLevel']);
        $this->assertSame('Preserved stale assignment', $rows['external.legacy']['result']);
        $this->assertTrue($impacts->has('Role label'));
        $this->assertTrue($impacts->has('Role description'));

        app(Writer::class)->update($actor, $role, 'Support Manager', 'Updated support role.', $requested);

        $this->assertSame(
            $resolved,
            $role->refresh()->permissions()->pluck('name')->sort()->values()->all(),
        );
    }

    public function test_non_super_admin_update_preview_includes_preserved_elevated_permissions(): void
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $actor = User::factory()->create();
        $actor->givePermissionTo(RoleCatalog::UPDATE);

        $role = Role::query()->create(['name' => 'security_owner', 'guard_name' => 'web']);
        $role->givePermissionTo(RoleCatalog::MANAGE, NotificationPermissions::VIEW);

        $preview = app(RoleMutationPreview::class)->forUpdate(
            $actor,
            $role,
            'Security Owner',
            null,
            [NotificationPermissions::VIEW],
        );

        $rows = collect($preview['permissionChangeRows'])->keyBy('key');

        $this->assertSame('warning', $preview['status']);
        $this->assertSame('preserved', $rows[RoleCatalog::MANAGE]['change']);
        $this->assertSame('Elevated', $rows[RoleCatalog::MANAGE]['accessLevel']);
        $this->assertSame('Preserved on role', $rows[RoleCatalog::MANAGE]['result']);
        $this->assertContains(
            RoleCatalog::MANAGE,
            app(RolePermissionResolver::class)->forUpdate($actor, $role, [NotificationPermissions::VIEW]),
        );
    }

    public function test_delete_preview_returns_blockers_for_system_assigned_and_last_manager_roles(): void
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $actor = $this->superAdmin();
        $superAdmin = Role::findByName(RoleCatalog::SUPER_ADMIN);

        $systemPreview = app(RoleMutationPreview::class)->forDelete($actor, $superAdmin);
        $systemBlockers = collect($systemPreview['blockerRows'])->pluck('blocker')->all();

        $this->assertSame('delete', $systemPreview['operation']);
        $this->assertSame('blocked', $systemPreview['variant']);
        $this->assertSame('error', $systemPreview['status']);
        $this->assertContains('System role', $systemBlockers);
        $this->assertContains('Protected role', $systemBlockers);
        $this->assertContains('Deletion disabled', $systemBlockers);
        $this->assertContains('Last role manager', $systemBlockers);

        $role = Role::query()->create(['name' => 'support_lead', 'guard_name' => 'web']);
        User::factory()->create()->assignRole($role);

        $assignedPreview = app(RoleMutationPreview::class)->forDelete($actor, $role);
        $assignedBlockers = collect($assignedPreview['blockerRows'])->pluck('blocker')->all();

        $this->assertSame('blocked', $assignedPreview['variant']);
        $this->assertContains('Assigned users', $assignedBlockers);
        $this->assertSame(1, $assignedPreview['subject']['assignedUsers']);

        $emptyRole = Role::query()->create(['name' => 'temporary_reviewer', 'guard_name' => 'web']);
        $allowedPreview = app(RoleMutationPreview::class)->forDelete($actor, $emptyRole);

        $this->assertSame('destructive', $allowedPreview['variant']);
        $this->assertSame('warning', $allowedPreview['status']);
        $this->assertSame([], $allowedPreview['blockerRows']);
        $this->assertTrue($allowedPreview['subject']['canDelete']);
    }

    public function test_system_role_permissions_can_be_edited_but_not_renamed_or_deleted(): void
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $actor = $this->superAdmin();
        $role = Role::findByName(RoleCatalog::ADMIN);

        $this->actingAs($actor)
            ->get("/platform/roles/{$role->id}/edit")
            ->assertOk()
            ->assertSee('Locked key')
            ->assertSee('data-roles-action-review-modal', false)
            ->assertSee('data-roles-action-review-operation="update"', false)
            ->assertSee('Review and save role')
            ->assertSee('data-roles-review-impact-summary', false)
            ->assertDontSee(route('roles.delete', $role, absolute: false), false);

        $this->actingAs($actor)
            ->patch("/platform/roles/{$role->id}", [
                'label' => 'Admin',
                'description' => 'Protected administrator role.',
                'permissions' => [NotificationPermissions::VIEW],
            ])
            ->assertRedirect();

        $role->refresh();

        $this->assertSame(RoleCatalog::ADMIN, $role->name);
        $this->assertTrue($role->hasPermissionTo(NotificationPermissions::VIEW));
        $this->assertFalse($role->hasPermissionTo('platform.users.view'));

        $this->actingAs($actor)
            ->delete("/platform/roles/{$role->id}")
            ->assertForbidden();
    }

    public function test_super_admin_role_is_immutable(): void
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $actor = $this->superAdmin();
        $role = Role::findByName(RoleCatalog::SUPER_ADMIN);

        $this->actingAs($actor)
            ->get("/platform/roles/{$role->id}/edit")
            ->assertForbidden();

        $this->actingAs($actor)
            ->patch("/platform/roles/{$role->id}", [
                'label' => 'Super Admin',
                'permissions' => [NotificationPermissions::VIEW],
            ])
            ->assertForbidden();
    }

    public function test_non_super_admin_cannot_assign_elevated_permissions(): void
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $actor = User::factory()->create();
        $actor->givePermissionTo(RoleCatalog::CREATE);

        $this->actingAs($actor)
            ->post('/platform/roles', [
                'key' => 'limited_manager',
                'label' => 'Limited Manager',
                'permissions' => [RoleCatalog::MANAGE],
            ])
            ->assertForbidden();

        $this->assertDatabaseMissing('roles', [
            'name' => 'limited_manager',
        ]);
    }

    public function test_custom_role_with_elevated_permissions_is_not_assignable_by_non_super_admin(): void
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $role = Role::query()->create(['name' => 'security_owner', 'guard_name' => 'web']);
        $role->givePermissionTo(RoleCatalog::MANAGE);

        $actor = User::factory()->create();
        $actor->assignRole(RoleCatalog::ADMIN);

        $this->assertFalse(app(AssignmentGuard::class)->canAssignRoles($actor, ['security_owner']));
    }

    public function test_assigned_custom_roles_cannot_be_deleted(): void
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $actor = $this->superAdmin();
        $role = Role::query()->create(['name' => 'support_lead', 'guard_name' => 'web']);
        User::factory()->create()->assignRole($role);

        $this->actingAs($actor)
            ->delete("/platform/roles/{$role->id}")
            ->assertForbidden();

        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
        ]);
    }

    public function test_unassigned_custom_roles_can_be_deleted_from_confirmation_flow(): void
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $actor = $this->superAdmin();
        $role = Role::query()->create(['name' => 'support_lead', 'guard_name' => 'web']);

        $this->actingAs($actor)
            ->get("/platform/roles/{$role->id}/delete")
            ->assertOk()
            ->assertSee('Delete Support Lead')
            ->assertSee('data-roles-action-review-modal', false)
            ->assertSee('data-roles-action-review-operation="delete"', false)
            ->assertSee('data-ui-notification-modal-variant="destructive"', false)
            ->assertSee('data-roles-review-impact-summary', false);

        $this->actingAs($actor)
            ->delete("/platform/roles/{$role->id}")
            ->assertRedirect('/platform/roles');

        $this->assertDatabaseMissing('roles', [
            'id' => $role->id,
        ]);
    }

    public function test_bootstrap_only_seeding_preserves_manual_role_permission_changes(): void
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $admin = Role::findByName(RoleCatalog::ADMIN);
        $admin->syncPermissions([NotificationPermissions::VIEW]);

        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $admin->refresh();

        $this->assertSame(
            [NotificationPermissions::VIEW],
            $admin->permissions()->pluck('name')->sort()->values()->all(),
        );
    }

    private function superAdmin(): User
    {
        $user = User::factory()->create();
        $user->assignRole(RoleCatalog::SUPER_ADMIN);

        return $user;
    }
}

