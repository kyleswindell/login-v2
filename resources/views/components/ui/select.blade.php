@props([
    'name',
    'id' => null,
    'label' => null,
    'options' => [],
    'optionGroups' => null,
    'value' => null,
    'defaultValue' => null,
    'placeholder' => null,
    'helper' => null,
    'helperText' => null,
    'error' => null,
    'invalid' => false,
    'invalidText' => null,
    'warning' => null,
    'warn' => false,
    'warnText' => null,
    'size' => 'md',
    'variant' => 'default',
    'style' => 'default',
    'inline' => false,
    'noLabel' => false,
    'hideLabel' => false,
    'ariaLabel' => null,
    'disabled' => false,
    'readonly' => false,
    'readOnly' => false,
    'required' => false,
    'skeleton' => false,
    'selectAttributes' => [],
])

@php
    $fieldId = $id ?? str($name)->slug('-')->toString();
    $selectedValue = $value ?? $defaultValue;
    $helper = $helper ?? $helperText;
    $error = $error ?? ($invalid ? $invalidText : null);
    $warning = $warning ?? ($warn ? $warnText : null);
    $size = in_array($size, ['xs', 'sm', 'md', 'lg'], true) ? $size : 'md';
    $requestedVariant = $inline || $variant === 'inline' ? 'inline' : (in_array($variant, ['default', 'fluid'], true) ? $variant : 'default');
    $variant = $requestedVariant === 'inline' ? 'inline' : 'default';
    $fieldStyle = $style === 'fluid' || $requestedVariant === 'fluid' ? 'fluid' : 'default';
    $isInvalid = filled($error);
    $isWarning = ! $isInvalid && filled($warning);
    $isReadOnly = (bool) ($readonly || $readOnly);
    $isDisabled = (bool) ($disabled || $skeleton);
    $hasOwnLabel = ! $noLabel && filled($label);
    $showSupportingText = ! $noLabel;
    $helperId = $helper && ! $isInvalid && ! $isWarning && $showSupportingText ? $fieldId.'-helper' : null;
    $statusId = ($isInvalid || $isWarning || $skeleton) && $showSupportingText ? $fieldId.'-status' : null;
    $describedBy = trim(collect([$helperId, $statusId])->filter()->implode(' '));
    $providedAriaLabel = $ariaLabel ?? $attributes->get('aria-label');
    $providedAriaLabelledBy = $attributes->get('aria-labelledby');
    $rootAttributes = $attributes->except(['aria-label', 'aria-labelledby']);
    $nativeSelectAttributes = (new \Illuminate\View\ComponentAttributeBag($selectAttributes))->except(['id', 'name']);

    $normalOptions = collect($options);
    $groupedOptions = collect($optionGroups ?? [])->map(function ($group) {
        return [
            'label' => data_get($group, 'label', data_get($group, 'text')),
            'disabled' => (bool) data_get($group, 'disabled', false),
            'className' => data_get($group, 'className'),
            'options' => collect(data_get($group, 'options', [])),
        ];
    });

    $embeddedGroups = $normalOptions->filter(fn ($option) => is_iterable(data_get($option, 'options')))->map(function ($group) {
        return [
            'label' => data_get($group, 'label', data_get($group, 'text', data_get($group, 'group'))),
            'disabled' => (bool) data_get($group, 'disabled', false),
            'className' => data_get($group, 'className'),
            'options' => collect(data_get($group, 'options', [])),
        ];
    });

    $standaloneOptions = $normalOptions->reject(fn ($option) => is_iterable(data_get($option, 'options')));
    $allGroups = $embeddedGroups->concat($groupedOptions);
    $flattenedOptions = $standaloneOptions->concat($allGroups->flatMap(fn ($group) => $group['options']));
    $selectedOption = $flattenedOptions->first(fn ($option) => (string) data_get($option, 'value') === (string) $selectedValue);
    $selectedLabel = data_get($selectedOption, 'text', data_get($selectedOption, 'label', $selectedValue));
    $labelId = $hasOwnLabel ? $fieldId.'-label' : null;
@endphp

<div
    {{ $rootAttributes->class([
        'ui-field',
        'ui-select-field',
        'ui-select-field-'.$fieldStyle,
        'ui-select-field-inline' => $variant === 'inline',
        'ui-select-field-no-label' => $noLabel,
        'ui-select-field-hidden-label' => $hideLabel,
        'ui-select-field-'.$size,
        'ui-select-field-invalid' => $isInvalid,
        'ui-select-field-warning' => $isWarning,
        'ui-select-field-disabled' => $isDisabled,
        'ui-select-field-readonly' => $isReadOnly,
        'ui-select-field-skeleton' => $skeleton,
    ]) }}
    data-ui-component="select"
    data-ui-select-field
    data-ui-select-size="{{ $size }}"
    data-ui-select-variant="{{ $variant }}"
    data-ui-select-style="{{ $fieldStyle }}"
    @if($noLabel) data-ui-select-no-label="true" @endif
    @if($hideLabel) data-ui-select-hidden-label="true" @endif
    @if($skeleton) aria-busy="true" @endif
