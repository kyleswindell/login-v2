@props([
    'for' => null,
    'label' => null,
    'helper' => null,
    'error' => null,
    'required' => false,
])

<div {{ $attributes->class(['ui-pattern-form-group']) }} data-ui-pattern="form-group">
    @if ($label)
        <label @if($for) for="{{ $for }}" @endif class="ui-control-label">
            {{ $label }}
            @if ($required)
                <span class="text-red-300">*</span>
            @endif
        </label>
    @endif

    <div class="mt-2">
        {{ $slot }}
    </div>

    @if ($helper)
        <p class="ui-control-copy">{{ $helper }}</p>
    @endif

    @if ($error)
        <p class="ui-control-error">{{ $error }}</p>
    @endif
</div>
