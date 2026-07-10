<?php

namespace Tests\Feature\Platform;

use App\Modules\Auth\Models\MfaRecoveryCode;
use App\Models\User;
use App\Modules\Auth\Models\UserMfaMethod;
use App\Modules\Auth\Notifications\Types as AuthNotificationTypes;
use App\Modules\Notifications\Models\Notification;
use App\Modules\Roles\Services\AssignmentGuard;
use App\Modules\Roles\Notifications\Types as RoleNotificationTypes;
use App\Modules\Roles\Services\RoleCatalog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FA\Google2FA;
use Database\Seeders\PlatformRolesAndPermissionsSeeder;
use Tests\TestCase;

class PlatformUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_deprecated_platform_users_setup_page_is_not_registered(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/setup/users')
            ->assertNotFound();
    }

    public function test_super_admin_can_view_platform_users_index(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/users')
            ->assertOk()
            ->assertSee('Platform Users');
    }

    public function test_platform_user_create_surface_uses_shared_phone_input_baseline(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/users/create')
            ->assertOk()
            ->assertSee('data-ui-phone-input', false)
            ->assertSee('placeholder="(555) 555-5555"', false);
    }

    public function test_permissioned_viewer_can_view_platform_users_index_but_not_manage_users(): void
    {
        $this->actingAsPlatformReviewer();

        $this->get('/platform/users')
            ->assertOk()
            ->assertSee('Platform Users');

        $this->get('/platform/administration/users')
            ->assertRedirect('/platform/users');

        $this->get('/platform/users/create')->assertForbidden();
    }

    public function test_super_admin_is_redirected_from_target_users_route_to_app_owned_surface(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/administration/users')
            ->assertRedirect('/platform/users');
    }

    public function test_standard_users_cannot_access_platform_user_management(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/platform/users')
            ->assertForbidden();

        $this->actingAs($user)
            ->get('/platform/administration/users')
            ->assertForbidden();
    }

    public function test_user_management_write_requests_authorize_before_validation(): void
    {
        $this->actingAsPlatformReviewer();

        $this->post('/platform/users', [
            'first_name' => 'Unauthorized',
            'last_name' => 'Create',
            'email' => 'unauthorized-create@example.com',
            'password' => 'River-Slate-47-Delta!',
            'is_active' => '1',
            'roles' => [RoleCatalog::MANAGER],
        ])->assertForbidden();

        $this->assertDatabaseMissing('users', [
            'email' => 'unauthorized-create@example.com',
        ]);
    }

    public function test_super_admin_can_create_platform_users_with_roles(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->post('/platform/users', [
            'first_name' => 'Operations',
            'last_name' => 'User',
            'email' => 'ops@example.com',
            'password' => 'River-Slate-47-Delta!',
            'phone' => '5555555555',
            'is_active' => '1',
            'roles' => [RoleCatalog::ADMIN],
        ])->assertRedirect();

        $user = User::query()->where('email', 'ops@example.com')->firstOrFail();

        $this->assertTrue($user->is_active);
        $this->assertSame('(555) 555-5555', $user->phone);
        $this->assertTrue(Hash::check('River-Slate-47-Delta!', $user->password));
        $this->assertTrue($user->hasRole(RoleCatalog::ADMIN));
    }

    public function test_super_admin_can_grant_super_admin_role(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->post('/platform/users', [
            'first_name' => 'Security',
            'last_name' => 'Owner',
            'email' => 'security.owner@example.com',
            'password' => 'River-Slate-47-Delta!',
            'is_active' => '1',
            'roles' => [RoleCatalog::SUPER_ADMIN],
        ])->assertRedirect();

        $user = User::query()->where('email', 'security.owner@example.com')->firstOrFail();

        $this->assertTrue($user->hasRole(RoleCatalog::SUPER_ADMIN));
    }

    public function test_admin_cannot_create_or_promote_super_admins(): void
    {
        $actor = $this->actingAsPlatformAdmin();

        $this->post('/platform/users', [
            'first_name' => 'Escalation',
            'last_name' => 'Attempt',
            'email' => 'escalation@example.com',
            'password' => 'River-Slate-47-Delta!',
            'is_active' => '1',
            'roles' => [RoleCatalog::SUPER_ADMIN],
        ])->assertForbidden();

        $this->assertDatabaseMissing('users', [
            'email' => 'escalation@example.com',
        ]);

        $target = User::factory()->create([
            'first_name' => 'Normal',
            'last_name' => 'User',
            'email' => 'normal.user@example.com',
        ]);
        $target->syncRoles([RoleCatalog::MANAGER]);

        $this->put("/platform/users/{$target->id}", [
            'first_name' => 'Normal',
            'last_name' => 'User',
            'email' => $target->email,
            'password' => '',
            'roles' => [RoleCatalog::SUPER_ADMIN],
        ])->assertForbidden();

        $this->assertFalse($target->fresh()->hasRole(RoleCatalog::SUPER_ADMIN));
    }

    public function test_admin_cannot_manage_existing_super_admin_account(): void
    {
        $actor = $this->actingAsPlatformAdmin();

        $target = User::factory()->create([
            'name' => 'Root Admin',
            'first_name' => 'Root',
            'last_name' => 'Admin',
            'email' => 'root.admin@example.com',
            'is_active' => true,
        ]);
        $target->syncRoles([RoleCatalog::SUPER_ADMIN]);

        $this->assertFalse(app(AssignmentGuard::class)->canManageTarget($actor, $target));

        $this->get("/platform/users/{$target->id}/edit")
            ->assertForbidden();

        $this->put("/platform/users/{$target->id}", [
            'first_name' => 'Changed',
            'last_name' => 'Admin',
            'email' => $target->email,
            'password' => '',
            'roles' => [RoleCatalog::SUPER_ADMIN],
        ])->assertForbidden();

        $this->post("/platform/users/{$target->id}/toggle-active")
            ->assertForbidden();

        $this->post("/platform/users/{$target->id}/mfa-requirement", [
            'mfa_required' => '1',
        ])->assertForbidden();

        $this->post("/platform/users/{$target->id}/mfa-reset")
            ->assertForbidden();

        $target->refresh();

        $this->assertSame('Root Admin', $target->name);
        $this->assertTrue($target->is_active);
        $this->assertTrue($target->hasRole(RoleCatalog::SUPER_ADMIN));
    }

    public function test_platform_user_password_policy_rejects_common_and_contextual_passwords(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->from('/platform/users/create')->post('/platform/users', [
            'first_name' => 'Operations',
            'last_name' => 'User',
            'email' => 'ops-common@example.com',
            'password' => 'Password123!',
            'is_active' => '1',
            'roles' => [RoleCatalog::ADMIN],
        ])->assertRedirect('/platform/users/create')
            ->assertSessionHasErrors(['password']);

        $this->from('/platform/users/create')->post('/platform/users', [
            'first_name' => 'Operations',
            'last_name' => 'User',
            'email' => 'ops-context@example.com',
            'password' => 'Operations2026!',
            'is_active' => '1',
            'roles' => [RoleCatalog::ADMIN],
        ])->assertRedirect('/platform/users/create')
            ->assertSessionHasErrors(['password']);

        $this->assertDatabaseMissing('users', [
            'email' => 'ops-common@example.com',
        ]);
        $this->assertDatabaseMissing('users', [
            'email' => 'ops-context@example.com',
        ]);
    }

    public function test_super_admin_can_update_platform_users(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $user = User::factory()->create([
            'is_active' => true,
        ]);

        $this->put("/platform/users/{$user->id}", [
            'first_name' => 'Updated',
            'last_name' => 'User',
            'email' => $user->email,
            'password' => 'NewPassword123!',
            'roles' => [RoleCatalog::ADMIN],
        ])->assertRedirect();

        $user->refresh();

        $this->assertSame('Updated User', $user->name);
        $this->assertTrue(Hash::check('NewPassword123!', $user->password));
        $this->assertTrue($user->is_active);
        $this->assertTrue($user->hasRole(RoleCatalog::ADMIN));
        $this->assertDatabaseHas('notifications', [
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'roles',
            'type_key' => RoleNotificationTypes::ASSIGNMENTS_UPDATED,
        ]);
        $this->assertDatabaseHas('notifications', [
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'auth',
            'type_key' => AuthNotificationTypes::PASSWORD_CHANGED,
        ]);
    }

    public function test_role_assignment_update_notifies_target_user_with_diff_metadata(): void
    {
        $actor = $this->actingAsPlatformSuperAdmin();
        $target = User::factory()->create([
            'first_name' => 'Target',
            'last_name' => 'User',
            'email' => 'target.user@example.com',
            'is_active' => true,
        ]);
        $target->syncRoles([RoleCatalog::USER]);

        $this->put("/platform/users/{$target->id}", [
            'first_name' => 'Target',
            'last_name' => 'User',
            'email' => $target->email,
            'password' => '',
            'roles' => [RoleCatalog::ADMIN],
        ])->assertRedirect();

        $notification = Notification::query()
            ->where('notifiable_type', User::class)
            ->where('notifiable_id', $target->id)
            ->where('type_key', RoleNotificationTypes::ASSIGNMENTS_UPDATED)
            ->firstOrFail();

        $this->assertSame('roles', $notification->module_key);
        $this->assertSame($actor->id, $notification->metadata['actor_user_id']);
        $this->assertSame([RoleCatalog::ADMIN], $notification->metadata['data']['added_roles']);
        $this->assertSame([RoleCatalog::USER], $notification->metadata['data']['removed_roles']);
    }

    public function test_unchanged_role_assignment_does_not_notify_target_user(): void
    {
        $this->actingAsPlatformSuperAdmin();
        $target = User::factory()->create([
            'first_name' => 'Stable',
            'last_name' => 'User',
            'email' => 'stable.user@example.com',
            'is_active' => true,
        ]);
        $target->syncRoles([RoleCatalog::ADMIN]);

        $this->put("/platform/users/{$target->id}", [
            'first_name' => 'Stable',
            'last_name' => 'User',
            'email' => $target->email,
            'password' => '',
            'roles' => [RoleCatalog::ADMIN],
        ])->assertRedirect();

        $this->assertDatabaseMissing('notifications', [
            'notifiable_type' => User::class,
            'notifiable_id' => $target->id,
            'type_key' => RoleNotificationTypes::ASSIGNMENTS_UPDATED,
        ]);
    }

    public function test_super_admin_can_toggle_user_mfa_requirement(): void
    {
        $actor = $this->actingAsPlatformSuperAdmin();
        $user = User::factory()->create();

        $this->post("/platform/users/{$user->id}/mfa-requirement", [
            'mfa_required' => '1',
        ])->assertRedirect();

        $policy = $user->fresh()->mfaPolicy()->firstOrFail();

        $this->assertTrue($policy->mfa_required);
        $this->assertNotNull($policy->required_at);
        $this->assertSame($actor->id, $policy->required_by_user_id);
        $this->assertSame($actor->id, $policy->updated_by_user_id);

        $this->assertDatabaseHas('platform_audit_logs', [
            'event_type' => 'auth.mfa_requirement_updated',
            'actor_user_id' => $actor->id,
            'subject_type' => User::class,
            'subject_id' => (string) $user->id,
            'is_security_event' => true,
        ]);

        $this->post("/platform/users/{$user->id}/mfa-requirement", [
            'mfa_required' => '0',
        ])->assertRedirect();

        $policy->refresh();

        $this->assertFalse($policy->mfa_required);
        $this->assertNull($policy->required_at);
        $this->assertNull($policy->required_by_user_id);
        $this->assertSame($actor->id, $policy->updated_by_user_id);
    }

    public function test_super_admin_can_reset_user_mfa_enrollment(): void
    {
        $actor = $this->actingAsPlatformSuperAdmin();
        $user = User::factory()->create();

        $method = UserMfaMethod::query()->create([
            'user_id' => $user->id,
            'type' => UserMfaMethod::TYPE_TOTP,
            'secret' => (new Google2FA())->generateSecretKey(),
            'pending_secret' => (new Google2FA())->generateSecretKey(),
            'pending_secret_expires_at' => now()->addMinutes(15),
            'confirmed_at' => now(),
            'last_challenged_at' => now(),
            'last_satisfied_at' => now(),
        ]);

        MfaRecoveryCode::query()->create([
            'user_id' => $user->id,
            'code_hash' => Hash::make('recovery-code'),
        ]);

        $this->post("/platform/users/{$user->id}/mfa-reset")
            ->assertRedirect();

        $method->refresh();

        $this->assertNull($method->secret);
        $this->assertNull($method->pending_secret);
        $this->assertNull($method->pending_secret_expires_at);
        $this->assertNull($method->confirmed_at);
        $this->assertNull($method->last_challenged_at);
        $this->assertNull($method->last_satisfied_at);
        $this->assertNotNull($method->reset_at);
        $this->assertSame($actor->id, $method->reset_by_user_id);
        $this->assertDatabaseMissing('mfa_recovery_codes', [
            'user_id' => $user->id,
        ]);
        $this->assertDatabaseHas('platform_audit_logs', [
            'event_type' => 'auth.mfa_reset',
            'actor_user_id' => $actor->id,
            'subject_type' => User::class,
            'subject_id' => (string) $user->id,
            'is_security_event' => true,
        ]);
        $this->assertDatabaseHas('notifications', [
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'auth',
            'type_key' => AuthNotificationTypes::MFA_RESET,
        ]);
    }

    public function test_super_admin_self_mfa_reset_clears_current_session_assurance(): void
    {
        $actor = $this->actingAsPlatformSuperAdmin();

        UserMfaMethod::query()->create([
            'user_id' => $actor->id,
            'type' => UserMfaMethod::TYPE_TOTP,
            'secret' => (new Google2FA())->generateSecretKey(),
            'confirmed_at' => now(),
        ]);

        $satisfied = [
            'user_id' => $actor->id,
            'satisfied_at' => now()->timestamp,
        ];

        $this->withSession([
            'mfa.satisfied' => $satisfied,
            'mfa.step_up_satisfied_at' => $satisfied,
        ])->post("/platform/users/{$actor->id}/mfa-reset")
            ->assertRedirect()
            ->assertSessionMissing('mfa.satisfied')
            ->assertSessionMissing('mfa.step_up_satisfied_at');

        $this->assertDatabaseHas('platform_audit_logs', [
            'event_type' => 'auth.mfa_reset',
            'actor_user_id' => $actor->id,
            'subject_type' => User::class,
            'subject_id' => (string) $actor->id,
            'is_security_event' => true,
        ]);
    }

    public function test_reviewer_and_standard_user_cannot_manage_user_mfa_controls(): void
    {
        $target = User::factory()->create();

        $this->actingAsPlatformReviewer();

        $this->post("/platform/users/{$target->id}/mfa-requirement", [
            'mfa_required' => '1',
        ])->assertForbidden();

        $this->post("/platform/users/{$target->id}/mfa-reset")
            ->assertForbidden();

        $standardUser = User::factory()->create();

        $this->actingAs($standardUser)
            ->post("/platform/users/{$target->id}/mfa-requirement", [
                'mfa_required' => '1',
            ])->assertForbidden();

        $this->actingAs($standardUser)
            ->post("/platform/users/{$target->id}/mfa-reset")
            ->assertForbidden();
    }

    private function actingAsPlatformAdmin(): User
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $user = User::factory()->create();
        $user->syncRoles([RoleCatalog::ADMIN]);
        $this->actingAs($user);

        return $user;
    }
}
