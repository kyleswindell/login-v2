{{-- ==========================================================================
    File: resources/views/components/shell/header-menu-button.blade.php
    Purpose: UI shell header menu button.

    Notes:
    - Mirrors the base UI shell header menu trigger structure.
    - Does not define icon artwork.
    - Consumers provide the icon markup through the default slot.
    - If an expanded/collapsed icon swap is needed, provide both icons with the
      expected base shell icon classes.
    ========================================================================== --}}

@props([
    'controls',
    'label' => 'Open menu',
    'closeLabel' => 'Close menu',
    'expanded' => false,
])

<button
    type="button"
    {{ $attributes->class([
        'ui-shell-header__action',
        'ui-shell-header__menu-trigger',
        'ui-shell-header__menu-toggle',
        'ui-button',
        'ui-button--icon-only',
        'ui-shell-header__action--active' => (bool) $expanded,
    ])->merge([
        'aria-label' => $expanded ? $closeLabel : $label,
        'aria-controls' => $controls,
        'aria-expanded' => $expanded ? 'true' : 'false',
        'data-ui-shell-header-menu-button' => true,
        'data-ui-shell-header-menu-button-active' => $expanded ? 'true' : 'false',
    ]) }}
>
    {{ $slot }}
</button>