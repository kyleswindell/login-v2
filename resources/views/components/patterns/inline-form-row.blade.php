@props([
    'for' => null,
    'label' => null,
    'helper' => null,
    'error' => null,
    'required' => false,
])

<div {{ $attributes->class(['ui-pattern-inline-form-row']) }} data-ui-pattern="inline-form-row">
    <div class="ui-pattern-inline-form-row-copy">
        @if ($label)
            <label @if($for) for="{{ $for }}" @endif class="ui-control-label">
                {{ $label }}
                @if ($required)
                    <span class="text-red-300">*</span>
                @endif
            </label>
        @endif

        @if ($helper)
            <p class="ui-control-copy">{{ $helper }}</p>
        @endif
        @if ($error)
            <p class="ui-control-error">{{ $error }}</p>
        @endif
    </div>

    <div class="ui-pattern-inline-form-row-control">
        {{ $slot }}
    </div>
</div>
