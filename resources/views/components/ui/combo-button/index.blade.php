{{-- ==========================================================================
    File: resources/views/components/ui/combo-button/index.blade.php
    Purpose: Combo Button component with primary action and attached menu.

    Notes:
    - Emits the installed Combo Button selector contract.
    - Uses the canonical .ui-btn Button selector contract for both controls.
    - Primary action and menu trigger are rendered separately.
    - The menu trigger owns aria-haspopup, aria-expanded, and aria-controls.
    - The menu surface is rendered by resources/views/components/ui/menu/index.blade.php.
    - Menu is rendered in triggerless mode because this component owns the trigger.
    - Menu positioning/open behavior is handled by installed Combo Button/Menu JS.
    ========================================================================== --}}

@props([
    'items' => [],
    'id' => null,
    'menuId' => null,
    'label' => 'Apply',
    'menuLabel' => 'Additional actions',
    'action' => null,
    'size' => 'md',
    'align' => 'bottom-end',
    'placement' => null,
    'menuAlignment' => null,
    'tooltipAlignment' => null,
    'open' => false,
    'disabled' => false,
    'loading' => false,
])

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedSizes = [
        'xs',
        'sm',
        'md',
        'lg',
    ];

    $allowedPlacements = [
        'top',
        'top-start',
        'top-end',
        'bottom',
        'bottom-start',
        'bottom-end',
    ];

    $placementAliases = [
        'start' => 'bottom-start',
        'end' => 'bottom-end',
        'top-left' => 'top-start',
        'top-right' => 'top-end',
        'bottom-left' => 'bottom-start',
        'bottom-right' => 'bottom-end',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    |
    | `placement` is canonical. `menuAlignment` is retained as the Carbon-style
    | name. `align` is retained as the older app alias.
    |
    */

    $resolvedId = $id
        ?? $attributes->get('id')
        ?? 'ui-combo-button-'.Str::uuid();

    $resolvedMenuId = $menuId ?? $resolvedId.'-menu';

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : 'md';

    $requestedPlacement = $placement ?? $menuAlignment ?? $align;
    $requestedPlacement = $placementAliases[$requestedPlacement] ?? $requestedPlacement;

    $resolvedPlacement = in_array($requestedPlacement, $allowedPlacements, true)
        ? $requestedPlacement
        : 'bottom-end';

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isOpen = filter_var($open, FILTER_VALIDATE_BOOLEAN);
    $isLoading = filter_var($loading, FILTER_VALIDATE_BOOLEAN);
    $isDisabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN) || $isLoading;

    $triggerControls = $isOpen ? $resolvedMenuId : null;

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    |
    | Existing ui-combo-button-* selectors are retained because they are the
    | installed Combo Button selectors.
    |
    */

    $containerClasses = [
        'ui-combo-button',
        'ui-combo-button-'.$resolvedSize,
        'ui-combo-button-open' => $isOpen,
    ];

    $primaryWrapperClasses = [
        'ui-combo-button-primary',
    ];

    $primaryActionClasses = [
        'ui-combo-button-primary',
        'ui-combo-button-primary-action',
    ];

    $triggerClasses = [
        'ui-combo-button-trigger',
        'ui-combo-button-trigger-open' => $isOpen,
    ];

    $menuClasses = [
        'ui-combo-button-menu',
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    */

    $comboAttributes = $attributes->except([
        'id',
    ]);
@endphp

<div
    id="{{ $resolvedId }}"
    {{ $comboAttributes->class($containerClasses)->merge([
        'aria-owns' => $isOpen ? $resolvedMenuId : null,
        'data-ui-component' => 'combo-button',
        'data-ui-combo-button' => true,
        'data-ui-combo-button-id' => $resolvedId,
        'data-ui-combo-button-menu-id' => $resolvedMenuId,
        'data-ui-combo-button-size' => $resolvedSize,
        'data-ui-combo-button-placement' => $resolvedPlacement,
        'data-ui-combo-button-open' => $isOpen ? 'true' : 'false',
        'data-ui-combo-button-disabled' => $isDisabled ? 'true' : 'false',
        'data-ui-combo-button-loading' => $isLoading ? 'true' : 'false',
    ]) }}
>
    {{-- ----------------------------------------------------------------------
        Primary Action
        ----------------------------------------------------------------------
        The primary action is a normal Button. Optional action metadata is
        exposed for installed JavaScript to handle.
        ---------------------------------------------------------------------- --}}

    <div @class($primaryWrapperClasses) data-ui-combo-button-primary>
        <x-ui.button
            kind="primary"
            :size="$resolvedSize"
            :disabled="$isDisabled"
            :loading="$isLoading"
            @class($primaryActionClasses)
            @if (filled($action)) data-ui-combo-button-action="{{ $action }}" @endif
            data-ui-combo-button-primary-action
        >
            @if ($label instanceof HtmlString)
                {!! $label !!}
            @else
                {{ $label }}
            @endif
        </x-ui.button>
    </div>

    {{-- ----------------------------------------------------------------------
        Menu Trigger
        ----------------------------------------------------------------------
        The attached trigger is an icon-only Button with a generated chevron
        icon. It controls the triggerless menu surface below.
        ---------------------------------------------------------------------- --}}

    <x-ui.icon-button
        kind="primary"
        :size="$resolvedSize"
        :label="$menuLabel"
        icon="chevron--down"
        :disabled="$isDisabled"
        :align="$tooltipAlignment"
        @class($triggerClasses)
        aria-haspopup="menu"
        aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
        @if (filled($triggerControls)) aria-controls="{{ $triggerControls }}" @endif
        data-ui-combo-button-trigger
    />

    {{-- ----------------------------------------------------------------------
        Menu Surface
        ----------------------------------------------------------------------
        x-ui.menu is rendered in triggerless mode because this component owns
        the menu trigger and ARIA relationship.
        ---------------------------------------------------------------------- --}}

    <x-ui.menu
        :trigger="false"
        :id="$resolvedMenuId"
        :items="$items"
        :label="$menuLabel"
        :size="$resolvedSize"
        :open="$isOpen"
        :placement="$resolvedPlacement"
        @class($menuClasses)
        data-ui-menu-button-kind="combo"
        data-ui-combo-button-menu
    >
        {{ $slot }}
    </x-ui.menu>
</div>