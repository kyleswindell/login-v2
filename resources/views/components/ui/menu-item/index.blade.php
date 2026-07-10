{{-- ==========================================================================
    File: resources/views/components/ui/menu-item/index.blade.php
    Purpose: Menu item, selectable menu item, submenu trigger, and divider.

    Notes:
    - Emits the canonical .ui-menu-item selector contract.
    - Divider output emits .ui-menu-item-divider.
    - Supports href-based items, button/action items, selectable states, danger
      descriptions, shortcuts, icons, and submenu triggers.
    - Menu behavior is handled by installed menu JavaScript.
    - Menu surface is handled by resources/views/components/ui/menu/index.blade.php.
    ========================================================================== --}}

@props([
'href' => null,
'type' => 'button',
'kind' => null,
'semantic' => 'neutral',
'tone' => null,
'danger' => false,
'dangerDescription' => null,
'action' => null,
'method' => null,
'current' => false,
'selected' => false,
'disabled' => false,
'shortcut' => null,
'icon' => null,
'submenu' => false,
'size' => 'md',
'state' => null,
'selectionType' => null,
'title' => null,
'reserveIndicator' => false,
'closeOnActivate' => true,
])

@php
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Supported public values
|--------------------------------------------------------------------------
*/

$isDivider = $type === 'divider';

$allowedKinds = ['default', 'danger'];
$allowedSemantics = ['neutral', 'primary', 'success', 'warning', 'danger', 'notice', 'info'];
$allowedSizes = ['xs', 'sm', 'md', 'lg'];
$allowedMethods = ['GET', 'POST', 'PATCH', 'DELETE'];
$allowedButtonTypes = ['button', 'submit', 'reset'];

/*
|--------------------------------------------------------------------------
| Resolve kind, semantic, size, method, and button type
|--------------------------------------------------------------------------
|
| `kind` is the canonical menu item API. The older `semantic`, `tone`, and
| `danger` inputs are retained as compatibility inputs.
|
*/

$requestedKind = $kind ?? (($danger || $tone === 'danger' || $semantic === 'danger') ? 'danger' : 'default');
$resolvedKind = in_array($requestedKind, $allowedKinds, true) ? $requestedKind : 'default';

$resolvedSemantic = $resolvedKind === 'danger'
? 'danger'
: (in_array($semantic, $allowedSemantics, true) ? $semantic : 'neutral');

$resolvedSize = in_array($size, $allowedSizes, true) ? $size : 'md';

$resolvedButtonType = in_array($type, $allowedButtonTypes, true) ? $type : 'button';

$resolvedMethod = filled($method) && in_array(strtoupper($method), $allowedMethods, true)
? strtoupper($method)
: null;

/*
|--------------------------------------------------------------------------
| Selection state
|--------------------------------------------------------------------------
|
| `multi` is accepted as a legacy alias for multiple selection.
|
*/

$requestedSelectionType = $selectionType === 'multi' ? 'multiple' : $selectionType;
$resolvedSelectionType = in_array($requestedSelectionType, ['single', 'multiple'], true)
? $requestedSelectionType
: null;

$isCurrent = (bool) $current;
$isSelected = (bool) $selected;
$isDisabled = (bool) $disabled;
$hasSubmenu = (bool) $submenu;

$shouldReserveIndicator = (bool) $reserveIndicator
|| filled($resolvedSelectionType)
|| $isSelected;

$resolvedRole = match ($resolvedSelectionType) {
'single' => 'menuitemradio',
'multiple' => 'menuitemcheckbox',
default => 'menuitem',
};

/*
|--------------------------------------------------------------------------
| Render state
|--------------------------------------------------------------------------
*/

$isLink = filled($href) && ! $isDisabled;

$stateValue = $isDisabled
? 'disabled'
: (filled($state) ? $state : ($isSelected ? 'selected' : 'default'));

/*
|--------------------------------------------------------------------------
| Danger assistive description
|--------------------------------------------------------------------------
*/

