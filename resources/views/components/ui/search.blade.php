@props([
    'name',
    'id' => null,
    'label' => 'Search',
    'value' => null,
    'defaultValue' => null,
    'placeholder' => 'Search',
    'scope' => 'page',
    'size' => 'md',
    'variant' => 'default',
    'style' => null,
    'expanded' => false,
    'openLabel' => 'Open search',
    'collapseOnEscape' => true,
    'clearable' => true,
    'active' => false,
    'debounce' => 300,
    'debounceMs' => null,
    'submit' => true,
    'loading' => false,
    'disabled' => false,
    'readonly' => false,
    'readOnly' => false,
    'helper' => null,
    'helperText' => null,
    'error' => null,
    'invalid' => false,
    'invalidText' => null,
    'warning' => null,
    'warn' => false,
    'warnText' => null,
    'resultsRegion' => null,
    'clearLabel' => 'Clear search',
    'showLabel' => false,
])

@php
    $fieldId = $id ?? str($name)->slug('-')->toString();
    $value = $value ?? $defaultValue;
    $helper = $helper ?? $helperText;
    $size = in_array($size, ['sm', 'md', 'lg'], true) ? $size : 'md';
    $scope = in_array($scope, ['page', 'table', 'component', 'global'], true) ? $scope : 'page';
    $variant = in_array(($style ?? $variant), ['default', 'fluid', 'expandable'], true) ? ($style ?? $variant) : 'default';
    $isExpandable = $variant === 'expandable';
    $isExpanded = ! $isExpandable || (bool) $expanded || filled($value);
    $isReadOnly = (bool) ($readonly || $readOnly);
    $isDisabled = (bool) ($disabled || $loading);
    $isFilled = filled($value);
    $helperId = $helper ? $fieldId.'-helper' : null;
    $statusId = $loading ? $fieldId.'-status' : null;
    $describedBy = trim(collect([$helperId, $statusId])->filter()->implode(' '));
    $debounce = $debounceMs ?? $debounce;
    $fieldShellId = $fieldId.'-field';
@endphp

<div
    {{ $attributes->class([
        'ui-field',
        'ui-search',
        'ui-search-'.$size,
        'ui-search-'.$variant,
        'ui-search-filled' => $isFilled,
        'ui-search-expanded' => $isExpanded,
        'ui-search-disabled' => $isDisabled,
        'ui-search-readonly' => $isReadOnly,
        'ui-search-loading' => $loading,
    ]) }}
    role="search"
    data-ui-component="search"
    data-ui-search
    data-ui-search-scope="{{ $scope }}"
    data-ui-search-size="{{ $size }}"
    data-ui-search-variant="{{ $variant }}"
    data-ui-search-clearable="{{ $clearable ? 'true' : 'false' }}"
    data-ui-search-submit="{{ $submit ? 'true' : 'false' }}"
    @if($isExpandable) data-ui-search-expandable="true" data-ui-search-expanded="{{ $isExpanded ? 'true' : 'false' }}" data-ui-search-collapse-on-escape="{{ $collapseOnEscape ? 'true' : 'false' }}" @endif
    @if($active) data-ui-search-active="true" @endif
    @if($debounce) data-ui-search-debounce="{{ $debounce }}" @endif
    @if($resultsRegion) data-ui-search-results-region="{{ $resultsRegion }}" @endif
    @if($loading) data-ui-search-loading="true" aria-busy="true" @endif
>
    @if ($isExpandable)
        <button
            type="button"
            class="ui-search-expandable-trigger"
            aria-label="{{ $openLabel }}"
            aria-expanded="{{ $isExpanded ? 'true' : 'false' }}"
            aria-controls="{{ $fieldShellId }}"
            data-ui-search-expandable-trigger
            @disabled($isDisabled)
            @if($isExpanded) hidden @endif
        >
            <x-heroicon-o-magnifying-glass class="ui-search-expandable-icon" aria-hidden="true" />
        </button>
    @endif

    @if ($variant === 'fluid')
        <label id="{{ $fieldId }}-label" for="{{ $isReadOnly ? $fieldId.'-value' : $fieldId }}" class="ui-field-label ui-search-fluid-label">{{ $label }}</label>
    @else
        <label id="{{ $fieldId }}-label" for="{{ $isReadOnly ? $fieldId.'-value' : $fieldId }}" @class(['ui-field-label', 'sr-only' => ! $showLabel])>{{ $label }}</label>
    @endif

    @if ($isReadOnly)
        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
        <div
            id="{{ $fieldId }}-value"
            class="ui-search-readonly-value"
            aria-labelledby="{{ $fieldId }}-label"
            @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
            data-ui-search-readonly
        >
            {{ filled($value) ? $value : 'No search applied' }}
        </div>
    @else
        <div id="{{ $fieldShellId }}" class="ui-search-field" data-ui-search-field @if($isExpandable && ! $isExpanded) hidden @endif>
            <x-heroicon-o-magnifying-glass class="ui-search-icon" aria-hidden="true" />
            <input
                id="{{ $fieldId }}"
                name="{{ $name }}"
                type="search"
                value="{{ $value }}"
                placeholder="{{ $placeholder }}"
                @disabled($isDisabled)
                @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
                @if($resultsRegion) aria-controls="{{ $resultsRegion }}" @endif
                class="ui-search-input"
                data-ui-search-input
            >

            @if ($loading)
                <span class="ui-search-loading-indicator" role="status" aria-label="Searching">
                    <span class="ui-spinner" aria-hidden="true"></span>
                </span>
            @endif

            @if ($clearable)
                <button
                    type="button"
                    class="ui-search-clear"
                    aria-label="{{ $clearLabel }}"
                    data-ui-search-clear
                    @if(! $isFilled || $isDisabled) hidden @endif
                    @disabled($isDisabled)
                >
                    <x-heroicon-o-x-mark class="ui-search-clear-icon" aria-hidden="true" />
                </button>
            @endif
        </div>
    @endif

    @if ($helper)
        <p id="{{ $helperId }}" class="ui-field-helper ui-search-helper">{{ $helper }}</p>
    @endif

    @if ($loading)
        <p id="{{ $statusId }}" class="ui-field-helper ui-search-message">Searching related results.</p>
    @endif
</div>
