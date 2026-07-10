<?php

declare(strict_types=1);

namespace App\Surfaces\Contracts;

/*
|--------------------------------------------------------------------------
| File: app/Surfaces/Contracts/Normalizer.php
| Purpose: Normalizes UI entry API contract arrays.
|--------------------------------------------------------------------------
|
| Merge rules:
| - associative arrays merge recursively
| - list arrays replace instead of merging by numeric index
| - scalar values and null override defaults
|
| The normalizer can either strip unknown top-level keys for new profile-based
| contracts or preserve them while loading legacy migration contracts.
|
*/

final class Normalizer
{
    /*
    |--------------------------------------------------------------------------
    | Normalize
    |--------------------------------------------------------------------------
    */

    public static function normalize(
        array $overrides,
        ?array $defaults = null,
        bool $preserveUnknownTopLevel = false,
    ): array {
        $base = $defaults ?? Defaults::base();

        if (! $preserveUnknownTopLevel) {
            $overrides = self::onlyKnownTopLevel($overrides);
        }

        return self::merge($base, $overrides);
    }

    /*
    |--------------------------------------------------------------------------
    | Merge
    |--------------------------------------------------------------------------
    */

    public static function merge(array $defaults, array $overrides): array
    {
        foreach ($overrides as $key => $value) {
            if (
                array_key_exists($key, $defaults)
                && is_array($defaults[$key])
                && is_array($value)
                && ! self::isList($defaults[$key])
                && ! self::isList($value)
            ) {
                $defaults[$key] = self::merge($defaults[$key], $value);
                continue;
            }

            $defaults[$key] = $value;
        }

        return $defaults;
    }

    /*
    |--------------------------------------------------------------------------
    | Top-Level Filtering
    |--------------------------------------------------------------------------
    */

    private static function onlyKnownTopLevel(array $surface): array
    {
        return array_intersect_key($surface, array_flip(Defaults::topLevelKeys()));
    }

    /*
    |--------------------------------------------------------------------------
    | List Detection
    |--------------------------------------------------------------------------
    */

    private static function isList(array $value): bool
    {
        if ($value === []) {
            return true;
        }

        return array_keys($value) === range(0, count($value) - 1);
    }
}
