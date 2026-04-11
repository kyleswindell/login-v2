<?php

namespace Tests\Feature\Platform;

use App\Filament\Resources\PlatformUsers\Pages\ManagePlatformUsers;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class PlatformUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_view_platform_users_setup_page(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/setup/users')
            ->assertOk()
            ->assertSee('Platform Users Setup')
            ->assertSee('Add Staff Member')
            ->assertSee('Existing Staff')
            ->assertSee('User Settings');
    }

    public function test_super_admin_can_view_platform_users_index(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/users')
            ->assertOk()
            ->assertSee('Platform Users');
    }

    public function test_super_admin_can_view_filament_platform_users_migration_surface(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/console/platform-users')
            ->assertOk()
            ->assertSee('Platform Users');
    }

    public function test_super_admin_is_redirected_from_target_users_route_to_filament_surface(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/administration/users')
            ->assertRedirect('/console/platform-users');
    }

    public function test_filament_platform_users_surface_lists_and_searches_users(): void
    {
        $this->actingAsPlatformSuperAdmin();
        Filament::setCurrentPanel('console');

        $matchingUser = User::factory()->create([
            'name' => 'Taylor Operator',
            'first_name' => 'Taylor',
            'last_name' => 'Operator',
            'email' => 'taylor.operator@example.com',
        ]);
        $hiddenUser = User::factory()->create([
            'name' => 'Morgan Analyst',
            'first_name' => 'Morgan',
            'last_name' => 'Analyst',
            'email' => 'morgan.analyst@example.com',
        ]);

        Livewire::test(ManagePlatformUsers::class)
            ->assertCanSeeTableRecords([$matchingUser, $hiddenUser])
            ->searchTable('Taylor')
            ->assertCanSeeTableRecords([$matchingUser])
            ->assertCanNotSeeTableRecords([$hiddenUser]);
    }

    public function test_filament_platform_users_surface_can_create_users_with_roles(): void
    {
        $this->actingAsPlatformSuperAdmin();
        Filament::setCurrentPanel('console');

        Livewire::test(ManagePlatformUsers::class)
            ->mountAction('create')
            ->set('mountedActions.0.data.first_name', 'Filament')
            ->set('mountedActions.0.data.last_name', 'Operator')
            ->set('mountedActions.0.data.email', 'filament.operator@example.com')
            ->set('mountedActions.0.data.password', 'Password123!')
            ->set('mountedActions.0.data.is_active', true)
            ->set('mountedActions.0.data.is_staff_member', true)
            ->set('mountedActions.0.data.roles', ['platform_admin'])
            ->callMountedAction()
            ->assertHasNoActionErrors();

        $user = User::query()->where('email', 'filament.operator@example.com')->firstOrFail();

        $this->assertSame('Filament Operator', $user->name);
        $this->assertTrue(Hash::check('Password123!', $user->password));
        $this->assertTrue($user->is_active);
        $this->assertTrue($user->is_staff_member);
        $this->assertTrue($user->hasRole('platform_admin'));
    }

    public function test_filament_platform_users_surface_can_update_profile_status_and_roles(): void
    {
        $this->actingAsPlatformSuperAdmin();
        Filament::setCurrentPanel('console');

        $user = User::factory()->create([
            'first_name' => 'Original',
            'last_name' => 'User',
            'name' => 'Original User',
            'email' => 'original.user@example.com',
            'is_active' => true,
            'is_staff_member' => true,
        ]);
        $user->syncRoles(['platform_operator']);

        Livewire::test(ManagePlatformUsers::class)
            ->mountAction(TestAction::make('edit')->table($user))
            ->set('mountedActions.0.data.first_name', 'Updated')
            ->set('mountedActions.0.data.last_name', 'Admin')
            ->set('mountedActions.0.data.email', 'updated.admin@example.com')
            ->set('mountedActions.0.data.password', 'NewPassword123!')
            ->set('mountedActions.0.data.hourly_rate', '125.50')
            ->set('mountedActions.0.data.is_active', false)
            ->set('mountedActions.0.data.is_staff_member', false)
            ->set('mountedActions.0.data.roles', ['platform_admin'])
            ->callMountedAction()
            ->assertHasNoActionErrors();

        $user->refresh();

        $this->assertSame('Updated Admin', $user->name);
        $this->assertSame('updated.admin@example.com', $user->email);
        $this->assertTrue(Hash::check('NewPassword123!', $user->password));
        $this->assertSame('125.50', $user->hourly_rate);
        $this->assertFalse($user->is_active);
        $this->assertFalse($user->is_staff_member);
        $this->assertTrue($user->hasRole('platform_admin'));
        $this->assertFalse($user->hasRole('platform_operator'));
    }

    public function test_standard_users_cannot_access_platform_user_management(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/platform/users')
            ->assertForbidden();

        $this->actingAs($user)
            ->get('/platform/setup/users')
            ->assertForbidden();

        $this->actingAs($user)
            ->get('/console/platform-users')
            ->assertForbidden();

        $this->actingAs($user)
            ->get('/platform/administration/users')
            ->assertForbidden();
    }

    public function test_super_admin_can_create_platform_users_with_roles(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->post('/platform/users', [
            'first_name' => 'Operations',
            'last_name' => 'User',
            'email' => 'ops@example.com',
            'password' => 'Password123!',
            'is_active' => '1',
            'roles' => ['platform_admin'],
        ])->assertRedirect();

        $user = User::query()->where('email', 'ops@example.com')->firstOrFail();

        $this->assertTrue($user->is_active);
        $this->assertTrue($user->hasRole('platform_admin'));
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
            'password' => '',
            'roles' => ['platform_admin'],
        ])->assertRedirect();

        $user->refresh();

        $this->assertSame('Updated User', $user->name);
        $this->assertTrue($user->is_active);
        $this->assertTrue($user->hasRole('platform_admin'));
    }
}
