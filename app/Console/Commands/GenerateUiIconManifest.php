<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| File: app/Console/Commands/GenerateUiIconManifest.php
| Purpose: Generate the trusted UI icon manifest from local SVG files.
|--------------------------------------------------------------------------
|
| The manifest records all available SVG sources and preselects one default
| source per icon name. Runtime icon rendering performs one direct lookup.
|
*/

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

final class GenerateUiIconManifest extends Command
{
    protected $signature = 'ui-icons:generate-manifest {--set=carbon : Icon set key from config/ui-icons.php}';

    protected $description = 'Generate the trusted UI icon manifest from local SVG files.';

    public function handle(): int
    {
        $set = (string) $this->option('set');
        $setConfig = config("ui-icons.sets.{$set}");

        if (! is_array($setConfig)) {
            $this->error("Icon set [{$set}] is not configured.");

            return self::FAILURE;
        }

        $sourcePath = $setConfig['path'] ?? null;
        $manifestPath = $setConfig['manifest'] ?? null;

        if (! is_string($sourcePath) || ! is_dir($sourcePath)) {
            $this->error("Icon source path is invalid: {$sourcePath}");

            return self::FAILURE;
        }

        if (! is_string($manifestPath) || $manifestPath === '') {
            $this->error("Icon manifest path is invalid for set [{$set}].");

            return self::FAILURE;
        }

        $this->ensureFallbackIcon($sourcePath);

        $sourceRoot = realpath($sourcePath);

        if (! is_string($sourceRoot)) {
            $this->error("Unable to resolve icon source path: {$sourcePath}");

            return self::FAILURE;
        }

        $icons = [];

        foreach (File::allFiles($sourceRoot) as $file) {
            if (strtolower($file->getExtension()) !== 'svg') {
                continue;
            }

            $absolutePath = $file->getRealPath();

            if (! is_string($absolutePath)) {
                continue;
            }

            $relativePath = str_replace(
                '\\',
                '/',
                substr($absolutePath, strlen($sourceRoot) + 1),
            );

            if ($relativePath === '' || $relativePath === 'manifest.php') {
                continue;
            }

            $iconName = pathinfo($relativePath, PATHINFO_FILENAME);
            $sourceGroup = $this->resolveSourceGroup($relativePath);

            $icons[$iconName]['sources'][$sourceGroup] = $relativePath;
        }

        $priority = (array) config('ui-icons.default_source_priority', [
            '16',
            '20',
            '24',
            '32',
            'root',
        ]);

        $manifest = [];

        foreach ($icons as $iconName => $definition) {
            $sources = $definition['sources'] ?? [];

            ksort($sources, SORT_NATURAL | SORT_FLAG_CASE);

            $defaultSource = $this->resolveDefaultSource($sources, $priority);

            if (! is_string($defaultSource)) {
                continue;
            }

            $manifest[$iconName] = [
                'default' => $defaultSource,
                'sources' => $sources,
            ];
        }

        ksort($manifest, SORT_NATURAL | SORT_FLAG_CASE);

        File::ensureDirectoryExists(dirname($manifestPath));

        File::put($manifestPath, $this->renderManifest($manifest));

        $this->info('UI icon manifest generated.');
        $this->line("Set: {$set}");
        $this->line("Icons: " . count($manifest));
        $this->line("Manifest: {$manifestPath}");

        return self::SUCCESS;
    }

    private function ensureFallbackIcon(string $sourcePath): void
    {
        $fallbackName = (string) config('ui-icons.fallback', 'empty');
        $fallbackPath = $sourcePath . DIRECTORY_SEPARATOR . $fallbackName . '.svg';

        if (is_file($fallbackPath)) {
            return;
        }

        File::put($fallbackPath, <<<'SVG'
<svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
    <rect width="16" height="16" fill="none"></rect>
</svg>
SVG);
    }

    private function resolveSourceGroup(string $relativePath): string
    {
        $segments = explode('/', $relativePath);
        $firstSegment = $segments[0] ?? '';

        if (! preg_match('/^(16|20|24|32)$/', $firstSegment)) {
            return 'root';
        }

        if (count($segments) > 2) {
            return $firstSegment . '/' . $segments[1];
        }

        return $firstSegment;
    }

    /**
     * @param array<string, string> $sources
     * @param array<int, string> $priority
     */
    private function resolveDefaultSource(array $sources, array $priority): ?string
    {
        foreach ($priority as $sourceGroup) {
            if (isset($sources[$sourceGroup])) {
                return $sources[$sourceGroup];
            }
        }

        return reset($sources) ?: null;
    }

    /**
     * @param array<string, array{default: string, sources: array<string, string>}> $manifest
     */
    private function renderManifest(array $manifest): string
    {
        $export = var_export($manifest, true);

        return <<<PHP
<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| File: resources/views/components/icons/src/svg/manifest.php
| Purpose: Generated Carbon SVG icon manifest.
|--------------------------------------------------------------------------
|
| Do not edit manually. Run:
| php artisan ui-icons:generate-manifest
|
*/

return {$export};

PHP;
    }
}
