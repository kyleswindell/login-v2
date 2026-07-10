<?php

use App\Support\ActiveBatchReviewQueue;
use App\Core\Modules\ContributionRegistry;
use App\Core\Modules\Repository;
use App\Core\Modules\Category;
use App\Platform\Security\RuntimeSecurityChecker;
use App\Support\LocalReviewEnvironment;
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
})->purpose('Synchronize the active-batch review manifest from docs/08-active/change-queue.md');

Artisan::command('platform:modules:list
    {--type= : Optional module type filter: core, shared, or platform_management.}
    {--json : Emit safe JSON output instead of a text table.}', function (Repository $registry) {
    $type = $this->option('type');
    $moduleType = null;

    if (is_string($type) && trim($type) !== '') {
        $moduleType = Category::tryFrom(trim($type));

        if (! $moduleType) {
            $this->error('Module type must be one of: core, shared, platform_management.');

            return Command::FAILURE;
        }
    }

    $modules = $registry->summaries($moduleType);

    if ((bool) $this->option('json')) {
        $this->line(json_encode(['modules' => $modules], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return Command::SUCCESS;
    }

    $this->table(
        ['Key', 'Type', 'Default state', 'Enabled', 'Disableable', 'Tenant eligible', 'Ownership'],
        array_map(static function (array $module): array {
            return [
                $module['key'],
                $module['type'],
                $module['default_state'],
                $module['default_enabled'] ? 'yes' : 'no',
                $module['disableable'] ? 'yes' : 'no',
                $module['tenant_eligible'] ? 'yes' : 'no',
                array_sum($module['ownership_counts']),
            ];
        }, $modules),
    );

    return Command::SUCCESS;
})->purpose('List registered module definitions and ownership metadata.');

Artisan::command('modules:sync-registries
    {--json : Emit safe JSON output instead of human-readable lines.}', function (ContributionRegistry $registry) {
    $result = $registry->sync();

    if ((bool) $this->option('json')) {
        $this->line(json_encode(['synced' => $result], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return Command::SUCCESS;
    }

    foreach ($result as $name => $count) {
        $this->info("Synced {$count} {$name} registry row(s).");
    }

    return Command::SUCCESS;
})->purpose('Sync module-declared contribution metadata into registry projection tables.');

Artisan::command('platform:security-runtime-check
    {--target=local : Runtime target to evaluate: local, staging, or production.}
    {--url= : Optional deployed URL to probe for response headers.}
    {--json : Emit safe JSON output instead of human-readable lines.}', function (RuntimeSecurityChecker $checker) {
    $result = $checker->check(
        target: (string) $this->option('target'),
        url: $this->option('url') ?: null,
    );

    if ((bool) $this->option('json')) {
        $this->line(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return (int) $result['exit_code'];
    }

    $this->line("Security runtime check target: {$result['target']}");

    foreach ($result['checks'] as $check) {
        $line = '['.strtoupper($check['status'])."] {$check['name']}: {$check['message']}";

        match ($check['status']) {
            'fail' => $this->error($line),
            'warn' => $this->warn($line),
            default => $this->info($line),
        };
    }

    return (int) $result['exit_code'];
})->purpose('Verify runtime hardening posture for local, staging, or production environments.');

Artisan::command('local:ready
    {--skip-http-checks : Prepare local review state without checking app and Vite HTTP endpoints.}
    {--env-path= : Override the env-file path; defaults to .env.}
    {--hot-path= : Override the hot-file path; defaults to public/hot.}
    {--app-url= : Local Laravel app URL to verify; defaults to APP_URL or localhost:8000.}
    {--reverb-host= : Browser-reachable Reverb host; defaults to the app URL host.}
    {--vite-check-url= : Override the Vite URL used for the HTTP check; defaults to node:5173 inside Docker and localhost:5173 outside Docker.}
    {--vite-url= : Local Vite URL to write to public/hot; defaults to VITE_DEV_SERVER_URL or localhost:5173.}', function () {
    if (app()->environment('production')) {
        $this->error('local:ready is not available in production.');

        return Command::FAILURE;
    }

    $result = app(LocalReviewEnvironment::class)->prepare(
        envPath: $this->option('env-path') ?: null,
        hotPath: $this->option('hot-path') ?: null,
        viteUrl: $this->option('vite-url') ?: null,
        viteCheckUrl: $this->option('vite-check-url') ?: null,
        appUrl: $this->option('app-url') ?: null,
        reverbHost: $this->option('reverb-host') ?: null,
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
    $this->line("Reverb browser host: {$result['reverb_host']}:{$result['reverb_port']}");
    $this->line("Login: {$result['email']} / {$result['password']}");

    return $hasFailure ? Command::FAILURE : Command::SUCCESS;
})->purpose('Prepare the local browser-review environment, Vite hot asset target, and review user.');
