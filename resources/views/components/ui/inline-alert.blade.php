@props([
    'semantic' => 'neutral',
    'title' => null,
    'role' => null,
])

@php
    $allowedSemantics = ['neutral', 'info', 'success', 'notice', 'warning', 'danger'];
    $resolvedSemantic = in_array($semantic, $allowedSemantics, true) ? $semantic : 'neutral';
    $resolvedRole = $role ?? (in_array($resolvedSemantic, ['warning', 'danger'], true) ? 'alert' : 'status');
    $classes = ['ui-inline-alert', 'ui-inline-alert-'.$resolvedSemantic];
@endphp

<div
    role="{{ $resolvedRole }}"
    {{ $attributes->class($classes)->merge(['data-ui-component' => 'inline-alert']) }}
>
    @if ($title)
        <p class="font-semibold">{{ $title }}</p>
    @endif
    <div @class(['mt-1' => $title])>{{ $slot }}</div>
</div>
