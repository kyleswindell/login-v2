{{-- ==========================================================================
    File: Modules/Account/resources/views/header/partials/navigation.blade.php
    Purpose: Account header navigation links.
========================================================================== --}}

@if (! empty($navigation))
    <nav
        class="ui-shell-account-menu__nav"
        aria-label="Account navigation"
    >
        @foreach ($navigation as $item)
            <x-ui.menu-item
                href="{{ $item['href'] ?? '#' }}"
                :current="! empty($item['current'])"
                wire:navigate
                class="{{ $loop->first ? 'mt-2' : 'mt-1' }}"
                data-account-menu-entry-key="{{ $item['key'] ?? '' }}"
                data-account-menu-entry-module="{{ $item['moduleKey'] ?? '' }}"
            >
                {{ $item['label'] ?? '' }}
            </x-ui.menu-item>
        @endforeach
    </nav>
@endif
