{{-- ==========================================================================
    File: resources/views/components/shell/side-nav/divider.blade.php
    Purpose: UI shell side navigation divider.

    Notes:
    - Renders a structural separator inside side navigation lists.
    - The separator is wrapped in an <li> to preserve valid list structure.
    - This component is non-interactive.
    ========================================================================== --}}

<li
    {{ $attributes->class('ui-shell-side-nav__divider')->merge([
        'data-ui-shell-side-nav-divider' => true,
    ]) }}
    aria-hidden="true"
>
    <hr>
</li>