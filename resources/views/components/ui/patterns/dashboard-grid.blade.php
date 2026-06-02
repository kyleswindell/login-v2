@props([
    'columns' => '3',
])

@php
    $columnClasses = match ((string) $columns) {
        '2' => 'md:grid-cols-2',
        '4' => 'md:grid-cols-2 xl:grid-cols-4',
        'widgets' => 'ui-pattern-dashboard-grid-widgets grid-flow-dense md:grid-cols-2 xl:grid-cols-6',
        '12' => 'md:grid-cols-2 xl:grid-cols-12',
        default => 'md:grid-cols-2 xl:grid-cols-3',
    };
@endphp

<div {{ $attributes->class(['ui-pattern-dashboard-grid', 'grid gap-4', $columnClasses])->merge(['data-ui-pattern' => 'dashboard-grid']) }}>
    {{ $slot }}
</div>
