<?php

namespace App\Support;

final class ActiveBatchReviewQueue
{
    private static ?array $implementedPendingReviewIds = null;

    /**
     * @return list<string>
     */
    public static function implementedPendingReviewIds(): array
    {
        if (self::$implementedPendingReviewIds !== null) {
            return self::$implementedPendingReviewIds;
        }

        $path = base_path('docs/08-active/change-queue.md');

        if (! is_file($path)) {
            return self::$implementedPendingReviewIds = [];
        }

        $contents = file_get_contents($path);

        if ($contents === false) {
            return self::$implementedPendingReviewIds = [];
        }

        if (! preg_match('/^## Implemented Pending Review\s*$(.*?)(?=^##\s|\z)/ms', $contents, $matches)) {
            return self::$implementedPendingReviewIds = [];
        }

        preg_match_all('/^\s*ID:\s*([A-Z0-9-]+)/m', $matches[1], $idMatches);

        return self::$implementedPendingReviewIds = array_values(array_unique($idMatches[1] ?? []));
    }
}
