@props([
'name',
'id' => null,
'label',
'options' => [],
'value' => null,
'placeholder' => 'Choose an option',
'helper' => null,
'error' => null,
'warning' => null,
'size' => 'md',
'variant' => 'default',
'required' => false,
'disabled' => false,
'readonly' => false,
'open' => false,
'menuMaxHeight' => null,
'placement' => 'auto',
])

@php
$fieldId = $id ?? str($name)->slug('-')->toString();
$listBoxId = $fieldId.'-listbox';
$menuId = $fieldId.'-menu';
$labelId = $fieldId.'-label';
$statusId = $error || $warning ? $fieldId.'-status' : null;
$helperId = $helper ? $fieldId.'-helper' : null;

$selected = collect($options)->first(fn ($option) => (string) data_get($option, 'value') === (string) $value);
$selectedLabel = data_get($selected, 'label');

$size = in_array($size, ['xs', 'sm', 'md', 'lg'], true) ? $size : 'md';
$variant = $variant === 'fluid' ? 'fluid' : 'default';
$placement = in_array($placement, ['auto', 'down', 'up'], true) ? $placement : 'auto';

$isDisabled = (bool) $disabled;
$isReadOnly = (bool) $readonly;
$isInvalid = filled($error);
$isWarning = ! $isInvalid && filled($warning);
$isOpen = (bool) $open;

$describedBy = trim(collect([$helperId, $statusId])->filter()->implode(' '));

$menuStyle = $menuMaxHeight
? '--ui-dropdown-menu-max-block-size: '.$menuMaxHeight.'; --ui-list-box-menu-max-block-size: '.$menuMaxHeight.';'
: null;

@endphp

