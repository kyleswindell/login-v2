{{-- ==========================================================================
    File: resources/views/components/ui/chat-button/index.blade.php
    Purpose: Chat Button component.

    Notes:
    - Emits the installed .ui-chat-btn selector contract.
    - Wraps resources/views/components/ui/button/index.blade.php.
    - Quick action mode forces kind="ghost" and size="sm".
    - Supports selected quick action state.
    - Uses generated UI icon components from resources/views/components/icons.
    - Chat Button styles are handled by resources/css/components/chat-button.css.
    - Base Button styles are handled by resources/css/components/button.css.
    ========================================================================== --}}

@props([
'kind' => 'primary',
'semantic' => null,
'size' => 'lg',
'quickAction' => false,
'isQuickAction' => null,
'selected' => false,
'isSelected' => null,
'disabled' => false,
'loading' => false,
'icon' => null,
'iconPosition' => 'trailing',
'type' => 'button',
])

@php
/*
|--------------------------------------------------------------------------
| Supported public values
|--------------------------------------------------------------------------
|
| Chat Button supports the standard chat kind set. Quick action mode
| resolves to a small ghost button.
|
*/

$allowedKinds = ['primary', 'secondary', 'danger', 'ghost', 'tertiary'];
$allowedSizes = ['sm', 'md', 'lg'];
$allowedTypes = ['button', 'submit', 'reset'];

/*
|--------------------------------------------------------------------------
| Resolve values
|--------------------------------------------------------------------------
|
| `semantic`, `isQuickAction`, and `isSelected` are retained as compatibility
| inputs for older app usage.
|
*/

$resolvedQuickAction = $isQuickAction ?? $quickAction;
$resolvedSelected = $isSelected ?? $selected;

$requestedKind = $semantic ?? $kind;
$resolvedKind = in_array($requestedKind, $allowedKinds, true) ? $requestedKind : 'primary';

$resolvedSize = in_array($size, $allowedSizes, true) ? $size : 'lg';
$resolvedType = in_array($type, $allowedTypes, true) ? $type : 'button';

/*
|--------------------------------------------------------------------------
| Quick action normalization
|--------------------------------------------------------------------------
|
| Quick action buttons are always small ghost buttons.
|
*/

if ($resolvedQuickAction) {
$resolvedKind = 'ghost';
$resolvedSize = 'sm';
}

/*
|--------------------------------------------------------------------------
| CSS class contract
|--------------------------------------------------------------------------
|
| These classes must match resources/css/components/chat-button.css.
|
*/

$classes = [
'ui-chat-btn',
'ui-chat-btn--with-icon' => filled($icon),
'ui-chat-btn--quick-action' => $resolvedQuickAction,
'ui-chat-btn--quick-action--selected' => $resolvedQuickAction && $resolvedSelected,
];
@endphp

{{-- ----------------------------------------------------------------------
    Chat Button
    ----------------------------------------------------------------------
    Rendering is delegated to the standard Button component so size, kind,
    icon placement, disabled, loading, and button semantics remain consistent.
    ---------------------------------------------------------------------- --}}

<x-ui.button
    :kind="$resolvedKind"
    :size="$resolvedSize"
    :type="$resolvedType"
    :disabled="$disabled"
    :loading="$loading"
    :icon="$icon"
    :icon-position="$iconPosition"
    :class="$classes"
    data-ui-component="chat-button"
    data-ui-chat-button
    data-ui-chat-button-kind="{{ $resolvedKind }}"
    data-ui-chat-button-size="{{ $resolvedSize }}"
    data-ui-chat-button-quick-action="{{ $resolvedQuickAction ? 'true' : 'false' }}"
    data-ui-chat-button-selected="{{ $resolvedSelected ? 'true' : 'false' }}">
    {{ $slot }}
</x-ui.button>