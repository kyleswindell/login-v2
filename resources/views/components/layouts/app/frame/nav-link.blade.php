{{-- ==========================================================================
    File: resources/views/components/layouts/app/frame/nav-link.blade.php
    Purpose: Application shell navigation link adapter.

    Notes:
    - Adapts app navigation data to the shell side navigation link component.
    - Icons must be passed through the shell side-nav icon prop.
    - Do not render icons inside this component slot because the slot is reserved
      for side navigation link text.
    - Side navigation icon placement is owned by x-shell.side-nav.link.
    ========================================================================== --}}

@props([
    'href' => '#',
    'current' => false,
    'active' => null,
    'wireNavigate' => true,
    'icon' => null,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Resolve state
    |--------------------------------------------------------------------------
    */

    $isCurrent = ! is_null($active)
        ? (bool) $active
        : (bool) $current;
@endphp

<x-shell.side-nav.link
    :href="$href"
    :icon="$icon"
    :current="$isCurrent"
    :wire-navigate="$wireNavigate"
    {{ $attributes }}
>
    {{ $slot }}
</x-shell.side-nav.link>
