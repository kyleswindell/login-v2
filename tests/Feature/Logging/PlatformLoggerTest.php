<?php

namespace Tests\Feature\Logging;

use App\Models\CentralErrorLog;
use App\Models\PlatformAuditLog;
use App\Models\User;
use App\Platform\Logging\PlatformLogger;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RuntimeException;
use Tests\TestCase;

class PlatformLoggerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_records_platform_audit_events(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        app(PlatformLogger::class)->recordEvent('test.event', [
            'example' => true,
        ]);

        $log = PlatformAuditLog::query()->firstOrFail();

        $this->assertSame('test.event', $log->event_type);
        $this->assertSame('event', $log->action);
        $this->assertSame($user->id, $log->actor_user_id);
        $this->assertSame('success', $log->result);
        $this->assertSame('info', $log->severity);
        $this->assertSame(['example' => true], $log->metadata);
    }

    public function test_it_records_application_errors(): void
    {
        $exception = new RuntimeException('Something went wrong.');

        app(PlatformLogger::class)->recordError(
            message: 'Example error',
            context: ['feature' => 'logging-test'],
            exception: $exception,
        );

        $log = CentralErrorLog::query()->firstOrFail();

        $this->assertSame('error', $log->severity);
        $this->assertSame('Example error', $log->message);
        $this->assertSame(RuntimeException::class, $log->exception_class);
        $this->assertSame(['feature' => 'logging-test'], $log->context);
        $this->assertNotEmpty($log->fingerprint);
    }
}
