@props([
    'name',
    'id' => null,
    'label' => 'Search',
    'value' => null,
    'placeholder' => 'Search',
    'helper' => null,
    'disabled' => false,
    'loading' => false,
])

@php
    $fieldId = $id ?? str($name)->slug('-')->toString();
    $helperId = $helper ? $fieldId.'-helper' : null;
@endphp

<div class="ui-field" data-ui-component="search" data-ui-search>
    <label for="{{ $fieldId }}" class="ui-field-label">{{ $label }}</label>
    <div class="relative mt-2">
        <input
            id="{{ $fieldId }}"
            name="{{ $name }}"
            type="search"
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            @disabled($disabled)
            @if ($helperId) aria-describedby="{{ $helperId }}" @endif
            data-ui-search-input
            {{ $attributes->class('ui-input pr-12') }}
        >
        <span class="pointer-events-none absolute inset-y-0 right-3 inline-flex items-center" style="color: var(--ui-icon-secondary);" aria-hidden="true">
            @if ($loading)
                <span class="ui-spinner"></span>
            @else
                <span class="text-sm">⌕</span>
            @endif
        </span>
    </div>
    @if ($helper)
        <p id="{{ $helperId }}" class="ui-field-helper">{{ $helper }}</p>
    @endif
</div>
