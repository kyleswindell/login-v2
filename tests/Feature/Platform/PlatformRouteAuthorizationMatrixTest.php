<?php

namespace Tests\Feature\Platform;

use App\Models\CentralErrorLog;
use App\Modules\Auth\Models\MfaRecoveryCode;
use App\Models\PlatformAuditLog;
use App\Models\SecurityRequirement;
use App\Models\User;
use App\Modules\Auth\Models\UserMfaMethod;
use App\Core\Modules\Repository;
use App\Modules\Notifications\Models\Notification;
use App\Modules\Notifications\Services\NotificationPermissions;
use App\Modules\Roles\Services\PermissionCatalog;
use App\Modules\Roles\Services\RoleCatalog;
use App\Modules\Settings\Services\SettingsPermissions;
use App\Modules\Settings\Services\Store;
use App\Modules\Setup\Services\SetupPermissions;
use Database\Seeders\PlatformRolesAndPermissionsSeeder;
use Database\Seeders\SecurityRequirementSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Testing\TestResponse;
use Spatie\Permission\Models\Role as SpatieRole;
use Tests\TestCase;

class PlatformRouteAuthorizationMatrixTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_from_authenticated_platform_route_families(): void
    {
        $targetUser = User::factory()->create();
        $auditLog = $this->auditLog();
        $errorLog = $this->errorLog();
        $requirement = $this->securityRequirement();
        $notification = $this->notification($targetUser);
        $role = SpatieRole::query()->create([
            'name' => 'guest_matrix_role',
            'guard_name' => 'web',
        ]);

        foreach ($this->guestProtectedRoutes($targetUser, $auditLog, $errorLog, $requirement, $notification, $role) as $route) {
            $response = $this->requestRoute($route);

            $response->assertRedirect('/login');
        }
    }

    public function test_platform_view_route_matrix_enforces_expected_permissions(): void
    {
        $targetUser = User::factory()->create();
        $auditLog = $this->auditLog();
        $errorLog = $this->errorLog();
        $requirement = $this->securityRequirement();

        foreach ($this->viewRouteMatrix($targetUser, $auditLog, $errorLog, $requirement) as $route) {
            $this->actingAs(User::factory()->create());
            $this->requestRoute($route)->assertForbidden();

            $this->actingAsPermissionedUser($route['permission']);
            $response = $this->requestRoute($route);

            $this->assertAllowedResponse($response, $route);

            if (isset($route['assert'])) {
                $route['assert']($response);
            }
        }
    }

    public function test_platform_manage_route_matrix_blocks_view_only_users(): void
    {
        $targetUser = User::factory()->create([
            'name' => 'Matrix Target',
            'first_name' => 'Matrix',
            'last_name' => 'Target',
            'email' => 'matrix.target@example.com',
        ]);
        $requirement = $this->securityRequirement();

        foreach ($this->manageRouteMatrix($targetUser, $requirement) as $route) {
            $this->actingAsPermissionedUser($route['view_permission']);

            if (isset($route['before'])) {
                $route['before']();
            }

            $this->requestRoute($route)->assertForbidden();

            if (isset($route['deny_assert'])) {
                $route['deny_assert']();
            }
        }
    }

    public function test_platform_manage_route_matrix_allows_manage_permissions(): void
    {
        $targetUser = User::factory()->create([
            'name' => 'Matrix Target',
            'first_name' => 'Matrix',
            'last_name' => 'Target',
            'email' => 'matrix.target@example.com',
        ]);
        $requirement = $this->securityRequirement();

        foreach ($this->manageRouteMatrix($targetUser, $requirement) as $route) {
            $this->actingAsPermissionedUser($route['manage_permission']);

            if (isset($route['before'])) {
                $route['before']();
            }

            $response = $this->requestRoute($route);

            $this->assertAllowedResponse($response, $route);

            if (isset($route['assert'])) {
                $route['assert']($response);
            }
        }
    }

    public function test_notification_mutating_routes_require_notification_permission_and_ownership(): void
    {
        $owner = User::factory()->create(['is_active' => true]);
        $otherUser = User::factory()->create(['is_active' => true]);
        $ownedReadNotification = $this->notification($owner);
        $ownedDismissNotification = $this->notification($owner);
        $ownedMarkAllNotification = $this->notification($owner);
        $otherNotification = $this->notification($otherUser);

        $this->actingAs(User::factory()->create(['is_active' => true]))
            ->post('/notifications/mark-all-read')
            ->assertForbidden();

        $this->assertNull($ownedMarkAllNotification->fresh()->read_at);

        $this->post("/notifications/{$ownedReadNotification->id}/read")
            ->assertForbidden();

        $this->assertNull($ownedReadNotification->fresh()->read_at);

        $this->post("/notifications/{$ownedDismissNotification->id}/dismiss")
            ->assertForbidden();

        $this->assertNull($ownedDismissNotification->fresh()->dismissed_at);

        $this->seed(PlatformRolesAndPermissionsSeeder::class);
        $owner->givePermissionTo(NotificationPermissions::VIEW);

        $this->actingAs($owner)
            ->post("/notifications/{$ownedReadNotification->id}/read")
            ->assertRedirect();

        $this->assertNotNull($ownedReadNotification->fresh()->read_at);

        $this->actingAs($owner)
            ->post("/notifications/{$ownedDismissNotification->id}/dismiss")
            ->assertRedirect();

        $this->assertNotNull($ownedDismissNotification->fresh()->dismissed_at);

        $this->actingAs($owner)
            ->post('/notifications/mark-all-read')
            ->assertRedirect();

        $this->assertNotNull($ownedMarkAllNotification->fresh()->read_at);
        $this->assertNull($otherNotification->fresh()->read_at);

        $this->actingAs($owner)
            ->post("/notifications/{$otherNotification->id}/dismiss")
            ->assertNotFound();

        $this->assertNull($otherNotification->fresh()->dismissed_at);
    }

    public function test_platform_mutating_route_inventory_is_covered_by_matrix_or_explicit_evidence(): void
    {
        $actualRoutes = collect(Route::getRoutes())
            ->flatMap(function (\Illuminate\Routing\Route $route): array {
                $uri = $this->normalizeRouteUri($route->uri());

                if (! str_starts_with($uri, 'platform/') && ! str_starts_with($uri, 'notifications')) {
                    return [];
                }

                return collect($route->methods())
                    ->filter(fn (string $method): bool => in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'], true))
                    ->map(fn (string $method): string => "{$method} {$uri}")
                    ->all();
            })
            ->sort()
            ->values();

        $coveredRoutes = collect($this->platformMutatingRouteInventory())
            ->merge($this->platformMutatingRoutesCoveredOutsideMatrix())
            ->sort()
            ->values();

        $this->assertSame([], $actualRoutes->diff($coveredRoutes)->values()->all());
        $this->assertSame([], $coveredRoutes->diff($actualRoutes)->values()->all());
    }

    public function test_route_matrix_permissions_have_structured_module_definitions(): void
    {
        $targetUser = User::factory()->create();
        $auditLog = $this->auditLog();
        $errorLog = $this->errorLog();
        $requirement = $this->securityRequirement();
        $definitions = collect(app(PermissionCatalog::class)->definitions())->keyBy('key');
        $registry = app(Repository::class);

        $permissions = collect($this->viewRouteMatrix($targetUser, $auditLog, $errorLog, $requirement))
            ->pluck('permission')
            ->merge(collect($this->manageRouteMatrix($targetUser, $requirement))
                ->flatMap(fn (array $route): array => [
                    $route['view_permission'],
                    $route['manage_permission'],
                ]))
            ->unique()
            ->sort()
            ->values();

        $this->assertNotEmpty($permissions);

        foreach ($permissions as $permission) {
            $this->assertTrue($definitions->has($permission), "Route matrix permission [{$permission}] must have structured metadata.");
            $this->assertCount(1, $registry->ownersForPermission($permission), "Route matrix permission [{$permission}] must have exactly one module owner.");
        }
    }

    public function test_account_and_mfa_self_service_routes_are_authenticated_not_platform_permission_gated(): void
    {
        $user = User::factory()->create([
            'name' => 'Account Matrix User',
            'email' => 'account.matrix@example.com',
        ]);

        foreach ($this->accountRouteMatrix($user) as $route) {
            $this->requestRoute($route)->assertRedirect('/login');
        }

        foreach ($this->accountRouteMatrix($user) as $route) {
            $this->actingAs($user);

            $response = $this->requestRoute($route);

            $this->assertAllowedResponse($response, $route);
        }
    }

    public function test_broadcast_auth_is_limited_to_notification_viewers_own_channels(): void
    {
        $viewer = $this->actingAsPermissionedUser(NotificationPermissions::VIEW);
        $otherUser = User::factory()->create();

        $this->post('/notifications/realtime/auth', [
            'channel_name' => "private-App.Models.User.{$viewer->id}",
            'socket_id' => '1234.5678',
        ])->assertOk();

        $this->post('/platform/realtime/auth', [
            'channel_name' => "private-App.Models.User.{$viewer->id}",
            'socket_id' => '1234.5678',
        ])->assertOk();

        $this->post('/notifications/realtime/auth', [
            'channel_name' => "private-App.Models.User.{$otherUser->id}",
            'socket_id' => '1234.5678',
        ])->assertForbidden();

        $standardUser = User::factory()->create();

        $this->actingAs($standardUser)
            ->post('/notifications/realtime/auth', [
                'channel_name' => "private-App.Models.User.{$standardUser->id}",
                'socket_id' => '1234.5678',
            ])->assertForbidden();
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function guestProtectedRoutes(
        User $targetUser,
        PlatformAuditLog $auditLog,
        CentralErrorLog $errorLog,
        SecurityRequirement $requirement,
        Notification $notification,
        SpatieRole $role,
    ): array {
        return [
            ['method' => 'get', 'url' => '/dashboard'],
            ['method' => 'post', 'url' => '/notifications/realtime/auth'],
            ['method' => 'post', 'url' => '/platform/realtime/auth'],
            ['method' => 'get', 'url' => '/account'],
            ['method' => 'get', 'url' => '/account/settings'],
            ['method' => 'patch', 'url' => '/account/details'],
            ['method' => 'patch', 'url' => '/account/profile-photo'],
            ['method' => 'delete', 'url' => '/account/profile-photo'],
            ['method' => 'post', 'url' => '/account/contact-emails'],
            ['method' => 'delete', 'url' => '/account/contact-emails/1'],
            ['method' => 'post', 'url' => '/account/password'],
            ['method' => 'post', 'url' => '/account/settings'],
            ['method' => 'get', 'url' => '/account/notifications'],
            ['method' => 'post', 'url' => '/account/notifications'],
            ['method' => 'get', 'url' => '/mfa/step-up'],
            ['method' => 'post', 'url' => '/mfa/step-up'],
            ['method' => 'get', 'url' => '/account/mfa/enroll'],
            ['method' => 'post', 'url' => '/account/mfa/enroll'],
            ['method' => 'get', 'url' => '/platform/users'],
            ['method' => 'post', 'url' => '/platform/users'],
            ['method' => 'put', 'url' => "/platform/users/{$targetUser->id}"],
            ['method' => 'post', 'url' => "/platform/users/{$targetUser->id}/toggle-active"],
            ['method' => 'post', 'url' => "/platform/users/{$targetUser->id}/mfa-requirement"],
            ['method' => 'post', 'url' => "/platform/users/{$targetUser->id}/mfa-reset"],
            ['method' => 'get', 'url' => '/platform/roles'],
            ['method' => 'get', 'url' => '/platform/roles/permissions'],
            ['method' => 'get', 'url' => '/platform/roles/create'],
            ['method' => 'post', 'url' => '/platform/roles'],
            ['method' => 'get', 'url' => "/platform/roles/{$role->id}"],
            ['method' => 'get', 'url' => "/platform/roles/{$role->id}/edit"],
            ['method' => 'get', 'url' => "/platform/roles/{$role->id}/delete"],
            ['method' => 'patch', 'url' => "/platform/roles/{$role->id}"],
            ['method' => 'delete', 'url' => "/platform/roles/{$role->id}"],
            ['method' => 'get', 'url' => '/settings'],
            ['method' => 'get', 'url' => '/platform/settings'],
            ['method' => 'get', 'url' => '/platform/settings/general'],
            ['method' => 'post', 'url' => '/platform/settings/general'],
            ['method' => 'post', 'url' => '/platform/settings/general/company-information'],
            ['method' => 'post', 'url' => '/platform/settings/general/localization'],
            ['method' => 'post', 'url' => '/platform/settings/general/email'],
            ['method' => 'post', 'url' => '/platform/settings/general/system-update'],
            ['method' => 'post', 'url' => '/platform/settings/notifications'],
            ['method' => 'post', 'url' => '/platform/settings/audit-logs'],
            ['method' => 'post', 'url' => '/platform/settings/docs'],
            ['method' => 'post', 'url' => '/platform/settings/users'],
            ['method' => 'get', 'url' => '/platform/security'],
            ['method' => 'patch', 'url' => "/platform/security/{$requirement->slug}"],
            ['method' => 'get', 'url' => '/notifications'],
            ['method' => 'post', 'url' => '/notifications/mark-all-read'],
            ['method' => 'post', 'url' => "/notifications/{$notification->id}/read"],
            ['method' => 'post', 'url' => "/notifications/{$notification->id}/dismiss"],
            ['method' => 'get', 'url' => '/platform/notifications'],
            ['method' => 'post', 'url' => '/platform/notifications/mark-all-read'],
            ['method' => 'post', 'url' => "/platform/notifications/{$notification->id}/read"],
            ['method' => 'post', 'url' => "/platform/notifications/{$notification->id}/dismiss"],
            ['method' => 'get', 'url' => '/platform/audit-logs'],
            ['method' => 'get', 'url' => "/platform/audit-logs/{$auditLog->id}"],
            ['method' => 'get', 'url' => '/platform/error-logs'],
            ['method' => 'get', 'url' => "/platform/error-logs/{$errorLog->id}"],
            ['method' => 'get', 'url' => '/platform/docs'],
            ['method' => 'post', 'url' => '/logout'],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function viewRouteMatrix(
        User $targetUser,
        PlatformAuditLog $auditLog,
        CentralErrorLog $errorLog,
        SecurityRequirement $requirement,
    ): array {
        $role = SpatieRole::query()->firstOrCreate([
            'name' => 'view_matrix_role',
            'guard_name' => 'web',
        ]);

        return [
            ['method' => 'get', 'url' => '/platform/users', 'permission' => 'platform.users.view'],
            ['method' => 'get', 'url' => '/platform/users/create', 'permission' => 'platform.users.manage'],
            ['method' => 'get', 'url' => "/platform/users/{$targetUser->id}/edit", 'permission' => 'platform.users.manage'],
            ['method' => 'get', 'url' => '/platform/administration/users', 'permission' => 'platform.users.view', 'redirect' => '/platform/users'],
            ['method' => 'get', 'url' => '/platform/setup', 'permission' => SetupPermissions::VIEW],
            ['method' => 'get', 'url' => '/platform/setup/notifications', 'permission' => NotificationPermissions::VIEW],
            ['method' => 'get', 'url' => '/platform/roles', 'permission' => RoleCatalog::VIEW],
            ['method' => 'get', 'url' => '/platform/roles/permissions', 'permission' => RoleCatalog::PERMISSIONS_VIEW],
            ['method' => 'get', 'url' => '/platform/roles/create', 'permission' => RoleCatalog::CREATE],
            ['method' => 'get', 'url' => "/platform/roles/{$role->id}", 'permission' => RoleCatalog::VIEW],
            ['method' => 'get', 'url' => "/platform/roles/{$role->id}/edit", 'permission' => RoleCatalog::UPDATE],
            ['method' => 'get', 'url' => "/platform/roles/{$role->id}/delete", 'permission' => RoleCatalog::DELETE],
            ['method' => 'get', 'url' => '/settings', 'permission' => SettingsPermissions::VIEW],
            ['method' => 'get', 'url' => '/platform/settings', 'permission' => SettingsPermissions::VIEW],
            ['method' => 'get', 'url' => '/platform/settings/general', 'permission' => SettingsPermissions::VIEW, 'redirect' => '/settings'],
            ['method' => 'get', 'url' => '/platform/settings/general/company-information', 'permission' => SettingsPermissions::VIEW, 'redirect' => '/settings'],
            ['method' => 'get', 'url' => '/platform/settings/general/system-server-info', 'permission' => SettingsPermissions::VIEW, 'redirect' => '/settings'],
            ['method' => 'get', 'url' => '/platform/administration/settings', 'permission' => SettingsPermissions::VIEW, 'redirect' => '/settings'],
            ['method' => 'get', 'url' => '/platform/security', 'permission' => 'platform.security-checklist.view'],
            ['method' => 'get', 'url' => "/platform/security/{$requirement->slug}", 'permission' => 'platform.security-checklist.view'],
            ['method' => 'get', 'url' => '/notifications', 'permission' => NotificationPermissions::VIEW],
            ['method' => 'get', 'url' => '/platform/notifications', 'permission' => NotificationPermissions::VIEW],
            ['method' => 'get', 'url' => '/platform/administration/notifications', 'permission' => NotificationPermissions::VIEW, 'redirect' => '/notifications'],
            ['method' => 'get', 'url' => '/platform/audit-logs', 'permission' => 'platform.audit-logs.view'],
            ['method' => 'get', 'url' => "/platform/audit-logs/{$auditLog->id}", 'permission' => 'platform.audit-logs.view'],
            ['method' => 'get', 'url' => '/platform/operations/audit-logs', 'permission' => 'platform.audit-logs.view', 'redirect' => '/platform/audit-logs'],
            ['method' => 'get', 'url' => '/platform/error-logs', 'permission' => 'platform.error-logs.view'],
            ['method' => 'get', 'url' => "/platform/error-logs/{$errorLog->id}", 'permission' => 'platform.error-logs.view'],
            ['method' => 'get', 'url' => '/platform/operations/error-logs', 'permission' => 'platform.error-logs.view', 'redirect' => '/platform/error-logs'],
            ['method' => 'get', 'url' => '/platform/docs', 'permission' => 'platform.docs.view'],
            // Retired rendered-evidence routes are intentionally absent from the
            // core workspace authorization matrix.
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function manageRouteMatrix(User $targetUser, SecurityRequirement $requirement): array
    {
        $roleToUpdate = SpatieRole::query()->create([
            'name' => 'matrix_role_update',
            'guard_name' => 'web',
        ]);

        $roleToDelete = SpatieRole::query()->create([
            'name' => 'matrix_role_delete',
            'guard_name' => 'web',
        ]);

        return [
            [
                'method' => 'post',
                'url' => '/platform/users',
                'view_permission' => 'platform.users.view',
                'manage_permission' => 'platform.users.manage',
                'payload' => [
                    'first_name' => 'Created',
                    'last_name' => 'Matrix',
                    'email' => 'created.matrix@example.com',
                    'password' => 'River-Slate-47-Delta!',
                    'is_active' => '1',
                    'roles' => [RoleCatalog::MANAGER],
                ],
                'allowed_statuses' => [302],
                'assert' => function (TestResponse $response): void {
                    $user = User::query()->where('email', 'created.matrix@example.com')->firstOrFail();

                    $response
                        ->assertSessionHasNoErrors()
                        ->assertRedirect(route('platform.users.edit', $user, absolute: false));

                    $this->assertSame('Created Matrix', $user->name);
                    $this->assertTrue($user->hasRole(RoleCatalog::MANAGER));
                },
                'deny_assert' => function (): void {
                    $this->assertDatabaseMissing('users', [
                        'email' => 'created.matrix@example.com',
                    ]);
                },
            ],
            [
                'method' => 'put',
                'url' => "/platform/users/{$targetUser->id}",
                'view_permission' => 'platform.users.view',
                'manage_permission' => 'platform.users.manage',
                'payload' => [
                    'first_name' => 'Updated',
                    'last_name' => 'Matrix',
                    'email' => $targetUser->email,
                    'password' => '',
                    'roles' => [RoleCatalog::MANAGER],
                ],
                'allowed_statuses' => [302],
                'assert' => function (TestResponse $response) use ($targetUser): void {
                    $response
                        ->assertSessionHasNoErrors()
                        ->assertRedirect(route('platform.users.edit', $targetUser, absolute: false));

                    $targetUser->refresh();

                    $this->assertSame('Updated Matrix', $targetUser->name);
                    $this->assertTrue($targetUser->hasRole(RoleCatalog::MANAGER));
                },
                'deny_assert' => function () use ($targetUser): void {
                    $targetUser->refresh();

                    $this->assertSame('Matrix Target', $targetUser->name);
                    $this->assertFalse($targetUser->hasRole(RoleCatalog::MANAGER));
                },
            ],
            [
                'method' => 'patch',
                'url' => "/platform/users/{$targetUser->id}",
                'view_permission' => 'platform.users.view',
                'manage_permission' => 'platform.users.manage',
                'payload' => [
                    'first_name' => 'Patched',
                    'last_name' => 'Matrix',
                    'email' => $targetUser->email,
                    'password' => '',
                    'roles' => [RoleCatalog::MANAGER],
                ],
                'allowed_statuses' => [302],
                'assert' => function (TestResponse $response) use ($targetUser): void {
                    $response
                        ->assertSessionHasNoErrors()
                        ->assertRedirect(route('platform.users.edit', $targetUser, absolute: false));

                    $targetUser->refresh();

                    $this->assertSame('Patched Matrix', $targetUser->name);
                    $this->assertTrue($targetUser->hasRole(RoleCatalog::MANAGER));
                },
                'deny_assert' => function () use ($targetUser): void {
                    $targetUser->refresh();

                    $this->assertSame('Matrix Target', $targetUser->name);
                    $this->assertFalse($targetUser->hasRole(RoleCatalog::MANAGER));
                },
            ],
            [
                'method' => 'post',
                'url' => "/platform/users/{$targetUser->id}/toggle-active",
                'view_permission' => 'platform.users.view',
                'manage_permission' => 'platform.users.manage',
                'allowed_statuses' => [302],
                'assert' => function (TestResponse $response) use ($targetUser): void {
                    $response->assertSessionHasNoErrors();
                    $this->assertFalse($targetUser->fresh()->is_active);
                },
                'deny_assert' => function () use ($targetUser): void {
                    $this->assertTrue($targetUser->fresh()->is_active);
                },
            ],
            [
                'method' => 'post',
                'url' => "/platform/users/{$targetUser->id}/mfa-requirement",
                'view_permission' => 'platform.users.view',
                'manage_permission' => 'platform.users.manage',
                'payload' => ['mfa_required' => '1'],
                'allowed_statuses' => [302],
                'assert' => function (TestResponse $response) use ($targetUser): void {
                    $response->assertSessionHasNoErrors();

                    $policy = $targetUser->fresh()->mfaPolicy()->firstOrFail();

                    $this->assertTrue($policy->mfa_required);
                },
                'deny_assert' => function () use ($targetUser): void {
                    $this->assertNull($targetUser->fresh()->mfaPolicy()->first());
                },
            ],
            [
                'method' => 'post',
                'url' => "/platform/users/{$targetUser->id}/mfa-reset",
                'view_permission' => 'platform.users.view',
                'manage_permission' => 'platform.users.manage',
                'allowed_statuses' => [302],
                'before' => function () use ($targetUser): void {
                    UserMfaMethod::query()->updateOrCreate([
                        'user_id' => $targetUser->id,
                        'type' => UserMfaMethod::TYPE_TOTP,
                    ], [
                        'secret' => 'matrix-secret',
                        'pending_secret' => 'matrix-pending-secret',
                        'pending_secret_expires_at' => now()->addMinutes(15),
                        'confirmed_at' => now(),
                        'last_challenged_at' => now(),
                        'last_satisfied_at' => now(),
                    ]);

                    MfaRecoveryCode::query()->create([
                        'user_id' => $targetUser->id,
                        'code_hash' => Hash::make('matrix-recovery-code'),
                    ]);
                },
                'assert' => function (TestResponse $response) use ($targetUser): void {
                    $response->assertSessionHasNoErrors();

                    $method = $targetUser->fresh()->totpMfaMethod()->firstOrFail();

                    $this->assertNull($method->secret);
                    $this->assertNull($method->pending_secret);
                    $this->assertNull($method->pending_secret_expires_at);
                    $this->assertNotNull($method->reset_at);
                    $this->assertDatabaseMissing('mfa_recovery_codes', [
                        'user_id' => $targetUser->id,
                    ]);
                },
                'deny_assert' => function () use ($targetUser): void {
                    $method = $targetUser->fresh()->totpMfaMethod()->firstOrFail();

                    $this->assertNotNull($method->secret);
                    $this->assertNotNull($method->pending_secret);
                    $this->assertNotNull($method->pending_secret_expires_at);
                    $this->assertNull($method->reset_at);
                    $this->assertDatabaseHas('mfa_recovery_codes', [
                        'user_id' => $targetUser->id,
                    ]);
                },
            ],
            [
                'method' => 'post',
                'url' => '/platform/roles',
                'view_permission' => RoleCatalog::VIEW,
                'manage_permission' => RoleCatalog::CREATE,
                'payload' => [
                    'key' => 'matrix_created_role',
                    'label' => 'Matrix Created Role',
                    'description' => 'Matrix-created role.',
                    'permissions' => [NotificationPermissions::VIEW],
                ],
                'allowed_statuses' => [302],
                'assert' => function (TestResponse $response): void {
                    $role = SpatieRole::query()->where('name', 'matrix_created_role')->firstOrFail();

                    $response
                        ->assertSessionHasNoErrors()
                        ->assertRedirect(route('roles.show', $role, absolute: false));

                    $this->assertTrue($role->hasPermissionTo(NotificationPermissions::VIEW));
                },
                'deny_assert' => function (): void {
                    $this->assertDatabaseMissing('roles', [
                        'name' => 'matrix_created_role',
                    ]);
                },
            ],
            [
                'method' => 'patch',
                'url' => "/platform/roles/{$roleToUpdate->id}",
                'view_permission' => RoleCatalog::VIEW,
                'manage_permission' => RoleCatalog::UPDATE,
                'payload' => [
                    'label' => 'Matrix Role Updated',
                    'description' => 'Updated matrix role.',
                    'permissions' => ['platform.audit-logs.view'],
                ],
                'allowed_statuses' => [302],
                'assert' => function (TestResponse $response) use ($roleToUpdate): void {
                    $roleToUpdate->refresh();

                    $response
                        ->assertSessionHasNoErrors()
                        ->assertRedirect(route('roles.show', $roleToUpdate, absolute: false));

                    $this->assertSame('matrix_role_update', $roleToUpdate->name);
                    $this->assertTrue($roleToUpdate->hasPermissionTo('platform.audit-logs.view'));
                },
                'deny_assert' => function () use ($roleToUpdate): void {
                    $this->assertSame('matrix_role_update', $roleToUpdate->fresh()->name);
                },
            ],
            [
                'method' => 'delete',
                'url' => "/platform/roles/{$roleToDelete->id}",
                'view_permission' => RoleCatalog::VIEW,
                'manage_permission' => RoleCatalog::DELETE,
                'allowed_statuses' => [302],
                'assert' => function (TestResponse $response) use ($roleToDelete): void {
                    $response
                        ->assertSessionHasNoErrors()
                        ->assertRedirect(route('roles.index', absolute: false));

                    $this->assertDatabaseMissing('roles', [
                        'id' => $roleToDelete->id,
                    ]);
                },
                'deny_assert' => function () use ($roleToDelete): void {
                    $this->assertDatabaseHas('roles', [
                        'id' => $roleToDelete->id,
                    ]);
                },
            ],
            ...$this->settingsManageRoutes(),
            [
                'method' => 'patch',
                'url' => "/platform/security/{$requirement->slug}",
                'view_permission' => 'platform.security-checklist.view',
                'manage_permission' => 'platform.security-checklist.manage',
                'payload' => [
                    'alignment_status' => SecurityRequirement::ALIGNMENT_ALIGNED,
                    'work_status' => SecurityRequirement::WORK_VALIDATED,
                ],
                'allowed_statuses' => [302],
                'assert' => function (TestResponse $response) use ($requirement): void {
                    $response
                        ->assertSessionHasNoErrors()
                        ->assertRedirect("/platform/security/{$requirement->slug}");

                    $requirement->refresh();

                    $this->assertSame(SecurityRequirement::ALIGNMENT_ALIGNED, $requirement->alignment_status);
                    $this->assertSame(SecurityRequirement::WORK_VALIDATED, $requirement->work_status);
                },
                'deny_assert' => function () use ($requirement): void {
                    $requirement->refresh();

                    $this->assertNotSame(SecurityRequirement::ALIGNMENT_ALIGNED, $requirement->alignment_status);
                    $this->assertNotSame(SecurityRequirement::WORK_VALIDATED, $requirement->work_status);
                },
            ],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function settingsManageRoutes(): array
    {
        return [
            [
                'method' => 'post',
                'url' => '/platform/settings/general',
                'view_permission' => SettingsPermissions::VIEW,
                'manage_permission' => SettingsPermissions::UPDATE,
                'payload' => [
                    'display_name' => 'Login App 2.0',
                    'timezone' => 'America/New_York',
                    'locale' => 'en',
                ],
                'allowed_statuses' => [302],
                'assert' => function (TestResponse $response): void {
                    $response->assertSessionHasNoErrors();
                    $this->assertSame('Login App 2.0', app(Store::class)->get('general', 'display_name'));
                },
                'deny_assert' => fn () => $this->assertSettingMissing('general', 'display_name'),
            ],
            [
                'method' => 'post',
                'url' => '/platform/settings/general/company-information',
                'view_permission' => SettingsPermissions::VIEW,
                'manage_permission' => SettingsPermissions::UPDATE,
                'payload' => [
                    'company_name' => 'Matrix Company',
                    'company_email' => 'matrix.company@example.com',
                    'company_phone' => '1234567890',
                    'company_address' => '123 Matrix Way',
                ],
                'allowed_statuses' => [302],
                'assert' => function (TestResponse $response): void {
                    $response->assertSessionHasNoErrors();
                    $this->assertSame('Matrix Company', app(Store::class)->get('general_company', 'name'));
                    $this->assertSame('(123) 456-7890', app(Store::class)->get('general_company', 'phone'));
                },
                'deny_assert' => fn () => $this->assertSettingMissing('general_company', 'name'),
            ],
            [
                'method' => 'post',
                'url' => '/platform/settings/general/localization',
                'view_permission' => SettingsPermissions::VIEW,
                'manage_permission' => SettingsPermissions::UPDATE,
                'payload' => [
                    'default_language' => 'en',
                    'date_format' => 'M j, Y',
                    'time_format' => 'g:i A',
                    'first_day_of_week' => 'sunday',
                ],
                'allowed_statuses' => [302],
                'assert' => function (TestResponse $response): void {
                    $response->assertSessionHasNoErrors();
                    $this->assertSame('sunday', app(Store::class)->get('general_localization', 'first_day_of_week'));
                },
                'deny_assert' => fn () => $this->assertSettingMissing('general_localization', 'first_day_of_week'),
            ],
            [
                'method' => 'post',
                'url' => '/platform/settings/general/email',
                'view_permission' => SettingsPermissions::VIEW,
                'manage_permission' => SettingsPermissions::UPDATE,
                'payload' => [
                    'from_name' => 'Matrix Mail',
                    'from_address' => 'matrix-mail@example.com',
                    'reply_to_address' => 'reply@example.com',
                    'mail_driver' => 'log',
                ],
                'allowed_statuses' => [302],
                'assert' => function (TestResponse $response): void {
                    $response->assertSessionHasNoErrors();
                    $this->assertSame('matrix-mail@example.com', app(Store::class)->get('general_email', 'from_address'));
                },
                'deny_assert' => fn () => $this->assertSettingMissing('general_email', 'from_address'),
            ],
            [
                'method' => 'post',
                'url' => '/platform/settings/general/system-update',
                'view_permission' => SettingsPermissions::VIEW,
                'manage_permission' => SettingsPermissions::UPDATE,
                'payload' => [
                    'update_channel' => 'preview',
                    'auto_check' => '0',
                    'maintenance_window' => 'saturday 01:00-02:00',
                ],
                'allowed_statuses' => [302],
                'assert' => function (TestResponse $response): void {
                    $response->assertSessionHasNoErrors();
                    $this->assertSame('preview', app(Store::class)->get('general_system_update', 'channel'));
                    $this->assertFalse(app(Store::class)->get('general_system_update', 'auto_check'));
                },
                'deny_assert' => fn () => $this->assertSettingMissing('general_system_update', 'channel'),
            ],
            [
                'method' => 'post',
                'url' => '/platform/settings/notifications',
                'view_permission' => NotificationPermissions::SETTINGS_VIEW,
                'manage_permission' => NotificationPermissions::SETTINGS_UPDATE,
                'payload' => [
                    'default_severity' => 'warning',
                    'max_per_user' => 250,
                ],
                'allowed_statuses' => [302],
                'assert' => function (TestResponse $response): void {
                    $response->assertSessionHasNoErrors();
                    $this->assertSame('warning', app(Store::class)->get('notifications', 'default_severity'));
                    $this->assertSame(250, app(Store::class)->get('notifications', 'max_per_user'));
                },
                'deny_assert' => fn () => $this->assertSettingMissing('notifications', 'default_severity'),
            ],
            [
                'method' => 'post',
                'url' => '/platform/settings/audit-logs',
                'view_permission' => SettingsPermissions::VIEW,
                'manage_permission' => SettingsPermissions::UPDATE,
                'payload' => [
                    'retention_days' => 730,
                    'login_event_severity' => 'notice',
                ],
                'allowed_statuses' => [302],
                'assert' => function (TestResponse $response): void {
                    $response->assertSessionHasNoErrors();
                    $this->assertSame(730, app(Store::class)->get('audit_logs', 'retention_days'));
                    $this->assertSame('notice', app(Store::class)->get('audit_logs', 'login_event_severity'));
                },
                'deny_assert' => fn () => $this->assertSettingMissing('audit_logs', 'retention_days'),
            ],
            [
                'method' => 'post',
                'url' => '/platform/settings/docs',
                'view_permission' => SettingsPermissions::VIEW,
                'manage_permission' => SettingsPermissions::UPDATE,
                'payload' => [
                    'access_scope' => 'super_admins_only',
                ],
                'allowed_statuses' => [302],
                'assert' => function (TestResponse $response): void {
                    $response->assertSessionHasNoErrors();
                    $this->assertSame('super_admins_only', app(Store::class)->get('docs', 'access_scope'));
                },
                'deny_assert' => fn () => $this->assertSettingMissing('docs', 'access_scope'),
            ],
            [
                'method' => 'post',
                'url' => '/platform/settings/users',
                'view_permission' => SettingsPermissions::VIEW,
                'manage_permission' => SettingsPermissions::UPDATE,
                'payload' => [
                    'default_role' => RoleCatalog::ADMIN,
                    'default_active' => '0',
                ],
                'allowed_statuses' => [302],
                'assert' => function (TestResponse $response): void {
                    $response->assertSessionHasNoErrors();
                    $this->assertSame(RoleCatalog::ADMIN, app(Store::class)->get('users', 'default_role'));
                    $this->assertFalse(app(Store::class)->get('users', 'default_active'));
                },
                'deny_assert' => fn () => $this->assertSettingMissing('users', 'default_role'),
            ],
        ];
    }

    /**
     * @return list<string>
     */
    private function platformMutatingRouteInventory(): array
    {
        return [
            'POST notifications/{notification}/dismiss',
            'POST notifications/{notification}/read',
            'POST notifications/mark-all-read',
            'POST notifications/realtime/auth',
            'PATCH platform/security/{requirement}',
            'DELETE platform/roles/{role}',
            'PATCH platform/roles/{role}',
            'POST platform/roles',
            'PATCH platform/users/{user}',
            'POST platform/notifications/{notification}/dismiss',
            'POST platform/notifications/{notification}/read',
            'POST platform/notifications/mark-all-read',
            'POST platform/settings/audit-logs',
            'POST platform/settings/docs',
            'POST platform/settings/general',
            'POST platform/settings/general/company-information',
            'POST platform/settings/general/email',
            'POST platform/settings/general/localization',
            'POST platform/settings/general/system-update',
            'POST platform/settings/notifications',
            'POST platform/settings/users',
            'POST platform/users',
            'POST platform/users/{user}/mfa-requirement',
            'POST platform/users/{user}/mfa-reset',
            'POST platform/users/{user}/toggle-active',
            'PUT platform/users/{user}',
        ];
    }

    /**
     * @return list<string>
     */
    private function platformMutatingRoutesCoveredOutsideMatrix(): array
    {
        return [
            // Covered by dedicated broadcast-channel authorization assertions.
            'POST platform/realtime/auth',
        ];
    }

    private function normalizeRouteUri(string $uri): string
    {
        return preg_replace('/\{([^}:]+):[^}]+\}/', '{$1}', $uri) ?? $uri;
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function accountRouteMatrix(User $user): array
    {
        return [
            ['method' => 'get', 'url' => '/dashboard'],
            ['method' => 'get', 'url' => '/account'],
            ['method' => 'get', 'url' => '/account/settings', 'redirect' => '/account'],
            [
                'method' => 'patch',
                'url' => '/account/details',
                'payload' => [
                    'first_name' => 'Matrix',
                    'last_name' => 'Account',
                    'name' => 'Matrix Account',
                    'phone' => '5555555555',
                ],
                'allowed_statuses' => [302],
                'assert' => function (TestResponse $response) use ($user): void {
                    $response->assertSessionHasNoErrors();

                    $user->refresh();

                    $this->assertSame('Matrix', $user->first_name);
                    $this->assertSame('Account', $user->last_name);
                    $this->assertSame('Matrix Account', $user->name);
                    $this->assertSame('(555) 555-5555', $user->phone);
                },
            ],
            ['method' => 'get', 'url' => '/account/preferences'],
            ['method' => 'get', 'url' => '/account/notifications'],
            [
                'method' => 'post',
                'url' => '/account/notifications',
                'payload' => [
                    'email_enabled' => '0',
                    'digest_frequency' => 'weekly',
                ],
                'allowed_statuses' => [302],
                'assert' => function (TestResponse $response) use ($user): void {
                    $response->assertSessionHasNoErrors();

                    $this->assertDatabaseHas('user_notification_preferences', [
                        'user_id' => $user->id,
                        'email_enabled' => false,
                        'digest_frequency' => 'weekly',
                    ]);
                },
            ],
            [
                'method' => 'post',
                'url' => '/account/preferences',
                'payload' => [
                    'timezone' => 'America/New_York',
                    'default_language' => 'en',
                    'theme_preference' => 'system',
                ],
                'allowed_statuses' => [302],
                'assert' => function (TestResponse $response) use ($user): void {
                    $response->assertSessionHasNoErrors();

                    $user->refresh();

                    $this->assertSame('America/New_York', $user->timezone);
                    $this->assertSame('en', $user->default_language);
                    $this->assertSame('system', $user->theme_preference);
                },
            ],
            [
                'method' => 'post',
                'url' => '/account/contact-emails',
                'payload' => [
                    'email' => 'matrix.contact@example.com',
                    'label' => 'Matrix',
                ],
                'allowed_statuses' => [302],
                'assert' => function (TestResponse $response) use ($user): void {
                    $response->assertSessionHasNoErrors();

                    $this->assertDatabaseHas('user_contact_emails', [
                        'user_id' => $user->id,
                        'normalized_email' => 'matrix.contact@example.com',
                    ]);
                },
            ],
            [
                'method' => 'post',
                'url' => '/account/settings',
                'payload' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => '5555555555',
                ],
                'allowed_statuses' => [302],
                'assert' => function (TestResponse $response) use ($user): void {
                    $response->assertSessionHasNoErrors();

                    $user->refresh();

                    $this->assertSame('(555) 555-5555', $user->phone);
                },
            ],
            ['method' => 'get', 'url' => '/account/mfa/enroll'],
            ['method' => 'get', 'url' => '/account/mfa/recovery-codes', 'redirect' => '/account'],
            ['method' => 'get', 'url' => '/mfa/step-up', 'redirect' => '/dashboard'],
        ];
    }

    /**
     * @param array<string, mixed> $route
     */
    private function requestRoute(array $route): TestResponse
    {
        $method = $route['method'];

        return $this->{$method}($route['url'], $route['payload'] ?? []);
    }

    /**
     * @param array<string, mixed> $route
     */
    private function assertAllowedResponse(TestResponse $response, array $route): void
    {
        if (isset($route['redirect'])) {
            $response->assertRedirect($route['redirect']);

            return;
        }

        $allowedStatuses = $route['allowed_statuses'] ?? [200];

        $this->assertContains(
            $response->getStatusCode(),
            $allowedStatuses,
            sprintf(
                'Expected [%s] for %s %s, got %s.',
                implode(', ', $allowedStatuses),
                strtoupper((string) $route['method']),
                $route['url'],
                $response->getStatusCode(),
            ),
        );
    }

    private function actingAsPermissionedUser(string $permission): User
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $user = User::factory()->create(['is_active' => true]);
        $user->givePermissionTo($permission);
        $this->actingAs($user);

        return $user;
    }

    private function auditLog(): PlatformAuditLog
    {
        return PlatformAuditLog::query()->create([
            'occurred_at' => now(),
            'event_type' => 'authorization.matrix',
            'action' => 'view',
            'result' => 'success',
            'severity' => 'info',
        ]);
    }

    private function errorLog(): CentralErrorLog
    {
        return CentralErrorLog::query()->create([
            'occurred_at' => now(),
            'environment' => 'testing',
            'service_name' => 'platform',
            'severity' => 'error',
            'message' => 'Authorization matrix error fixture.',
            'fingerprint' => hash('sha256', uniqid('authorization-matrix', true)),
            'handled' => false,
        ]);
    }

    private function notification(User $user): Notification
    {
        return Notification::query()->create([
            'uuid' => (string) fake()->uuid(),
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'platform',
            'severity' => 'info',
            'title' => 'Authorization matrix notification',
            'body' => 'Authorization matrix notification body.',
        ]);
    }

    private function assertSettingMissing(string $groupKey, string $key): void
    {
        $this->assertSame(
            '__missing__',
            app(Store::class)->get($groupKey, $key, '__missing__'),
        );
    }

    private function securityRequirement(): SecurityRequirement
    {
        $this->seed(SecurityRequirementSeeder::class);

        return SecurityRequirement::query()->where('slug', 'authorization-tenant-boundary-evidence')->firstOrFail();
    }
}
