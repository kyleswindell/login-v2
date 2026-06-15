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
    $error = $error ?? ($invalid ? $invalidText : null);
    $warning = $warning ?? ($warn ? $warnText : null);
    $size = in_array($size, ['sm', 'md', 'lg'], true) ? $size : 'md';
    $scope = in_array($scope, ['page', 'table', 'component', 'global'], true) ? $scope : 'page';
    $variant = ($style ?? $variant) === 'fluid' ? 'fluid' : 'default';
    $isInvalid = filled($error);
    $isWarning = ! $isInvalid && filled($warning);
    $isReadOnly = (bool) ($readonly || $readOnly);
    $isDisabled = (bool) ($disabled || $loading);
    $isFilled = filled($value);
    $helperId = $helper && ! $isInvalid && ! $isWarning ? $fieldId.'-helper' : null;
    $statusId = $isInvalid || $isWarning || $loading ? $fieldId.'-status' : null;
    $describedBy = trim(collect([$helperId, $statusId])->filter()->implode(' '));
    $debounce = $debounceMs ?? $debounce;
@endphp

<div
    {{ $attributes->class([
        'ui-field',
        'ui-search',
        'ui-search-'.$size,
        'ui-search-'.$variant,
        'ui-search-filled' => $isFilled,
        'ui-search-invalid' => $isInvalid,
        'ui-search-warning' => $isWarning,
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
    @if($active) data-ui-search-active="true" @endif
    @if($debounce) data-ui-search-debounce="{{ $debounce }}" @endif
    @if($resultsRegion) data-ui-search-results-region="{{ $resultsRegion }}" @endif
    @if($loading) data-ui-search-loading="true" aria-busy="true" @endif
>
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
        <div class="ui-search-field">
            <x-heroicon-o-magnifying-glass class="ui-search-icon" aria-hidden="true" />
            <input
                id="{{ $fieldId }}"
                name="{{ $name }}"
                type="search"
                value="{{ $value }}"
                placeholder="{{ $placeholder }}"
                @disabled($isDisabled)
                @if($isInvalid) aria-invalid="true" @endif
                @if($isWarning) data-ui-field-warning="true" @endif
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

    @if ($helper && ! $isInvalid && ! $isWarning)
        <p id="{{ $helperId }}" class="ui-field-helper ui-search-helper">{{ $helper }}</p>
    @endif

    @if ($isInvalid)
        <p id="{{ $statusId }}" class="ui-field-error ui-search-error">{{ $error }}</p>
    @elseif ($isWarning)
        <p id="{{ $statusId }}" class="ui-field-warning ui-search-warning-message">{{ $warning }}</p>
    @elseif ($loading)
        <p id="{{ $statusId }}" class="ui-field-helper ui-search-message">Searching related results.</p>
    @endif
</div>
