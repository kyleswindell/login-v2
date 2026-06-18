@php
    $items = $sample['items'] ?? [];
    $triggerLabel = $sample['trigger_label'] ?? 'Actions';
    $triggerKind = $sample['trigger_kind'] ?? 'text';
    $size = $sample['size'] ?? 'md';
    $align = $sample['align'] ?? 'bottom-start';
    $open = $sample['open'] ?? false;
    $rtl = $sample['rtl'] ?? false;
    $proofPanel = $sample['proof_panel'] ?? false;
@endphp

<div class="space-y-4" data-menu-live-proof>
    <x-ui.menu
        :items="$items"
        :trigger-label="$triggerLabel"
        :trigger-kind="$triggerKind"
        :size="$size"
        :align="$align"
        :open="$open"
        :rtl="$rtl"
    />

    @if ($proofPanel)
        @php
            $proofSize = in_array($size, ['xs', 'sm', 'md', 'lg'], true) ? $size : 'md';
            $proofAlign = in_array($align, ['top-start', 'top-end', 'bottom-start', 'bottom-end'], true) ? $align : 'bottom-start';
            $proofItems = collect($items)->reject(fn ($item) => $item['hidden'] ?? false);
            $proofReservesSelectionIndicator = $proofItems->contains(fn ($item) => ($item['selected'] ?? false) || filled($item['selection_type'] ?? $item['selectionType'] ?? null));
        @endphp

        <div
            class="ui-menu ui-menu-{{ $proofSize }} ui-menu-proof-panel"
            role="menu"
            data-ui-menu-proof-panel
            data-ui-menu-placement="{{ $proofAlign }}"
            data-ui-menu-size="{{ $proofSize }}"
            @if ($rtl) dir="rtl" @endif
        >
            @foreach ($proofItems as $item)
                @php
                    $isDivider = ($item['divider'] ?? false) || (($item['type'] ?? 'item') === 'divider');
                    $hasLabel = filled($item['label'] ?? null);
                    $children = collect($item['children'] ?? [])->reject(fn ($child) => $child['hidden'] ?? false);
                    $hasSubmenu = $children->isNotEmpty();
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
                            :current="$item['current'] ?? false"
                            :selected="$item['selected'] ?? false"
                            :disabled="$item['disabled'] ?? false"
                            :shortcut="$item['shortcut'] ?? null"
                            submenu
                            :size="$proofSize"
                            :state="$item['state'] ?? null"
                            :selection-type="$item['selection_type'] ?? $item['selectionType'] ?? null"
                            :title="$item['title'] ?? null"
                            :reserve-indicator="$proofReservesSelectionIndicator"
                        >
                            {{ $item['label'] }}
                        </x-ui.menu-item>

                        <div
                            class="ui-menu ui-menu-{{ $proofSize }} ui-menu-submenu-panel"
                            role="menu"
                            data-ui-menu-submenu-panel
                            data-ui-menu-size="{{ $proofSize }}"
                            hidden
                        >
                            @foreach ($children as $child)
                                @php
                                    $childIsDivider = ($child['divider'] ?? false) || (($child['type'] ?? 'item') === 'divider');
                                    $childHasLabel = filled($child['label'] ?? null);
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
                                        :size="$proofSize"
                                        :state="$child['state'] ?? null"
                                        :selection-type="$child['selection_type'] ?? $child['selectionType'] ?? null"
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
                        :size="$proofSize"
                        :state="$item['state'] ?? null"
                        :selection-type="$item['selection_type'] ?? $item['selectionType'] ?? null"
                        :title="$item['title'] ?? null"
                        :reserve-indicator="$proofReservesSelectionIndicator"
                    >
                        {{ $item['label'] }}
                    </x-ui.menu-item>
                @endif
            @endforeach
        </div>
        <p class="ui-menu-proof-note">Static proof panel uses <code>x-ui.menu-item</code> states without forcing the interactive menu open.</p>
    @endif
</div>
