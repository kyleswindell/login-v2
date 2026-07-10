<?php
/*
|--------------------------------------------------------------------------
| File: tests/Feature/Platform/TransientToastTest.php
| Purpose: Verify non-persistent Notifications module toast helpers.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace Tests\Feature\Platform;

use App\Models\User;
use App\Modules\Notifications\Models\Notification;
use App\Modules\Notifications\Services\TransientToasts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Tests\TestCase;

final class TransientToastTest extends TestCase
{
    use RefreshDatabase;

    public function test_transient_toasts_flash_payloads_without_persisting_notifications(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $payload = app(TransientToasts::class)->success(
            title: 'Settings saved',
            subtitle: 'Your preferences were updated.',
        );

        $this->assertSame('success', $payload['kind']);
        $this->assertSame('Settings saved', $payload['title']);
        $this->assertSame('Your preferences were updated.', $payload['subtitle']);
        $this->assertSame(0, Notification::query()->count());
        $this->assertSame([$payload], session(TransientToasts::SESSION_KEY));
    }

    public function test_transient_toasts_support_carbon_status_kinds(): void
    {
        $service = app(TransientToasts::class);

        $this->assertSame('success', $service->payload('success', 'Done')['kind']);
        $this->assertSame('warning', $service->payload('warning', 'Review')['kind']);
        $this->assertSame('error', $service->payload('error', 'Failed')['kind']);
        $this->assertSame('info', $service->payload('info', 'Queued')['kind']);
    }

    public function test_transient_toasts_reject_unsupported_kinds(): void
    {
        $this->expectException(InvalidArgumentException::class);

        app(TransientToasts::class)->payload('notice', 'Notice is not a toast kind');
    }
}
