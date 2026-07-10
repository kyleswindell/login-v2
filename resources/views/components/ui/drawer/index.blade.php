@props([
    'titleId' => null,
    'title' => null,
    'kicker' => null,
    'description' => null,
])

<div
    {{ $attributes->class(['fixed inset-0 z-50 hidden bg-black/60'])->merge(['aria-hidden' => 'true', 'data-ui-component' => 'drawer']) }}
>
    <div
        class="ui-log-drawer-panel"
        data-ui-demo-panel
        data-ui-overlay-panel
        tabindex="-1"
        role="dialog"
        aria-modal="true"
        @if ($titleId) aria-labelledby="{{ $titleId }}" @endif
    >
        <div class="flex items-start justify-between gap-3 border-b border-slate-800 px-6 py-5">
            <div>
                @if ($kicker)
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">{{ $kicker }}</p>
                @endif
                @if ($title)
                    <h2 @if ($titleId) id="{{ $titleId }}" @endif class="mt-2 text-2xl font-semibold text-white">{{ $title }}</h2>
                @endif
                @if ($description)
                    <p class="mt-2 text-sm text-slate-400">{{ $description }}</p>
                @endif
            </div>

            @isset($headerActions)
                <div class="shrink-0">
                    {{ $headerActions }}
                </div>
            @endisset
        </div>

        <div class="overflow-y-auto px-6 py-6">
            {{ $slot }}
        </div>

        @isset($actions)
            <div class="border-t border-slate-800 px-6 py-4">
                <div class="flex flex-wrap justify-end gap-3">
                    {{ $actions }}
                </div>
            </div>
        @endisset
    </div>
</div>
