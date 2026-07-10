{{-- ==========================================================================
    File: Modules/Settings/resources/views/index.blade.php
    Purpose: Settings module landing page.
========================================================================== --}}

<x-layouts.app
    :title="__('settings::module.title')"
    :page-title="__('settings::module.title')"
    :page-subtitle="__('settings::module.description')"
    :reserve-page-tabs="true"
>
    <x-ui.grid-column
        tag="section"
        span="100"
        lg="12"
        xlg="12"
    >
        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-3" aria-label="{{ __('settings::module.landing_title') }}">
            @forelse ($settingsItems as $item)
                <x-ui.tile
                    :title="$item['label']"
                    :icon="$item['icon']"
                    data-settings-landing-tile
                    data-settings-route="{{ $item['route_name'] }}"
                >
                    <x-slot name="actions">
                        <x-ui.button
                            :href="$item['href']"
                            kind="primary"
                            size="md"
                            wire:navigate
                        >
                            {{ __('settings::module.open_action') }}
                        </x-ui.button>
                    </x-slot>
                </x-ui.tile>
            @empty
                <x-ui.tile
                    :title="__('settings::module.no_pages_title')"
                    :description="__('settings::module.no_pages_description')"
                />
            @endforelse
        </section>
    </x-ui.grid-column>
</x-layouts.app>
