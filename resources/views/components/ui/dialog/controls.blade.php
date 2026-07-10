{{-- ==========================================================================
    File: resources/views/components/ui/dialog/controls.blade.php
    Purpose: UI dialog header controls region.

    Source: Converted from the Carbon DialogControls React component.

    Notes:
    - Owns the dialog header controls wrapper.
    - Usually contains x-ui.dialog.close-button.
    - Does not own close behavior; close behavior is handled by slotted controls
      and installed dialog JavaScript through data-ui-dialog-close.
    ========================================================================== --}}

<div
    {{
        $attributes
            ->class("ui-dialog__header-controls")
            ->merge([
                "data-ui-component" => "dialog-controls",
                "data-ui-dialog-controls" => true,
            ])
    }}
>
    {{ $slot }}
</div>
