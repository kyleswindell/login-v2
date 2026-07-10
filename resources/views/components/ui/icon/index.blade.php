{{-- ==========================================================================
    File: resources/views/components/ui/icon/index.blade.php
    Purpose: Canonical SVG icon renderer.

    Notes:
    - Loads trusted local SVG files from the generated icon manifest.
    - Does not use x-dynamic-component.
    - Unknown icon names render the configured empty icon/fallback shell.
    - Supports size, decorative icons, aria-label, and aria-labelledby.
    - SVG body markup must come only from trusted local SVG files.
    ========================================================================== --}}

@props([
    /*
    |--------------------------------------------------------------------------
    | Icon identity
    |--------------------------------------------------------------------------
    */

    'name' => null,
    'fallback' => null,

    /*
    |--------------------------------------------------------------------------
    | Size / accessibility
    |--------------------------------------------------------------------------
    */

    'size' => 'md',
    'decorative' => true,
    'label' => null,
    'labelledby' => null,
])

@php
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Resolve configuration
    |--------------------------------------------------------------------------
    */

    $set = (string) config('ui-icons.default_set', 'carbon');
    $setConfig = (array) config("ui-icons.sets.{$set}", []);

    $sourcePath = (string) ($setConfig['path'] ?? resource_path('views/components/icons/src/svg'));
    $manifestPath = (string) ($setConfig['manifest'] ?? $sourcePath.'/manifest.php');

    $manifest = is_file($manifestPath) ? require $manifestPath : [];

    $sizes = (array) config('ui-icons.sizes', [
        'xs' => 12,
        'sm' => 16,
        'md' => 16,
        'lg' => 20,
        'xl' => 24,
        '2xl' => 32,
    ]);

    /*
    |--------------------------------------------------------------------------
    | Resolve request
    |--------------------------------------------------------------------------
    |
    | Icon names are intentionally exact. Do not add broad aliases here.
    | Navigation/config should use canonical Carbon icon names.
    |
    */

    $requestedName = is_string($name) ? trim($name) : '';
    $fallbackName = is_string($fallback) && trim($fallback) !== ''
        ? trim($fallback)
        : (string) config('ui-icons.fallback', 'empty');

    $resolvedSize = is_string($size) && array_key_exists($size, $sizes)
        ? $size
        : 'md';

    $resolvedPixelSize = (int) ($sizes[$resolvedSize] ?? 16);

    $hasRequestedIcon = $requestedName !== ''
        && is_array($manifest)
        && array_key_exists($requestedName, $manifest);

    $resolvedName = $hasRequestedIcon ? $requestedName : $fallbackName;

    $entry = is_array($manifest) ? ($manifest[$resolvedName] ?? null) : null;

    if (! is_array($entry) && $resolvedName !== $fallbackName) {
        $resolvedName = $fallbackName;
        $entry = is_array($manifest) ? ($manifest[$resolvedName] ?? null) : null;
    }

    $relativeFile = is_array($entry)
        ? ($entry['default'] ?? null)
        : null;

    $isMissing = ! $hasRequestedIcon;

    /*
    |--------------------------------------------------------------------------
    | Resolve trusted SVG file
    |--------------------------------------------------------------------------
    |
    | The requested icon name is never used directly as a file path.
    |
    */

    $sourceRoot = realpath($sourcePath);
    $iconPath = null;

    if (
        is_string($sourceRoot)
        && is_string($relativeFile)
        && $relativeFile !== ''
    ) {
        $candidatePath = realpath(
            $sourceRoot.DIRECTORY_SEPARATOR.str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relativeFile),
        );

        if (
            is_string($candidatePath)
            && str_starts_with($candidatePath, $sourceRoot.DIRECTORY_SEPARATOR)
            && is_file($candidatePath)
            && is_readable($candidatePath)
        ) {
            $iconPath = $candidatePath;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Read and cache SVG source for the current request
    |--------------------------------------------------------------------------
    */

    static $svgCache = [];

    $svgSource = false;

    if (is_string($iconPath)) {
        if (! array_key_exists($iconPath, $svgCache)) {
            $svgCache[$iconPath] = file_get_contents($iconPath);
        }

        $svgSource = $svgCache[$iconPath];
    }

    if (! is_string($svgSource)) {
        $svgSource = '<svg viewBox="0 0 16 16"><rect width="16" height="16" fill="none"></rect></svg>';
        $resolvedName = $fallbackName;
        $isMissing = true;
    }

    /*
    |--------------------------------------------------------------------------
    | Extract SVG viewBox and body
    |--------------------------------------------------------------------------
    |
    | The component owns the outer SVG element so sizing, classes, and
    | accessibility are consistent.
    |
    */

    preg_match('/<svg\b([^>]*)>(.*?)<\/svg>/is', $svgSource, $svgMatches);

    $svgAttributes = $svgMatches[1] ?? '';
    $svgBody = trim((string) ($svgMatches[2] ?? ''));

    preg_match('/\sviewBox=(["\'])(.*?)\1/i', $svgAttributes, $viewBoxMatches);

    $viewBox = $viewBoxMatches[2] ?? '0 0 16 16';

    if ($svgBody === '') {
        $svgBody = '<rect width="16" height="16" fill="none"></rect>';
        $resolvedName = $fallbackName;
        $isMissing = true;
    }

    /*
    |--------------------------------------------------------------------------
    | Accessibility
    |--------------------------------------------------------------------------
    */

    $hasAccessibleName = filled($label) || filled($labelledby);
    $isDecorative = ! $hasAccessibleName && (bool) $decorative;

    /*
    |--------------------------------------------------------------------------
    | Missing icon diagnostics
    |--------------------------------------------------------------------------
    */

    static $loggedMissingIcons = [];

    if (
        $isMissing
        && (bool) config('ui-icons.log_missing', true)
        && app()->environment(['local', 'testing'])
    ) {
        $missingKey = $requestedName !== '' ? $requestedName : '(empty)';

        if (! isset($loggedMissingIcons[$missingKey])) {
            $loggedMissingIcons[$missingKey] = true;

            Log::warning('Missing UI icon.', [
                'requested' => $requestedName,
                'fallback' => $fallbackName,
                'resolved' => $resolvedName,
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CSS class contract
    |--------------------------------------------------------------------------
    */

    $classes = [
        'ui-icon',
        'ui-icon--'.$resolvedSize,
        'ui-icon--missing' => $isMissing,
    ];
@endphp

<svg
    {{ $attributes->class($classes)->merge([
        'viewBox' => $viewBox,
        'width' => $resolvedPixelSize,
        'height' => $resolvedPixelSize,
        'focusable' => 'false',
        'preserveAspectRatio' => 'xMidYMid meet',
        'fill' => 'currentColor',
        'xmlns' => 'http://www.w3.org/2000/svg',
        'aria-hidden' => $isDecorative ? 'true' : null,
        'role' => $isDecorative ? null : 'img',
        'aria-label' => ! $isDecorative && filled($label) ? $label : null,
        'aria-labelledby' => ! $isDecorative && filled($labelledby) ? $labelledby : null,
        'data-ui-component' => 'icon',
        'data-ui-icon' => true,
        'data-ui-icon-name' => $resolvedName,
        'data-ui-icon-requested' => $requestedName,
        'data-ui-icon-size' => $resolvedSize,
        'data-ui-icon-missing' => $isMissing ? 'true' : 'false',
    ]) }}
>
    {!! new HtmlString($svgBody) !!}
</svg>