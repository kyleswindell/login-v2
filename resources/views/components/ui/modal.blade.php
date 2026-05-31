@props([
    'titleId' => null,
    'title' => null,
    'kicker' => null,
    'description' => null,
    'tone' => 'neutral',
])

@php
    $kickerClasses = $tone === 'danger'
        ? 'text-xs font-semibold uppercase tracking-[0.3em] text-red-300'
        : 'text-xs font-semibold uppercase tracking-[0.3em] text-slate-400';
@endphp

<div
    {{ $attributes->class(['fixed inset-0 z-50 hidden bg-black/70 px-4 py-8'])->merge(['aria-hidden' => 'true', 'data-ui-component' => 'modal']) }}
>
    <div class="mx-auto flex min-h-full max-w-xl items-center justify-center">
        <div
            class="ui-modal-panel"
            data-ui-demo-panel
            data-ui-overlay-panel
            tabindex="-1"
            role="dialog"
            aria-modal="true"
            @if ($titleId) aria-labelledby="{{ $titleId }}" @endif
        >
            @if ($kicker)
                <p class="{{ $kickerClasses }}">{{ $kicker }}</p>
            @endif
            @if ($title)
                <h2 @if ($titleId) id="{{ $titleId }}" @endif class="mt-2 text-2xl font-semibold text-white">{{ $title }}</h2>
            @endif
            @if ($description)
                <p class="mt-3 text-sm text-slate-400">{{ $description }}</p>
            @endif

            <div class="mt-4">
                {{ $slot }}
            </div>

            @isset($actions)
                <div class="mt-6 flex flex-wrap justify-end gap-3">
                    {{ $actions }}
                </div>
            @endisset
        </div>
    </div>
</div>
