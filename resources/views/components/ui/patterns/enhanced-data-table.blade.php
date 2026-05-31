@props([
    'label' => null,
    'description' => null,
])

<section {{ $attributes->class(['ui-pattern-enhanced-table']) }} data-ui-pattern="enhanced-data-table">
    @if ($label || $description)
        <div class="mb-4">
            @if ($label)
                <p class="ui-kicker">{{ $label }}</p>
            @endif
            @if ($description)
                <p class="ui-card-copy @if($label) mt-2 @endif">{{ $description }}</p>
            @endif
        </div>
    @endif

    @isset($toolbar)
        <div class="ui-pattern-enhanced-table-toolbar">
            {{ $toolbar }}
        </div>
    @endisset

    @isset($filters)
        <div class="ui-pattern-enhanced-table-filters">
            {{ $filters }}
        </div>
    @endisset

    <div class="ui-pattern-enhanced-table-surface">
        {{ $slot }}
    </div>

    @isset($pagination)
        <div class="ui-pattern-enhanced-table-pagination">
            {{ $pagination }}
        </div>
    @endisset
</section>
