@props([
    'steps' => [],
    'orientation' => 'horizontal',
])

<ol
    @class(['flex gap-4', 'flex-col' => $orientation === 'vertical', 'flex-row flex-wrap' => $orientation !== 'vertical'])
    data-ui-component="progress-indicator"
    data-ui-progress-indicator-orientation="{{ $orientation }}"
>
    @foreach ($steps as $step)
        <x-ui.progress-step :label="data_get($step, 'label')" :state="data_get($step, 'state', 'upcoming')" />
    @endforeach
</ol>
