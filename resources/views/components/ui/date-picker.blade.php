@props([
    'datePickerType' => 'single',
    'value' => null,
    'defaultValue' => null,
    'dateFormat' => 'Y-m-d',
    'locale' => null,
    'minDate' => null,
    'maxDate' => null,
    'disable' => null,
    'enable' => null,
    'allowInput' => true,
    'closeOnSelect' => null,
    'inline' => false,
    'appendTo' => null,
    'prevMonthAriaLabel' => 'Previous month',
    'nextMonthAriaLabel' => 'Next month',
    'ariaDateFormat' => 'F j, Y',
])

@php
    $type = in_array($datePickerType, ['simple', 'single', 'range'], true) ? $datePickerType : 'single';
    $value = $value ?? $defaultValue;

    $normalizeList = static function ($value): array {
        if ($value === null || $value === '') {
            return [];
        }

        if (is_array($value)) {
            return array_values(array_filter($value, static fn ($item) => $item !== null && $item !== ''));
        }

        return [$value];
    };

    $valueJson = json_encode($normalizeList($value), JSON_UNESCAPED_SLASHES);
    $disableJson = json_encode($normalizeList($disable), JSON_UNESCAPED_SLASHES);
    $enableJson = json_encode($normalizeList($enable), JSON_UNESCAPED_SLASHES);
    $shouldCloseOnSelect = $closeOnSelect === null ? ($type !== 'range') : (bool) $closeOnSelect;
@endphp

<div
    {{ $attributes->class([
        'ui-date-picker',
        'ui-date-picker-'.$type,
    ]) }}
    data-ui-component="date-picker"
    data-ui-date-picker
    data-ui-date-picker-type="{{ $type }}"
    @if($type !== 'simple') data-ui-date-picker-flatpickr @endif
    data-ui-date-picker-date-format="{{ $dateFormat }}"
    data-ui-date-picker-value="{{ $valueJson }}"
    data-ui-date-picker-allow-input="{{ $allowInput ? 'true' : 'false' }}"
    data-ui-date-picker-close-on-select="{{ $shouldCloseOnSelect ? 'true' : 'false' }}"
    data-ui-date-picker-inline="{{ $inline ? 'true' : 'false' }}"
    data-ui-date-picker-aria-date-format="{{ $ariaDateFormat }}"
    data-ui-date-picker-prev-month-aria-label="{{ $prevMonthAriaLabel }}"
    data-ui-date-picker-next-month-aria-label="{{ $nextMonthAriaLabel }}"
    @if($locale) data-ui-date-picker-locale="{{ $locale }}" @endif
    @if($minDate) data-ui-date-picker-min-date="{{ $minDate }}" @endif
    @if($maxDate) data-ui-date-picker-max-date="{{ $maxDate }}" @endif
    @if($disableJson !== '[]') data-ui-date-picker-disable="{{ $disableJson }}" @endif
    @if($enableJson !== '[]') data-ui-date-picker-enable="{{ $enableJson }}" @endif
    @if($appendTo) data-ui-date-picker-append-to="{{ $appendTo }}" @endif
>
    {{ $slot }}
</div>
