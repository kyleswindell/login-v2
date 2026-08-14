<?php

/*
|--------------------------------------------------------------------------
| File: tests/Feature/Ui/NotificationToastContractTest.php
| Purpose: Verify notification toast component and runtime DOM contracts.
|--------------------------------------------------------------------------
|
| These tests protect the installed Notification toast contract from drifting
| back to ad hoc preview-card runtime markup.
|
*/

declare(strict_types=1);

namespace Tests\Feature\Ui;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

final class NotificationToastContractTest extends TestCase
{
    public function test_toast_renders_default_status_icons_for_supported_kinds(): void
    {
        $expectedIcons = [
            'error' => 'error--filled',
            'success' => 'checkmark--filled',
            'warning' => 'warning--filled',
            'warning-alt' => 'warning--alt--filled',
            'info' => 'information--filled',
            'info-square' => 'information--square--filled',
        ];

        foreach ($expectedIcons as $kind => $iconName) {
            $html = Blade::render(
                '<x-ui.notification.toast kind="'.$kind.'" title="Toast title" subtitle="Toast body" />',
            );

            $this->assertStringContainsString('class="ui-toast-notification__icon"', $html);
            $this->assertStringContainsString('kind="'.$kind.'"', $html);
            $this->assertStringContainsString('data-ui-notification-kind="'.$kind.'"', $html);
            $this->assertStringContainsString('data-ui-icon-name="'.$iconName.'"', $html);
        }
    }

    public function test_toast_defaults_to_status_role_and_contract_close_button(): void
    {
        $html = Blade::render(
            '<x-ui.notification.toast kind="info" title="Toast title" subtitle="Toast body" />',
        );

        $this->assertStringContainsString('role="status"', $html);
        $this->assertStringContainsString('data-ui-notification', $html);
        $this->assertStringContainsString('data-ui-notification-type="toast"', $html);
        $this->assertStringContainsString('data-ui-notification-close', $html);
        $this->assertStringContainsString('class="ui-toast-notification__close-button"', $html);
    }

    public function test_runtime_notification_toast_uses_notification_contract_markup(): void
    {
        $runtimePath = base_path('Modules/Notifications/resources/js/runtime.js');
        $dashboardRuntimePath = base_path('resources/js/dashboard-test-notification.js');
        $legacyRuntimePath = base_path('resources/js/realtime-notifications.js');
        $appSource = File::get(base_path('resources/js/app.js'));
        $runtimeSource = File::get($runtimePath);
        $dashboardRuntimeSource = File::get($dashboardRuntimePath);
        $createToastSource = self::sourceBetween(
            $runtimeSource,
            'const createToast =',
            'const transientToastPayloads =',
        );

        $this->assertFileExists($runtimePath);
        $this->assertFileExists($dashboardRuntimePath);
        $this->assertFileDoesNotExist($legacyRuntimePath);
        $this->assertStringContainsString('initNotificationRuntime', $appSource);
        $this->assertStringContainsString('/Modules/Notifications/resources/js', $appSource);
        $this->assertStringNotContainsString('initRealtimeNotifications', $appSource);
        $this->assertStringNotContainsString('./realtime-notifications', $appSource);

        $this->assertStringContainsString('ui-toast-notification', $createToastSource);
        $this->assertStringContainsString('role', $createToastSource);
        $this->assertStringContainsString('status', $createToastSource);
        $this->assertStringContainsString('setAttribute("kind", kind)', $createToastSource);
        $this->assertStringContainsString('data-ui-notification-close', $createToastSource);
        $this->assertStringContainsString('ui-toast-notification__details', $createToastSource);
        $this->assertStringContainsString('ui-toast-notification__title', $createToastSource);
        $this->assertStringContainsString('ui-toast-notification__subtitle', $createToastSource);

        $this->assertStringNotContainsString('ui-notification-runtime-toast', $createToastSource);
        $this->assertStringNotContainsString('data-notification-toast-close', $createToastSource);
        $this->assertStringNotContainsString('ui-notification-preview-pill', $createToastSource);
        $this->assertStringNotContainsString('ui-notification-card-title', $createToastSource);
        $this->assertStringNotContainsString('ui-notification-card-body', $createToastSource);

        $this->assertStringNotContainsString('platform-notification-created', $runtimeSource);
        $this->assertStringNotContainsString('platform-notification-created', $dashboardRuntimeSource);
        $this->assertStringNotContainsString('form.submit()', $dashboardRuntimeSource);
        $this->assertStringContainsString('notifications:toast', $dashboardRuntimeSource);
        $this->assertStringContainsString('id: payload.notification_id', $dashboardRuntimeSource);
        $this->assertStringContainsString('"success"', $dashboardRuntimeSource);
        $this->assertStringContainsString('Test notification created', $dashboardRuntimeSource);
        $this->assertStringContainsString('submit.matches("[data-ui-tile]")', $dashboardRuntimeSource);
        $this->assertStringContainsString('data-ui-loading', $dashboardRuntimeSource);
    }

