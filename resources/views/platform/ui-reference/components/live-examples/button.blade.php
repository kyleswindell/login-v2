@php
    $variantRows = [
        ['Primary', 'Principal call to action. Use once per screen except app header, modal, side panel, or a temporary focused flow.', '<x-ui.button semantic="primary">Save changes</x-ui.button>'],
        ['Secondary', 'Negative paired action with a primary button, such as Cancel or Back. Do not use alone or for a positive action.', '<x-ui.button semantic="secondary">Cancel</x-ui.button>'],
        ['Tertiary', 'Lower-prominence action that can stand alone, support a primary action, or serve a sub-task.', '<x-ui.button semantic="tertiary">Export report</x-ui.button>'],
        ['Ghost', 'Least-pronounced supplementary action. Use with primary/secondary actions, flush cards, or side panels.', '<x-ui.button semantic="ghost">View details</x-ui.button>'],
        ['Danger primary', 'Destructive primary step when deletion or removal is the required decision.', '<x-ui.button semantic="danger">Delete tenant</x-ui.button>'],
        ['Danger tertiary', 'Lower-emphasis destructive action among several available actions.', '<x-ui.button semantic="danger-tertiary">Remove access</x-ui.button>'],
        ['Danger ghost', 'Least-prominent destructive action when the destructive option must remain available but not dominant.', '<x-ui.button semantic="danger-ghost">Delete draft</x-ui.button>'],
    ];

    $sizeRows = [
        ['Extra small', '24px / 1.5rem', 'Confined layout or dense utility area.', 'xs', null],
        ['Small', '32px / 2rem', 'Pairs with 32px small controls.', 'sm', null],
        ['Medium', '40px / 2.5rem', 'Pairs with 40px medium controls.', 'md', null],
        ['Large productive', '48px / 3rem', 'Common software product size.', 'lg', null],
        ['Large expressive', '48px / 3rem', 'Expressive type treatment for non-dense/editorial contexts only.', 'lg-expressive', null],
        ['Extra large', '64px / 4rem', 'Full-bleed inside large components such as modals or side panels.', 'xl', 'w-full justify-start'],
        ['2XL', '80px / 5rem', 'Full-screen or large-surface contexts only.', '2xl', 'w-full justify-start'],
    ];

    $stateRows = [
        ['Default', '<x-ui.button semantic="primary">Save changes</x-ui.button>'],
        ['Hover', '<x-ui.button semantic="primary" class="is-hover">Save changes</x-ui.button>'],
        ['Focus-visible', '<x-ui.button semantic="primary" class="is-focus">Save changes</x-ui.button>'],
        ['Active', '<x-ui.button semantic="primary" class="is-active">Save changes</x-ui.button>'],
        ['Disabled', '<x-ui.button semantic="primary" disabled>Save changes</x-ui.button>'],
        ['Loading', '<x-ui.button semantic="primary" loading>Saving changes</x-ui.button>'],
        ['Danger hover', '<x-ui.button semantic="danger" class="is-hover">Delete tenant</x-ui.button>'],
    ];

    $groupRows = [
        ['2 buttons with primary', 'Primary + secondary, primary + tertiary, primary + ghost, primary + danger tertiary, danger primary + secondary, danger primary + ghost.'],
        ['3 buttons with primary', 'Primary + secondary + tertiary, primary + secondary + ghost, primary + two secondary, primary + two tertiary, primary + tertiary + danger tertiary.'],
        ['No-primary groups', 'Two tertiary, tertiary + ghost, two ghost, three tertiary, or two tertiary + one danger tertiary.'],
        ['More than 3 actions', 'Move actions into Menu buttons or Toolbar instead of expanding a button group.'],
    ];

    $iconStateRows = [
        ['Default', 'Refresh data', 'heroicon-o-arrow-path', 'ghost', null, false, false],
        ['Hover', 'Refresh data hover', 'heroicon-o-arrow-path', 'ghost', 'is-hover', false, false],
        ['Focus-visible', 'Refresh data focus', 'heroicon-o-arrow-path', 'ghost', 'is-focus', false, false],
        ['Pressed', 'Refresh data pressed', 'heroicon-o-arrow-path', 'ghost', 'is-active', false, false],
        ['Disabled', 'Refresh data disabled', 'heroicon-o-arrow-path', 'ghost', null, true, false],
        ['Loading', 'Refresh data loading', 'heroicon-o-arrow-path', 'ghost', null, false, true],
    ];

    $tokenRows = [
        ['Primary', '$button-primary / hover / active', '--ui-action-primary-bg / -hover / -active', 'Button-owned action color family.'],
        ['Secondary', '$button-secondary / hover / active', '--ui-action-secondary-bg / -hover / -active', 'Light: Gray 80 #393939, Gray 80 hover #4c4c4c, Gray 60 active #6f6f6f. Dark uses the corresponding lighter gray secondary family.'],
        ['Tertiary', '$button-tertiary / hover / active', '--ui-action-tertiary-bg / -hover / -active', 'Transparent default with token-backed border/text and filled interaction states.'],
        ['Ghost', '$background-hover + $link-primary roles', '--ui-action-ghost-*', 'Transparent low-emphasis trigger with token-backed hover and active treatment.'],
        ['Danger', '$button-danger-primary / hover / active + $button-danger-secondary', '--ui-action-danger-*', 'Destructive button hierarchy only.'],
        ['Disabled', '$button-disabled + $text-on-color-disabled', '--ui-action-disabled-*', 'Disabled surface, label, and icon roles.'],
    ];
