@if ($icon)
    <span class="ui-tile__icon" aria-hidden="true">
        <x-dynamic-component :component="$icon" />
    </span>
@endif

@if ($meta)
    <span class="ui-tile__meta">{{ $meta }}</span>
@endif

@if ($title || $usesSlotAsTitle)
    <span class="ui-tile__title">{{ $title ?? $slot }}</span>
@endif

@if ($description)
    <span class="ui-tile__description">{{ $description }}</span>
@endif

@if ($hasBody)
    <div class="ui-tile__body">{{ $slot }}</div>
@endif
