{{-- ==========================================================================
    File: resources/views/components/ui/list-item/index.blade.php
    Purpose: UI list item component.

    Source: Converted from the Carbon ListItem React component.
    Notes:
    - Renders an li element.
    - Applies the base UI list item class.
    - Intended for use inside ordered and unordered list components.
    ========================================================================== --}}

<li {{ $attributes->class('ui-list__item') }}>
    {{ $slot }}
</li>