<?php

namespace Tests\Feature\Platform;

use App\Models\User;
use App\Platform\Settings\SettingsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_persists_and_reads_platform_settings(): void
    {
        $user = User::factory()->create();

        $setting = app(SettingsService::class)->put(
            groupKey: 'platform',
            key: 'timezone',
            value: 'UTC',
            updatedBy: $user->id,
        );

        $this->assertSame('UTC', app(SettingsService::class)->get('platform', 'timezone'));

        $this->assertDatabaseHas('settings', [
            'id' => $setting->id,
            'scope_type' => 'platform',
            'group_key' => 'platform',
            'key' => 'timezone',
            'updated_by' => $user->id,
        ]);
    }
}
