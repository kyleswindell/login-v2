{{-- ==========================================================================
    File: resources/views/components/shell/side-nav/details.blade.php
    Purpose: UI shell side navigation details region.

    Notes:
    - Renders the side navigation title/detail block.
    - Intended for side nav header content, workspace context, product context,
      or switcher placement.
    - Optional slot content may be used for a switcher or compact metadata.
    ========================================================================== --}}

@props([
    'title',
])

@php
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | CSS class contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-shell-side-nav__details',
    ];
@endphp

<div
    {{ $attributes->class($classes)->merge([
        'data-ui-shell-side-nav-details' => true,
    ]) }}
>
    <h2
        class="ui-shell-side-nav__title"
        title="{{ $title instanceof HtmlString ? strip_tags((string) $title) : $title }}"
        data-ui-shell-side-nav-title
    >
        @if ($title instanceof HtmlString)
            {!! $title !!}
        @else
            {{ $title }}
        @endif
    </h2>

    @unless ($slot->isEmpty())
        <div class="ui-shell-side-nav__details-content">
            {{ $slot }}
        </div>
    @endunless
</div>