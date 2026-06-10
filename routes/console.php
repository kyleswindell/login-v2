<?php

use App\Support\LocalReviewEnvironment;
use App\Support\ActiveBatchReviewQueue;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Command\Command;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('active-batch-review:sync-manifest', function () {
    $manifest = ActiveBatchReviewQueue::syncManifest();
    $count = count($manifest['implemented_pending_review_ids']);

    $this->info("Synchronized active batch review manifest with {$count} pending-review ID(s).");
})->purpose('Synchronize the UI Reference active-batch review manifest from docs/08-active/change-queue.md');

Artisan::command('local:ready
    {--skip-http-checks : Prepare local review state without checking app and Vite HTTP endpoints.}
    {--hot-path= : Override the hot-file path; defaults to public/hot.}
    {--app-url=http://localhost:8000 : Local Laravel app URL to verify.}
    {--vite-check-url= : Override the Vite URL used for the HTTP check; defaults to node:5173 inside Docker and localhost:5173 outside Docker.}
    {--vite-url=http://localhost:5173 : Local Vite URL to verify.}', function () {
    if (app()->environment('production')) {
        $this->error('local:ready is not available in production.');

        return Command::FAILURE;
    }

    $result = app(LocalReviewEnvironment::class)->prepare(
        hotPath: $this->option('hot-path') ?: null,
        viteUrl: $this->option('vite-url'),
        viteCheckUrl: $this->option('vite-check-url') ?: null,
        appUrl: $this->option('app-url'),
        skipHttpChecks: (bool) $this->option('skip-http-checks'),
    );

    $hasFailure = false;

    foreach ($result['checks'] as $check) {
        $line = "[{$check['status']}] {$check['name']}: {$check['message']}";

        if ($check['status'] === 'failed') {
            $hasFailure = true;
            $this->error($line);

            continue;
        }

        if ($check['status'] === 'skipped') {
            $this->warn($line);

            continue;
        }

        $this->info($line);
    }

    $this->newLine();
    $this->line("App: {$result['app_url']}");
    $this->line("Vite: {$result['vite_url']}");
    $this->line("Vite check: {$result['vite_check_url']}");
    $this->line("Login: {$result['email']} / {$result['password']}");

    return $hasFailure ? Command::FAILURE : Command::SUCCESS;
})->purpose('Prepare the local browser-review environment, Vite hot asset target, and review user.');
