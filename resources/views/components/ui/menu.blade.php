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
    $visibleItems = collect($items)->reject(fn ($item) => $item['hidden'] ?? false);
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
            :icon="$triggerIcon"
            :disabled="$disabled"
            data-ui-menu-trigger
            aria-haspopup="menu"
            aria-expanded="{{ $open ? 'true' : 'false' }}"
            aria-controls="{{ $panelId }}"
        >
            @unless (filled($triggerIcon))
                <span aria-hidden="true">...</span>
            @endunless
        </x-ui.icon-button>
    @else
        <x-ui.button
            :semantic="$resolvedTriggerVariant"
            :size="$resolvedSize"
            :disabled="$disabled"
            data-ui-menu-trigger
            aria-haspopup="menu"
            aria-expanded="{{ $open ? 'true' : 'false' }}"
            aria-controls="{{ $panelId }}"
        >
            {{ $triggerLabel }}
            <span aria-hidden="true">v</span>
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
                $selectionType = $item['selection_type'] ?? $item['selectionType'] ?? null;
                $resolvedSelectionType = $selectionType === 'multi' ? 'multiple' : $selectionType;
            @endphp

            @if ($isDivider)
                <div class="ui-menu-divider" role="separator"></div>
            @else
                <x-ui.menu-item
                    href="{{ $item['href'] ?? null }}"
                    :semantic="($item['danger'] ?? false) ? 'danger' : ($item['semantic'] ?? 'neutral')"
                    :current="$item['current'] ?? false"
                    :selected="$item['selected'] ?? false"
                    :disabled="$item['disabled'] ?? false"
                    :shortcut="$item['shortcut'] ?? null"
                    :submenu="$item['submenu'] ?? false"
                    :size="$resolvedSize"
                    :state="$item['state'] ?? null"
                    :selection-type="$resolvedSelectionType"
                    :title="$item['title'] ?? null"
                >
                    {{ $item['label'] }}
                </x-ui.menu-item>
            @endif
        @endforeach
    </div>
</div>