$dangerDescriptionId = $resolvedKind === 'danger' && filled($dangerDescription)
? 'ui-menu-item-danger-description-'.Str::uuid()
: null;

$existingDescribedBy = $attributes->get('aria-describedby');

$ariaDescribedBy = collect([$existingDescribedBy, $dangerDescriptionId])
->filter()
->implode(' ');

/*
|--------------------------------------------------------------------------
| CSS class contract
|--------------------------------------------------------------------------
|
| Canonical classes are emitted first. A small number of older classes are
| retained as compatibility hooks for existing CSS/JS during migration.
|
*/

$classes = [
'ui-menu-item',
'ui-menu-item--disabled' => $isDisabled,
'ui-menu-item--danger' => $resolvedKind === 'danger',
'ui-menu-item--selected' => $isSelected && ! $isDisabled,
'ui-menu-item--current' => $isCurrent && ! $isDisabled,
'ui-menu-item--'.$state => filled($state) && ! $isDisabled,

// Compatibility hooks.
'ui-menu-item-'.$resolvedSize,
'ui-menu-item-'.$resolvedSemantic,
'ui-menu-item-disabled' => $isDisabled,
'ui-menu-item-current' => $isCurrent && ! $isDisabled,
'is-selected' => $isSelected && ! $isDisabled,
'is-'.$state => filled($state) && ! $isDisabled,
];

$dividerClasses = [
'ui-menu-item-divider',

// Compatibility hook.
'ui-menu-divider',
];

/*
|--------------------------------------------------------------------------
| Attribute handling
|--------------------------------------------------------------------------
|
| aria-describedby is rebuilt so caller-provided values and generated
| danger description IDs can both be preserved.
|
*/

$componentAttributes = $attributes->except('aria-describedby');
@endphp

@if ($isDivider)
{{-- ----------------------------------------------------------------------
        Divider
        ----------------------------------------------------------------------
        Separates groups of menu items.
        ---------------------------------------------------------------------- --}}

<div
    {{ $attributes->class($dividerClasses)->merge([
            'role' => 'separator',
            'data-ui-component' => 'menu-divider',
            'data-ui-menu-divider' => true,
        ]) }}></div>
@elseif ($isLink)
{{-- ----------------------------------------------------------------------
        Link menu item
        ----------------------------------------------------------------------
        Used for menu items that navigate to another URL.
        ---------------------------------------------------------------------- --}}

<a
    href="{{ $href }}"
    tabindex="{{ $isDisabled ? '-1' : '0' }}"
    @if ($isCurrent) aria-current="true" @endif
    @if ($resolvedSelectionType) aria-checked="{{ $isSelected ? 'true' : 'false' }}" @endif
    @if ($hasSubmenu) aria-haspopup="menu" aria-expanded="false" @endif
    @if ($isDisabled) aria-disabled="true" @endif
    @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
    @if (filled($title)) title="{{ $title }}" @endif
    {{ $componentAttributes->class($classes)->merge([
            'data-ui-component' => 'menu-item',
            'data-ui-menu-item' => true,
            'data-ui-menu-close' => $closeOnActivate && ! $hasSubmenu ? 'true' : null,
            'data-ui-menu-action' => filled($action) ? $action : null,
            'data-ui-menu-method' => $resolvedMethod,
            'data-ui-menu-item-size' => $resolvedSize,
            'data-ui-menu-item-state' => $stateValue,
            'data-ui-menu-submenu-trigger' => $hasSubmenu ? true : null,
            'data-ui-current' => $isCurrent ? 'true' : 'false',
            'role' => $resolvedRole,
        ]) }}>
    {{-- Selection/check region is always present when reserved. --}}
    @if ($shouldReserveIndicator)
    <span class="ui-menu-item__selection-icon ui-menu-item-check" aria-hidden="true">
        @if ($isSelected)
        <x-ui.icon name="checkmark" class="ui-menu-item__selection-icon-svg ui-menu-item-check-icon" />
        @endif
    </span>
    @endif

    {{-- Optional leading item icon. --}}
    <span class="ui-menu-item__icon" aria-hidden="true">
        @if (filled($icon))
        <x-ui.icon :name="$icon" class="ui-menu-item__icon-svg" />
        @endif
    </span>

    <span class="ui-menu-item__label ui-menu-item-label">{{ $slot }}</span>

    @if (filled($dangerDescriptionId))
    <span id="{{ $dangerDescriptionId }}" class="ui-visually-hidden">
        {{ $dangerDescription }}
    </span>
    @endif

    @if (filled($shortcut) && ! $hasSubmenu)
    <span class="ui-menu-item__shortcut ui-menu-item-shortcut">
        {{ $shortcut }}
    </span>
    @endif

    @if ($hasSubmenu)
    <span class="ui-menu-item__shortcut ui-menu-item-submenu" aria-hidden="true">
        <x-ui.icon name="chevron--right" class="ui-menu-item__shortcut-icon ui-menu-item-submenu-icon" />
    </span>
    @endif
