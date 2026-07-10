<?php
/*
|--------------------------------------------------------------------------
| File: tests/Feature/Ui/NotificationPatternContractTest.php
| Purpose: Verify notification Tier 2 pattern wrappers compose primitives.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace Tests\Feature\Ui;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

final class NotificationPatternContractTest extends TestCase
{
    public function test_inline_toast_actionable_and_callout_patterns_compose_notification_primitives(): void
    {
        $patterns = [
            'inline' => ['component' => 'x-patterns.notifications.inline', 'class' => 'ui-inline-notification'],
            'toast' => ['component' => 'x-patterns.notifications.toast', 'class' => 'ui-toast-notification'],
            'actionable' => ['component' => 'x-patterns.notifications.actionable', 'class' => 'ui-actionable-notification'],
            'callout' => ['component' => 'x-patterns.notifications.callout', 'class' => 'ui-actionable-notification'],
        ];

        foreach ($patterns as $type => $expectation) {
            $html = Blade::render(
                '<'.$expectation['component'].' kind="info" title="Pattern title" subtitle="Pattern body" />',
            );

            $this->assertStringContainsString($expectation['class'], $html, "Pattern [{$type}] did not render the expected primitive class.");
            $this->assertStringContainsString('data-ui-notification', $html);
            $this->assertStringContainsString('data-ui-notification-kind="info"', $html);
        }
    }

    public function test_modal_pattern_remains_out_of_scope_for_this_contract(): void
    {
        $modalPath = base_path('resources/views/components/patterns/notifications/modal/index.blade.php');
        $modalSource = File::get($modalPath);

        $this->assertStringContainsString('Purpose: Modal Notification pattern.', $modalSource);
        $this->assertStringNotContainsString('TransientToasts', $modalSource);
    }

    public function test_callout_pattern_keeps_guidance_oriented_kinds(): void
    {
        $html = Blade::render(
            '<x-patterns.notifications.callout kind="success" title="Guidance" subtitle="Callouts are not success feedback." />',
        );

        $this->assertStringContainsString('data-ui-notification-type="callout"', $html);
        $this->assertStringContainsString('data-ui-notification-kind="info"', $html);
        $this->assertStringNotContainsString('data-ui-notification-kind="success"', $html);
    }
}
