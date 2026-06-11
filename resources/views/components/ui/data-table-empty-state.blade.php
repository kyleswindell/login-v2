@props([
    'title' => 'No records',
    'description' => null,
])

<div {{ $attributes->class(['ui-data-table-empty']) }} data-ui-data-table-empty>
    <p class="ui-data-table-empty-title">{{ $title }}</p>
    @if($description)
        <p class="ui-data-table-empty-description">{{ $description }}</p>
    @endif
    {{ $slot }}
</div>