<div
    {{ $attributes->class([
        'ui-field',
        'ui-list-box-wrapper',
        'ui-dropdown',
        'ui-dropdown-'.$size,
        'ui-dropdown-fluid' => $variant === 'fluid',
        'ui-dropdown-open' => $isOpen,
        'ui-dropdown-focus' => $isOpen,
        'ui-dropdown-up' => $placement === 'up',
        'ui-dropdown-disabled' => $isDisabled,
        'ui-dropdown-readonly' => $isReadOnly,
        'ui-dropdown-invalid' => $isInvalid,
        'ui-dropdown-warning' => $isWarning,
    ]) }}
    data-ui-component="dropdown"
    data-ui-dropdown
    data-ui-dropdown-size="{{ $size }}"
    data-ui-dropdown-variant="{{ $variant }}"
    data-ui-dropdown-placement="{{ $placement }}"
    data-ui-dropdown-open="{{ $isOpen ? 'true' : 'false' }}"
    data-ui-dropdown-readonly="{{ $isReadOnly ? 'true' : 'false' }}">
    <label
        id="{{ $labelId }}"
        for="{{ $fieldId }}"
        class="ui-field-label"
        data-ui-dropdown-label>
        {{ $label }}
    </label>

    <input
        type="hidden"
        name="{{ $name }}"
        value="{{ $value }}"
        data-ui-dropdown-hidden-input>

    <div
        id="{{ $listBoxId }}"
        @class([ 'ui-list-box' , 'ui-list-box-' .$size, 'ui-list-box-expanded'=> $isOpen,
        'ui-list-box-up' => $placement === 'up',
        'ui-list-box-disabled' => $isDisabled,
        'ui-list-box-invalid' => $isInvalid,
        'ui-list-box-warning' => $isWarning,
        ])
        data-ui-list-box
        data-ui-dropdown-list-box
        @if($isInvalid) data-invalid @endif
        @if($isWarning) data-ui-field-warning="true" @endif
        @if($placement === 'up') data-ui-list-box-placement="up" @endif
        @if($isOpen) data-ui-list-box-expanded="true" @endif
        >
        @if ($isInvalid)
        <x-heroicon-o-x-circle
            class="ui-list-box-invalid-icon ui-dropdown-invalid-icon"
            aria-hidden="true" />
        @elseif ($isWarning)
        <x-heroicon-o-exclamation-triangle
            class="ui-list-box-warning-icon ui-dropdown-warning-icon"
            aria-hidden="true" />
        @endif

        <button
            id="{{ $fieldId }}"
            type="button"
            class="ui-list-box-field ui-dropdown-trigger"
            aria-haspopup="listbox"
            aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
            aria-controls="{{ $menuId }}"
            aria-labelledby="{{ $labelId }}"
            @if($describedBy !=='' ) aria-describedby="{{ $describedBy }}" @endif
            @if($isInvalid) aria-invalid="true" @endif
            @if($isReadOnly) aria-readonly="true" aria-disabled="true" @endif
            @if($required) aria-required="true" @endif
            @disabled($isDisabled)
            title="{{ $selectedLabel ?? $placeholder }}"
            data-ui-dropdown-trigger
            data-ui-dropdown-field
            data-ui-dropdown-unified-trigger>
            <span
                @class([ 'ui-list-box-label' , 'ui-dropdown-value' , 'ui-dropdown-placeholder'=> blank($selectedLabel),
                ])
                data-ui-dropdown-value
                >
                {{ $selectedLabel ?? $placeholder }}
            </span>

            <span
                class="ui-list-box-menu-icon ui-dropdown-chevron"
                aria-hidden="true"
                data-ui-dropdown-chevron>
                <x-heroicon-o-chevron-down class="ui-dropdown-chevron-icon" />
            </span>
        </button>

        <div
            id="{{ $menuId }}"
            @class([ 'ui-list-box-menu' , 'ui-dropdown-list' , 'ui-list-box-menu-open'=> $isOpen,
            ])
            role="listbox"
            tabindex="-1"
            aria-labelledby="{{ $labelId }}"
            data-ui-dropdown-menu
            @if($menuStyle) style="{{ $menuStyle }}" @endif
            @if(! $isOpen) hidden @endif
            @if($placement === 'up') data-ui-dropdown-resolved-placement="up" data-ui-list-box-resolved-placement="up" @endif
            >
            @foreach ($options as $option)
            @php
            $optionValue = data_get($option, 'value');
            $optionLabel = data_get($option, 'label', $optionValue);
            $isSelected = (string) $optionValue === (string) $value;
            $optionDisabled = (bool) data_get($option, 'disabled', false);
            $optionId = $fieldId.'-option-'.str($optionValue)->slug('-')->toString();
            @endphp

            <button
                id="{{ $optionId }}"
                type="button"
                @class([ 'ui-list-box-menu-item' , 'ui-dropdown-item' , 'ui-list-box-menu-item-selected'=> $isSelected,
                'ui-list-box-menu-item-active' => $isSelected,
                'ui-dropdown-selected' => $isSelected,
                'ui-list-box-menu-item-disabled' => $optionDisabled,
                'ui-dropdown-option-disabled' => $optionDisabled,
                ])
                role="option"
                aria-selected="{{ $isSelected ? 'true' : 'false' }}"
                @if($optionDisabled) aria-disabled="true" @endif
                @disabled($optionDisabled)
                title="{{ $optionLabel }}"
                data-ui-dropdown-option
                data-ui-dropdown-value="{{ $optionValue }}"
                data-ui-dropdown-option-value="{{ $optionValue }}"
                data-ui-dropdown-option-label="{{ $optionLabel }}"
                >
                <span class="ui-list-box-menu-item-option ui-dropdown-link ui-dropdown-option-label">
                    {{ $optionLabel }}
                </span>

                <x-heroicon-o-check
                    class="ui-list-box-menu-item-selected-icon ui-dropdown-option-check"
                    aria-hidden="true" />
            </button>
            @endforeach
        </div>
    </div>

    @if ($helper)
    <p id="{{ $helperId }}" class="ui-field-helper">{{ $helper }}</p>
    @endif

    @if ($error)
    <p id="{{ $statusId }}" class="ui-field-error">{{ $error }}</p>
    @elseif ($warning)
    <p id="{{ $statusId }}" class="ui-field-warning">{{ $warning }}</p>
    @endif

</div>