</a>
@else
{{-- ----------------------------------------------------------------------
        Button/action menu item
        ----------------------------------------------------------------------
        Used for non-navigation menu actions.
        ---------------------------------------------------------------------- --}}

<button
    type="{{ $resolvedButtonType }}"
    tabindex="{{ $isDisabled ? '-1' : '0' }}"
    @disabled($isDisabled)
    @if ($resolvedSelectionType) aria-checked="{{ $isSelected ? 'true' : 'false' }}" @endif
    @if ($hasSubmenu) aria-haspopup="menu" aria-expanded="false" @endif
    @if (filled($ariaDescribedBy)) aria-describedby="{{ $ariaDescribedBy }}" @endif
    @if (filled($title)) title="{{ $title }}" @endif
    {{ $componentAttributes->class($classes)->merge([
            'data-ui-component' => 'menu-item',
            'data-ui-menu-item' => true,
            'data-ui-menu-close' => $closeOnActivate && ! $hasSubmenu ? 'true' : null,
            'data-ui-menu-action' => filled($action) ? $action : null,
            'data-ui-menu-method' => $resolvedMethod,
            'data-ui-menu-item-size' => $resolvedSize,
            'data-ui-menu-item-state' => $stateValue,
            'data-ui-menu-submenu-trigger' => $hasSubmenu ? true : null,
            'data-ui-current' => $isCurrent ? 'true' : 'false',
            'role' => $resolvedRole,
        ]) }}>
    {{-- Selection/check region is always present when reserved. --}}
    @if ($shouldReserveIndicator)
    <span class="ui-menu-item__selection-icon ui-menu-item-check" aria-hidden="true">
        @if ($isSelected)
        <x-ui.icon name="checkmark" class="ui-menu-item__selection-icon-svg ui-menu-item-check-icon" />
        @endif
    </span>
    @endif

    {{-- Optional leading item icon. --}}
    <span class="ui-menu-item__icon" aria-hidden="true">
        @if (filled($icon))
        <x-ui.icon :name="$icon" class="ui-menu-item__icon-svg" />
        @endif
    </span>

    <span class="ui-menu-item__label ui-menu-item-label">{{ $slot }}</span>

    @if (filled($dangerDescriptionId))
    <span id="{{ $dangerDescriptionId }}" class="ui-visually-hidden">
        {{ $dangerDescription }}
    </span>
    @endif

    @if (filled($shortcut) && ! $hasSubmenu)
    <span class="ui-menu-item__shortcut ui-menu-item-shortcut">
        {{ $shortcut }}
    </span>
    @endif

    @if ($hasSubmenu)
    <span class="ui-menu-item__shortcut ui-menu-item-submenu" aria-hidden="true">
        <x-ui.icon name="chevron--right" class="ui-menu-item__shortcut-icon ui-menu-item-submenu-icon" />
    </span>
    @endif
</button>
@endif
