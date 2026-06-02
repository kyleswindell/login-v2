<?php

use App\Support\ActiveBatchReviewQueue;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('active-batch-review:sync-manifest', function () {
    $manifest = ActiveBatchReviewQueue::syncManifest();
    $count = count($manifest['implemented_pending_review_ids']);

    $this->info("Synchronized active batch review manifest with {$count} pending-review ID(s).");
})->purpose('Synchronize the UI Reference active-batch review manifest from docs/08-active/change-queue.md');
