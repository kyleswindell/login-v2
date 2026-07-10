{{-- ==========================================================================
    File: resources/views/components/ui/menu/index.blade.php
    Purpose: Menu composition and triggerless menu surface component.

    Notes:
    - Supports the existing item-array API and slot-based menu content.
    - Can render its own trigger or operate in triggerless mode.
    - Triggerless mode is used by resources/views/components/ui/menu-button/index.blade.php.
    - Emits the canonical .ui-menu selector contract.
    - Menu items are rendered by resources/views/components/ui/menu-item/index.blade.php.
    - Menu open/close, keyboard behavior, positioning, and submenu behavior are
      handled by installed menu JavaScript.
    ========================================================================== --}}

@props([
'items' => [],
'trigger' => true,
'triggerLabel' => 'Actions',
'triggerKind' => 'text',
'triggerIcon' => null,
'triggerVariant' => null,
'size' => 'md',
'align' => 'bottom-start',
'placement' => null,
'menuAlignment' => null,
'open' => false,
'disabled' => false,
'id' => null,
'label' => null,
'menuLabel' => null,
'triggerClass' => null,
'triggerTooltip' => null,
'rtl' => false,
'backgroundToken' => 'layer',
'border' => false,
])

@php
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Supported public values
|--------------------------------------------------------------------------
*/

$allowedSizes = ['xs', 'sm', 'md', 'lg'];

$allowedAlignments = [
'top',
'top-start',
'top-end',
'bottom',
'bottom-start',
'bottom-end',
'left',
'left-start',
'left-end',
'right',
'right-start',
'right-end',
];

$allowedBackgroundTokens = ['layer', 'background'];

/*
|--------------------------------------------------------------------------
| Resolve trigger and surface mode
|--------------------------------------------------------------------------
|
| When trigger=false, this component renders only the menu surface. This is
| required by Menu Button, which owns its trigger directly.
|
*/

$shouldRenderTrigger = (bool) $trigger;

/*
|--------------------------------------------------------------------------
| Resolve size, alignment, label, and background treatment
|--------------------------------------------------------------------------
*/

$resolvedSize = in_array($size, $allowedSizes, true) ? $size : 'md';

$requestedPlacement = $menuAlignment ?? $placement ?? $align;

$resolvedAlign = match ($requestedPlacement) {
'start' => 'bottom-start',
'end' => 'bottom-end',
'top',
'top-start',
'top-end',
'bottom',
'bottom-start',
'bottom-end',
'left',
'left-start',
'left-end',
'right',
'right-start',
'right-end' => $requestedPlacement,
default => 'bottom-start',
};

$resolvedAlign = in_array($resolvedAlign, $allowedAlignments, true)
? $resolvedAlign
: 'bottom-start';

$resolvedBackgroundToken = in_array($backgroundToken, $allowedBackgroundTokens, true)
? $backgroundToken
: 'layer';

$resolvedMenuLabel = $menuLabel ?? $label ?? $triggerLabel;

/*
|--------------------------------------------------------------------------
| IDs and trigger wiring
|--------------------------------------------------------------------------
|
| Triggerless mode uses the provided root ID as the menu panel ID so an
| external trigger can target it with aria-controls.
|
*/

$rootId = $id ?? 'ui-menu-'.Str::uuid();
$panelId = $shouldRenderTrigger ? $rootId.'-panel' : $rootId;

/*
|--------------------------------------------------------------------------
| Trigger defaults
|--------------------------------------------------------------------------
*/

$isIconTrigger = $triggerKind === 'icon' || filled($triggerIcon);
$resolvedTriggerVariant = $triggerVariant ?? ($isIconTrigger ? 'ghost' : 'tertiary');
$resolvedTriggerIcon = $triggerIcon ?? ($isIconTrigger ? 'overflow-menu--vertical' : null);
$resolvedTriggerClass = filled($triggerClass) ? $triggerClass : null;

/*
|--------------------------------------------------------------------------
| Item collection
|--------------------------------------------------------------------------
|
| Hidden items are filtered before rendering. Selection indicator space is
| reserved when any item in the menu has selected/selectable state.
|
*/

$visibleItems = collect($items)->reject(fn ($item) => $item['hidden'] ?? false);

$reservesSelectionIndicator = $visibleItems->contains(function ($item) {
return ($item['selected'] ?? false)
|| filled($item['selection_type'] ?? $item['selectionType'] ?? null);
});

/*
|--------------------------------------------------------------------------
| Render state
|--------------------------------------------------------------------------
*/

$isOpen = (bool) $open && ! (bool) $disabled;

/*
|--------------------------------------------------------------------------
| CSS class contract
|--------------------------------------------------------------------------
|
| Canonical classes are emitted first. Older placement/size classes are kept
| only as compatibility hooks for existing JavaScript or transitional CSS.
|
*/

