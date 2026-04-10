<?php

namespace Tests\Feature\Platform;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BroadcastChannelAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_platform_super_admin_can_authorize_their_own_notification_channel(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        $this->post('/platform/realtime/auth', [
            'channel_name' => "private-App.Models.User.{$user->id}",
            'socket_id' => '1234.5678',
        ])->assertOk();
    }

    public function test_platform_users_cannot_authorize_another_users_notification_channel(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();
        $otherUser = User::factory()->create();

        $this->post('/platform/realtime/auth', [
            'channel_name' => "private-App.Models.User.{$otherUser->id}",
            'socket_id' => '1234.5678',
        ])->assertForbidden();
    }

    public function test_standard_users_cannot_authorize_notification_channels(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/platform/realtime/auth', [
                'channel_name' => "private-App.Models.User.{$user->id}",
                'socket_id' => '1234.5678',
            ])->assertForbidden();
    }
}
