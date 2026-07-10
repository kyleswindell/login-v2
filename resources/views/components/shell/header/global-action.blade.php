{{-- ==========================================================================
    File: resources/views/components/shell/header/global-action.blade.php
    Purpose: UI shell header global action button.

    Notes:
    - Used inside the shell header global actions region.
    - Designed for icon-only actions such as account, notifications, settings,
      theme, search, or panel toggles.
    - Accepts either an icon component name or an icon slot.
    - Active state is visual and available to JavaScript through data attributes.
    - If controls is provided, aria-controls and aria-expanded are emitted for
      shell header panel behavior.
    - Tooltip configuration is emitted as data attributes for installed tooltip
      behavior.
    ========================================================================== --}}

@props([
    'icon' => null,
    'label' => null,
    'labelledby' => null,
    'controls' => null,
    'active' => false,
    'expanded' => null,
    'isActive' => null,
    'tooltipAlignment' => null,
    'tooltipDropShadow' => false,
    'tooltipHighContrast' => true,
    'type' => 'button',
])

@php
    /*
    |--------------------------------------------------------------------------
    | Resolve values
    |--------------------------------------------------------------------------
    */

    $isActionActive = ! is_null($isActive)
        ? (bool) $isActive
        : (! is_null($expanded) ? (bool) $expanded : (bool) $active);

    $resolvedAriaLabel = $label ?? $attributes->get('aria-label');
    $resolvedAriaLabelledby = $labelledby ?? $attributes->get('aria-labelledby');
    $resolvedAriaControls = $controls ?? $attributes->get('aria-controls');

    /*
    |--------------------------------------------------------------------------
    | CSS class contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-shell-header__action',
        'ui-shell-header__global-action',
        'ui-button',
        'ui-button--icon-only',
        'ui-shell-header__action--active' => $isActionActive,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute handling
    |--------------------------------------------------------------------------
    */

    $buttonAttributes = $attributes->except([
        'aria-label',
        'aria-labelledby',
        'aria-controls',
        'controls',
    ]);
@endphp

<button
    type="{{ $type }}"
    {{ $buttonAttributes->class($classes)->merge([
        'aria-label' => $resolvedAriaLabel,
        'aria-labelledby' => $resolvedAriaLabelledby,
        'aria-controls' => $resolvedAriaControls,
        'aria-expanded' => $resolvedAriaControls ? ($isActionActive ? 'true' : 'false') : null,
        'aria-pressed' => ! $resolvedAriaControls && $isActionActive ? 'true' : null,
        'data-ui-shell-header-global-action' => true,
        'data-ui-shell-header-global-action-active' => $isActionActive ? 'true' : 'false',
        'data-ui-tooltip-placement' => 'bottom',
        'data-ui-tooltip-alignment' => $tooltipAlignment,
        'data-ui-tooltip-drop-shadow' => $tooltipDropShadow ? 'true' : 'false',
        'data-ui-tooltip-high-contrast' => $tooltipHighContrast ? 'true' : 'false',
    ]) }}
>
    @if ($icon)
        <x-ui.icon
            :name="$icon"
            class="ui-shell-header__action-icon"
            width="20"
            height="20"
            aria-hidden="true"
            focusable="false"
        />
    @else
        {{ $slot }}
    @endif
</button>
