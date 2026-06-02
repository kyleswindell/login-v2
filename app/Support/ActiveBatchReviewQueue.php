<?php

namespace App\Support;

final class ActiveBatchReviewQueue
{
    private static ?array $implementedPendingReviewIds = null;

    /**
     * @return array{generated_at: string, source_hash: string|null, implemented_pending_review_ids: list<string>}
     */
    public static function syncManifest(): array
    {
        $manifest = self::buildManifest();

        $directory = dirname(self::manifestPath());

        if (! is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        file_put_contents(
            self::manifestPath(),
            json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR)
        );

        self::$implementedPendingReviewIds = $manifest['implemented_pending_review_ids'];

        return $manifest;
    }

    public static function clearCache(): void
    {
        self::$implementedPendingReviewIds = null;
    }

    /**
     * @return list<string>
     */
    public static function implementedPendingReviewIds(): array
    {
        if (self::$implementedPendingReviewIds !== null) {
            return self::$implementedPendingReviewIds;
        }

        $source = self::readSource();
        $manifest = self::readManifest();

        if ($source['hash'] !== null && ($manifest['source_hash'] ?? null) !== $source['hash']) {
            $manifest = self::syncManifest();
        }

        if ($manifest === null) {
            return self::$implementedPendingReviewIds = [];
        }

        return self::$implementedPendingReviewIds = self::normalizeIds($manifest['implemented_pending_review_ids'] ?? []);
    }

    /**
     * @return array{generated_at: string, source_hash: string|null, implemented_pending_review_ids: list<string>}
     */
    private static function buildManifest(): array
    {
        $source = self::readSource();

        return [
            'generated_at' => now()->toIso8601String(),
            'source_hash' => $source['hash'],
            'implemented_pending_review_ids' => self::extractIds($source['contents']),
        ];
    }

    /**
     * @return array{contents: string, hash: string|null}
     */
    private static function readSource(): array
    {
        $path = self::sourcePath();

        if (! is_file($path)) {
            return ['contents' => '', 'hash' => null];
        }

        $contents = file_get_contents($path);

        if ($contents === false) {
            return ['contents' => '', 'hash' => null];
        }

        return [
            'contents' => $contents,
            'hash' => hash('sha256', $contents),
        ];
    }

    /**
     * @return array{generated_at?: mixed, source_hash?: mixed, implemented_pending_review_ids?: mixed}|null
     */
    private static function readManifest(): ?array
    {
        $path = self::manifestPath();

        if (! is_file($path)) {
            return null;
        }

        $contents = file_get_contents($path);

        if ($contents === false) {
            return null;
        }

        try {
            $decoded = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return null;
        }

        return is_array($decoded) ? $decoded : null;
    }

    /**
     * @return list<string>
     */
    private static function extractIds(string $contents): array
    {
        if (! preg_match('/^## Implemented Pending Review\s*$(.*?)(?=^##\s|\z)/ms', $contents, $matches)) {
            return [];
        }

        preg_match_all('/^\s*ID:\s*([A-Z0-9-]+)/m', $matches[1], $idMatches);

        return self::normalizeIds($idMatches[1] ?? []);
    }

    /**
     * @param mixed $ids
     * @return list<string>
     */
    private static function normalizeIds(mixed $ids): array
    {
        if (! is_array($ids)) {
            return [];
        }

        return array_values(array_unique(array_filter(array_map(function (mixed $id): string {
            return is_scalar($id) ? trim((string) $id) : '';
        }, $ids))));
    }

    private static function sourcePath(): string
    {
        return (string) config(
            'platform.ui_reference.active_batch_review_source_path',
            base_path('docs/08-active/change-queue.md'),
        );
    }

    private static function manifestPath(): string
    {
        return (string) config(
            'platform.ui_reference.active_batch_review_manifest_path',
            storage_path('framework/cache/data/active-batch-review-manifest.json'),
        );
    }
}
