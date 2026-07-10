{{-- ==========================================================================
    File: resources/views/components/ui/dialog/close-button.blade.php
    Purpose: UI dialog close button.

    Source: Converted from the Carbon DialogCloseButton React component.

    Notes:
    - Renders a default close icon through x-ui.icon when no slot is provided.
    - The data-ui-dialog-close hook is for dialog JavaScript.
    - The parent x-ui.dialog.controls component owns header-control placement.
    ========================================================================== --}}

@props ([
    "label" => "Close",
    "type" => "button",
])

@php
    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedTypes = [
        'button',
        'submit',
        'reset',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $resolvedType = in_array($type, $allowedTypes, true)
        ? $type
        : 'button';

    $hasSlot = trim($slot->toHtml()) !== '';
@endphp

<button
    type="{{ $resolvedType }}"
    {{
        $attributes
            ->class("ui-dialog__close")
            ->merge([
                "aria-label" => $label,
                "title" => $label,
                "data-ui-component" => "dialog-close-button",
                "data-ui-dialog-close-button" => true,
                "data-ui-dialog-close" => true,
            ])
    }}
>
    @if ($hasSlot)
        {{ $slot }}
    @else
        <x-ui.icon
            name="close"
            class="ui-icon__close"
            aria-hidden="true"
            tabindex="-1"
        />
    @endif
</button>
