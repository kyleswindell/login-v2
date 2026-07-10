{{-- ==========================================================================
    File: resources/views/components/ui/toggle-skeleton/index.blade.php
    Purpose: Toggle skeleton/loading placeholder component.

    Notes:
    - Emits the installed .ui-toggle skeleton selector contract.
    - Supports default and small toggle skeleton sizing.
    - Uses skeleton animation styles from resources/css/base/skeleton.css.
    - Uses Toggle skeleton styles from resources/css/components/toggle.css.
    - Does not render an interactive switch control.
    ========================================================================== --}}

@props([
'id' => null,
'size' => 'md',
'labelText' => null,
'ariaLabel' => null,
])

@php
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Supported public values
|--------------------------------------------------------------------------
*/

$allowedSizes = ['sm', 'md'];

/*
|--------------------------------------------------------------------------
| Resolve values
|--------------------------------------------------------------------------
*/

$resolvedId = $id ?? 'ui-toggle-skeleton-'.Str::uuid();
$resolvedSize = in_array($size, $allowedSizes, true) ? $size : 'md';
$isSmall = $resolvedSize === 'sm';

/*
|--------------------------------------------------------------------------
| CSS class contract
|--------------------------------------------------------------------------
|
| These classes must match toggle.css and skeleton.css.
|
*/

$wrapperClasses = [
'ui-toggle',
'ui-toggle--skeleton',
'ui-toggle--small' => $isSmall,
'ui-toggle--small-skeleton' => $isSmall,
];

$labelTextClasses = [
'ui-toggle__label-text',
'ui-skeleton',
];

$appearanceClasses = [
'ui-toggle__appearance',
'ui-toggle__appearance--sm' => $isSmall,
];
@endphp

<div
    @if (filled($ariaLabel)) aria-label="{{ $ariaLabel }}" @else aria-hidden="true" @endif
    {{ $attributes->class($wrapperClasses)->merge([
        'data-ui-component' => 'toggle-skeleton',
        'data-ui-toggle-skeleton' => true,
        'data-ui-toggle-skeleton-size' => $resolvedSize,
    ]) }}>
    @if ($isSmall)
    {{-- ------------------------------------------------------------------
            Small toggle skeleton
            ------------------------------------------------------------------
            Mirrors the small toggle visual anatomy without rendering an
            interactive input.
            ------------------------------------------------------------------ --}}

    <span
        id="{{ $resolvedId }}"
        class="ui-toggle__label ui-skeleton">
        @if (filled($labelText))
        <span @class($labelTextClasses)>{{ $labelText }}</span>
        @endif

        <span @class($appearanceClasses)>
            <span class="ui-toggle__switch ui-skeleton">
                <x-ui.icon name="checkmark"
                    class="ui-toggle__check"
                    aria-hidden="true" />
            </span>
        </span>
    </span>
    @else
    {{-- ------------------------------------------------------------------
            Default toggle skeleton
            ------------------------------------------------------------------
            Non-interactive placeholder for the standard toggle size.
            ------------------------------------------------------------------ --}}

    <div class="ui-toggle__skeleton-circle ui-skeleton"></div>
    <div class="ui-toggle__skeleton-rectangle ui-skeleton"></div>
    @endif
</div>