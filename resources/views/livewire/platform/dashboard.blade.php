<section class="flex flex-1 flex-col gap-6">

        {{-- Page header --}}
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="ui-page-header-title">Dashboard</h1>
                <p class="ui-page-header-copy">Welcome back, {{ auth()->user()->name ?? auth()->user()->email }}.</p>
            </div>

            <div class="flex items-center gap-2 flex-shrink-0">
                @if ($isEditing)
                    <button
                        wire:click="resetLayout"
                        wire:confirm="Reset your dashboard to the default layout?"
                        class="ui-action ui-action-ghost"
                    >
                        Reset
                    </button>
                @endif

                <button
                    wire:click="toggleLock"
                    @class([
                        'ui-action gap-2',
                        'ui-action-success' => $isEditing,
                        'ui-action-outline' => ! $isEditing,
                    ])
                >
                    @if ($isEditing)
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Lock Dashboard
                    @else
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                        </svg>
                        Customize
                    @endif
                </button>
            </div>
        </div>

        {{-- Widget grid --}}
        <div
            id="dashboard-widget-grid"
            class="grid grid-cols-12 gap-4"
            @if ($isEditing)
                data-sortable="true"
                x-data="dashboardSort(@js(collect($widgetLayout)->pluck('widget_key')->all()))"
                x-init="init()"
            @endif
        >
            @foreach ($visibleWidgets as $slot)
                <div
                    class="col-span-12
                        {{ $slot['column_span'] === 'full' ? 'xl:col-span-12' : 'xl:col-span-' . $slot['column_span'] }}"
                    data-widget-key="{{ $slot['widget_key'] }}"
                >
                    @if ($isEditing)
                        {{-- Edit mode card wrapper with drag handle + visibility toggle --}}
                        <div class="group relative rounded-lg border border-slate-700/60 bg-slate-900/50">
                            <div class="flex items-center justify-between rounded-t-lg border-b border-slate-700/60 bg-slate-800/60 py-1.5 px-3">
                                <span class="dashboard-drag-handle cursor-grab active:cursor-grabbing text-slate-500 hover:text-slate-300 transition" title="Drag to reorder">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M7 2a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm6 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM7 8a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm6 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM7 14a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm6 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                                    </svg>
                                </span>
                                    <button
                                        wire:click="toggleWidgetVisibility('{{ $slot['widget_key'] }}')"
                                        class="ui-action ui-action-ghost ui-action-xs"
                                        title="Hide widget"
                                    >
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="pointer-events-none select-none opacity-90">
                                {!! $slot['renderedHtml'] !!}
                            </div>
                        </div>
                    @else
                        {!! $slot['renderedHtml'] !!}
                    @endif
                </div>
            @endforeach

            {{-- Hidden widgets panel (edit mode only) --}}
            @if ($isEditing)
                @php
                    $hiddenSlots = collect($allSlots)->filter(fn($s) => !($s['is_visible'] ?? true));
                @endphp
                @if ($hiddenSlots->isNotEmpty())
                    <div class="col-span-12">
                        <div class="rounded-lg border border-slate-700/40 bg-slate-800/30 p-4">
                            <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-slate-500">Hidden Widgets</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($hiddenSlots as $slot)
                                    <button
                                        wire:click="toggleWidgetVisibility('{{ $slot['widget_key'] }}')"
                                        class="ui-action ui-action-outline ui-action-xs"
                                    >
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                        </svg>
                                        {{ $slot['widget_key'] }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>

    </section>
