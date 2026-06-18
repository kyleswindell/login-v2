@props([
    'semantic' => 'neutral',
    'title' => null,
    'role' => null,
    'live' => null,
    'dismissible' => false,
])

@php
    $allowedSemantics = ['neutral', 'info', 'success', 'notice', 'warning', 'danger'];
    $resolvedSemantic = in_array($semantic, $allowedSemantics, true) ? $semantic : 'neutral';
    $resolvedRole = $role ?? (in_array($resolvedSemantic, ['warning', 'danger'], true) ? 'alert' : 'status');
    $resolvedLive = $live ?? ($resolvedRole === 'alert' ? 'assertive' : 'polite');
    $titleClasses = $resolvedSemantic === 'neutral' ? 'font-semibold text-white' : 'font-semibold';
@endphp

<div
    role="{{ $resolvedRole }}"
    aria-live="{{ $resolvedLive }}"
    {{ $attributes->class(['ui-toast', 'ui-toast-'.$resolvedSemantic])->merge(['data-ui-component' => 'toast']) }}
>
    <div class="flex items-start justify-between gap-3">
        <div class="min-w-0 flex-1">
            @if ($title)
                <p class="{{ $titleClasses }}">{{ $title }}</p>
            @endif
            <div @class(['mt-1' => $title])>{{ $slot }}</div>
        </div>

        @isset($actions)
            <div class="flex shrink-0 items-start gap-2">
                {{ $actions }}
            </div>
        @elseif ($dismissible)
            <div class="flex shrink-0 items-start gap-2">
                <x-ui.button semantic="ghost" size="xs">Dismiss</x-ui.button>
            </div>
        @endisset
    </div>
</div>
