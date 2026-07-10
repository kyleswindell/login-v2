<?php

namespace Tests\Feature\Platform;

use App\Models\PlatformAuditLog;
use App\Models\SecurityRequirement;
use App\Models\User;
use App\Modules\Roles\Services\RoleCatalog;
use Database\Seeders\PlatformRolesAndPermissionsSeeder;
use Database\Seeders\SecurityRequirementSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlatformSecurityChecklistTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_view_security_checklist_and_detail(): void
    {
        $this->actingAsPlatformSuperAdmin();
        $this->seed(SecurityRequirementSeeder::class);

        $requirement = SecurityRequirement::query()->where('slug', 'asvs-evidence-matrix')->firstOrFail();

        $this->get('/platform/security')
            ->assertOk()
            ->assertSee('Security Checklist')
            ->assertSee('ASVS baseline and evidence matrix')
            ->assertSee('Create requirement-level ASVS evidence matrix');

        $this->get("/platform/security/{$requirement->slug}")
            ->assertOk()
            ->assertSee($requirement->title)
            ->assertSee('Requirement context')
            ->assertSee('Evidence links');
    }

    public function test_reviewer_can_view_but_not_update_security_requirements(): void
    {
        $this->actingAsPlatformReviewer();
        $this->seed(SecurityRequirementSeeder::class);

        $requirement = SecurityRequirement::query()->where('slug', 'auth-mfa-assurance-boundary')->firstOrFail();

        $this->get('/platform/security')
            ->assertOk()
            ->assertSee('Security Checklist');

        $this->patch("/platform/security/{$requirement->slug}", [
            'alignment_status' => SecurityRequirement::ALIGNMENT_ALIGNED,
            'work_status' => SecurityRequirement::WORK_VALIDATED,
        ])->assertForbidden();
    }

    public function test_manager_without_security_permission_cannot_access_checklist(): void
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);
        $this->seed(SecurityRequirementSeeder::class);

        $user = User::factory()->create();
        $user->syncRoles([RoleCatalog::MANAGER]);

        $this->actingAs($user)
            ->get('/platform/security')
            ->assertForbidden();
    }

    public function test_manager_can_update_requirement_and_records_safe_audit_event(): void
    {
        $actor = $this->actingAsPlatformSuperAdmin();
        $owner = User::factory()->create(['name' => 'Security Owner']);
        $this->seed(SecurityRequirementSeeder::class);

        $requirement = SecurityRequirement::query()->where('slug', 'password-anti-automation-controls')->firstOrFail();

        $this->patch("/platform/security/{$requirement->slug}", [
            'alignment_status' => SecurityRequirement::ALIGNMENT_PARTIAL,
            'work_status' => SecurityRequirement::WORK_IN_PROGRESS,
            'owner_user_id' => $owner->id,
            'target_phase' => 'Security readiness pass',
            'notes' => 'Internal note with sensitive implementation detail placeholder.',
            'evidence_links' => [
                ['label' => 'Auth standards', 'url' => '/platform/docs?path=docs/02-standards/security/Identity%20And%20Account%20Security%20Standards.md'],
                ['label' => 'ASVS baseline', 'url' => 'docs/02-standards/security/OWASP ASVS Level 2 Baseline.md'],
                ['label' => 'OWASP ASVS', 'url' => 'https://owasp.org/www-project-application-security-verification-standard/'],
            ],
        ])->assertRedirect("/platform/security/{$requirement->slug}");

        $requirement->refresh();

        $this->assertSame(SecurityRequirement::ALIGNMENT_PARTIAL, $requirement->alignment_status);
        $this->assertSame(SecurityRequirement::WORK_IN_PROGRESS, $requirement->work_status);
        $this->assertSame($owner->id, $requirement->owner_user_id);
        $this->assertSame('Security readiness pass', $requirement->target_phase);
        $this->assertNotNull($requirement->last_reviewed_at);
        $this->assertSame($actor->id, $requirement->last_reviewed_by);

        $log = PlatformAuditLog::query()
            ->where('event_type', 'security.requirement_updated')
            ->firstOrFail();

        $this->assertSame($actor->id, $log->actor_user_id);
        $this->assertSame(SecurityRequirement::class, $log->subject_type);
        $this->assertSame((string) $requirement->id, $log->subject_id);
        $this->assertTrue($log->is_security_event);
        $this->assertSame($requirement->slug, $log->metadata['requirement_slug']);
        $this->assertSame(3, $log->metadata['evidence_link_count']);
        $this->assertStringNotContainsString('sensitive implementation detail', json_encode($log->metadata));
    }

    public function test_unsafe_evidence_links_are_rejected_and_not_rendered(): void
    {
        $this->actingAsPlatformSuperAdmin();
        $this->seed(SecurityRequirementSeeder::class);

        $requirement = SecurityRequirement::query()->where('slug', 'password-anti-automation-controls')->firstOrFail();

        $unsafeRows = [
            ['label' => 'Unsafe script', 'url' => 'javascript:alert(1)', 'error' => 'evidence_links.0.url'],
            ['label' => 'Unsafe data', 'url' => 'data:text/html,<h1>X</h1>', 'error' => 'evidence_links.0.url'],
            ['label' => 'Protocol relative', 'url' => '//evil.example.test/path', 'error' => 'evidence_links.0.url'],
            ['label' => 'Raw <strong>HTML</strong>', 'url' => '/platform/docs', 'error' => 'evidence_links.0.label'],
            ['label' => 'Traversal', 'url' => 'docs/../.env', 'error' => 'evidence_links.0.url'],
            ['label' => 'Embedded credentials', 'url' => 'https://user:secret@example.test/security', 'error' => 'evidence_links.0.url'],
            ['label' => 'Missing URL', 'url' => '', 'error' => 'evidence_links.0.url'],
            ['label' => '', 'url' => '/platform/docs', 'error' => 'evidence_links.0.label'],
            ['label' => str_repeat('A', 161), 'url' => '/platform/docs', 'error' => 'evidence_links.0.label'],
            ['label' => 'Overlong URL', 'url' => '/'.str_repeat('a', 1001), 'error' => 'evidence_links.0.url'],
        ];

        foreach ($unsafeRows as $row) {
            $this->from("/platform/security/{$requirement->slug}")
                ->patch("/platform/security/{$requirement->slug}", [
                    'alignment_status' => SecurityRequirement::ALIGNMENT_PARTIAL,
                    'work_status' => SecurityRequirement::WORK_IN_PROGRESS,
                    'evidence_links' => [
                        ['label' => $row['label'], 'url' => $row['url']],
                    ],
                ])->assertRedirect("/platform/security/{$requirement->slug}")
                ->assertSessionHasErrors([$row['error']]);

            $this->assertSame([], $requirement->fresh()->evidence_links ?? []);
        }

        $this->get("/platform/security/{$requirement->slug}")
            ->assertOk()
            ->assertDontSee('javascript:alert', false)
            ->assertDontSee('data:text/html', false)
            ->assertDontSee('//evil.example.test', false);
    }

    public function test_invalid_requirement_status_is_rejected(): void
    {
        $this->actingAsPlatformSuperAdmin();
        $this->seed(SecurityRequirementSeeder::class);

        $requirement = SecurityRequirement::query()->firstOrFail();

        $this->patch("/platform/security/{$requirement->slug}", [
            'alignment_status' => 'complete',
            'work_status' => SecurityRequirement::WORK_VALIDATED,
        ])->assertSessionHasErrors('alignment_status');
    }

    public function test_security_checklist_filters_by_alignment_status(): void
    {
        $this->actingAsPlatformSuperAdmin();
        $this->seed(SecurityRequirementSeeder::class);

        SecurityRequirement::query()
            ->where('slug', 'asvs-evidence-matrix')
            ->update(['alignment_status' => SecurityRequirement::ALIGNMENT_ALIGNED]);

        $this->get('/platform/security?alignment_status=aligned')
            ->assertOk()
            ->assertSee('Create requirement-level ASVS evidence matrix')
            ->assertDontSee('Add password and login anti-automation evidence');
    }

    public function test_security_requirement_seeder_is_idempotent_and_preserves_managed_status(): void
    {
        $this->seed(SecurityRequirementSeeder::class);

        $initialCount = SecurityRequirement::query()->count();
        $requirement = SecurityRequirement::query()->where('slug', 'asvs-evidence-matrix')->firstOrFail();
        $requirement->update([
            'alignment_status' => SecurityRequirement::ALIGNMENT_ACCEPTED_RISK,
            'work_status' => SecurityRequirement::WORK_DEFERRED,
            'notes' => 'Manual review state.',
        ]);

        $this->seed(SecurityRequirementSeeder::class);

        $requirement->refresh();

        $this->assertSame($initialCount, SecurityRequirement::query()->count());
        $this->assertSame(SecurityRequirement::ALIGNMENT_ACCEPTED_RISK, $requirement->alignment_status);
        $this->assertSame(SecurityRequirement::WORK_DEFERRED, $requirement->work_status);
        $this->assertSame('Manual review state.', $requirement->notes);
    }

    public function test_dashboard_security_readiness_widget_is_deferred_during_blank_dashboard_proof(): void
    {
        $this->actingAsPlatformSuperAdmin();
        $this->seed(SecurityRequirementSeeder::class);

        $this->get('/dashboard')
            ->assertOk()
            ->assertDontSee('Security Readiness')
            ->assertDontSee('Open checklist');
    }
}
