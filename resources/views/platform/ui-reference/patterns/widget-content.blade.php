<x-layouts.app title="UI Reference - Widget Content Standards">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'patterns.widget-content'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <x-ui.patterns.page-title-actions-row
            title="Widget Content Standards"
            description="Size-aware dashboard widget content allowances built from calibrated grid geometry, realistic fill levels, and constrained viewport review."
            kicker="Dashboard widgets"
        >
            <x-slot:actions>
                <x-ui.button :href="route('platform.ui-reference.patterns.layout')" variant="outline">Back to dashboard demo</x-ui.button>
                <x-ui.button :href="route('dashboard')" semantic="primary">Compare live dashboard</x-ui.button>
            </x-slot:actions>
        </x-ui.patterns.page-title-actions-row>

        <x-ui.patterns.proof-review-banner
            :items="[
                ['id' => 'P2-B-CQ-023', 'note' => 'Review the rebuilt widget content standards proof for calibrated geometry and realistic per-size content density.'],
            ]"
            :focus="[
                'Confirm the four-unit desktop model, 18rem one-row baseline, and filled examples make each supported widget size usable without clipping, internal scrolling, or excessive unused space.',
            ]"
        />

        <x-ui.patterns.content-section-block
            title="Geometry decision"
            description="This standards page uses a four-unit desktop proof model before content examples are judged. The prior three-unit proof made small cards too wide and encouraged sparse placeholder content."
            kicker="Grid calibration"
            data-widget-geometry-decision
        >
            <div class="grid gap-4 lg:grid-cols-4">
                <div class="ui-card">
                    <p class="ui-kicker">Selected model</p>
                    <h3 class="ui-card-title mt-3">Four-unit dashboard model</h3>
                    <p class="ui-card-copy">At desktop review widths, `1x` is one quarter, `2x` is half width, and `3x` is three quarters of the widget row.</p>
                </div>
                <div class="ui-card">
                    <p class="ui-kicker">Row height</p>
                    <h3 class="ui-card-title mt-3">18rem one-row baseline</h3>
                    <p class="ui-card-copy">One-row widgets must prove content density inside an 18rem track. Two-row widgets reserve exactly two 18rem tracks plus the grid gap.</p>
                </div>
                <div class="ui-card">
                    <p class="ui-kicker">Full-row handling</p>
                    <h3 class="ui-card-title mt-3">No implicit 3x full row</h3>
                    <p class="ui-card-copy">Full-row widgets need a future explicit `4x` contract or a page-specific dashboard composition, not a silent reinterpretation of `3x`.</p>
                </div>
                <div class="ui-card">
                    <p class="ui-kicker">Proof scope</p>
                    <h3 class="ui-card-title mt-3">Shared standards only</h3>
                    <p class="ui-card-copy">The Layout + Dashboard customization proof keeps its approved 24rem row-height proof so `x2` span behavior remains visibly obvious.</p>
                </div>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Viewport review baseline"
            description="Approve these content allowances only after checking the examples at constrained office-monitor widths and the larger reference monitor width."
            kicker="Review widths"
            data-widget-viewport-baseline
        >
            <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-5">
                @foreach (['1024', '1280', '1366', '1440', '1920'] as $width)
                    <div class="ui-pattern-widget-shell-section">
                        <p class="ui-pattern-key-value-label">{{ $width }}px</p>
                        <p class="ui-card-copy mt-2">No clipping, crowding, hidden controls, or internal scroll.</p>
                    </div>
                @endforeach
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Filled widget size examples"
            description="Each example uses neutral widget styling and intentionally realistic content. Semantic color remains reserved for alerts, notices, and status states."
            kicker="Content allowances"
            data-widget-content-standards
        >
            <x-ui.patterns.dashboard-grid columns="widgets" data-widget-content-size-grid>
                <x-ui.patterns.widget-shell
                    title="1x1 Summary"
                    description="One compact scan target."
                    kicker="Allowance 1x1"
                    span="1x1"
                    data-widget-content-size="1x1"
                >
                    <div class="flex items-end justify-between gap-3">
                        <div>
                            <p class="ui-pattern-key-value-label">SLA health</p>
                            <p class="ui-stat-value">84%</p>
                        </div>
                        <span class="rounded-full border px-3 py-1 text-xs font-semibold" style="border-color: var(--ui-border-default); color: var(--ui-text-secondary);">+6%</span>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center justify-between gap-3">
                            <span class="truncate text-[color:var(--ui-text-muted)]">Queue age</span>
                            <strong class="shrink-0 text-[color:var(--ui-text-strong)]">18m</strong>
                        </div>
                        <div class="flex items-center justify-between gap-3">
                            <span class="truncate text-[color:var(--ui-text-muted)]">Blocked deploys</span>
                            <strong class="shrink-0 text-[color:var(--ui-text-strong)]">0</strong>
                        </div>
                    </div>
                    <p class="ui-card-copy">Fits title, one metric, one status chip, and two compact support rows.</p>
                </x-ui.patterns.widget-shell>

                <x-ui.patterns.widget-shell
                    title="2x1 Wide Summary"
                    description="Two to three related summary signals."
                    kicker="Allowance 2x1"
                    span="2x1"
                    data-widget-content-size="2x1"
                >
                    <div class="grid gap-3 sm:grid-cols-3">
                        <div>
                            <p class="ui-pattern-key-value-label">Open</p>
                            <p class="ui-stat-value">12</p>
                            <p class="ui-card-copy">reviews</p>
                        </div>
                        <div>
                            <p class="ui-pattern-key-value-label">Escalated</p>
                            <p class="ui-stat-value">2</p>
                            <p class="ui-card-copy">owner needed</p>
                        </div>
                        <div>
                            <p class="ui-pattern-key-value-label">Median</p>
                            <p class="ui-stat-value">31m</p>
                            <p class="ui-card-copy">age stable</p>
                        </div>
                    </div>
                    <div class="grid gap-2 text-sm sm:grid-cols-2">
                        <div class="rounded-md border px-3 py-2" style="border-color: var(--ui-border-subtle);">4 awaiting design sign-off</div>
                        <div class="rounded-md border px-3 py-2" style="border-color: var(--ui-border-subtle);">2 need escalation review</div>
                    </div>
                </x-ui.patterns.widget-shell>

                <x-ui.patterns.widget-shell
                    title="1x2 Tall List"
                    description="Narrow vertical list or activity feed."
                    kicker="Allowance 1x2"
                    span="1x2"
                    data-widget-content-size="1x2"
                >
                    <div class="space-y-3">
                        @foreach ([
                            ['09:10', 'Lock widget shell contract'],
                            ['09:24', 'Recheck overlay publication'],
                            ['09:41', 'Publish menu-item re-review'],
                            ['10:05', 'Confirm form pattern owner'],
                            ['10:33', 'Assign dashboard density pass'],
                            ['10:58', 'Close stale review cue'],
                        ] as [$time, $label])
                            <div class="flex gap-3 rounded-md border p-3 text-sm" style="border-color: var(--ui-border-subtle);">
                                <span class="shrink-0 font-semibold text-[color:var(--ui-text-secondary)]">{{ $time }}</span>
                                <span class="min-w-0 text-[color:var(--ui-text-strong)]">{{ $label }}</span>
                            </div>
                        @endforeach
                    </div>
                    <p class="ui-card-copy">Fits 4-6 compact same-topic rows. Escalate if each row needs actions, filters, or long copy.</p>
                </x-ui.patterns.widget-shell>

                <x-ui.patterns.widget-shell
                    title="2x2 Detail"
                    description="Primary metric plus same-topic detail."
                    kicker="Allowance 2x2"
                    span="2x2"
                    data-widget-content-size="2x2"
                >
                    <div class="grid gap-3 sm:grid-cols-3">
                        <div>
                            <p class="ui-pattern-key-value-label">Unread</p>
                            <p class="ui-stat-value">7</p>
                            <p class="ui-card-copy">notifications</p>
                        </div>
                        <div>
                            <p class="ui-pattern-key-value-label">Routed</p>
                            <p class="ui-stat-value">3</p>
                            <p class="ui-card-copy">to operations</p>
                        </div>
                        <div>
                            <p class="ui-pattern-key-value-label">Pinned</p>
                            <p class="ui-stat-value">1</p>
                            <p class="ui-card-copy">manual review</p>
                        </div>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="rounded-md border p-3" style="border-color: var(--ui-border-subtle);">
                            <p class="ui-pattern-key-value-label">Detail body</p>
                            <p class="ui-card-copy mt-2">A two-row detail widget can carry one short explanatory paragraph tied to the primary metric.</p>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="rounded-md border px-3 py-2" style="border-color: var(--ui-border-subtle);">Oldest alert: 18m</div>
                            <div class="rounded-md border px-3 py-2" style="border-color: var(--ui-border-subtle);">3 routed to operations</div>
                            <div class="rounded-md border px-3 py-2" style="border-color: var(--ui-border-subtle);">1 pinned for manual review</div>
                        </div>
                    </div>
                </x-ui.patterns.widget-shell>

                <x-ui.patterns.widget-shell
                    title="3x1 Wide Summary"
                    description="Three-quarter row summary in the four-unit model."
                    kicker="Allowance 3x1"
                    span="3x1"
                    data-widget-content-size="3x1"
                >
                    <div class="grid gap-3 sm:grid-cols-4">
                        <div>
                            <p class="ui-pattern-key-value-label">Ready</p>
                            <p class="ui-stat-value">18</p>
                            <p class="ui-card-copy">deploys</p>
                        </div>
                        <div>
                            <p class="ui-pattern-key-value-label">Held</p>
                            <p class="ui-stat-value">3</p>
                            <p class="ui-card-copy">owner review</p>
                        </div>
                        <div>
                            <p class="ui-pattern-key-value-label">Risk</p>
                            <p class="ui-stat-value">1</p>
                            <p class="ui-card-copy">rollback note</p>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="rounded-md border px-3 py-2" style="border-color: var(--ui-border-subtle);">Staging owner assigned</div>
                            <div class="rounded-md border px-3 py-2" style="border-color: var(--ui-border-subtle);">Production hold active</div>
                        </div>
                    </div>
                    <p class="ui-card-copy">Fits one horizontal same-topic summary. It is not a full-row contract.</p>
                </x-ui.patterns.widget-shell>

                <x-ui.patterns.widget-shell
                    title="3x2 Rich Summary"
                    description="Largest approved same-topic widget surface in this proof."
                    kicker="Allowance 3x2"
                    span="3x2"
                    data-widget-content-size="3x2"
                >
                    <div class="grid gap-3 sm:grid-cols-4">
                        <div>
                            <p class="ui-pattern-key-value-label">Capacity</p>
                            <p class="ui-stat-value">72%</p>
                            <p class="ui-card-copy">reviewer load</p>
                        </div>
                        <div>
                            <p class="ui-pattern-key-value-label">Open</p>
                            <p class="ui-stat-value">6</p>
                            <p class="ui-card-copy">workstreams</p>
                        </div>
                        <div>
                            <p class="ui-pattern-key-value-label">Oldest</p>
                            <p class="ui-stat-value">41m</p>
                            <p class="ui-card-copy">blocker age</p>
                        </div>
                        <div>
                            <p class="ui-pattern-key-value-label">Owner SLA</p>
                            <p class="ui-stat-value">92%</p>
                            <p class="ui-card-copy">on target</p>
                        </div>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-[1.2fr_0.8fr]">
                        <div class="rounded-md border p-3" style="border-color: var(--ui-border-subtle);">
                            <p class="ui-pattern-key-value-label">Throughput trend</p>
                            <div class="mt-4 grid h-24 grid-cols-7 items-end gap-2">
                                @foreach ([36, 58, 44, 71, 63, 82, 76] as $height)
                                    <span class="rounded-t" style="height: {{ $height }}%; background-color: color-mix(in srgb, var(--ui-text-muted) 34%, transparent);"></span>
                                @endforeach
                            </div>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="rounded-md border px-3 py-2" style="border-color: var(--ui-border-subtle);">6 open workstreams</div>
                            <div class="rounded-md border px-3 py-2" style="border-color: var(--ui-border-subtle);">Oldest blocker: 41m</div>
                            <div class="rounded-md border px-3 py-2" style="border-color: var(--ui-border-subtle);">Two reviewer gaps</div>
                            <div class="rounded-md border px-3 py-2" style="border-color: var(--ui-border-subtle);">No production hold</div>
                        </div>
                    </div>
                    <p class="ui-card-copy">Fits one rich dashboard topic with KPI group, compact visualization, exception list, and one support line.</p>
                </x-ui.patterns.widget-shell>
            </x-ui.patterns.dashboard-grid>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Allowance matrix"
            description="Use this as the future-module starting point. The widget size should be selected by content density, not by stretching a sparse card."
            kicker="Fits, stretch, escalate"
            data-widget-allowance-matrix
        >
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="text-xs uppercase tracking-[0.18em] text-[color:var(--ui-text-secondary)]">
                        <tr>
                            <th class="border-b px-3 py-3" style="border-color: var(--ui-border-subtle);">Size</th>
                            <th class="border-b px-3 py-3" style="border-color: var(--ui-border-subtle);">Fits</th>
                            <th class="border-b px-3 py-3" style="border-color: var(--ui-border-subtle);">Stretch limit</th>
                            <th class="border-b px-3 py-3" style="border-color: var(--ui-border-subtle);">Escalate when</th>
                        </tr>
                    </thead>
                    <tbody class="align-top text-[color:var(--ui-text-strong)]">
                        @foreach ([
                            ['1x1', 'One metric or status, one chip, two support rows.', 'A third support row only if labels are short.', 'It needs a list, actions, or body copy.'],
                            ['2x1', 'Two or three related metrics plus one compact status strip.', 'One short explanation can replace a metric.', 'It needs stacked detail or independent sections.'],
                            ['1x2', 'Four to six compact timeline/list rows.', 'One short footer note.', 'Rows need controls, long sentences, or side-by-side layout.'],
                            ['2x2', 'Metric group, short body block, and same-topic list.', 'Small compact visualization or exception group.', 'It becomes a workflow, form, or mixed-topic card.'],
                            ['3x1', 'Horizontal same-topic summary across three-quarter width.', 'Four compact columns if labels remain short.', 'It requires full-row ownership or second-row detail.'],
                            ['3x2', 'Rich same-topic summary with KPIs, compact visual, list, and footer.', 'One dense support area if scan target remains clear.', 'It needs tabs, filters, tables, or unrelated subjects.'],
                        ] as [$size, $fits, $stretch, $escalate])
                            <tr>
                                <th class="border-b px-3 py-3 font-semibold" style="border-color: var(--ui-border-subtle);">{{ $size }}</th>
                                <td class="border-b px-3 py-3" style="border-color: var(--ui-border-subtle);">{{ $fits }}</td>
                                <td class="border-b px-3 py-3" style="border-color: var(--ui-border-subtle);">{{ $stretch }}</td>
                                <td class="border-b px-3 py-3" style="border-color: var(--ui-border-subtle);">{{ $escalate }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-ui.patterns.content-section-block>

        <x-ui.patterns.content-section-block
            title="Negative boundary"
            description="A widget should not become a miniature page. When content crosses these boundaries, select a larger approved surface or link to a dedicated page."
            kicker="Escalation rule"
            data-widget-negative-boundary
        >
            <div class="grid gap-4 lg:grid-cols-3">
                <div class="ui-card">
                    <p class="ui-kicker">Do not fit by clipping</p>
                    <h3 class="ui-card-title mt-3">No hidden overflow</h3>
                    <p class="ui-card-copy">If the declared size cuts off content, reduce the content, choose a larger size, or move the workflow out of the widget.</p>
                </div>
                <div class="ui-card">
                    <p class="ui-kicker">Do not fit by scrolling</p>
                    <h3 class="ui-card-title mt-3">No internal scroll baseline</h3>
                    <p class="ui-card-copy">Baseline dashboard widgets must scan without nested scroll regions. Scrolling needs a separate reviewed exception.</p>
                </div>
                <div class="ui-card">
                    <p class="ui-kicker">Do not mix topics</p>
                    <h3 class="ui-card-title mt-3">One dashboard subject</h3>
                    <p class="ui-card-copy">Related metric, body, visual, and list content can coexist. Unrelated subjects should become separate widgets or a page.</p>
                </div>
            </div>
        </x-ui.patterns.content-section-block>
    </section>
</x-layouts.app>
