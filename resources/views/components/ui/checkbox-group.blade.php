@props([
    'name',
    'legend' => null,
    'options' => [],
    'selected' => [],
    'orientation' => 'vertical',
    'helper' => null,
    'error' => null,
    'warning' => null,
    'disabled' => false,
    'readonly' => false,
    'required' => false,
    'nested' => false,
])

@php
    $groupId = str($name)->slug('-')->toString();
    $isHorizontal = $orientation === 'horizontal';
    $selectedValues = collect($selected)->map(fn ($value) => (string) $value)->all();
    $hasNestedOptions = collect($options)->contains(fn ($option) => filled(data_get($option, 'children')));
    $helperId = $helper ? $groupId.'-helper' : null;
    $statusId = $error || $warning ? $groupId.'-status' : null;
    $describedBy = trim(collect([$helperId, $statusId])->filter()->implode(' '));
@endphp

<fieldset
    {{ $attributes->class([
        'ui-checkbox-group',
        'ui-checkbox-group-horizontal' => $isHorizontal,
        'ui-checkbox-group-vertical' => ! $isHorizontal,
        'ui-checkbox-invalid' => (bool) $error,
        'ui-checkbox-warning-state' => (bool) $warning && ! $error,
    ]) }}
    data-ui-checkbox-group
    @if($hasNestedOptions || $nested) data-ui-checkbox-nested-group @endif
    @if($readonly) data-ui-checkbox-readonly @endif
    @if($describedBy !== '') aria-describedby="{{ $describedBy }}" @endif
    @if($disabled) disabled @endif
>
    @if($legend)
        <legend class="ui-checkbox-group-legend">{{ $legend }}</legend>
    @endif

    @if($helper)
        <p id="{{ $helperId }}" class="ui-checkbox-group-helper">{{ $helper }}</p>
    @endif

    <div class="ui-checkbox-group-options">
        @foreach($options as $index => $option)
            @php
                $optionValue = (string) data_get($option, 'value', $index);
                $optionName = str_ends_with($name, '[]') ? $name : $name.'[]';
                $optionId = data_get($option, 'id', $groupId.'-'.$index);
                $children = data_get($option, 'children', []);
                $hasChildren = filled($children);
                $childrenValues = collect($children)->map(fn ($child, $childIndex) => (string) data_get($child, 'value', $childIndex))->all();
                $selectedChildren = array_values(array_intersect($childrenValues, $selectedValues));
                $parentChecked = $hasChildren
                    ? count($childrenValues) > 0 && count($selectedChildren) === count($childrenValues)
                    : in_array($optionValue, $selectedValues, true) || (bool) data_get($option, 'checked', false);
                $parentIndeterminate = $hasChildren
                    ? count($selectedChildren) > 0 && count($selectedChildren) < count($childrenValues)
                    : (bool) data_get($option, 'indeterminate', false);
            @endphp
            <div @class(['ui-checkbox-option-tree' => $hasChildren])>
                <x-ui.checkbox
                    :name="$optionName"
                    :id="$optionId"
                    :value="$optionValue"
                    :label="data_get($option, 'label', $optionValue)"
                    :checked="$parentChecked"
                    :indeterminate="$parentIndeterminate"
                    :disabled="$disabled || (bool) data_get($option, 'disabled', false)"
                    :readonly="$readonly || (bool) data_get($option, 'readonly', false)"
                    :required="$required && $index === 0"
                    :helper="data_get($option, 'helper')"
                    :error="data_get($option, 'error')"
                    :warning="data_get($option, 'warning')"
                    @class(['ui-checkbox-nested' => $nested || (bool) data_get($option, 'nested', false)])
                    :data-ui-checkbox-parent="$hasChildren ? $optionId : null"
                />

                @if($hasChildren)
                    <div class="ui-checkbox-children" data-ui-checkbox-children="{{ $optionId }}">
                        @foreach($children as $childIndex => $child)
                            @php
                                $childValue = (string) data_get($child, 'value', $childIndex);
                                $childId = data_get($child, 'id', $optionId.'-child-'.$childIndex);
                            @endphp
                            <x-ui.checkbox
                                :name="$optionName"
                                :id="$childId"
                                :value="$childValue"
                                :label="data_get($child, 'label', $childValue)"
                                :checked="in_array($childValue, $selectedValues, true) || (bool) data_get($child, 'checked', false)"
                                :disabled="$disabled || (bool) data_get($child, 'disabled', false)"
                                :readonly="$readonly || (bool) data_get($child, 'readonly', false)"
                                :helper="data_get($child, 'helper')"
                                :error="data_get($child, 'error')"
                                :warning="data_get($child, 'warning')"
                                class="ui-checkbox-nested"
                                :data-ui-checkbox-child="$optionId"
                            />
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    @if($error)
        <p id="{{ $statusId }}" class="ui-checkbox-error">
            <x-ui.status-icon icon="x-circle" class="ui-checkbox-status-icon h-4 w-4 shrink-0" />
            <span>{{ $error }}</span>
        </p>
    @elseif($warning)
        <p id="{{ $statusId }}" class="ui-checkbox-warning">
            <x-ui.status-icon icon="exclamation-triangle" class="ui-checkbox-status-icon h-4 w-4 shrink-0" />
            <span>{{ $warning }}</span>
        </p>
    @endif
</fieldset>
