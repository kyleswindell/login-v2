{{-- ==========================================================================
    File: resources/views/components/ui/data-table/toolbar/search.blade.php
    Purpose: Data Table toolbar search composition wrapper.

    Notes:
    - Composes the existing x-ui.search component.
    - Adds table-toolbar search container classes and data attributes.
    - Keeps toolbar data attributes on the toolbar search container, not on the
      nested search input.
    - Supports parent-aware toolbar size and explicit size override.
    - Does not own filtering logic or query state.
    ========================================================================== --}}

@aware([
    'size' => null,
])

@props([
    'id' => null,
    'name' => null,
    'labelText' => 'Filter table',
    'placeholder' => 'Filter table',
    'defaultValue' => '',
    'disabled' => false,
    'expanded' => null,
    'defaultExpanded' => false,
    'persistent' => false,
    'tabIndex' => 0,
    'searchContainerClass' => null,
])

@php
    use Illuminate\Support\Str;

    /*
    |--------------------------------------------------------------------------
    | Resolve Search Values
    |--------------------------------------------------------------------------
    */

    $resolvedId = $id ?? 'ui-table-toolbar-search-'.Str::uuid();

    $requestedSize = $attributes->get('size') ?? $size;

    $resolvedSize = in_array($requestedSize, ['xs', 'sm', 'md', 'lg'], true)
        ? $requestedSize
        : null;

    $resolvedTabIndex = $attributes->get('tabindex', $attributes->get('tabIndex', $tabIndex));

    /*
    |--------------------------------------------------------------------------
    | Resolve Expanded State
    |--------------------------------------------------------------------------
    */

    $isPersistent = (bool) $persistent;
    $isDisabled = (bool) $disabled;

    $isControlledExpanded = ! is_null($expanded);
    $isExpanded = $isControlledExpanded
        ? (bool) $expanded
        : ((bool) $defaultExpanded || filled($defaultValue) || $isPersistent);

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        $searchContainerClass,
        'ui-toolbar-search-container',
        'ui-toolbar-search-container-active' => $isExpanded,
        'ui-toolbar-search-container-disabled' => $isDisabled,
        'ui-toolbar-search-container-expandable' => ! $isPersistent,
        'ui-toolbar-search-container-persistent' => $isPersistent,
    ];

    /*
    |--------------------------------------------------------------------------
    | Attribute Handling
    |--------------------------------------------------------------------------
    |
    | Container attributes stay on this wrapper. Search-specific input behavior
    | is passed explicitly into x-ui.search.
    |
    */

    $containerAttributes = $attributes->except([
        'size',
        'tabindex',
        'tabIndex',
    ]);
@endphp

<div
    {{ $containerAttributes->class($classes)->merge([
        'data-ui-table-toolbar-search' => true,
        'data-ui-table-toolbar-search-expanded' => $isExpanded ? 'true' : 'false',
        'data-ui-table-toolbar-search-persistent' => $isPersistent ? 'true' : 'false',
    ]) }}
>
    <x-ui.search
        :id="$resolvedId"
        :name="$name"
        :label-text="$labelText"
        :placeholder="$placeholder"
        :default-value="$defaultValue"
        :disabled="$isDisabled"
        :size="$resolvedSize"
        :is-expanded="$isExpanded"
        :expandable="! $isPersistent"
        tabindex="{{ $resolvedTabIndex }}"
    />
</div>