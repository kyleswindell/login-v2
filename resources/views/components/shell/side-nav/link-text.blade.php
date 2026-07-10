{{-- ==========================================================================
    File: resources/views/components/shell/side-nav/link-text.blade.php
    Purpose: UI shell side navigation link text.

    Notes:
    - Renders the text label inside a side navigation link or menu item.
    - Kept as a separate primitive for cases where custom side nav content needs
      the same text selector contract as x-shell.side-nav.link.
    - Most standard side navigation links do not need to call this directly
      because x-shell.side-nav.link already renders the text wrapper.
    ========================================================================== --}}

<span
    {{ $attributes->class('ui-shell-side-nav__link-text')->merge([
        'data-ui-shell-side-nav-link-text' => true,
    ]) }}
>
    {{ $slot }}
</span>
