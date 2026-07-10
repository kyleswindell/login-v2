{{-- ==========================================================================
    File: resources/views/components/ui/data-table/toolbar/menu.blade.php
    Purpose: Data Table toolbar overflow menu composition.

    Notes:
    - Uses the existing x-ui.icon-button and triggerless x-ui.menu APIs.
    - Keeps toolbar action classes required by data-table-toolbar.css.
    - Supports parent-aware toolbar size and explicit size override.
    - Accepts slot content, including x-ui.data-table.toolbar.action items.
    ========================================================================== --}}

@aware([
    'size' => null,
])

@props([
    'id' => null,
    'label' => 'Settings',
    'flipped' => true,
    'open' => false,
    'disabled' => false,
])

@php
    use Illuminate\Support\Str;

    /*
    |--------------------------------------------------------------------------
    | Resolve Menu Values
    |--------------------------------------------------------------------------
    */

    $requestedSize = $attributes->get('size') ?? $size;

    $resolvedSize = in_array($requestedSize, ['xs', 'sm', 'md', 'lg'], true)
        ? $requestedSize
        : 'md';

    $isOpen = (bool) $open;
    $isDisabled = (bool) $disabled;

    $resolvedPlacement = (bool) $flipped ? 'bottom-end' : 'bottom-start';

    $menuId = $id ?? 'ui-table-toolbar-menu-'.Str::uuid();
    $panelId = $menuId.'-panel';

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    |
    | size is consumed by this component and must not render as a raw attribute
    | on the toolbar menu wrapper.
    |
    */

    $menuAttributes = $attributes->except([
        'size',
    ]);
@endphp

<div
    {{ $menuAttributes->class([
        'ui-toolbar-action',
        'ui-overflow-menu',
    ])->merge([
        'data-ui-table-toolbar-menu' => true,
    ]) }}
>
    <x-ui.icon-button
        :label="$label"
        :tooltip="$label"
        icon="overflow-menu--vertical"
        semantic="ghost"
        :size="$resolvedSize"
        :disabled="$isDisabled"
        class="ui-overflow-menu-trigger"
        data-ui-menu-trigger
        aria-haspopup="menu"
        aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
        aria-controls="{{ $panelId }}"
    />

    <x-ui.menu
        :id="$panelId"
        :label="$label"
        :menu-label="$label"
        :size="$resolvedSize"
        :placement="$resolvedPlacement"
        :open="$isOpen"
        :trigger="false"
        class="ui-toolbar-action__menu"
    >
        {{ $slot }}
    </x-ui.menu>
</div>