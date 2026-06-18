@props([
    'items' => [],
    'triggerLabel' => 'Actions',
    'triggerKind' => 'text',
    'triggerIcon' => null,
    'triggerVariant' => null,
    'size' => 'md',
    'align' => 'bottom-start',
    'placement' => null,
    'open' => false,
    'disabled' => false,
    'id' => null,
    'menuLabel' => null,
    'triggerClass' => null,
    'triggerTooltip' => null,
    'rtl' => false,
])

@php
    $resolvedSize = in_array($size, ['xs', 'sm', 'md', 'lg'], true) ? $size : 'md';
    $requestedPlacement = $placement ?? $align;
    $resolvedAlign = in_array($requestedPlacement, ['top-start', 'top-end', 'bottom-start', 'bottom-end'], true) ? $requestedPlacement : 'bottom-start';
    $rootId = $id ?? 'ui-menu-'.Illuminate\Support\Str::uuid()->toString();
    $panelId = $rootId.'-panel';
    $isIconTrigger = $triggerKind === 'icon' || filled($triggerIcon);
    $resolvedTriggerVariant = $triggerVariant ?? ($isIconTrigger ? 'ghost' : 'tertiary');
    $resolvedTriggerIcon = $triggerIcon ?? ($isIconTrigger ? 'heroicon-o-ellipsis-vertical' : null);
    $resolvedTriggerClass = filled($triggerClass) ? $triggerClass : null;
    $visibleItems = collect($items)->reject(fn ($item) => $item['hidden'] ?? false);
    $reservesSelectionIndicator = $visibleItems->contains(fn ($item) => ($item['selected'] ?? false) || filled($item['selection_type'] ?? $item['selectionType'] ?? null));
@endphp

<div
    {{ $attributes->class(['ui-menu-composition', 'ui-menu-composition-rtl' => $rtl]) }}
    id="{{ $rootId }}"
    data-ui-component="menu-composition"
    data-ui-menu-open="{{ $open ? 'true' : 'false' }}"
    @if ($rtl) dir="rtl" @endif
>
    @if ($isIconTrigger)
        <x-ui.icon-button
            label="{{ $triggerLabel }}"
            :semantic="$resolvedTriggerVariant"
            :size="$resolvedSize"
            :icon="$resolvedTriggerIcon"
            :tooltip="$triggerTooltip"
            :disabled="$disabled"
            :class="$resolvedTriggerClass"
            data-ui-menu-trigger
            aria-haspopup="menu"
            aria-expanded="{{ $open ? 'true' : 'false' }}"
            aria-controls="{{ $panelId }}"
        />
    @else
        <x-ui.button
            :semantic="$resolvedTriggerVariant"
            :size="$resolvedSize"
            icon="heroicon-o-chevron-down"
            :disabled="$disabled"
            :class="$resolvedTriggerClass"
            data-ui-menu-trigger
            aria-haspopup="menu"
            aria-expanded="{{ $open ? 'true' : 'false' }}"
            aria-controls="{{ $panelId }}"
        >
            {{ $triggerLabel }}
        </x-ui.button>
    @endif

    <div
        id="{{ $panelId }}"
        class="ui-menu ui-menu-{{ $resolvedSize }} ui-menu-align-{{ $resolvedAlign }}"
        role="menu"
        data-ui-menu
        data-ui-menu-panel
        data-ui-menu-placement="{{ $resolvedAlign }}"
        data-ui-menu-size="{{ $resolvedSize }}"
        @if (filled($menuLabel)) aria-label="{{ $menuLabel }}" @endif
        @if (! $open || $disabled) hidden @endif
    >
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
            @elseif ($children->isNotEmpty())
                <div class="ui-menu-submenu-group" data-ui-menu-submenu>
                    <x-ui.menu-item
                        :semantic="$item['semantic'] ?? 'neutral'"
                        :tone="$item['tone'] ?? null"
                        :danger="$isDangerItem"
                        :danger-description="$item['dangerDescription'] ?? $item['danger_description'] ?? null"
                        :disabled="$item['disabled'] ?? false"
                        :shortcut="$item['shortcut'] ?? null"
                        submenu
                        :size="$resolvedSize"
                        :state="$item['state'] ?? null"
                        :title="$item['title'] ?? null"
                        :reserve-indicator="$reservesSelectionIndicator"
                    >
                        {{ $item['label'] }}
                    </x-ui.menu-item>

                    <div
                        class="ui-menu ui-menu-{{ $resolvedSize }} ui-menu-submenu-panel"
                        role="menu"
                        data-ui-menu-submenu-panel
                        data-ui-menu-size="{{ $resolvedSize }}"
                        hidden
                    >
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
                                    :tone="$child['tone'] ?? null"
                                    :danger="$isDangerChild"
                                    :danger-description="$child['dangerDescription'] ?? $child['danger_description'] ?? null"
                                    :action="$child['action'] ?? null"
                                    :method="$child['method'] ?? null"
                                    :current="$child['current'] ?? false"
                                    :selected="$child['selected'] ?? false"
                                    :disabled="$child['disabled'] ?? false"
                                    :shortcut="$child['shortcut'] ?? null"
                                    :size="$resolvedSize"
                                    :state="$child['state'] ?? null"
                                    :selection-type="$resolvedChildSelectionType"
                                    :title="$child['title'] ?? null"
                                >
                                    {{ $child['label'] }}
                                </x-ui.menu-item>
                            @endif
                        @endforeach
                    </div>
                </div>
            @else
                <x-ui.menu-item
                    href="{{ $item['href'] ?? null }}"
                    :semantic="$item['semantic'] ?? 'neutral'"
                    :tone="$item['tone'] ?? null"
                    :danger="$isDangerItem"
                    :danger-description="$item['dangerDescription'] ?? $item['danger_description'] ?? null"
                    :action="$item['action'] ?? null"
                    :method="$item['method'] ?? null"
                    :current="$item['current'] ?? false"
                    :selected="$item['selected'] ?? false"
                    :disabled="$item['disabled'] ?? false"
                    :shortcut="$item['shortcut'] ?? null"
                    :submenu="$hasSubmenu"
                    :size="$resolvedSize"
                    :state="$item['state'] ?? null"
                    :selection-type="$resolvedSelectionType"
                    :title="$item['title'] ?? null"
                    :reserve-indicator="$reservesSelectionIndicator"
                >
                    {{ $item['label'] }}
                </x-ui.menu-item>
            @endif
        @endforeach

        @if (trim($slot->toHtml()) !== '')
            {{ $slot }}
        @endif
    </div>
</div>