>
    @if ($hasOwnLabel && $fieldStyle !== 'fluid')
        <label id="{{ $labelId }}" for="{{ $isReadOnly ? $fieldId.'-value' : $fieldId }}" @class(['ui-field-label', 'sr-only' => $hideLabel])>{{ $label }}</label>
    @endif

    @if ($isReadOnly)
        <input type="hidden" name="{{ $name }}" value="{{ $selectedValue }}">
        <div
            class="ui-select-readonly-value"
            id="{{ $fieldId }}-value"
            @if($labelId) aria-labelledby="{{ $labelId }}" @endif
            @if(! $labelId && filled($providedAriaLabel)) aria-label="{{ $providedAriaLabel }}" @endif
            @if(! $labelId && filled($providedAriaLabelledBy)) aria-labelledby="{{ $providedAriaLabelledBy }}" @endif
            @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
            data-ui-select-readonly
        >
            @if ($hasOwnLabel && $fieldStyle === 'fluid')
                <span id="{{ $labelId }}" @class(['ui-field-label', 'ui-select-fluid-label', 'sr-only' => $hideLabel])>{{ $label }}</span>
            @endif
            <span class="ui-select-readonly-text">{{ filled($selectedLabel) ? $selectedLabel : ($placeholder ?? 'No selection') }}</span>
        </div>
    @else
        <div class="ui-select-shell">
            @if ($hasOwnLabel && $fieldStyle === 'fluid')
                <label id="{{ $labelId }}" for="{{ $fieldId }}" @class(['ui-field-label', 'ui-select-fluid-label', 'sr-only' => $hideLabel])>{{ $label }}</label>
            @endif
            <select
                id="{{ $fieldId }}"
                name="{{ $name }}"
                {{ $nativeSelectAttributes->class(['ui-select']) }}
                @required($required)
                @disabled($isDisabled)
                @if($labelId) aria-labelledby="{{ $labelId }}" @endif
                @if(! $labelId && filled($providedAriaLabel)) aria-label="{{ $providedAriaLabel }}" @endif
                @if(! $labelId && filled($providedAriaLabelledBy)) aria-labelledby="{{ $providedAriaLabelledBy }}" @endif
                @if($isInvalid) aria-invalid="true" @endif
                @if($isWarning) data-ui-field-warning="true" @endif
                @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
                data-ui-select
            >
                @if($placeholder)
                    <option value="" @selected(blank($selectedValue)) @disabled($required)>{{ $placeholder }}</option>
                @endif
                @foreach($standaloneOptions as $option)
                    @php
                        $optionValue = data_get($option, 'value');
                        $optionText = data_get($option, 'text', data_get($option, 'label', $optionValue));
                        $optionClass = data_get($option, 'className');
                    @endphp
                    <option
                        value="{{ $optionValue }}"
                        @selected((string) $optionValue === (string) $selectedValue)
                        @disabled((bool) data_get($option, 'disabled', false))
                        @if((bool) data_get($option, 'hidden', false)) hidden @endif
                        @if(filled($optionClass)) class="{{ $optionClass }}" @endif
                    >{{ $optionText }}</option>
                @endforeach
                @foreach($allGroups as $group)
                    <optgroup
                        label="{{ $group['label'] }}"
                        @disabled($group['disabled'])
                        @if(filled($group['className'])) class="{{ $group['className'] }}" @endif
                    >
                        @foreach($group['options'] as $groupOption)
                            @php
                                $optionValue = data_get($groupOption, 'value');
                                $optionText = data_get($groupOption, 'text', data_get($groupOption, 'label', $optionValue));
                                $optionClass = data_get($groupOption, 'className');
                            @endphp
                            <option
                                value="{{ $optionValue }}"
                                @selected((string) $optionValue === (string) $selectedValue)
                                @disabled((bool) data_get($groupOption, 'disabled', false))
                                @if((bool) data_get($groupOption, 'hidden', false)) hidden @endif
                                @if(filled($optionClass)) class="{{ $optionClass }}" @endif
                            >{{ $optionText }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
            @if ($isInvalid)
                <x-heroicon-o-x-circle class="ui-select-status-icon ui-select-status-icon-error" aria-hidden="true" />
            @elseif ($isWarning)
                <x-heroicon-o-exclamation-triangle class="ui-select-status-icon ui-select-status-icon-warning" aria-hidden="true" />
            @endif
            <x-heroicon-o-chevron-down class="ui-select-chevron-icon" aria-hidden="true" />
        </div>
    @endif

    @if ($helper && ! $isInvalid && ! $isWarning && $showSupportingText)
        <p id="{{ $helperId }}" class="ui-field-helper">{{ $helper }}</p>
    @endif
    @if ($isInvalid && $showSupportingText)
        <p id="{{ $statusId }}" class="ui-field-error">{{ $error }}</p>
    @elseif ($isWarning && $showSupportingText)
        <p id="{{ $statusId }}" class="ui-field-warning">{{ $warning }}</p>
    @elseif ($skeleton && $showSupportingText)
        <p id="{{ $statusId }}" class="ui-field-helper">Options loading.</p>
    @endif
</div>
