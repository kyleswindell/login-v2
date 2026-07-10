{{-- ==========================================================================
    File: resources/views/components/ui/form/index.blade.php
    Purpose: Form wrapper component.

    Notes:
    - Emits the installed .ui-form selector contract.
    - Renders a native <form> element.
    - Does not manage validation, submission, method spoofing, or CSRF by itself.
    - Child form controls own their own labels, helper text, validation text,
      and ARIA wiring.
    - Form styles are handled by shared form CSS.
    ========================================================================== --}}

@props([
    'method' => 'POST',
    'action' => null,
    'csrf' => true,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Resolve form method
    |--------------------------------------------------------------------------
    |
    | Native HTML forms only support GET and POST. Other methods are emitted
    | through Laravel method spoofing.
    |
    */

    $requestedMethod = strtoupper($method);
    $nativeMethod = in_array($requestedMethod, ['GET', 'POST'], true)
        ? $requestedMethod
        : 'POST';

    $spoofedMethod = in_array($requestedMethod, ['PUT', 'PATCH', 'DELETE'], true)
        ? $requestedMethod
        : null;

    /*
    |--------------------------------------------------------------------------
    | CSRF behavior
    |--------------------------------------------------------------------------
    |
    | CSRF is emitted for non-GET forms by default.
    |
    */

    $usesCsrf = (bool) $csrf && $nativeMethod !== 'GET';

    /*
    |--------------------------------------------------------------------------
    | CSS class contract
    |--------------------------------------------------------------------------
    |
    | These classes must match shared form styles.
    |
    */

    $classes = [
        'ui-form',
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute handling
    |--------------------------------------------------------------------------
    |
    | Native form method and action are owned by this component.
    |
    */

    $formAttributes = $attributes->except([
        'method',
        'action',
    ]);
@endphp

<form
    method="{{ $nativeMethod }}"
    @if (filled($action)) action="{{ $action }}" @endif
    {{ $formAttributes->class($classes)->merge(['data-ui-component' => 'form']) }}
>
    {{-- ----------------------------------------------------------------------
        Laravel form security
        ----------------------------------------------------------------------
        CSRF and spoofed HTTP method fields are emitted when applicable.
        ---------------------------------------------------------------------- --}}

    @if ($usesCsrf)
        @csrf
    @endif

    @if (filled($spoofedMethod))
        @method($spoofedMethod)
    @endif

    {{-- ----------------------------------------------------------------------
        Form content
        ----------------------------------------------------------------------
        Child controls own their individual semantics and validation messaging.
        ---------------------------------------------------------------------- --}}

    {{ $slot }}
</form>