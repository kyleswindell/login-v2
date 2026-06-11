@php
    $placementRows = [
        ['Top', 'top', 'center', 'Top placement'],
        ['Right', 'right', 'center', 'Right placement'],
        ['Bottom', 'bottom', 'center', 'Bottom placement'],
        ['Left', 'left', 'center', 'Left placement'],
    ];

    $alignmentRows = [
        ['Start aligned', 'top', 'start'],
        ['Center aligned', 'top', 'center'],
        ['End aligned', 'top', 'end'],
    ];

    $contentRows = [
        ['Icon-only action', 'Refresh data', 'One or two words that name the action.'],
        ['Definition', 'A workspace groups users, roles, and settings for one account.', 'A short complete sentence with punctuation.'],
        ['Disabled reason', 'You need admin access to delete this workspace.', 'A brief explanation for the unavailable action.'],
    ];

    $boundaryRows = [
        ['Tooltip', 'Short, non-interactive, optional hover/focus help.'],
        ['Toggletip', 'Dismissible help when users need more time or richer content.'],
        ['Popover', 'A positioned overlay with richer content or component-owned interaction.'],
        ['Modal', 'A blocking decision or task that must be completed or dismissed.'],
        ['Helper text', 'Visible required guidance that should not disappear.'],
    ];
@endphp

