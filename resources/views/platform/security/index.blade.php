@php
    $groupItems = collect([['value' => '', 'label' => 'Any group']])
        ->merge($groups->map(fn ($group): array => ['value' => $group->slug, 'label' => $group->title]))
        ->all();

    $alignmentItems = collect([['value' => '', 'label' => 'Any alignment']])
        ->merge(collect($alignmentStatuses)->map(fn ($label, $value): array => ['value' => $value, 'label' => $label])->values())
        ->all();

    $workItems = collect([['value' => '', 'label' => 'Any work status']])
        ->merge(collect($workStatuses)->map(fn ($label, $value): array => ['value' => $value, 'label' => $label])->values())
        ->all();

    $priorityItems = collect([['value' => '', 'label' => 'Any priority']])
        ->merge(collect($priorities)->map(fn ($label, $value): array => ['value' => $value, 'label' => $label])->values())
        ->all();

    $familyItems = collect([['value' => '', 'label' => 'Any family']])
        ->merge(collect($asvsFamilies)->map(fn ($family): array => ['value' => $family, 'label' => $family])->values())
        ->all();

    $lastUpdatedLabel = $lastUpdatedAt
        ? 'Updated '.$lastUpdatedAt->format('M j, Y g:i A')
        : 'Not reviewed yet';
@endphp

