@php($generalTab = $generalTab ?? 'general')

@php
    $generalTabItems = [
        ['label' => 'General', 'href' => route('platform.settings.general'), 'current' => $generalTab === 'general'],
        ['label' => 'Company Information', 'href' => route('platform.settings.general.company-information'), 'current' => $generalTab === 'company-information'],
        ['label' => 'Localization', 'href' => route('platform.settings.general.localization'), 'current' => $generalTab === 'localization'],
        ['label' => 'Email', 'href' => route('platform.settings.general.email'), 'current' => $generalTab === 'email'],
        ['label' => 'System Update', 'href' => route('platform.settings.general.system-update'), 'current' => $generalTab === 'system-update'],
        ['label' => 'System / Server Info', 'href' => route('platform.settings.general.system-server-info'), 'current' => $generalTab === 'system-server-info'],
    ];
@endphp

<ul class="ui-shell-page-tabs__list">
    @foreach ($generalTabItems as $item)
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
                wire:navigate
                data-ui-shell-page-tabs-link
            >
                {{ $item['label'] }}
            </a>
        </li>
    @endforeach
</ul>
