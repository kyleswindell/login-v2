<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\SecurityRequirement;
use App\Models\SecurityRequirementGroup;
use App\Models\User;
use App\Platform\Logging\PlatformLogger;
use App\Rules\SafeEvidenceLinkUrl;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SecurityChecklistController extends Controller
{
    public function __construct(private readonly PlatformLogger $logger) {}

    public function index(Request $request): View
    {
        $this->authorize('view-platform-security-checklist');

        $filters = [
            'group' => trim($request->string('group')->toString()),
            'alignment_status' => trim($request->string('alignment_status')->toString()),
            'work_status' => trim($request->string('work_status')->toString()),
            'priority' => trim($request->string('priority')->toString()),
            'asvs_family' => trim($request->string('asvs_family')->toString()),
        ];

        $applyFilters = fn ($query) => $query
            ->when($filters['group'] !== '', fn ($query) => $query->where('security_requirement_groups.slug', $filters['group']))
            ->when($filters['alignment_status'] !== '', fn ($query) => $query->where('security_requirements.alignment_status', $filters['alignment_status']))
            ->when($filters['work_status'] !== '', fn ($query) => $query->where('security_requirements.work_status', $filters['work_status']))
            ->when($filters['priority'] !== '', fn ($query) => $query->where('security_requirements.priority', $filters['priority']))
            ->when($filters['asvs_family'] !== '', fn ($query) => $query->where('security_requirement_groups.asvs_family', $filters['asvs_family']));

        $requirements = $applyFilters(SecurityRequirement::query()
            ->with(['group', 'owner', 'lastReviewedBy'])
            ->join('security_requirement_groups', 'security_requirements.group_id', '=', 'security_requirement_groups.id')
            ->select('security_requirements.*'))
            ->orderBy('security_requirement_groups.sort_order')
            ->orderBy('security_requirements.priority')
            ->orderBy('security_requirements.title')
            ->get();

        $groups = SecurityRequirementGroup::query()
            ->withCount('requirements')
            ->orderBy('sort_order')
            ->get();

        $summaryCounts = SecurityRequirement::query()
            ->selectRaw('alignment_status, count(*) as aggregate')
            ->groupBy('alignment_status')
            ->pluck('aggregate', 'alignment_status')
            ->map(fn (int|string $count): int => (int) $count)
            ->all();

        $highRiskGaps = $applyFilters(SecurityRequirement::query()
            ->with('group')
            ->join('security_requirement_groups', 'security_requirements.group_id', '=', 'security_requirement_groups.id')
            ->select('security_requirements.*'))
            ->whereIn('priority', ['critical', 'high'])
            ->whereIn('alignment_status', [
                SecurityRequirement::ALIGNMENT_PARTIAL,
                SecurityRequirement::ALIGNMENT_LACKING,
            ])
            ->orderBy('security_requirement_groups.sort_order')
            ->orderBy('security_requirements.priority')
            ->limit(8)
            ->get();

        return view('platform.security.index', [
            'requirements' => $requirements,
            'groups' => $groups,
            'filters' => $filters,
            'summaryCounts' => $summaryCounts,
            'highRiskGaps' => $highRiskGaps,
            'lastUpdatedAt' => SecurityRequirement::query()->latest('updated_at')->first()?->updated_at,
            'alignmentStatuses' => SecurityRequirement::alignmentStatuses(),
            'workStatuses' => SecurityRequirement::workStatuses(),
            'priorities' => SecurityRequirement::priorities(),
            'asvsFamilies' => SecurityRequirementGroup::query()->whereNotNull('asvs_family')->distinct()->orderBy('asvs_family')->pluck('asvs_family')->all(),
            'canManage' => $request->user()?->can('manage-platform-security-checklist') ?? false,
        ]);
    }

    public function show(Request $request, SecurityRequirement $requirement): View
    {
        $this->authorize('view-platform-security-checklist');

        return view('platform.security.show', [
            'requirement' => $requirement->load(['group', 'owner', 'lastReviewedBy']),
            'alignmentStatuses' => SecurityRequirement::alignmentStatuses(),
            'workStatuses' => SecurityRequirement::workStatuses(),
            'users' => User::query()->where('is_active', true)->orderBy('name')->get(['id', 'name', 'email']),
            'canManage' => $request->user()?->can('manage-platform-security-checklist') ?? false,
        ]);
    }

    public function update(Request $request, SecurityRequirement $requirement): RedirectResponse
    {
        $this->authorize('manage-platform-security-checklist');

        $this->prepareEvidenceLinksForValidation($request);

        $validated = $request->validate([
            'alignment_status' => ['required', Rule::in(array_keys(SecurityRequirement::alignmentStatuses()))],
            'work_status' => ['required', Rule::in(array_keys(SecurityRequirement::workStatuses()))],
            'owner_user_id' => ['nullable', 'integer', 'exists:users,id'],
            'target_phase' => ['nullable', 'string', 'max:150'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'evidence_links' => ['nullable', 'array', 'max:8'],
            'evidence_links.*.label' => ['nullable', 'string', 'max:160', 'required_with:evidence_links.*.url', 'not_regex:/[<>\x00-\x1F\x7F]/u'],
            'evidence_links.*.url' => ['nullable', 'string', 'max:1000', 'required_with:evidence_links.*.label', new SafeEvidenceLinkUrl()],
        ]);

        $editableFields = [
            'alignment_status',
            'work_status',
            'owner_user_id',
            'target_phase',
            'notes',
            'evidence_links',
        ];

        $before = $requirement->only($editableFields);

        $evidenceLinks = collect($validated['evidence_links'] ?? [])
            ->map(fn (array $link): array => [
                'label' => trim((string) ($link['label'] ?? '')),
                'url' => trim((string) ($link['url'] ?? '')),
            ])
            ->filter(fn (array $link): bool => $link['label'] !== '' && $link['url'] !== '')
            ->values()
            ->all();

        $requirement->fill([
            'alignment_status' => $validated['alignment_status'],
            'work_status' => $validated['work_status'],
            'owner_user_id' => $validated['owner_user_id'] ?? null,
            'target_phase' => $validated['target_phase'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'evidence_links' => $evidenceLinks,
            'last_reviewed_at' => now('UTC'),
            'last_reviewed_by' => $request->user()?->id,
        ]);

        $after = $requirement->only($editableFields);
        $changedFields = collect($after)
            ->filter(fn (mixed $value, string $field): bool => $before[$field] != $value)
            ->keys()
            ->values()
            ->all();

        $requirement->save();

        if ($changedFields !== []) {
            $this->logger->recordEvent(
                event: 'security.requirement_updated',
                metadata: [
                    'requirement_slug' => $requirement->slug,
                    'changed_fields' => $changedFields,
                    'old_alignment_status' => $before['alignment_status'],
                    'new_alignment_status' => $after['alignment_status'],
                    'old_work_status' => $before['work_status'],
                    'new_work_status' => $after['work_status'],
                    'evidence_link_count' => count($evidenceLinks),
                ],
                subjectType: SecurityRequirement::class,
                subjectId: (string) $requirement->id,
                severity: 'notice',
                isSecurityEvent: true,
            );
        }

        return redirect()
            ->route('platform.security.show', ['requirement' => $requirement->slug])
            ->with('status', 'Security requirement updated.');
    }

    private function prepareEvidenceLinksForValidation(Request $request): void
    {
        $links = $request->input('evidence_links');

        if (! is_array($links)) {
            return;
        }

        $request->merge([
            'evidence_links' => collect($links)
                ->map(fn (mixed $link): array => is_array($link) ? [
                    'label' => trim((string) ($link['label'] ?? '')),
                    'url' => trim((string) ($link['url'] ?? '')),
                ] : [
                    'label' => '',
                    'url' => '',
                ])
                ->all(),
        ]);
    }
}
