{{-- ==========================================================================
    File: resources/views/components/shell/side-nav/footer.blade.php
    Purpose: UI shell side navigation footer.

    Notes:
    - Renders the side navigation footer toggle control.
    - Used for rail/fixed side navigation expand-collapse behavior.
    - Emits state through data attributes for installed shell JavaScript.
    - Uses generated UI icon components from resources/views/components/icons.
    ========================================================================== --}}

@props([
    'assistiveText' => 'Toggle opening or closing the side navigation',
    'expanded' => false,
    'controls' => null,
    'closeIcon' => 'close',
    'openIcon' => 'chevron--right',
])

@php
    /*
    |--------------------------------------------------------------------------
    | Render state
    |--------------------------------------------------------------------------
    */

    $isExpanded = (bool) $expanded;

    /*
    |--------------------------------------------------------------------------
    | CSS class contract
    |--------------------------------------------------------------------------
    */

    $footerClasses = [
        'ui-shell-side-nav__footer',
    ];

    $toggleClasses = [
        'ui-shell-side-nav__toggle',
        'ui-shell-side-nav__toggle--expanded' => $isExpanded,
    ];
@endphp

<footer
    {{ $attributes->class($footerClasses)->merge([
        'data-ui-shell-side-nav-footer' => true,
    ]) }}
>
    <button
        type="button"
        title="{{ $assistiveText }}"
        @class($toggleClasses)
        aria-label="{{ $assistiveText }}"
        aria-expanded="{{ $isExpanded ? 'true' : 'false' }}"
        @if ($controls) aria-controls="{{ $controls }}" @endif
        data-ui-shell-side-nav-footer-toggle
        data-ui-shell-side-nav-footer-toggle-expanded="{{ $isExpanded ? 'true' : 'false' }}"
    >
        <span class="ui-shell-side-nav__icon" aria-hidden="true">
            @if ($isExpanded)
                <x-ui.icon
                    :name="$closeIcon"
                    class="ui-shell-side-nav__icon-svg"
                />
            @else
                <x-ui.icon
                    :name="$openIcon"
                    class="ui-shell-side-nav__icon-svg"
                />
            @endif
        </span>

        <span class="ui-assistive-text">
            {{ $assistiveText }}
        </span>
    </button>
</footer>
