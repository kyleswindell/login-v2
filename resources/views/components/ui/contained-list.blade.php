@props([
    'title' => null,
    'description' => null,
    'items' => [],
    'variant' => 'on-page',
    'size' => 'md',
    'titleIcon' => null,
    'headerActionLabel' => null,
    'headerActionIcon' => 'heroicon-o-magnifying-glass',
    'headerActionHref' => null,
    'headerActionTooltip' => null,
    'insetDividers' => false,
    'stickyHeader' => false,
    'loading' => false,
    'emptyTitle' => 'No items',
    'emptyDescription' => null,
])

@php
    $variant = in_array($variant, ['on-page', 'disclosed', 'elevated'], true) ? $variant : 'on-page';
    $size = in_array($size, ['sm', 'md', 'lg', 'xl'], true) ? $size : 'md';
    $hasHeaderAction = filled($headerActionLabel);
@endphp

<section
    {{ $attributes->class(['ui-contained-list', 'ui-contained-list-inset-dividers' => $insetDividers]) }}
    data-ui-component="contained-list"
    data-ui-contained-list
    data-ui-contained-list-variant="{{ $variant }}"
    data-ui-contained-list-size="{{ $size }}"
    data-ui-contained-list-inset-dividers="{{ $insetDividers ? 'true' : 'false' }}"
    @if($loading) aria-busy="true" @endif
>
    @if ($title || $description)
        <header @class(['ui-contained-list-header', 'ui-contained-list-header-sticky' => $stickyHeader])>
            <span class="ui-contained-list-header-content">
                @if ($title)
                    <h3 class="ui-contained-list-title">
                        @if ($titleIcon)
                            <x-dynamic-component :component="$titleIcon" class="ui-contained-list-title-icon" aria-hidden="true" />
                        @endif
                        <span>{{ $title }}</span>
                    </h3>
                @endif
                @if ($description)
                    <p class="ui-contained-list-description">{{ $description }}</p>
                @endif
            </span>
            @if ($hasHeaderAction)
                <span class="ui-contained-list-header-actions">
                    <x-ui.icon-button
                        :href="$headerActionHref"
                        :icon="$headerActionIcon"
                        :label="$headerActionLabel"
                        :tooltip="$headerActionTooltip ?? $headerActionLabel"
                        tooltip-placement="auto"
                        size="sm"
                        semantic="ghost"
                    />
                </span>
            @endif
        </header>
    @endif

    <div class="ui-contained-list-body" data-ui-contained-list-body role="list">
        @if ($loading)
            <div class="ui-contained-list-state" data-ui-contained-list-loading>
                Loading list items
            </div>
        @elseif (! empty($items))
            @foreach ($items as $item)
                <x-ui.contained-list-item
                    :title="data_get($item, 'title')"
                    :description="data_get($item, 'description')"
                    :meta="data_get($item, 'meta')"
                    :href="data_get($item, 'href')"
                    :icon="data_get($item, 'icon')"
                    :status="data_get($item, 'status')"
                    :action-items="data_get($item, 'actions', [])"
                    :selected="(bool) data_get($item, 'selected', false)"
                    :current="(bool) data_get($item, 'current', false)"
                    :disabled="(bool) data_get($item, 'disabled', false)"
                />
            @endforeach
        @elseif (trim((string) $slot) !== '')
            {{ $slot }}
        @else
            <div class="ui-contained-list-state" data-ui-contained-list-empty>
                <p class="ui-contained-list-state-title">{{ $emptyTitle }}</p>
                @if ($emptyDescription)
                    <p class="ui-contained-list-state-description">{{ $emptyDescription }}</p>
                @endif
            </div>
        @endif
    </div>
</section>
