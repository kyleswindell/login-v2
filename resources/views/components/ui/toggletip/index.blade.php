{{-- ==========================================================================
    File: resources/views/components/ui/toggletip/index.blade.php
    Purpose: Toggletip component.

    Carbon reference:
    - Toggletip composes Popover.
    - Opens on click, not hover.
    - Uses a trigger button, popover content, optional actions, and a caret.

    Notes:
    - This component is intended for short contextual help next to labels,
      field text, table headers, or similar UI copy.
    - For purely hover/focus labels on icon-only buttons, use Tooltip instead.
    - JS behavior is handled by resources/js/ui-controls/toggletip.js.
    - Save this file as UTF-8 without BOM.
    ========================================================================== --}}

@props([
    /*
    |--------------------------------------------------------------------------
    | Identity / placement
    |--------------------------------------------------------------------------
    */

    'id' => null,
    'align' => null,
    'placement' => 'right',

    /*
    |--------------------------------------------------------------------------
    | Trigger
    |--------------------------------------------------------------------------
    */

    'label' => 'Show information',
    'buttonClass' => null,

    /*
    |--------------------------------------------------------------------------
    | Initial state / behavior
    |--------------------------------------------------------------------------
    */

    'defaultOpen' => false,
    'autoAlign' => false,

    /*
    |--------------------------------------------------------------------------
    | Content / actions
    |--------------------------------------------------------------------------
    */

    'closeButton' => true,
    'closeLabel' => 'Close',
    'contentClass' => null,

    /*
    |--------------------------------------------------------------------------
    | Visual treatment
    |--------------------------------------------------------------------------
    */

    'highContrast' => true,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Alignment
    |--------------------------------------------------------------------------
    |
    | Carbon Toggletip inherits Popover alignment values. `placement` is kept
    | as a friendlier alias, while `align` takes priority when supplied.
    |
    */

    $allowedAlignments = [
        'top',
        'top-start',
        'top-end',
        'bottom',
        'bottom-start',
        'bottom-end',
        'left',
        'left-start',
        'left-end',
        'right',
        'right-start',
        'right-end',
    ];

    $resolvedAlign = $align ?? $placement;

    $resolvedAlign = in_array($resolvedAlign, $allowedAlignments, true)
        ? $resolvedAlign
        : 'right';

    /*
    |--------------------------------------------------------------------------
    | IDs
    |--------------------------------------------------------------------------
    |
    | The trigger and panel are connected with aria-controls. When open, the
    | trigger also receives aria-describedby via Blade and JS.
    |
    */

    $rootId = $id ?? 'ui-toggletip-'.str()->uuid();
    $contentId = $rootId.'-content';

    /*
    |--------------------------------------------------------------------------
    | Initial open state
    |--------------------------------------------------------------------------
    |
    | JS preserves this value on initialization instead of forcing the panel
    | closed.
    |
    */

    $isOpen = (bool) $defaultOpen;
@endphp

<span
    id="{{ $rootId }}"
    {{ $attributes->class([
        /*
        |--------------------------------------------------------------------------
        | Popover + Toggletip contract
        |--------------------------------------------------------------------------
        |
        | The popover alignment class is used by CSS to position the panel and
        | caret relative to the trigger.
        |
        */

        'ui-popover-container',
        'ui-toggletip',
        'ui-toggletip--open' => $isOpen,
        'ui-autoalign' => $autoAlign,
        'ui-popover--'.$resolvedAlign,
        'ui-toggletip--high-contrast' => $highContrast,
    ])->merge([
        'data-ui-component' => 'toggletip',
        'data-ui-toggletip' => true,
        'data-ui-toggletip-placement' => $resolvedAlign,
        'data-ui-toggletip-state' => $isOpen ? 'open' : 'closed',
    ]) }}
>
    {{-- ---------------------------------------------------------------------
        Trigger button

        A toggletip trigger is an actual button because it opens a disclosure
        panel on click. This is intentionally not hover-only behavior.
        ------------------------------------------------------------------ --}}
    <button
        type="button"
        class="{{ trim('ui-toggletip-button '.$buttonClass) }}"
        aria-label="{{ $label }}"
        aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
        aria-controls="{{ $contentId }}"
        aria-haspopup="dialog"
        @if ($isOpen) aria-describedby="{{ $contentId }}" @endif
        data-ui-toggletip-trigger
    >
        @isset($trigger)
            {{-- Custom trigger slot, for example an app-owned info icon. --}}
            {{ $trigger }}
        @else
            {{-- Default information icon. --}}
            <svg
                viewBox="0 0 16 16"
                focusable="false"
                preserveAspectRatio="xMidYMid meet"
                fill="currentColor"
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true"
                class="ui-icon ui-toggletip-button__icon"
            >
                <polygon points="8.5,11 8.5,6.5 6.5,6.5 6.5,7.5 7.5,7.5 7.5,11 6,11 6,12 10,12 10,11"></polygon>
                <path d="M8,3.5c-0.4,0-0.8,0.3-0.8,0.8S7.6,5,8,5c0.4,0,0.8-0.3,0.8-0.8S8.4,3.5,8,3.5z"></path>
                <path d="M8,15c-3.9,0-7-3.1-7-7s3.1-7,7-7s7,3.1,7,7S11.9,15,8,15z M8,2C4.7,2,2,4.7,2,8s2.7,6,6,6s6-2.7,6-6S11.3,2,8,2z"></path>
            </svg>
        @endisset
    </button>

    {{-- ---------------------------------------------------------------------
        Popover wrapper

        Kept separate from the panel so the CSS can position the whole popover
        surface and caret based on the root alignment class.
        ------------------------------------------------------------------ --}}
    <span class="ui-popover" data-ui-toggletip-popover>
        <span
            id="{{ $contentId }}"
            role="dialog"
            class="{{ trim('ui-popover-content ui-toggletip-popover-content '.$contentClass) }}"
            aria-hidden="{{ $isOpen ? 'false' : 'true' }}"
            data-ui-toggletip-panel
            @unless ($isOpen) hidden @endunless
        >
            {{-- Main toggletip message content. --}}
            <span class="ui-toggletip-content">
                {{ $slot }}
            </span>

            {{-- Optional action row. Usually contains one or two links/buttons. --}}
            @if ($closeButton || isset($actions))
                <span class="ui-toggletip-actions">
                    @isset($actions)
                        {{ $actions }}
                    @endisset

                    @if ($closeButton)
                        <button
                            type="button"
                            class="ui-link ui-toggletip-close"
                            data-ui-toggletip-close
                        >
                            {{ $closeLabel }}
                        </button>
                    @endif
                </span>
            @endif

            {{-- Caret / arrow pointing back to the trigger. --}}
            <span
                class="ui-popover-caret"
                aria-hidden="true"
                data-ui-popover-caret
            ></span>
        </span>
    </span>
</span>