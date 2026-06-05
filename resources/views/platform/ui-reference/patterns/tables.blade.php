<x-layouts.app title="UI Reference · Table Baselines">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.tables'])
    </x-slot:sidebar>

    @php
        $tablesUrl = function (array $overrides = [], string $anchor = '') {
            $query = array_merge(request()->query(), $overrides);

            return route('platform.ui-reference.patterns.tables').($query !== [] ? '?'.http_build_query($query) : '').$anchor;
        };

        $sortMeta = function (
            string $currentSort,
            string $currentDirection,
            string $column,
            string $defaultDirection = 'asc'
        ): array {
            $active = $currentSort === $column;
            $nextDirection = $active && $currentDirection === 'asc' ? 'desc' : 'asc';
            $initialDirection = $active ? $currentDirection : $defaultDirection;

            return [
                'active' => $active,
                'aria' => $active ? ($currentDirection === 'asc' ? 'ascending' : 'descending') : null,
                'next' => $nextDirection,
                'icon_component' => $active
                    ? ($currentDirection === 'asc' ? 'heroicon-o-arrow-small-up' : 'heroicon-o-arrow-small-down')
                    : 'heroicon-o-arrows-up-down',
                'sr_label' => $active
                    ? 'Sorted '.($currentDirection === 'asc' ? 'ascending' : 'descending').'. Activate to sort '.($nextDirection === 'asc' ? 'ascending' : 'descending').'.'
                    : 'Not currently sorted. Activate to sort '.($initialDirection === 'asc' ? 'ascending' : 'descending').'.',
            ];
        };
    @endphp

    <section class="flex flex-1 flex-col gap-6" data-ui-reference-tables-root>
        @include('platform.ui-reference.patterns.tables.intro')
        @include('platform.ui-reference.patterns.tables.workspace')
        @include('platform.ui-reference.patterns.tables.state-validation')
        @include('platform.ui-reference.patterns.tables.audit')
        @include('platform.ui-reference.patterns.tables.error')
        @include('platform.ui-reference.patterns.tables.drawers')
    </section>
</x-layouts.app>