@endphp

<div class="space-y-6" data-component-live-layout="button-matrix">
    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-button-live-section="variant-purpose-matrix">
        <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
            <div>
                <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Variant purpose matrix</h3>
                <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Each Button variant signals a different action hierarchy. Use the variant for its role, not for decoration.</p>
            </div>
            <span class="inline-flex w-fit items-center rounded-full border px-2.5 py-1 text-xs font-semibold" style="border-color: var(--ui-border-subtle-01); color: var(--ui-text-secondary);">Flexible live-example layout</span>
        </div>
        <div class="mt-4 overflow-x-auto rounded-lg border" style="border-color: var(--ui-border-subtle-01);">
            <table class="min-w-full text-left text-sm">
                <thead style="background-color: var(--ui-layer-accent-01); color: var(--ui-text-secondary);">
                    <tr>
                        <th class="px-4 py-3">Variant</th>
                        <th class="px-4 py-3">Purpose</th>
                        <th class="px-4 py-3">Rendered example</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($variantRows as [$label, $purpose, $example])
                        <tr class="border-t" style="border-color: var(--ui-border-subtle-01);" data-button-variant-row="{{ Str::slug($label) }}">
                            <td class="px-4 py-3 font-semibold" style="color: var(--ui-text-primary);">{{ $label }}</td>
                            <td class="max-w-xl px-4 py-3 leading-6" style="color: var(--ui-text-secondary);">{{ $purpose }}</td>
                            <td class="px-4 py-3">{!! Blade::render($example) !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-button-live-section="size-scale">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Size scale</h3>
        <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Do not mix button sizes in button groups. Existing API support covers the current app sizes; larger full-bleed rows document the target treatment for later API completion.</p>
        <div class="mt-4 grid gap-3">
            @foreach ($sizeRows as [$label, $height, $purpose, $size, $extraClass])
                <div class="grid gap-3 rounded-md border p-3 md:grid-cols-[11rem_9rem_minmax(0,1fr)_minmax(14rem,0.7fr)] md:items-center" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-button-size-row="{{ Str::slug($label) }}">
                    <p class="font-semibold" style="color: var(--ui-text-primary);">{{ $label }}</p>
                    <p class="text-sm" style="color: var(--ui-text-helper);">{{ $height }}</p>
                    <p class="text-sm leading-6" style="color: var(--ui-text-secondary);">{{ $purpose }}</p>
                    <x-ui.button semantic="primary" :size="$size" @class([$extraClass => filled($extraClass)])>{{ $label }}</x-ui.button>
                </div>
            @endforeach
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-button-live-section="state-matrix">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">State matrix</h3>
        <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">States use app action tokens for container, label, icon, focus, active, disabled, loading, and danger behavior.</p>
        <div class="mt-4 grid gap-3 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($stateRows as [$label, $example])
                <article class="rounded-md border p-3" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-button-state-row="{{ Str::slug($label) }}">
                    <p class="mb-3 text-sm font-semibold" style="color: var(--ui-text-primary);">{{ $label }}</p>
                    {!! Blade::render($example) !!}
                </article>
            @endforeach
        </div>
    </section>

    <section class="grid gap-4 xl:grid-cols-2">
        <article class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-button-live-section="button-groups">
            <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Button groups</h3>
            <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Use groups when there are two or three actions to consider. More than three actions belong in Menu buttons or Toolbar.</p>
            <div class="mt-4 space-y-4">
                <div class="flex flex-wrap gap-3" data-button-group-example="primary-secondary">
                    <x-ui.button semantic="primary">Save changes</x-ui.button>
                    <x-ui.button semantic="secondary">Cancel</x-ui.button>
                </div>
                <div class="flex flex-wrap gap-3" data-button-group-example="primary-secondary-tertiary">
                    <x-ui.button semantic="primary">Continue</x-ui.button>
                    <x-ui.button semantic="secondary">Back</x-ui.button>
                    <x-ui.button semantic="tertiary">Save draft</x-ui.button>
                </div>
                <div class="flex flex-wrap gap-3" data-button-group-example="no-primary">
                    <x-ui.button semantic="tertiary">Filter table</x-ui.button>
                    <x-ui.button semantic="ghost">Clear filters</x-ui.button>
                </div>
                <ul class="space-y-2 text-sm leading-6" style="color: var(--ui-text-secondary);">
                    @foreach ($groupRows as [$label, $purpose])
                        <li><strong style="color: var(--ui-text-primary);">{{ $label }}:</strong> {{ $purpose }}</li>
                    @endforeach
                </ul>
            </div>
        </article>

        <article class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-button-live-section="icon-usage">
            <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Icon usage</h3>
            <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Icons support recognizable actions. Button icons appear to the right of the label; icon-only buttons require a tooltip and accessible name.</p>
            <div class="mt-4 flex flex-wrap items-center gap-3">
                <x-ui.button semantic="primary" icon="heroicon-o-arrow-down-tray">Download report</x-ui.button>
                <x-ui.button semantic="ghost" icon="heroicon-o-arrow-top-right-on-square">Open docs</x-ui.button>
            </div>
            <div class="mt-4 grid gap-3 sm:grid-cols-2 xl:grid-cols-3" data-button-icon-state-matrix>
                @foreach ($iconStateRows as [$label, $accessibleLabel, $icon, $semantic, $stateClass, $disabled, $loading])
                    <div class="rounded-md border p-3" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-button-icon-state-row="{{ Str::slug($label) }}">
                        <p class="mb-3 text-sm font-semibold" style="color: var(--ui-text-primary);">Icon-only {{ $label }}</p>
                        <span class="inline-flex items-center gap-2">
                            <x-ui.icon-button
                                :icon="$icon"
                                :label="$accessibleLabel"
                                :semantic="$semantic"
                                :disabled="$disabled"
                                :loading="$loading"
                                @class([$stateClass => filled($stateClass)])
                            />
                            @if ($label === 'Hover')
                                <span class="rounded-md px-2 py-1 text-xs" style="background-color: var(--ui-layer-inverse); color: var(--ui-text-inverse);">Refresh data</span>
                            @endif
                        </span>
                    </div>
                @endforeach
                <div class="rounded-md border p-3" style="border-color: var(--ui-support-error); background-color: var(--ui-layer-02);" data-button-icon-state-row="danger-prohibited">
                    <p class="text-sm font-semibold" style="color: var(--ui-text-primary);">Icon-only danger prohibited</p>
                    <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Do not use danger icon-only buttons for destructive actions. Use a labeled danger button so the destructive consequence is visible in text.</p>
                    <div class="mt-3">
                        <x-ui.button semantic="danger">Delete tenant</x-ui.button>
                    </div>
                </div>
            </div>
            <ul class="mt-4 space-y-2 text-sm leading-6" style="color: var(--ui-text-secondary);">
                <li>Use 16px icons inside most buttons; reserve 20px icons for expressive large buttons.</li>
                <li>Icon color must match the label color unless a semantic status requires otherwise.</li>
                <li data-button-rule="no-danger-icon-only">Danger icon-only is not allowed for destructive actions; use a visible label.</li>
            </ul>
        </article>
    </section>

    <section class="grid gap-4 xl:grid-cols-2">
        <article class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-button-live-section="content-behavior">
            <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Content behavior</h3>
            <ul class="mt-3 space-y-2 text-sm leading-6" style="color: var(--ui-text-secondary);">
                <li data-button-content-rule="verb-noun">Prefer verb + noun labels such as Save changes, Create workspace, or Delete tenant.</li>
                <li data-button-content-rule="sentence-case">Use sentence case for all button labels.</li>
                <li data-button-content-rule="left-align">Labels remain left-aligned when the button is wide.</li>
                <li data-button-content-rule="rtl">RTL mirrors the button horizontally and right-aligns the label.</li>
                <li data-button-content-rule="wrap-not-truncate">Long button labels wrap to a second line instead of truncating.</li>
            </ul>
            <div class="mt-4 grid gap-3">
                <x-ui.button semantic="primary" class="w-full justify-start">Create workspace</x-ui.button>
                <x-ui.button semantic="tertiary" class="w-56 justify-start whitespace-normal text-left">Send security review request</x-ui.button>
            </div>
        </article>

        <article class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-button-live-section="token-style-roles">
            <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Token and style roles</h3>
            <dl class="mt-3 grid gap-3 text-sm">
                <div>
                    <dt class="font-semibold" style="color: var(--ui-text-primary);">Container</dt>
                    <dd style="color: var(--ui-text-secondary);">Uses action background, border, hover, active, disabled, danger, and focus tokens.</dd>
                </div>
                <div>
                    <dt class="font-semibold" style="color: var(--ui-text-primary);">Label and icon</dt>
                    <dd style="color: var(--ui-text-secondary);">Use paired action text/icon tokens. Do not hard-code icon color apart from the label.</dd>
                </div>
                <div>
                    <dt class="font-semibold" style="color: var(--ui-text-primary);">Spacing</dt>
                    <dd style="color: var(--ui-text-secondary);">Buttons own internal padding; parent layouts own external gaps and grouping.</dd>
                </div>
            </dl>
            <div class="mt-4 overflow-x-auto rounded-lg border" style="border-color: var(--ui-border-subtle-01);" data-button-token-contract="carbon-button-colors">
                <table class="min-w-full text-left text-xs">
                    <thead style="background-color: var(--ui-layer-accent-01); color: var(--ui-text-secondary);">
                        <tr>
                            <th class="px-3 py-2">Role</th>
                            <th class="px-3 py-2">Carbon token coverage</th>
                            <th class="px-3 py-2">Login token owner</th>
                            <th class="px-3 py-2">Alignment rule</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tokenRows as [$role, $carbon, $login, $rule])
                            <tr class="border-t" style="border-color: var(--ui-border-subtle-01);" data-button-token-row="{{ Str::slug($role) }}">
                                <td class="px-3 py-2 font-semibold" style="color: var(--ui-text-primary);">{{ $role }}</td>
                                <td class="px-3 py-2 font-mono" style="color: var(--ui-text-secondary);">{{ $carbon }}</td>
                                <td class="px-3 py-2 font-mono" style="color: var(--ui-text-secondary);">{{ $login }}</td>
                                <td class="px-3 py-2 leading-5" style="color: var(--ui-text-secondary);">{{ $rule }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <x-ui.code-snippet class="mt-4" language="Blade" copyable><span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.button</span> <span class="ui-code-token-property">semantic</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"primary"</span> <span class="ui-code-token-property">size</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"lg"</span><span class="ui-code-token-punctuation">&gt;</span>Save changes<span class="ui-code-token-punctuation">&lt;/</span><span class="ui-code-token-keyword">x-ui.button</span><span class="ui-code-token-punctuation">&gt;</span></x-ui.code-snippet>
        </article>
    </section>
</div>
