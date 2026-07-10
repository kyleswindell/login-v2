{{-- ==========================================================================
    File: resources/views/components/ui/dialog/header.blade.php
    Purpose: UI dialog header.

    Source: Converted from the Carbon DialogHeader React component.

    Notes:
    - Renders the dialog header region.
    - Accepts extraAttributes for safe component-to-component attribute
      forwarding.
    ========================================================================== --}}

@props ([
    "extraAttributes" => null,
])

@php
    use Illuminate\View\ComponentAttributeBag;

    /*
     *--------------------------------------------------------------------------
     * Attribute bag state
     *--------------------------------------------------------------------------
     */

    $extraAttributes = $extraAttributes instanceof ComponentAttributeBag
        ? $extraAttributes
        : new ComponentAttributeBag();

    /*
     *--------------------------------------------------------------------------
     * Attribute handling
     *--------------------------------------------------------------------------
     */

    $mergedAttributes = (new ComponentAttributeBag(
        array_merge(
            $extraAttributes->getAttributes(),
            $attributes->getAttributes()
        )
    ))
        ->class('ui-dialog__header')
        ->merge([
            'data-ui-component' => 'dialog-header',
            'data-ui-dialog-header' => 'true',
        ]);
@endphp

<div {{ $mergedAttributes }}>{{ $slot }}</div>
