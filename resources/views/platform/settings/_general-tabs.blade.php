@php($generalTab = $generalTab ?? 'general')

<x-ui.patterns.sub-navigation-bar
    :items="[
        ['label' => 'General', 'href' => route('platform.settings.general'), 'current' => $generalTab === 'general'],
        ['label' => 'Company Information', 'href' => route('platform.settings.general.company-information'), 'current' => $generalTab === 'company-information'],
        ['label' => 'Localization', 'href' => route('platform.settings.general.localization'), 'current' => $generalTab === 'localization'],
        ['label' => 'Email', 'href' => route('platform.settings.general.email'), 'current' => $generalTab === 'email'],
        ['label' => 'System Update', 'href' => route('platform.settings.general.system-update'), 'current' => $generalTab === 'system-update'],
        ['label' => 'System / Server Info', 'href' => route('platform.settings.general.system-server-info'), 'current' => $generalTab === 'system-server-info'],
    ]"
/>
