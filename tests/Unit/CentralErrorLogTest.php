<?php

namespace Tests\Unit;

use App\Models\CentralErrorLog;
use Tests\TestCase;

class CentralErrorLogTest extends TestCase
{
    public function test_occurred_at_display_converts_stored_utc_to_viewer_timezone(): void
    {
        $log = new CentralErrorLog([
            'occurred_at' => '2026-04-11 03:27:00',
        ]);

        $this->assertSame(
            'Apr 10, 2026 11:27 PM EDT',
            $log->occurredAtForTimezone('America/New_York')?->format('M j, Y g:i A T'),
        );
    }
}
