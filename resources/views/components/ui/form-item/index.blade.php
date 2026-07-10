{{-- ==========================================================================
    File: resources/views/components/ui/form-item/index.blade.php
    Purpose: Form item layout wrapper component.

    Notes:
    - Emits the installed .ui-form-item selector contract.
    - Intended as a low-level wrapper for form controls and custom form layouts.
    - Does not add label, helper, validation, or ARIA behavior by itself.
    - Form item spacing/layout styles are handled by shared form CSS.
    ========================================================================== --}}

@props([])

@php
    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    |
    | This component intentionally emits only the base form item wrapper class.
    |
    */

    $classes = [
        'ui-form-item',
    ];
@endphp

<div
    {{ $attributes->class($classes)->merge([
        'data-ui-component' => 'form-item',
        'data-ui-form-item' => true,
    ]) }}
>
    {{ $slot }}
</div>