$rootClasses = [
'ui-menu-composition',
'ui-menu-composition--rtl' => $rtl,

// Compatibility hook.
'ui-menu-composition-rtl' => $rtl,
];

$panelClasses = [
'ui-menu',
'ui-menu--'.$resolvedSize,
'ui-menu--open' => $isOpen,
'ui-menu--shown' => $isOpen,
'ui-menu--box-shadow-top' => str_starts_with($resolvedAlign, 'top'),
'ui-menu--with-selectable-items' => $reservesSelectionIndicator,
'ui-menu--border' => (bool) $border,
'ui-menu--background-token__background' => $resolvedBackgroundToken === 'background',

// Compatibility hooks.
'ui-menu-'.$resolvedSize,
'ui-menu-align-'.$resolvedAlign,
];

/*
|--------------------------------------------------------------------------
| Slot detection
|--------------------------------------------------------------------------
*/

$hasSlotContent = trim($slot->toHtml()) !== '';
@endphp

@if ($shouldRenderTrigger)
{{-- ----------------------------------------------------------------------
        Triggered menu composition
        ----------------------------------------------------------------------
        This mode preserves the standalone <x-ui.menu> behavior where the menu
        component owns both the trigger and menu surface.
        ---------------------------------------------------------------------- --}}

<div
    {{ $attributes->class($rootClasses)->merge([
            'id' => $rootId,
            'data-ui-component' => 'menu-composition',
            'data-ui-menu-open' => $isOpen ? 'true' : 'false',
            'dir' => $rtl ? 'rtl' : null,
        ]) }}>
    @if ($isIconTrigger)
    {{-- Icon trigger --}}
    <x-ui.icon-button
        label="{{ $triggerLabel }}"
        :kind="$resolvedTriggerVariant"
        :semantic="$resolvedTriggerVariant"
        :size="$resolvedSize"
        :icon="$resolvedTriggerIcon"
        :tooltip="$triggerTooltip"
        :disabled="$disabled"
        :class="$resolvedTriggerClass"
        data-ui-menu-trigger
        aria-haspopup="menu"
        aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
        aria-controls="{{ $panelId }}" />
    @else
    {{-- Text trigger --}}
    <x-ui.button
        :kind="$resolvedTriggerVariant"
        :semantic="$resolvedTriggerVariant"
        :size="$resolvedSize"
        icon="chevron--down"
        :disabled="$disabled"
        :class="$resolvedTriggerClass"
        data-ui-menu-trigger
        aria-haspopup="menu"
        aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
        aria-controls="{{ $panelId }}">
        {{ $triggerLabel }}
    </x-ui.button>
    @endif

    {{-- Menu surface --}}
    <div
        id="{{ $panelId }}"
        @class($panelClasses)
        role="menu"
        tabindex="-1"
        data-ui-menu
        data-ui-menu-panel
        data-ui-menu-placement="{{ $resolvedAlign }}"
        data-ui-menu-size="{{ $resolvedSize }}"
        data-ui-menu-background-token="{{ $resolvedBackgroundToken }}"
        @if (filled($resolvedMenuLabel)) aria-label="{{ $resolvedMenuLabel }}" @endif
        @if (! $isOpen) hidden @endif>
        {{-- Render item-array content first. --}}
        @foreach ($visibleItems as $item)
        @php
        $isDivider = ($item['divider'] ?? false) || (($item['type'] ?? 'item') === 'divider');
        $hasLabel = filled($item['label'] ?? null);

        $children = collect($item['children'] ?? [])->reject(fn ($child) => $child['hidden'] ?? false);
        $hasSubmenu = $children->isNotEmpty();

        $selectionType = $item['selection_type'] ?? $item['selectionType'] ?? null;
        $resolvedSelectionType = $selectionType === 'multi' ? 'multiple' : $selectionType;

        $isDangerItem = ($item['danger'] ?? false) || (($item['tone'] ?? null) === 'danger');
        @endphp

        @continue(! $isDivider && ! $hasLabel)

        @if ($item['dividerBefore'] ?? $item['divider_before'] ?? false)
        <x-ui.menu-item type="divider" />
        @endif

        @if ($isDivider)
        <x-ui.menu-item type="divider" />
        @elseif ($hasSubmenu)
        {{-- Submenu trigger item --}}
        <x-ui.menu-item
            :semantic="$item['semantic'] ?? 'neutral'"
            :kind="$isDangerItem ? 'danger' : 'default'"
            :tone="$item['tone'] ?? null"
            :danger="$isDangerItem"
            :danger-description="$item['dangerDescription'] ?? $item['danger_description'] ?? null"
            :disabled="$item['disabled'] ?? false"
            :shortcut="$item['shortcut'] ?? null"
            :icon="$item['icon'] ?? null"
            submenu
            :size="$resolvedSize"
            :state="$item['state'] ?? null"
            :title="$item['title'] ?? null"
            :reserve-indicator="$reservesSelectionIndicator">
            {{ $item['label'] }}
        </x-ui.menu-item>

        {{-- Submenu surface --}}
        <div
            class="ui-menu ui-menu--{{ $resolvedSize }} ui-menu-submenu-panel"
            role="menu"
            tabindex="-1"
            data-ui-menu-submenu-panel
            data-ui-menu-size="{{ $resolvedSize }}"
            hidden>
            @foreach ($children as $child)
            @php
            $childIsDivider = ($child['divider'] ?? false) || (($child['type'] ?? 'item') === 'divider');
            $childHasLabel = filled($child['label'] ?? null);

            $childSelectionType = $child['selection_type'] ?? $child['selectionType'] ?? null;
            $resolvedChildSelectionType = $childSelectionType === 'multi' ? 'multiple' : $childSelectionType;

            $isDangerChild = ($child['danger'] ?? false) || (($child['tone'] ?? null) === 'danger');
            @endphp

            @continue(! $childIsDivider && ! $childHasLabel)

            @if ($child['dividerBefore'] ?? $child['divider_before'] ?? false)
            <x-ui.menu-item type="divider" />
            @endif

            @if ($childIsDivider)
            <x-ui.menu-item type="divider" />
            @else
            <x-ui.menu-item
                href="{{ $child['href'] ?? null }}"
                :semantic="$child['semantic'] ?? 'neutral'"
                :kind="$isDangerChild ? 'danger' : 'default'"
                :tone="$child['tone'] ?? null"
                :danger="$isDangerChild"
                :danger-description="$child['dangerDescription'] ?? $child['danger_description'] ?? null"
                :action="$child['action'] ?? null"
                :method="$child['method'] ?? null"
                :current="$child['current'] ?? false"
                :selected="$child['selected'] ?? false"
                :disabled="$child['disabled'] ?? false"
                :shortcut="$child['shortcut'] ?? null"
                :icon="$child['icon'] ?? null"
                :size="$resolvedSize"
                :state="$child['state'] ?? null"
                :selection-type="$resolvedChildSelectionType"
                :title="$child['title'] ?? null">
                {{ $child['label'] }}
            </x-ui.menu-item>
            @endif
            @endforeach
        </div>
        @else
        <x-ui.menu-item
            href="{{ $item['href'] ?? null }}"
            :semantic="$item['semantic'] ?? 'neutral'"
            :kind="$isDangerItem ? 'danger' : 'default'"
            :tone="$item['tone'] ?? null"
            :danger="$isDangerItem"
            :danger-description="$item['dangerDescription'] ?? $item['danger_description'] ?? null"
            :action="$item['action'] ?? null"
            :method="$item['method'] ?? null"
            :current="$item['current'] ?? false"
            :selected="$item['selected'] ?? false"
            :disabled="$item['disabled'] ?? false"
            :shortcut="$item['shortcut'] ?? null"
            :icon="$item['icon'] ?? null"
            :submenu="$hasSubmenu"
            :size="$resolvedSize"
            :state="$item['state'] ?? null"
            :selection-type="$resolvedSelectionType"
            :title="$item['title'] ?? null"
            :reserve-indicator="$reservesSelectionIndicator">
            {{ $item['label'] }}
        </x-ui.menu-item>
        @endif
        @endforeach

        {{-- Render explicit slot content after item-array content. --}}
        @if ($hasSlotContent)
        {{ $slot }}
        @endif
    </div>
