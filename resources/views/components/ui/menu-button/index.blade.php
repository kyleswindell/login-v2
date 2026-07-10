{{-- ==========================================================================
    File: resources/views/components/ui/menu-button/index.blade.php
    Purpose: Button-triggered action menu component.

    Notes:
    - Emits the canonical Menu Button wrapper and trigger selector contract.
    - Uses the canonical .ui-btn Button selector contract for the trigger.
    - The trigger owns aria-haspopup, aria-expanded, and aria-controls.
    - The menu surface is rendered by resources/views/components/ui/menu/index.blade.php.
    - Menu is rendered in triggerless mode because this component owns the trigger.
    - Menu positioning/open behavior is handled by installed Menu/Menu Button JS.
    - Valid trigger kinds are primary, tertiary, and ghost.
    ========================================================================== --}}

@props([
'items' => [],
'label' => 'Actions',
'kind' => null,
'type' => null,
'variant' => null,
'size' => 'lg',
'menuAlignment' => null,
'align' => 'bottom',
'placement' => null,
'open' => false,
'disabled' => false,
'loading' => false,
'tabIndex' => 0,
'menuBackgroundToken' => 'layer',
'menuBorder' => false,
])

@php
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Supported public values
|--------------------------------------------------------------------------
|
| Menu Button intentionally supports only primary, tertiary, and ghost
| trigger kinds.
|
*/

$allowedKinds = ['primary', 'tertiary', 'ghost'];
$allowedSizes = ['xs', 'sm', 'md', 'lg'];

$allowedMenuAlignments = [
'top',
'top-start',
'top-end',
'bottom',
'bottom-start',
'bottom-end',
];

$allowedBackgroundTokens = ['layer', 'background'];

/*
|--------------------------------------------------------------------------
| Resolve trigger kind
|--------------------------------------------------------------------------
|
| `kind` is canonical. `type` and `variant` are retained as compatibility
| aliases for older app usage.
|
*/

$requestedKind = $kind ?? $variant ?? $type ?? 'primary';

$resolvedKind = match ($requestedKind) {
'outline' => 'tertiary',
'primary', 'tertiary', 'ghost' => $requestedKind,
default => 'primary',
};

$resolvedKind = in_array($resolvedKind, $allowedKinds, true)
? $resolvedKind
: 'primary';

/*
|--------------------------------------------------------------------------
| Resolve size and menu alignment
|--------------------------------------------------------------------------
|
| `menuAlignment` is canonical. `placement` and `align` are compatibility
| aliases.
|
*/

$resolvedSize = in_array($size, $allowedSizes, true) ? $size : 'lg';

$requestedMenuAlignment = $menuAlignment ?? $placement ?? $align;

$resolvedMenuAlignment = match ($requestedMenuAlignment) {
'start' => 'bottom-start',
'end' => 'bottom-end',
'top', 'top-start', 'top-end', 'bottom', 'bottom-start', 'bottom-end' => $requestedMenuAlignment,
default => 'bottom',
};

$resolvedMenuAlignment = in_array($resolvedMenuAlignment, $allowedMenuAlignments, true)
? $resolvedMenuAlignment
: 'bottom';

$resolvedBackgroundToken = in_array($menuBackgroundToken, $allowedBackgroundTokens, true)
? $menuBackgroundToken
: 'layer';

/*
|--------------------------------------------------------------------------
| Render state
|--------------------------------------------------------------------------
*/

$isOpen = (bool) $open;
$isDisabled = (bool) $disabled || (bool) $loading;

/*
|--------------------------------------------------------------------------
| IDs and ARIA wiring
|--------------------------------------------------------------------------
|
| The trigger controls the menu only when the menu is open.
|
*/

$menuId = 'ui-menu-button-'.Str::uuid();
$containerOwns = $isOpen ? $menuId : null;
$triggerControls = $isOpen ? $menuId : null;

/*
|--------------------------------------------------------------------------
| CSS class contract
|--------------------------------------------------------------------------
|
| These classes must match menu-button.css, button.css, and menu.css.
|
*/

$containerClasses = [
'ui-menu-button__container',
];

$triggerClasses = [
'ui-menu-button__trigger',
'ui-menu-button__trigger--open' => $isOpen,
];

$menuClasses = [
'ui-menu-button__'.$resolvedMenuAlignment,
];
@endphp

<div
    @if (filled($containerOwns)) aria-owns="{{ $containerOwns }}" @endif
    {{ $attributes->class($containerClasses)->merge([
        'data-ui-component' => 'menu-button',
        'data-ui-menu-button' => true,
        'data-ui-menu-button-kind' => $resolvedKind,
        'data-ui-menu-button-size' => $resolvedSize,
        'data-ui-menu-button-alignment' => $resolvedMenuAlignment,
        'data-ui-menu-button-open' => $isOpen ? 'true' : 'false',
    ]) }}>
    {{-- ----------------------------------------------------------------------
        Trigger button
        ----------------------------------------------------------------------
        Menu Button owns the trigger directly. The trigger uses standard Button
        anatomy with a trailing chevron icon.
        ---------------------------------------------------------------------- --}}

    <x-ui.button
        :kind="$resolvedKind"
        :size="$resolvedSize"
        :disabled="$isDisabled"
        :loading="$loading"
        icon="chevron--down"
        icon-position="trailing"
        tabindex="{{ $tabIndex }}"
        :class="$triggerClasses"
        aria-haspopup="menu"
        aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
        @if (filled($triggerControls)) aria-controls="{{ $triggerControls }}" @endif
        data-ui-menu-button-trigger>
        {{ $label }}
    </x-ui.button>

    {{-- ----------------------------------------------------------------------
        Menu surface
        ----------------------------------------------------------------------
        x-ui.menu is rendered in triggerless mode because this component owns
        the trigger and ARIA relationship.
        ---------------------------------------------------------------------- --}}

    <x-ui.menu
        :trigger="false"
        :id="$menuId"
        :items="$items"
        :label="$label"
        :size="$resolvedSize"
        :open="$isOpen"
        :placement="$resolvedMenuAlignment"
        :background-token="$resolvedBackgroundToken"
        :border="$menuBorder"
        :class="$menuClasses"
        data-ui-menu-button-menu>
        {{ $slot }}
    </x-ui.menu>
</div>