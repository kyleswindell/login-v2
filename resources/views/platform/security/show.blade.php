@php
    $evidenceLinks = old('evidence_links', $requirement->evidence_links ?? []);
    $evidenceRows = max(3, count($evidenceLinks) + 1);

    $alignmentItems = collect($alignmentStatuses)
        ->map(fn ($label, $value): array => ['value' => $value, 'label' => $label])
        ->values()
        ->all();

    $workItems = collect($workStatuses)
        ->map(fn ($label, $value): array => ['value' => $value, 'label' => $label])
        ->values()
        ->all();

    $ownerItems = collect([['value' => '', 'label' => 'Unassigned']])
        ->merge($users->map(fn ($user): array => [
            'value' => (string) $user->id,
            'label' => $user->name.' ('.$user->email.')',
        ]))
        ->all();

    $contextItems = [
        ['label' => 'ASVS family', 'value' => $requirement->group?->asvs_family ?? 'n/a'],
        ['label' => 'Risk level', 'value' => str_replace('_', ' ', $requirement->group?->risk_level ?? 'n/a')],
        ['label' => 'Priority', 'value' => $requirement->priorityLabel()],
        ['label' => 'Target phase', 'value' => $requirement->target_phase ?: 'Not assigned'],
    ];

    $auditItems = [
        ['label' => 'Last reviewed by', 'value' => $requirement->lastReviewedBy?->name ?? 'n/a'],
        ['label' => 'Updated', 'value' => $requirement->updated_at?->format('M j, Y g:i A') ?? 'n/a'],
        ['label' => 'Slug', 'value' => $requirement->slug],
    ];
@endphp

