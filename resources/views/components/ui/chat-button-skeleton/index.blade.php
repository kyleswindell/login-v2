{{-- ==========================================================================
    File: resources/views/components/ui/chat-button-skeleton/index.blade.php
    Purpose: Chat Button skeleton/loading placeholder component.

    Notes:
    - Emits the installed .ui-chat-btn skeleton selector contract.
    - Matches the Chat Button size API used by chat-button.blade.php.
    - Uses skeleton animation styles from resources/css/base/skeleton.css.
    - Uses Button skeleton support from resources/css/components/button.css.
    - Uses Chat Button styles from resources/css/components/chat-button.css.
    - Does not render interactive button content.
    ========================================================================== --}}

@props([
'size' => 'lg',
])

@php
/*
|--------------------------------------------------------------------------
| Supported public values
|--------------------------------------------------------------------------
*/

$allowedSizes = ['sm', 'md', 'lg'];

/*
|--------------------------------------------------------------------------
| Resolve size
|--------------------------------------------------------------------------
*/

$resolvedSize = in_array($size, $allowedSizes, true) ? $size : 'lg';

/*
|--------------------------------------------------------------------------
| CSS class contract
|--------------------------------------------------------------------------
|
| These classes must match button.css, chat-button.css, and skeleton.css.
|
*/

$classes = [
'ui-skeleton',
'ui-btn',
'ui-btn--'.$resolvedSize,
'ui-layout--size-'.$resolvedSize,
'ui-chat-btn',
];
@endphp

{{-- ----------------------------------------------------------------------
    Chat Button skeleton
    ----------------------------------------------------------------------
    Non-interactive placeholder used while chat button content is loading.
    ---------------------------------------------------------------------- --}}

<div
    aria-hidden="true"
    {{ $attributes->class($classes)->merge(['data-ui-component' => 'chat-button-skeleton']) }}></div>