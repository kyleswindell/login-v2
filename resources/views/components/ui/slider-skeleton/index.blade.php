{{-- ==========================================================================
    File: resources/views/components/ui/slider-skeleton/index.blade.php
    Purpose: Slider skeleton/loading placeholder component.

    Notes:
    - Emits the installed .ui-slider skeleton selector contract.
    - Supports single-handle and two-handle range slider skeletons.
    - Supports hidden label and RTL state.
    - Uses skeleton animation styles from resources/css/base/skeleton.css.
    - Uses Slider styles from resources/css/components/slider.css.
    - Does not render an interactive slider.
    ========================================================================== --}}

@props([
    'hideLabel' => false,
    'twoHandles' => false,
    'rtl' => false,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Render state
    |--------------------------------------------------------------------------
    */

    $usesTwoHandles = (bool) $twoHandles;

    /*
    |--------------------------------------------------------------------------
    | CSS class contract
    |--------------------------------------------------------------------------
    */

    $containerClasses = [
        'ui-slider-container',
        'ui-skeleton',
        'ui-slider-container--two-handles' => $usesTwoHandles,
        'ui-slider-container--rtl' => (bool) $rtl,
    ];

    $lowerThumbClasses = [
        'ui-slider__thumb',
        'ui-slider__thumb--lower' => $usesTwoHandles,
    ];

    $upperThumbClasses = [
        'ui-slider__thumb',
        'ui-slider__thumb--upper' => $usesTwoHandles,
    ];

    $lowerThumbWrapperClasses = [
        'ui-slider__thumb-wrapper',
        'ui-slider__thumb-wrapper--lower' => $usesTwoHandles,
    ];

    $upperThumbWrapperClasses = [
        'ui-slider__thumb-wrapper',
        'ui-slider__thumb-wrapper--upper' => $usesTwoHandles,
    ];
@endphp

<div
    aria-hidden="true"
    {{ $attributes->class('ui-form-item')->merge(['data-ui-component' => 'slider-skeleton']) }}
>
    @unless ($hideLabel)
        <span class="ui-label ui-skeleton"></span>
    @endunless

    <div @class($containerClasses)>
        <span class="ui-slider__range-label"></span>

        <div class="ui-slider">
            <div class="ui-slider__track"></div>
            <div class="ui-slider__filled-track"></div>

            <div @class($lowerThumbWrapperClasses)>
                <div @class($lowerThumbClasses)>
                    @if ($usesTwoHandles)
                        <svg
                            class="ui-slider__thumb-icon ui-slider__thumb-icon--lower"
                            viewBox="0 0 16 24"
                            aria-hidden="true"
                            focusable="false"
                        >
                            <path d="M15.08 6.46H16v11.08h-.92zM4.46 17.54c-.25 0-.46-.21-.46-.46V6.92a.465.465 0 0 1 .69-.4l8.77 5.08a.46.46 0 0 1 0 .8l-8.77 5.08c-.07.04-.15.06-.23.06Z" />
                        </svg>
                    @endif
                </div>
            </div>

            @if ($usesTwoHandles)
                <div @class($upperThumbWrapperClasses)>
                    <div @class($upperThumbClasses)>
                        <svg
                            class="ui-slider__thumb-icon ui-slider__thumb-icon--upper"
                            viewBox="0 0 16 24"
                            aria-hidden="true"
                            focusable="false"
                        >
                            <path d="M0 6.46h.92v11.08H0zM11.54 6.46c.25 0 .46.21.46.46v10.15a.465.465 0 0 1-.69.4L2.54 12.4a.46.46 0 0 1 0-.8l8.77-5.08c.07-.04.15-.06.23-.06Z" />
                        </svg>
                    </div>
                </div>
            @endif
        </div>

        <span class="ui-slider__range-label"></span>
    </div>
</div>