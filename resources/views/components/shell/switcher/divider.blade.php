{{-- ==========================================================================
    File: resources/views/components/shell/divider.blade.php
    Purpose: UI shell switcher divider item.

    Notes:
    - Mirrors the base UI shell SwitcherDivider structure.
    - The divider class is applied to the hr element.
    - Custom attributes apply to the hr element.
    ========================================================================== --}}

<li
    data-ui-component="shell-switcher-divider"
    data-ui-shell-switcher-divider
>
    <hr
        {{ $attributes->class('ui-shell-switcher__item--divider') }}
        role="separator"
    >
</li>