<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\Models\Role;

abstract class TestCase extends BaseTestCase
{
    protected function actingAsPlatformSuperAdmin(?User $user = null): User
    {
        $user ??= User::factory()->create();

        Role::query()->firstOrCreate([
            'name' => 'platform_super_admin',
            'guard_name' => 'web',
        ]);

        $user->syncRoles(['platform_super_admin']);
        $this->actingAs($user);

        return $user;
    }
}
