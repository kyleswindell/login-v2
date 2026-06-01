@props([
    'fromId' => 'date-filter-from',
    'toId' => 'date-filter-to',
    'fromName' => 'date_from',
    'toName' => 'date_to',
    'fromValue' => null,
    'toValue' => null,
    'fromLabel' => 'From',
    'toLabel' => 'To',
    'presetId' => null,
    'presetName' => 'date_preset',
    'presetLabel' => 'Preset',
    'presetOptions' => [],
    'presetValue' => null,
])

<section {{ $attributes->class(['ui-pattern-date-range-filter'])->merge(['data-ui-pattern' => 'date-range-filter']) }}>
    <div class="ui-pattern-date-range-filter-fields">
        <label class="ui-pattern-date-range-field">
            <span class="ui-control-label">{{ $fromLabel }}</span>
            <input id="{{ $fromId }}" type="date" name="{{ $fromName }}" value="{{ $fromValue }}" class="ui-input mt-2 w-full" />
        </label>

        <label class="ui-pattern-date-range-field">
            <span class="ui-control-label">{{ $toLabel }}</span>
            <input id="{{ $toId }}" type="date" name="{{ $toName }}" value="{{ $toValue }}" class="ui-input mt-2 w-full" />
        </label>

        @if ($presetOptions !== [])
            <label class="ui-pattern-date-range-field">
                <span class="ui-control-label">{{ $presetLabel }}</span>
                <select id="{{ $presetId }}" name="{{ $presetName }}" class="ui-select mt-2 w-full">
                    @foreach ($presetOptions as $value => $label)
                        <option value="{{ $value }}" @selected((string) $presetValue === (string) $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>
        @endif
    </div>

    @isset($actions)
        <div class="ui-pattern-date-range-filter-actions">
            {{ $actions }}
        </div>
    @endisset
</section>
