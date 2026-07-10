@props([
    'items' => [],
])

<nav {{ $attributes->class(['ui-pattern-subnav']) }} aria-label="Section navigation" data-ui-pattern="sub-navigation-bar">
    @foreach ($items as $item)
        @php
            $isCurrent = (bool) ($item['current'] ?? false);
            $isDisabled = (bool) ($item['disabled'] ?? false);
        @endphp

        @if ($isDisabled)
            <span class="ui-pattern-subnav-item is-disabled" aria-disabled="true">{{ $item['label'] }}</span>
        @else
            <a
                href="{{ $item['href'] ?? '#' }}"
                @if ($isCurrent) aria-current="page" @endif
                @class(['ui-pattern-subnav-item', 'is-current' => $isCurrent])
            >
                {{ $item['label'] }}
            </a>
        @endif
    @endforeach
</nav>
