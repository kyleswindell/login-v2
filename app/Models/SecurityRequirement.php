<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SecurityRequirement extends Model
{
    public const ALIGNMENT_ALIGNED = 'aligned';
    public const ALIGNMENT_PARTIAL = 'partial';
    public const ALIGNMENT_LACKING = 'lacking';
    public const ALIGNMENT_NOT_APPLICABLE = 'not_applicable';
    public const ALIGNMENT_ACCEPTED_RISK = 'accepted_risk';

    public const WORK_NOT_STARTED = 'not_started';
    public const WORK_PLANNED = 'planned';
    public const WORK_IN_PROGRESS = 'in_progress';
    public const WORK_IMPLEMENTED_PENDING_REVIEW = 'implemented_pending_review';
    public const WORK_VALIDATED = 'validated';
    public const WORK_DEFERRED = 'deferred';

    /** @var list<string> */
    protected $fillable = [
        'group_id',
        'slug',
        'title',
        'summary',
        'asvs_refs',
        'canonical_docs',
        'alignment_status',
        'work_status',
        'priority',
        'owner_user_id',
        'target_phase',
        'evidence_links',
        'notes',
        'last_reviewed_at',
        'last_reviewed_by',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'asvs_refs' => 'array',
            'canonical_docs' => 'array',
            'evidence_links' => 'array',
            'last_reviewed_at' => 'datetime',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function alignmentStatuses(): array
    {
        return [
            self::ALIGNMENT_ALIGNED => 'Aligned',
            self::ALIGNMENT_PARTIAL => 'Partial',
            self::ALIGNMENT_LACKING => 'Lacking',
            self::ALIGNMENT_NOT_APPLICABLE => 'Not applicable',
            self::ALIGNMENT_ACCEPTED_RISK => 'Accepted risk',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function workStatuses(): array
    {
        return [
            self::WORK_NOT_STARTED => 'Not started',
            self::WORK_PLANNED => 'Planned',
            self::WORK_IN_PROGRESS => 'In progress',
            self::WORK_IMPLEMENTED_PENDING_REVIEW => 'Implemented pending review',
            self::WORK_VALIDATED => 'Validated',
            self::WORK_DEFERRED => 'Deferred',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function priorities(): array
    {
        return [
            'critical' => 'Critical',
            'high' => 'High',
            'medium' => 'Medium',
            'low' => 'Low',
        ];
    }

    public function alignmentLabel(): string
    {
        return self::alignmentStatuses()[$this->alignment_status] ?? $this->alignment_status;
    }

    public function workStatusLabel(): string
    {
        return self::workStatuses()[$this->work_status] ?? $this->work_status;
    }

    public function priorityLabel(): string
    {
        return self::priorities()[$this->priority] ?? $this->priority;
    }

    public function alignmentBadgeStatus(): string
    {
        return match ($this->alignment_status) {
            self::ALIGNMENT_ALIGNED => 'compliant',
            self::ALIGNMENT_PARTIAL => 'under review',
            self::ALIGNMENT_LACKING => 'non-compliant',
            self::ALIGNMENT_ACCEPTED_RISK => 'warning',
            self::ALIGNMENT_NOT_APPLICABLE => 'neutral',
            default => 'neutral',
        };
    }

    public function workBadgeStatus(): string
    {
        return match ($this->work_status) {
            self::WORK_VALIDATED => 'approved',
            self::WORK_IN_PROGRESS => 'in progress',
            self::WORK_IMPLEMENTED_PENDING_REVIEW => 'pending review',
            self::WORK_PLANNED => 'ready',
            self::WORK_DEFERRED => 'archived',
            self::WORK_NOT_STARTED => 'draft',
            default => 'neutral',
        };
    }

    /**
     * @return BelongsTo<SecurityRequirementGroup, $this>
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(SecurityRequirementGroup::class, 'group_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function lastReviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_reviewed_by');
    }
}
