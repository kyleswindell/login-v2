<?php

namespace Tests;

use App\Models\User;
use App\Support\ActiveBatchReviewQueue;
use Database\Seeders\PlatformRolesAndPermissionsSeeder;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\File;

abstract class TestCase extends BaseTestCase
{
    private ?string $activeBatchReviewTempDir = null;

    protected function setUp(): void
    {
        parent::setUp();

        // Feature tests should assert authorization and validation behavior,
        // not CSRF token wiring from rendered forms.
        $this->withoutMiddleware(PreventRequestForgery::class);
    }

    protected function actingAsPlatformSuperAdmin(?User $user = null): User
    {
        $user ??= User::factory()->create();

        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $user->syncRoles(['platform_super_admin']);
        $this->actingAs($user);

        return $user;
    }

    protected function actingAsPlatformReviewer(?User $user = null): User
    {
        $user ??= User::factory()->create();

        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $user->syncRoles(['platform_reviewer']);
        $this->actingAs($user);

        return $user;
    }

    protected function useActiveBatchReviewIds(array $ids): void
    {
        $this->activeBatchReviewTempDir = storage_path('framework/testing/active-batch-review/'.uniqid('', true));

        File::ensureDirectoryExists($this->activeBatchReviewTempDir);

        $queuePath = $this->activeBatchReviewTempDir.'/change-queue.md';
        $manifestPath = $this->activeBatchReviewTempDir.'/active-batch-review-manifest.json';

        File::put($queuePath, $this->activeBatchReviewQueueFixture($ids));

        config()->set('platform.ui_reference.active_batch_review_source_path', $queuePath);
        config()->set('platform.ui_reference.active_batch_review_manifest_path', $manifestPath);

        ActiveBatchReviewQueue::clearCache();
        ActiveBatchReviewQueue::syncManifest();
    }

    protected function tearDown(): void
    {
        ActiveBatchReviewQueue::clearCache();

        if ($this->activeBatchReviewTempDir !== null) {
            File::deleteDirectory($this->activeBatchReviewTempDir);
            $this->activeBatchReviewTempDir = null;
        }

        parent::tearDown();
    }

    /**
     * @param list<string> $ids
     */
    private function activeBatchReviewQueueFixture(array $ids): string
    {
        $items = collect($ids)
            ->map(fn (string $id): string => "- [ ] Placeholder review item\n  ID: {$id}")
            ->implode("\n");

        $implementedPendingReview = $items === ''
            ? ''
            : $items."\n";

        return <<<MD
# Change Queue

## Ready To Implement

## In Progress

## Implemented Pending Review
{$implementedPendingReview}
## Blocked

## Deferred

## Passed Review

## Closed
MD;
    }
}
