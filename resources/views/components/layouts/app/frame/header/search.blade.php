{{-- ==========================================================================
    File: resources/views/components/layouts/app/frame/header/search.blade.php
    Purpose: Signed-in app global header search.

    Notes:
    - App-specific header search composition.
    - Mirrors the Carbon docs/global-search pattern rather than the base Search
      field component.
    - Search trigger and close button are 3rem-wide header controls.
    - The wrapper expands inline inside the header global action area.
    ========================================================================== --}}

@props([
    'id' => 'app-header-search',
    'name' => 'q',
    'label' => 'Search',
    'placeholder' => 'Search',
    'expanded' => false,
])

@php
    $menuId = "{$id}-menu";
@endphp

<div
    class="app-header-search"
    data-app-header-search
    data-app-header-search-expanded="{{ $expanded ? 'true' : 'false' }}"
>
    <label
        id="{{ $id }}-label"
        for="{{ $id }}"
        class="ui-visually-hidden"
    >
        {{ $label }}
    </label>

    <div
        class="app-header-search__input-wrapper"
        aria-owns="{{ $menuId }}"
        aria-haspopup="menu"
    >
        <button
            type="button"
            class="app-header-search__button app-header-search__button--open"
            aria-label="Open search"
            aria-expanded="{{ $expanded ? 'true' : 'false' }}"
            data-app-header-search-trigger
        >
            <x-ui.icon name="search"
                width="20"
                height="20"
                aria-hidden="true"
                focusable="false"
            />
        </button>

        <input
            id="{{ $id }}"
            name="{{ $name }}"
            type="text"
            autocomplete="off"
            class="app-header-search__input"
            aria-label="{{ $label }}"
            aria-autocomplete="list"
            aria-controls="{{ $menuId }}"
            placeholder="{{ $placeholder }}"
            tabindex="{{ $expanded ? '0' : '-1' }}"
            data-app-header-search-input
        >

        <button
            type="button"
            class="app-header-search__button app-header-search__button--close"
            aria-label="Clear search"
            tabindex="{{ $expanded ? '0' : '-1' }}"
            data-app-header-search-close
        >
            <x-ui.icon name="close"
                width="20"
                height="20"
                aria-hidden="true"
                focusable="false"
            />
        </button>
    </div>

    <ul
        id="{{ $menuId }}"
        class="app-header-search__list"
        role="menu"
        aria-labelledby="{{ $id }}-label"
        hidden
        data-app-header-search-results
    ></ul>
</div>
