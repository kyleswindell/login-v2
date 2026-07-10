{{-- ==========================================================================
    File: Modules/Setup/resources/views/index.blade.php
    Purpose: Setup module landing page.
========================================================================== --}}

<x-layouts.app
    :title="__('setup::module.title')"
    :page-title="__('setup::module.title')"
    :page-subtitle="__('setup::module.description')"
    :reserve-page-tabs="true"
>
    <x-ui.grid-column
        tag="section"
        span="100"
        lg="12"
        xlg="12"
    >
        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-3" aria-label="{{ __('setup::module.landing_title') }}">
            @forelse ($setupItems as $item)
                <x-ui.tile
                    :title="$item['label']"
                    :icon="$item['icon']"
                    data-setup-landing-tile
                    data-setup-route="{{ $item['route_name'] }}"
                >
                    <x-slot name="actions">
                        <x-ui.button
                            :href="$item['href']"
                            kind="primary"
                            size="md"
                            wire:navigate
                        >
                            {{ __('setup::module.open_action') }}
                        </x-ui.button>
                    </x-slot>
                </x-ui.tile>
            @empty
                <x-ui.tile
                    :title="__('setup::module.no_pages_title')"
                    :description="__('setup::module.no_pages_description')"
                />
            @endforelse
        </section>
    </x-ui.grid-column>
</x-layouts.app>
