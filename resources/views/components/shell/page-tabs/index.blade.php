{{-- ==========================================================================
    File: resources/views/components/shell/page-tabs/index.blade.php
    Purpose: UI shell page tabs navigation.

    Notes:
    - Renders page-level variant links such as Usage, Examples, Accessibility,
      and Implementation.
    - These are navigation links, not in-page tab panels.
    - Use x-ui.tabs for interactive tab panels. Use this component for
      route/page navigation.
    - Page tabs own route-style navigation anatomy only. Page content, selected
      route state, and page layout are owned by the caller.
    ========================================================================== --}}

@props([
    'items' => [],
    'label' => 'Page sections',
])

@php
    /*
    |--------------------------------------------------------------------------
    | Normalize Items
    |--------------------------------------------------------------------------
    */

    $tabItems = collect($items)->map(function ($item) {
        return [
            'label' => (string) data_get($item, 'label', ''),
            'href' => data_get($item, 'href', '#') ?: '#',
            'current' => (bool) (
                data_get($item, 'current')
                ?? data_get($item, 'active')
                ?? false
            ),
            'wireNavigate' => (bool) data_get($item, 'wireNavigate', false),
        ];
    })->filter(fn ($item) => filled($item['label']))->values();

    /*
    |--------------------------------------------------------------------------
    | Resolve Rendering State
    |--------------------------------------------------------------------------
    */

    $hasSlotContent = trim((string) $slot) !== '';
    $hasItems = $tabItems->isNotEmpty();
    $selectedCount = $tabItems->filter(fn ($item) => $item['current'])->count();

    /*
    |--------------------------------------------------------------------------
    | Resolve Accessible Label
    |--------------------------------------------------------------------------
    */

    $resolvedLabel = $attributes->get('aria-label') ?? $label ?? 'Page sections';

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    |
    | aria-label is owned by this component so label and caller aria-label
    | resolve to a single output.
    |
    */

    $navAttributes = $attributes->except([
        'aria-label',
    ]);
@endphp

@if ($hasItems || $hasSlotContent)
    <nav
        {{ $navAttributes->class('ui-shell-page-tabs')->merge([
            'aria-label' => $resolvedLabel,
            'data-ui-component' => 'shell-page-tabs',
            'data-ui-shell-page-tabs' => true,
            'data-ui-shell-page-tabs-source' => $hasSlotContent ? 'slot' : 'items',
            'data-ui-shell-page-tabs-count' => $tabItems->count(),
            'data-ui-shell-page-tabs-selected-count' => $selectedCount,
        ]) }}
    >
        @if ($hasSlotContent)
            {{ $slot }}
        @else
            <ul class="ui-shell-page-tabs__list">
                @foreach ($tabItems as $item)
                    <li
                        @class([
                            'ui-shell-page-tabs__item',
                            'ui-shell-page-tabs__item--selected' => $item['current'],
                        ])
                        data-ui-shell-page-tabs-item
                        @if ($item['current']) data-ui-shell-page-tabs-selected="true" @endif
                    >
                        <a
                            href="{{ $item['href'] }}"
                            @class([
                                'ui-shell-page-tabs__link',
                                'ui-shell-page-tabs__link--selected' => $item['current'],
                            ])
                            @if ($item['current']) aria-current="page" @endif
                            @if ($item['wireNavigate']) wire:navigate @endif
                            data-ui-shell-page-tabs-link
                        >
                            {{ $item['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </nav>
@endif