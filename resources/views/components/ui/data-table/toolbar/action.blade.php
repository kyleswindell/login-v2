{{-- ==========================================================================
    File: resources/views/components/ui/data-table/toolbar/action.blade.php
    Purpose: Data Table toolbar overflow menu action item.

    Notes:
    - Renders a menu item for use inside x-ui.data-table.toolbar.menu.
    - Supports anchor and button actions with the same visual class contract.
    - Does not own action behavior beyond disabled and danger presentation.
    ========================================================================== --}}

@props([
    'href' => null,
    'disabled' => false,
    'danger' => false,
])

@php
    $classes = [
        'ui-overflow-menu-options__btn',
        'ui-toolbar-action__item',
        'ui-toolbar-action__item--danger' => $danger,
    ];
@endphp

@if ($href && ! $disabled)
    <a
        href="{{ $href }}"
        {{ $attributes->class($classes)->merge([
            'role' => 'menuitem',
            'data-ui-table-toolbar-action' => true,
        ]) }}
    >
        <span class="ui-overflow-menu-options__option-content">
            {{ $slot }}
        </span>
    </a>
@else
    <button
        type="button"
        @disabled($disabled)
        {{ $attributes->class($classes)->merge([
            'role' => 'menuitem',
            'data-ui-table-toolbar-action' => true,
        ]) }}
    >
        <span class="ui-overflow-menu-options__option-content">
            {{ $slot }}
        </span>
    </button>
@endif
