<?php

namespace Tests\Unit;

use App\Support\ActiveBatchReviewQueue;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ActiveBatchReviewQueueTest extends TestCase
{
    public function test_sync_manifest_extracts_pending_review_ids_from_the_change_queue(): void
    {
        $directory = storage_path('framework/testing/active-batch-review-sync/'.uniqid('', true));
        File::ensureDirectoryExists($directory);

        $queuePath = $directory.'/change-queue.md';
        $manifestPath = $directory.'/active-batch-review-manifest.json';

        File::put($queuePath, <<<'MD'
# Change Queue

## Ready To Implement

## In Progress

## Implemented Pending Review
- [ ] First item
  ID: P2-B-CQ-013
- [ ] Second item
  ID: P2-B-CQ-018

## Blocked
MD);

        config()->set('platform.active_batch_review.active_batch_review_source_path', $queuePath);
        config()->set('platform.active_batch_review.active_batch_review_manifest_path', $manifestPath);

        ActiveBatchReviewQueue::clearCache();

        $manifest = ActiveBatchReviewQueue::syncManifest();

        $this->assertSame(['P2-B-CQ-013', 'P2-B-CQ-018'], $manifest['implemented_pending_review_ids']);
        $this->assertSame(['P2-B-CQ-013', 'P2-B-CQ-018'], ActiveBatchReviewQueue::implementedPendingReviewIds());

        $stored = json_decode(File::get($manifestPath), true, 512, JSON_THROW_ON_ERROR);

        $this->assertSame(['P2-B-CQ-013', 'P2-B-CQ-018'], $stored['implemented_pending_review_ids']);
        $this->assertArrayHasKey('source_hash', $stored);

        File::deleteDirectory($directory);
    }

    public function test_runtime_lookup_regenerates_the_manifest_when_the_queue_changes(): void
    {
        $directory = storage_path('framework/testing/active-batch-review-regenerate/'.uniqid('', true));
        File::ensureDirectoryExists($directory);

        $queuePath = $directory.'/change-queue.md';
        $manifestPath = $directory.'/active-batch-review-manifest.json';

        File::put($queuePath, <<<'MD'
# Change Queue

## Implemented Pending Review
- [ ] First item
  ID: P2-B-CQ-014
MD);

        config()->set('platform.active_batch_review.active_batch_review_source_path', $queuePath);
        config()->set('platform.active_batch_review.active_batch_review_manifest_path', $manifestPath);

        ActiveBatchReviewQueue::clearCache();
        ActiveBatchReviewQueue::syncManifest();

        File::put($queuePath, <<<'MD'
# Change Queue

## Implemented Pending Review
- [ ] Remaining item
  ID: P2-B-CQ-013
MD);

        ActiveBatchReviewQueue::clearCache();

        $this->assertSame(['P2-B-CQ-013'], ActiveBatchReviewQueue::implementedPendingReviewIds());

        $stored = json_decode(File::get($manifestPath), true, 512, JSON_THROW_ON_ERROR);

        $this->assertSame(['P2-B-CQ-013'], $stored['implemented_pending_review_ids']);

        File::deleteDirectory($directory);
    }
}