</div>
@else
{{-- ----------------------------------------------------------------------
        Triggerless menu surface
        ----------------------------------------------------------------------
        Used when another component owns the trigger and ARIA relationship.
        Attributes passed to <x-ui.menu> are applied to the surface itself.
        ---------------------------------------------------------------------- --}}

<div
    id="{{ $panelId }}"
    {{ $attributes->class($panelClasses)->merge([
            'role' => 'menu',
            'tabindex' => '-1',
            'data-ui-menu' => true,
            'data-ui-menu-panel' => true,
            'data-ui-menu-placement' => $resolvedAlign,
            'data-ui-menu-size' => $resolvedSize,
            'data-ui-menu-background-token' => $resolvedBackgroundToken,
            'aria-label' => filled($resolvedMenuLabel) ? $resolvedMenuLabel : null,
            'hidden' => ! $isOpen ? true : null,
        ]) }}>
    {{-- Render item-array content first. --}}
    @foreach ($visibleItems as $item)
    @php
    $isDivider = ($item['divider'] ?? false) || (($item['type'] ?? 'item') === 'divider');
    $hasLabel = filled($item['label'] ?? null);

    $children = collect($item['children'] ?? [])->reject(fn ($child) => $child['hidden'] ?? false);
    $hasSubmenu = $children->isNotEmpty();

    $selectionType = $item['selection_type'] ?? $item['selectionType'] ?? null;
    $resolvedSelectionType = $selectionType === 'multi' ? 'multiple' : $selectionType;

    $isDangerItem = ($item['danger'] ?? false) || (($item['tone'] ?? null) === 'danger');
    @endphp

    @continue(! $isDivider && ! $hasLabel)

    @if ($item['dividerBefore'] ?? $item['divider_before'] ?? false)
    <x-ui.menu-item type="divider" />
    @endif

    @if ($isDivider)
    <x-ui.menu-item type="divider" />
    @elseif ($hasSubmenu)
    {{-- Submenu trigger item --}}
    <x-ui.menu-item
        :semantic="$item['semantic'] ?? 'neutral'"
        :kind="$isDangerItem ? 'danger' : 'default'"
        :tone="$item['tone'] ?? null"
        :danger="$isDangerItem"
        :danger-description="$item['dangerDescription'] ?? $item['danger_description'] ?? null"
        :disabled="$item['disabled'] ?? false"
        :shortcut="$item['shortcut'] ?? null"
        :icon="$item['icon'] ?? null"
        submenu
        :size="$resolvedSize"
        :state="$item['state'] ?? null"
        :title="$item['title'] ?? null"
        :reserve-indicator="$reservesSelectionIndicator">
        {{ $item['label'] }}
    </x-ui.menu-item>

    {{-- Submenu surface --}}
    <div
        class="ui-menu ui-menu--{{ $resolvedSize }} ui-menu-submenu-panel"
        role="menu"
        tabindex="-1"
        data-ui-menu-submenu-panel
        data-ui-menu-size="{{ $resolvedSize }}"
        hidden>
        @foreach ($children as $child)
        @php
        $childIsDivider = ($child['divider'] ?? false) || (($child['type'] ?? 'item') === 'divider');
        $childHasLabel = filled($child['label'] ?? null);

        $childSelectionType = $child['selection_type'] ?? $child['selectionType'] ?? null;
        $resolvedChildSelectionType = $childSelectionType === 'multi' ? 'multiple' : $childSelectionType;

        $isDangerChild = ($child['danger'] ?? false) || (($child['tone'] ?? null) === 'danger');
        @endphp

        @continue(! $childIsDivider && ! $childHasLabel)

        @if ($child['dividerBefore'] ?? $child['divider_before'] ?? false)
        <x-ui.menu-item type="divider" />
        @endif

        @if ($childIsDivider)
        <x-ui.menu-item type="divider" />
        @else
        <x-ui.menu-item
            href="{{ $child['href'] ?? null }}"
            :semantic="$child['semantic'] ?? 'neutral'"
            :kind="$isDangerChild ? 'danger' : 'default'"
            :tone="$child['tone'] ?? null"
            :danger="$isDangerChild"
            :danger-description="$child['dangerDescription'] ?? $child['danger_description'] ?? null"
            :action="$child['action'] ?? null"
            :method="$child['method'] ?? null"
            :current="$child['current'] ?? false"
            :selected="$child['selected'] ?? false"
            :disabled="$child['disabled'] ?? false"
            :shortcut="$child['shortcut'] ?? null"
            :icon="$child['icon'] ?? null"
            :size="$resolvedSize"
            :state="$child['state'] ?? null"
            :selection-type="$resolvedChildSelectionType"
            :title="$child['title'] ?? null">
            {{ $child['label'] }}
        </x-ui.menu-item>
        @endif
        @endforeach
    </div>
    @else
    <x-ui.menu-item
        href="{{ $item['href'] ?? null }}"
        :semantic="$item['semantic'] ?? 'neutral'"
        :kind="$isDangerItem ? 'danger' : 'default'"
        :tone="$item['tone'] ?? null"
        :danger="$isDangerItem"
        :danger-description="$item['dangerDescription'] ?? $item['danger_description'] ?? null"
        :action="$item['action'] ?? null"
        :method="$item['method'] ?? null"
        :current="$item['current'] ?? false"
        :selected="$item['selected'] ?? false"
        :disabled="$item['disabled'] ?? false"
        :shortcut="$item['shortcut'] ?? null"
        :icon="$item['icon'] ?? null"
        :submenu="$hasSubmenu"
        :size="$resolvedSize"
        :state="$item['state'] ?? null"
        :selection-type="$resolvedSelectionType"
        :title="$item['title'] ?? null"
        :reserve-indicator="$reservesSelectionIndicator">
        {{ $item['label'] }}
    </x-ui.menu-item>
    @endif
    @endforeach

    {{-- Render explicit slot content after item-array content. --}}
    @if ($hasSlotContent)
    {{ $slot }}
    @endif
</div>
@endif