<x-layouts.app title="Security Requirement">
    <section class="flex flex-1 flex-col gap-6">
        <x-patterns.page-title-actions-row
            :title="$requirement->title"
            :description="$requirement->summary"
            :kicker="$requirement->group?->title"
        >
            <x-slot:actions>
                <x-ui.button :href="route('platform.security.index')" semantic="ghost" wire:navigate>
                    Back to checklist
                </x-ui.button>
            </x-slot:actions>
        </x-patterns.page-title-actions-row>

        @if (session('status'))
            <x-ui.notification.inline kind="success" title="Security requirement updated">
                {{ session('status') }}
            </x-ui.notification.inline>
        @endif

        @if ($errors->any())
            <x-patterns.validation-summary :errors="$errors->all()" />
        @endif

        <div class="grid gap-4 md:grid-cols-4">
            <x-patterns.stat-card
                label="Alignment"
                :value="$requirement->alignmentLabel()"
            />
            <x-patterns.stat-card
                label="Work status"
                :value="$requirement->workStatusLabel()"
            />
            <x-patterns.stat-card
                label="Owner"
                :value="$requirement->owner?->name ?? 'Unassigned'"
            />
            <x-patterns.stat-card
                label="Last reviewed"
                :value="$requirement->last_reviewed_at?->format('M j, Y g:i A') ?? 'Not reviewed'"
            />
        </div>

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_28rem]">
            <div class="space-y-6">
                <x-patterns.content-section-block title="Requirement context">
                    <x-patterns.key-value-display :items="$contextItems" />

                    <div class="mt-6 grid gap-5">
                        <div>
                            <p class="ui-kicker">ASVS references</p>
                            <div class="mt-3 flex flex-wrap gap-2">
                                @forelse (($requirement->asvs_refs ?? []) as $ref)
                                    <x-ui.tag :label="$ref" type="outline" size="sm" />
                                @empty
                                    <x-ui.tag label="Unmapped" type="outline" size="sm" />
                                @endforelse
                            </div>
                        </div>

                        <div>
                            <p class="ui-kicker">Canonical docs</p>
                            <div class="mt-3 flex flex-col gap-2">
                                @forelse (($requirement->canonical_docs ?? []) as $doc)
                                    <x-ui.link
                                        :href="route('platform.docs.index', ['path' => $doc['path'] ?? 'docs/00-start-here.md'])"
                                        :text="$doc['label'] ?? $doc['path'] ?? 'Documentation'"
                                        variant="standalone"
                                        wire:navigate
                                    />
                                @empty
                                            <x-ui.tag label="No canonical docs linked" tone="neutral" size="sm" />
                                @endforelse
                            </div>
                        </div>
                    </div>
                </x-patterns.content-section-block>

                <x-patterns.content-section-block
                    title="Evidence links"
                    description="Safe labels and app paths or URLs attached to this requirement."
                >
                    @if (empty($requirement->evidence_links ?? []))
                        <x-patterns.empty-state
                            title="No evidence links"
                            description="No evidence links have been recorded yet."
                        />
                    @else
                        <x-ui.contained-list aria-label="Evidence links" inset-dividers>
                            @foreach (($requirement->evidence_links ?? []) as $link)
                                @php($href = $link['url'] ?? '#')
                                <x-ui.contained-list-item
                                    :href="$href"
                                    :title="$link['label'] ?? $href"
                                    :description="$href"
                                    icon="link"
                                />
                            @endforeach
                        </x-ui.contained-list>
                    @endif
                </x-patterns.content-section-block>
            </div>

            <aside class="space-y-6">
                @if ($canManage)
                    <x-patterns.form-section
                        title="Update requirement"
                        description="Status updates are recorded as security audit events."
                    >
                        <form method="POST" action="{{ route('platform.security.update', ['requirement' => $requirement->slug]) }}" class="grid gap-5">
                            @csrf
                            @method('PATCH')

                            <x-ui.select
                                name="alignment_status"
                                label="Alignment"
                                :items="$alignmentItems"
                                :value="old('alignment_status', $requirement->alignment_status)"
                                :invalid="$errors->has('alignment_status')"
                                :invalid-text="$errors->first('alignment_status')"
                            />

                            <x-ui.select
                                name="work_status"
                                label="Work status"
                                :items="$workItems"
                                :value="old('work_status', $requirement->work_status)"
                                :invalid="$errors->has('work_status')"
                                :invalid-text="$errors->first('work_status')"
                            />

                            <x-ui.select
                                name="owner_user_id"
                                label="Owner"
                                :items="$ownerItems"
                                :value="old('owner_user_id', $requirement->owner_user_id)"
                                :invalid="$errors->has('owner_user_id')"
                                :invalid-text="$errors->first('owner_user_id')"
                            />

                            <x-ui.text-input
                                name="target_phase"
                                label="Target phase"
                                :value="old('target_phase', $requirement->target_phase)"
                                maxlength="150"
                                :invalid="$errors->has('target_phase')"
                                :invalid-text="$errors->first('target_phase')"
                            />

                            <x-ui.text-area
                                name="notes"
                                label="Notes"
                                :value="old('notes', $requirement->notes)"
                                rows="6"
                                :invalid="$errors->has('notes')"
                                :invalid-text="$errors->first('notes')"
                            />

                            <div class="grid gap-3">
                                <div>
                                    <p class="ui-kicker">Evidence links</p>
                                    <p class="ui-card-copy">Store safe labels and URLs or app paths only.</p>
                                </div>

                                @for ($index = 0; $index < $evidenceRows; $index++)
                                    <div class="grid gap-3">
                                        <x-ui.text-input
                                            :name="'evidence_links['.$index.'][label]'"
                                            label="Evidence label {{ $index + 1 }}"
                                            :value="$evidenceLinks[$index]['label'] ?? ''"
                                            :invalid="$errors->has('evidence_links.'.$index.'.label')"
                                            :invalid-text="$errors->first('evidence_links.'.$index.'.label')"
                                        />
                                        <x-ui.text-input
                                            :name="'evidence_links['.$index.'][url]'"
                                            label="Evidence URL {{ $index + 1 }}"
                                            :value="$evidenceLinks[$index]['url'] ?? ''"
                                            placeholder="https://... or /platform/..."
                                            :invalid="$errors->has('evidence_links.'.$index.'.url')"
                                            :invalid-text="$errors->first('evidence_links.'.$index.'.url')"
                                        />
                                    </div>
                                @endfor
                            </div>

                            <x-patterns.forms.actions>
                                <x-ui.button type="submit" semantic="primary">
                                    Save requirement
                                </x-ui.button>
                            </x-patterns.forms.actions>
                        </form>
                    </x-patterns.form-section>
                @else
                    <x-patterns.content-section-block
                        title="Review state"
                        description="Status updates require security checklist management access."
                    >
                        <x-ui.notification.inline kind="info" title="Read-only access">
                            You can view the checklist, but cannot update requirement state.
                        </x-ui.notification.inline>
                    </x-patterns.content-section-block>
                @endif

                <x-patterns.content-section-block title="Audit context">
                    <x-patterns.key-value-display :items="$auditItems" :columns="1" />
                </x-patterns.content-section-block>
            </aside>
        </div>
    </section>
</x-layouts.app>
