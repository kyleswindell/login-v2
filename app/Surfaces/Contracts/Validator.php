<?php

declare(strict_types=1);

namespace App\Surfaces\Contracts;

/*
|--------------------------------------------------------------------------
| File: app/Surfaces/Contracts/Validator.php
| Purpose: Reports UI entry API contract shape and enum issues.
|--------------------------------------------------------------------------
|
| Validation reports issues without throwing. This keeps migration, scanner,
| and test tooling able to evaluate readiness without changing runtime
| behavior.
|
*/

final class Validator
{
    private const DISALLOWED_TOP_LEVEL_KEYS = [
        'api_layer',
        'build_tier',
        'Definitions',
        'depends_on',
        'examples',
        'reference',
        'required_live_examples',
        'review',
        'review_state',
        'testing',
    ];

    private const IDENTITY_TYPES = [
        'element',
        'component',
        'pattern',
    ];

    private const LIFECYCLE_STATUS = [
        'legacy',
        'legacy-compatible',
        'provisional',
        'approved',
        'deprecated',
        'internal',
        'planned',
    ];

    private const API_USAGE_LEVELS = [
        'public',
        'advanced',
        'internal',
        'deprecated',
        'pattern-only',
    ];

    private const ENFORCEMENT_MODE = [
        'legacy',
        'legacy-compatible',
        'provisional',
        'strict',
        'deprecated',
        'internal',
    ];

    private const INVALID_USAGE = [
        'throw',
        'warn',
        'log',
        'ignore',
    ];

    /*
    |--------------------------------------------------------------------------
    | Validate
    |--------------------------------------------------------------------------
    */

    public static function validate(array $surface, bool $requireIdentity = false): array
    {
        $issues = [];

        foreach (Defaults::topLevelKeys() as $key) {
            if (! array_key_exists($key, $surface)) {
                $issues[] = self::issue('error', $key, "Missing required top-level key [{$key}].");
            }
        }

        foreach (array_keys($surface) as $key) {
            if (in_array($key, self::DISALLOWED_TOP_LEVEL_KEYS, true)) {
                $issues[] = self::issue('error', $key, "Unsupported top-level key [{$key}]. Move reference, examples, testing, or review data out of contract.php.");
                continue;
            }

            if (! in_array($key, Defaults::topLevelKeys(), true)) {
                $issues[] = self::issue('warning', $key, "Unknown top-level key [{$key}].");
            }
        }

        $slug = self::stringValue($surface, 'identity.slug');

        if ($requireIdentity && $slug === '') {
            $issues[] = self::issue('error', 'identity.slug', 'identity.slug is required for production surface contracts.');
        } elseif ($slug === '') {
            $issues[] = self::issue('warning', 'identity.slug', 'identity.slug is empty. Fill this before treating the surface as production-ready.');
        }

        self::enum($issues, $surface, 'identity.type', self::IDENTITY_TYPES);
        self::enum($issues, $surface, 'lifecycle.status', self::LIFECYCLE_STATUS);
        self::enum($issues, $surface, 'api.usage_level', self::API_USAGE_LEVELS);
        self::enum($issues, $surface, 'enforcement.mode', self::ENFORCEMENT_MODE);
        self::enum($issues, $surface, 'enforcement.invalid_usage', self::INVALID_USAGE);

        return $issues;
    }

    /*
    |--------------------------------------------------------------------------
    | Enum Helpers
    |--------------------------------------------------------------------------
    */

    private static function enum(array &$issues, array $surface, string $path, array $allowed): void
    {
        $value = self::value($surface, $path);

        if (! is_string($value) || ! in_array($value, $allowed, true)) {
            $issues[] = self::issue('error', $path, "Invalid value for {$path}.");
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Value Helpers
    |--------------------------------------------------------------------------
    */

    private static function value(array $surface, string $path, mixed $default = null): mixed
    {
        $current = $surface;

        foreach (explode('.', $path) as $segment) {
            if (! is_array($current) || ! array_key_exists($segment, $current)) {
                return $default;
            }

            $current = $current[$segment];
        }

        return $current;
    }

    private static function stringValue(array $surface, string $path): string
    {
        $value = self::value($surface, $path, '');

        return is_string($value) ? trim($value) : '';
    }

    private static function issue(string $level, string $path, string $message): array
    {
        return [
            'level' => $level,
            'path' => $path,
            'message' => $message,
        ];
    }
}
