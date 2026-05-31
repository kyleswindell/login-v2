@props([
    'label' => 'Actions',
    'iconOnly' => false,
])

<details {{ $attributes->class(['ui-pattern-dropdown-menu']) }} data-ui-pattern="dropdown-action-menu">
    <summary class="ui-pattern-dropdown-trigger">
        @if ($iconOnly)
            <span class="ui-icon-button" aria-label="{{ $label }}">
                <x-heroicon-o-ellipsis-horizontal class="h-4 w-4" aria-hidden="true" />
            </span>
        @else
            <span class="ui-action ui-action-outline ui-action-sm">
                {{ $label }}
                <x-heroicon-o-chevron-down class="h-4 w-4" aria-hidden="true" />
            </span>
        @endif
    </summary>

    <div class="ui-pattern-dropdown-panel">
        {{ $slot }}
    </div>
</details>
