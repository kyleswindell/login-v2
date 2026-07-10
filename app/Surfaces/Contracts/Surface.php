<?php

declare(strict_types=1);

namespace App\Surfaces\Contracts;

/*
|--------------------------------------------------------------------------
| File: app/Surfaces/Contracts/Surface.php
| Purpose: Public factory for UI entry API contracts.
|--------------------------------------------------------------------------
|
| Surface provides profile helpers for contract.php files. These helpers reduce
| repeated boilerplate while still returning the normalized public API contract
| shape used by Elements, Components, and Patterns.
|
| This class does not render UI, handle requests, define evidence pages, create
| examples, or replace Laravel Blade components.
|
*/

final class Surface
{
    /*
    |--------------------------------------------------------------------------
    | Base Surface
    |--------------------------------------------------------------------------
    */

    public static function base(array $overrides = []): array
    {
        return Normalizer::normalize($overrides, Defaults::base(), false);
    }

    /*
    |--------------------------------------------------------------------------
    | Foundation Element Surface
    |--------------------------------------------------------------------------
    */

    public static function element(array $overrides = []): array
    {
        return Normalizer::normalize($overrides, Defaults::element(), false);
    }

    /*
    |--------------------------------------------------------------------------
    | Component Surface
    |--------------------------------------------------------------------------
    */

    public static function component(array $overrides = []): array
    {
        return Normalizer::normalize($overrides, Defaults::component(), false);
    }

    /*
    |--------------------------------------------------------------------------
    | Pattern Surface
    |--------------------------------------------------------------------------
    */

    public static function pattern(array $overrides = []): array
    {
        return Normalizer::normalize($overrides, Defaults::pattern(), false);
    }
}