<div class="space-y-6" data-component-live-layout="tooltip-matrix">
    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tooltip-live-section="anatomy">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Anatomy</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Tooltip anatomy is the UI trigger, caret tip, and non-interactive container. The caret remains visually attached to the trigger.</p>

        <div class="mt-8 flex min-h-40 items-center justify-center rounded-md border p-8" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
            <x-ui.tooltip text="Edit workspace" placement="top" align="center" size="single" open>
                <x-ui.icon-button icon="heroicon-o-pencil-square" label="Edit workspace" semantic="ghost" />
            </x-ui.tooltip>
        </div>

        <div class="mt-4 grid gap-3 md:grid-cols-3">
            <div class="rounded-md border p-3" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-tooltip-anatomy-part="trigger">
                <p class="text-sm font-semibold" style="color: var(--ui-text-primary);">UI trigger</p>
                <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Any component with integrated tooltip help, or a definition term.</p>
            </div>
            <div class="rounded-md border p-3" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-tooltip-anatomy-part="caret">
                <p class="text-sm font-semibold" style="color: var(--ui-text-primary);">Caret tip</p>
                <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">A 6px caret associates the container with the trigger.</p>
            </div>
            <div class="rounded-md border p-3" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-tooltip-anatomy-part="container">
                <p class="text-sm font-semibold" style="color: var(--ui-text-primary);">Container</p>
                <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Contains short, optional, non-interactive text.</p>
            </div>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tooltip-live-section="placement-alignment">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Placement and alignment</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Placement defaults to auto. Manual placements use top, right, bottom, or left; alignment uses start, center, or end to keep the container in view.</p>

        <div class="mt-6 rounded-md border p-6" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-tooltip-placement-proof="auto">
            <p class="mb-8 text-sm font-semibold" style="color: var(--ui-text-primary);">Auto placement</p>
            <x-ui.tooltip text="Auto placement" open>
                <x-ui.button semantic="tertiary" size="sm">Default auto</x-ui.button>
            </x-ui.tooltip>
        </div>

        <div class="mt-6 grid gap-4 xl:grid-cols-4">
            @foreach ($placementRows as [$label, $placement, $align, $copy])
                <article class="min-h-44 rounded-md border p-6" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-tooltip-placement-proof="{{ $placement }}">
                    <p class="mb-10 text-sm font-semibold" style="color: var(--ui-text-primary);">{{ $label }}</p>
                    <div class="flex justify-center">
                        <x-ui.tooltip :text="$copy" :placement="$placement" :align="$align" size="single" open>
                            <x-ui.button semantic="tertiary" size="sm">{{ $label }}</x-ui.button>
                        </x-ui.tooltip>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-6 grid gap-4 xl:grid-cols-3">
            @foreach ($alignmentRows as [$label, $placement, $align])
                <article class="min-h-36 rounded-md border p-6" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-tooltip-alignment-proof="{{ $align }}">
                    <p class="mb-10 text-sm font-semibold" style="color: var(--ui-text-primary);">{{ $label }}</p>
                    <x-ui.tooltip text="Aligned container" :placement="$placement" :align="$align" size="single" open>
                        <x-ui.button semantic="ghost" size="sm">{{ Str::headline($align) }}</x-ui.button>
                    </x-ui.tooltip>
                </article>
            @endforeach
        </div>
    </section>

    <section class="grid gap-4 xl:grid-cols-2">
        <article class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tooltip-live-section="sizing">
            <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Sizing and structure</h3>
            <div class="mt-6 grid gap-5">
                <div class="min-h-20 rounded-md border p-5" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-tooltip-size-proof="single">
                    <x-ui.tooltip text="Refresh data" placement="right" size="single" open>
                        <x-ui.icon-button icon="heroicon-o-arrow-path" label="Refresh data" semantic="ghost" />
                    </x-ui.tooltip>
                </div>
                <div class="min-h-32 rounded-md border p-5" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-tooltip-size-proof="multi">
                    <x-ui.tooltip text="This action refreshes the table data without changing the current filters." placement="right" size="multi" open>
                        <x-ui.button semantic="secondary" size="sm">Refresh table</x-ui.button>
                    </x-ui.tooltip>
                </div>
                <div class="min-h-28 rounded-md border p-5" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-tooltip-size-proof="definition">
                    <p class="text-sm leading-6" style="color: var(--ui-text-secondary);">
                        Assign users to a
                        <x-ui.tooltip text="A workspace groups users, roles, and settings for one account." placement="top" kind="definition" open>
                            <button type="button" class="ui-tooltip-definition-trigger">workspace</button>
                        </x-ui.tooltip>
                        before granting access.
                    </p>
                </div>
            </div>
        </article>

        <article class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tooltip-live-section="behavior">
            <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Behavior and accessibility</h3>
            <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Tooltips open on hover and focus, close on blur/pointer leave, and dismiss with Escape. Content stays non-interactive.</p>
            <div class="mt-5 grid gap-4">
                <div class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-tooltip-state-proof="closed">
                    <p class="mb-3 text-sm font-semibold" style="color: var(--ui-text-primary);">Closed by default</p>
                    <x-ui.tooltip text="Closed until hover or focus" placement="top">
                        <x-ui.button semantic="ghost" size="sm">Hover or focus</x-ui.button>
                    </x-ui.tooltip>
                </div>
                <div class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-tooltip-state-proof="focus">
                    <p class="mb-3 text-sm font-semibold" style="color: var(--ui-text-primary);">Keyboard focus</p>
                    <x-ui.tooltip text="Focus keeps the tooltip associated through aria-describedby." placement="top" open>
                        <x-ui.button semantic="tertiary" size="sm" class="is-focus">Focused trigger</x-ui.button>
                    </x-ui.tooltip>
                </div>
                <div class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-tooltip-state-proof="disabled-wrapper">
                    <p class="mb-3 text-sm font-semibold" style="color: var(--ui-text-primary);">Disabled-control explanation</p>
                    <x-ui.tooltip text="You need admin access to delete this workspace." placement="top" size="multi" open>
                        <span tabindex="0">
                            <x-ui.button semantic="danger" size="sm" disabled>Delete workspace</x-ui.button>
                        </span>
                    </x-ui.tooltip>
                </div>
            </div>
        </article>
    </section>

    <section class="grid gap-4 xl:grid-cols-2">
        <article class="min-w-0 rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tooltip-live-section="content">
            <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Content</h3>
            <div class="mt-4 overflow-x-auto rounded-lg border" style="border-color: var(--ui-border-subtle-01);">
                <table class="min-w-full text-left text-sm">
                    <thead style="background-color: var(--ui-layer-accent-01); color: var(--ui-text-secondary);">
                        <tr>
                            <th class="px-4 py-3">Context</th>
                            <th class="px-4 py-3">Tooltip copy</th>
                            <th class="px-4 py-3">Rule</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contentRows as [$context, $copy, $rule])
                            <tr class="border-t" style="border-color: var(--ui-border-subtle-01);" data-tooltip-content-row="{{ Str::slug($context) }}">
                                <td class="px-4 py-3 font-semibold" style="color: var(--ui-text-primary);">{{ $context }}</td>
                                <td class="px-4 py-3" style="color: var(--ui-text-secondary);">{{ $copy }}</td>
                                <td class="px-4 py-3" style="color: var(--ui-text-secondary);">{{ $rule }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </article>

        <article class="min-w-0 rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-tooltip-live-section="related-overlays">
            <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Related overlays</h3>
            <dl class="mt-4 grid gap-3 text-sm">
                @foreach ($boundaryRows as [$label, $rule])
                    <div class="rounded-md border p-3" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-tooltip-boundary-row="{{ Str::slug($label) }}">
                        <dt class="font-semibold" style="color: var(--ui-text-primary);">{{ $label }}</dt>
                        <dd class="mt-1 leading-6" style="color: var(--ui-text-secondary);">{{ $rule }}</dd>
                    </div>
                @endforeach
            </dl>
        </article>
    </section>
</div>