<x-layouts.app title="Security Checklist">
    <section class="flex flex-1 flex-col gap-6">
        <x-patterns.page-title-actions-row
            title="Security Checklist"
            description="Track ASVS readiness, security requirements, current alignment, and remaining implementation gaps."
        >
            <x-slot:actions>
                <x-ui.button
                    :href="route('platform.docs.index', ['path' => 'docs/02-standards/security/OWASP ASVS Level 2 Baseline.md'])"
                    semantic="ghost"
                    wire:navigate
                >
                    ASVS baseline
                </x-ui.button>
            </x-slot:actions>
        </x-patterns.page-title-actions-row>

        @if (session('status'))
            <x-ui.notification.inline kind="success" title="Security checklist updated">
                {{ session('status') }}
            </x-ui.notification.inline>
        @endif

        <div class="grid gap-4 md:grid-cols-5">
            @foreach ($alignmentStatuses as $status => $label)
                <x-patterns.stat-card
                    :label="$label"
                    :value="$summaryCounts[$status] ?? 0"
                />
            @endforeach
        </div>

        <x-patterns.content-section-block
            title="High-risk open items"
            description="Critical and high-priority controls still marked partial or lacking."
        >
            <x-slot:headerActions>
                <x-ui.tag :label="$lastUpdatedLabel" tone="info" size="sm" />
            </x-slot:headerActions>

            @if ($highRiskGaps->isEmpty())
                <x-patterns.empty-state
                    title="No high-risk gaps"
                    description="No high-risk partial or lacking controls are currently tracked."
                    icon="checkmark--filled"
                />
            @else
                <x-ui.contained-list aria-label="High-risk open security requirements" inset-dividers>
                    @foreach ($highRiskGaps as $gap)
                        <x-ui.contained-list-item
                            :href="route('platform.security.show', ['requirement' => $gap->slug])"
                            :title="$gap->title"
                            :description="$gap->group?->title"
                            :meta="$gap->priorityLabel().' / '.$gap->alignmentLabel()"
                            status="warning"
                            wire:navigate
                        />
                    @endforeach
                </x-ui.contained-list>
            @endif
        </x-patterns.content-section-block>

        <x-patterns.content-section-block
            title="Filters"
            description="Narrow the checklist by group, ASVS family, priority, and current readiness state."
        >
            <form method="GET" action="{{ route('platform.security.index') }}">
                <x-patterns.search-filter-bar>
                    <x-ui.select
                        name="group"
                        label="Group"
                        :items="$groupItems"
                        :value="$filters['group']"
                    />

                    <x-ui.select
                        name="alignment_status"
                        label="Alignment"
                        :items="$alignmentItems"
                        :value="$filters['alignment_status']"
                    />

                    <x-ui.select
                        name="work_status"
                        label="Work"
                        :items="$workItems"
                        :value="$filters['work_status']"
                    />

                    <x-ui.select
                        name="priority"
                        label="Priority"
                        :items="$priorityItems"
                        :value="$filters['priority']"
                    />

                    <x-ui.select
                        name="asvs_family"
                        label="ASVS family"
                        :items="$familyItems"
                        :value="$filters['asvs_family']"
                    />

                    <x-slot:actions>
                        <x-ui.button type="submit" semantic="primary">
                            Apply filters
                        </x-ui.button>
                        <x-ui.button :href="route('platform.security.index')" semantic="ghost" wire:navigate>
                            Reset
                        </x-ui.button>
                    </x-slot:actions>
                </x-patterns.search-filter-bar>
            </form>
        </x-patterns.content-section-block>

        <x-ui.data-table.container
            title="Security requirements"
            description="Grouped security controls seeded from canonical ASVS and security readiness follow-ups."
            title-id="security-requirements-title"
            description-id="security-requirements-description"
        >
            <x-ui.data-table.table
                size="md"
                aria-labelledby="security-requirements-title"
                aria-describedby="security-requirements-description"
            >
                <x-ui.data-table.head>
                    <tr>
                        <x-ui.data-table.header>Requirement</x-ui.data-table.header>
                        <x-ui.data-table.header>ASVS</x-ui.data-table.header>
                        <x-ui.data-table.header>Alignment</x-ui.data-table.header>
                        <x-ui.data-table.header>Work</x-ui.data-table.header>
                        <x-ui.data-table.header>Owner</x-ui.data-table.header>
                        <x-ui.data-table.header>Reviewed</x-ui.data-table.header>
                        <x-ui.data-table.header align="end">Actions</x-ui.data-table.header>
                    </tr>
                </x-ui.data-table.head>

                <x-ui.data-table.body>
                    @forelse ($requirements as $requirement)
                        <x-ui.data-table.row>
                            <x-ui.data-table.cell>
                                <div class="grid gap-2">
                                    <strong>{{ $requirement->title }}</strong>
                                    <span>{{ $requirement->group?->title }}</span>
                                    <span>{{ $requirement->summary }}</span>
                                    <span>
                                        <x-ui.tag
                                            :label="$requirement->priorityLabel()"
                                            :tone="match ($requirement->priority) {
                                                'critical', 'high' => 'danger',
                                                'medium' => 'warning',
                                                'low' => 'success',
                                                default => 'neutral',
                                            }"
                                            size="sm"
                                        />
                                    </span>
                                </div>
                            </x-ui.data-table.cell>

                            <x-ui.data-table.cell>
                                <div class="flex flex-wrap gap-2">
                                    @forelse (($requirement->asvs_refs ?? []) as $ref)
                                        <x-ui.tag :label="$ref" type="outline" size="sm" />
                                    @empty
                                        <x-ui.tag label="Unmapped" type="outline" size="sm" />
                                    @endforelse
                                </div>
                            </x-ui.data-table.cell>

                            <x-ui.data-table.cell>
                                <x-ui.tag
                                    :label="$requirement->alignmentLabel()"
                                    :tone="match ($requirement->alignmentBadgeStatus()) {
                                        'compliant' => 'success',
                                        'under review' => 'notice',
                                        'non-compliant' => 'danger',
                                        'warning' => 'warning',
                                        default => 'neutral',
                                    }"
                                    size="sm"
                                />
                            </x-ui.data-table.cell>

                            <x-ui.data-table.cell>
                                <x-ui.tag
                                    :label="$requirement->workStatusLabel()"
                                    :tone="match ($requirement->workBadgeStatus()) {
                                        'approved' => 'success',
                                        'in progress', 'pending review', 'ready' => 'notice',
                                        'archived', 'draft' => 'neutral',
                                        default => 'neutral',
                                    }"
                                    size="sm"
                                />
                            </x-ui.data-table.cell>

                            <x-ui.data-table.cell>
                                {{ $requirement->owner?->name ?? 'Unassigned' }}
                            </x-ui.data-table.cell>

                            <x-ui.data-table.cell>
                                {{ $requirement->last_reviewed_at?->format('M j, Y') ?? 'Not reviewed' }}
                            </x-ui.data-table.cell>

                            <x-ui.data-table.cell align="end">
                                <x-ui.button
                                    :href="route('platform.security.show', ['requirement' => $requirement->slug])"
                                    semantic="primary"
                                    size="sm"
                                    wire:navigate
                                >
                                    View
                                </x-ui.button>
                            </x-ui.data-table.cell>
                        </x-ui.data-table.row>
                    @empty
                        <x-ui.data-table.row>
                            <x-ui.data-table.cell :colspan="7">
                                <x-patterns.empty-state
                                    title="No matching requirements"
                                    description="No security requirements match the current filters."
                                />
                            </x-ui.data-table.cell>
                        </x-ui.data-table.row>
                    @endforelse
                </x-ui.data-table.body>
            </x-ui.data-table.table>
        </x-ui.data-table.container>
    </section>
</x-layouts.app>