    public function test_notification_runtime_declares_idempotent_transport_and_toast_guards(): void
    {
        $runtimeSource = File::get(base_path('Modules/Notifications/resources/js/runtime.js'));

        $this->assertStringContainsString('MAX_PRESENTED_TOAST_IDS = 250', $runtimeSource);
        $this->assertStringContainsString('presentedPersistentToastIds', $runtimeSource);
        $this->assertStringContainsString('presentedTransientToastIds', $runtimeSource);
        $this->assertStringContainsString('currentApplyNotification', $runtimeSource);
        $this->assertStringContainsString('currentCreateToast', $runtimeSource);
        $this->assertStringContainsString('realtimeConnectionSignature', $runtimeSource);
        $this->assertStringContainsString('notificationRealtimeState', $runtimeSource);
        $this->assertStringContainsString('"state_change"', $runtimeSource);
        $this->assertStringContainsString('.subscribed(() =>', $runtimeSource);
        $this->assertStringContainsString('.error(() =>', $runtimeSource);
        $this->assertStringContainsString('disconnectRealtime()', $runtimeSource);
        $this->assertStringContainsString('MARK_ALL_BOUND_ATTR', $runtimeSource);
        $this->assertStringContainsString('return existing;', $runtimeSource);
        $this->assertStringNotContainsString('dismissToast(existing)', $runtimeSource);
    }

    public function test_runtime_toast_kind_normalizes_notice_and_urgent_without_changing_stored_severity(): void
    {
        $runtimeSource = File::get(base_path('Modules/Notifications/resources/js/runtime.js'));

        $this->assertMatchesRegularExpression(
            '/case [\'\"]info[\'\"]:\s+case [\'\"]notice[\'\"]:\s+return [\'\"]info[\'\"];/s',
            $runtimeSource,
        );

        $this->assertMatchesRegularExpression(
            '/case [\'\"]urgent[\'\"]:\s+return [\'\"]warning[\'\"];/s',
            $runtimeSource,
        );
    }

    public function test_transient_toast_runtime_mount_uses_toast_templates(): void
    {
        $mountPath = base_path('Modules/Notifications/resources/views/runtime/toasts.blade.php');
        $runtimeSource = File::get(base_path('Modules/Notifications/resources/js/runtime.js'));
        $mountSource = File::get($mountPath);

        $this->assertFileExists($mountPath);
        $this->assertStringContainsString('data-transient-notifications', $mountSource);
        $this->assertStringContainsString('data-transient-notification-payloads', $mountSource);
        $this->assertStringContainsString('data-notification-toast-container', $mountSource);
        $this->assertStringContainsString('data-notification-toast-template', $mountSource);
        $this->assertStringContainsString('<x-ui.notification.toast', $mountSource);

        $this->assertStringContainsString('notifications:toast', $runtimeSource);
        $this->assertStringContainsString('transientToastPayloads', $runtimeSource);
    }

    private static function sourceBetween(string $source, string $start, string $end): string
    {
        $startPosition = strpos($source, $start);
        $endPosition = strpos($source, $end, $startPosition ?: 0);

        self::assertIsInt($startPosition, "Could not find source start marker [{$start}].");
        self::assertIsInt($endPosition, "Could not find source end marker [{$end}].");

        return substr($source, $startPosition, $endPosition - $startPosition);
    }
}
