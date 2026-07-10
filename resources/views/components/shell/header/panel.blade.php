{{-- ==========================================================================
    File: resources/views/components/shell/header-panel.blade.php
    Purpose: UI shell header panel.

    Notes:
    - Renders expandable header panel content such as account, notifications,
      switcher, or settings panels.
    - Open/close, Escape behavior, outside click, and focus-return behavior are
      handled by installed shell JavaScript.
    - The panel remains slot-driven so application-specific panel content stays
      outside the shell primitive.
    ========================================================================== --}}

@props([
    'id' => null,
    'label' => null,
    'labelledby' => null,
    'expanded' => false,
    'addFocusListeners' => true,
    'href' => null,
    'role' => null,
])

@php
    use Illuminate\Support\Str;

    /*
    |--------------------------------------------------------------------------
    | Resolve values
    |--------------------------------------------------------------------------
    */

    $resolvedId = $id ?? 'ui-shell-header-panel-'.Str::uuid();
    $isExpanded = (bool) $expanded;

    $resolvedAriaLabel = $label ?? $attributes->get('aria-label');
    $resolvedAriaLabelledby = $labelledby ?? $attributes->get('aria-labelledby');

    /*
    |--------------------------------------------------------------------------
    | CSS class contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-shell-header-panel',
        'ui-shell-header-panel--expanded' => $isExpanded,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute handling
    |--------------------------------------------------------------------------
    */

    $panelAttributes = $attributes->except([
        'aria-label',
        'aria-labelledby',
    ]);
@endphp

<div
    id="{{ $resolvedId }}"
    {{ $panelAttributes->class($classes)->merge([
        'data-ui-shell-header-panel' => true,
        'data-ui-shell-header-panel-expanded' => $isExpanded ? 'true' : 'false',
        'data-ui-shell-header-panel-focus-listeners' => $addFocusListeners ? 'true' : 'false',
        'data-ui-shell-header-panel-collapse-href' => $href,
    ]) }}
    @if ($role) role="{{ $role }}" @endif
    @if ($resolvedAriaLabel) aria-label="{{ $resolvedAriaLabel }}" @endif
    @if ($resolvedAriaLabelledby) aria-labelledby="{{ $resolvedAriaLabelledby }}" @endif
    @if (! $isExpanded) hidden @endif
>
    {{ $slot }}
</div>