<?php
/*
|--------------------------------------------------------------------------
| File: tests/Feature/Ui/ModalDialogCompileTest.php
| Purpose: Verify modal and dialog Blade composition compiles safely.
|--------------------------------------------------------------------------
|
| These tests protect x-ui.modal from forwarding raw attribute bags through
| nested anonymous component openings, which can leave malformed compiled PHP.
|
*/

declare(strict_types=1);

namespace Tests\Feature\Ui;

use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

final class ModalDialogCompileTest extends TestCase
{
    public function test_modal_component_compiles_nested_dialog_components(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-ui.modal
                id="compile-proof-modal"
                title="Compile proof"
                label="Confirmation"
                description="Confirm this modal can render."
                primary-button-text="Confirm"
                secondary-button-text="Cancel"
                data-proof-modal="true"
            >
                Modal body content.
            </x-ui.modal>
        BLADE);

        $this->assertStringContainsString('<dialog', $html);
        $this->assertStringContainsString('id="compile-proof-modal"', $html);
        $this->assertStringContainsString('data-ui-dialog-container', $html);
        $this->assertStringContainsString('data-ui-modal-container="true"', $html);
        $this->assertStringContainsString('data-proof-modal="true"', $html);
        $this->assertStringContainsString('Confirm this modal can render.', $html);
        $this->assertStringContainsString('Modal body content.', $html);
        $this->assertStringNotContainsString('<x-ui.dialog', $html);
        $this->assertStringNotContainsString(
            'data-ui-dialog-container=""><div data-ui-dialog-panel',
            $html,
        );
    }

    public function test_notification_modal_pattern_compiles_modal_component(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-patterns.notifications.modal
                id="notification-modal-compile-proof"
                variant="confirmation"
                title="Apply changes?"
                label="Confirmation"
                confirm-label="Apply"
                cancel-label="Cancel"
            >
                Review the changes before applying them.
            </x-patterns.notifications.modal>
        BLADE);

        $this->assertStringContainsString('<dialog', $html);
        $this->assertStringContainsString('id="notification-modal-compile-proof"', $html);
        $this->assertStringContainsString('data-ui-notification-modal="true"', $html);
        $this->assertStringContainsString('data-ui-modal-container="true"', $html);
        $this->assertStringContainsString('Review the changes before applying them.', $html);
        $this->assertStringNotContainsString('<x-ui.dialog', $html);
    }
}
