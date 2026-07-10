<section {{ $attributes->class(['ui-pattern-search-filter-bar']) }} data-ui-pattern="search-filter-bar">
    <div class="ui-pattern-search-filter-main">
        {{ $slot }}
    </div>

    @isset($actions)
        <div class="ui-pattern-search-filter-actions">
            {{ $actions }}
        </div>
    @endisset
</section>
