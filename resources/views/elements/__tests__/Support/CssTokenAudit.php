<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| File: tests/Ui/Elements/Support/CssTokenAudit.php
| Purpose: Shared UI standards audit helpers.
|--------------------------------------------------------------------------
|
| Provides reusable file discovery, CSS declaration parsing, token assertion,
| report-only baseline, icon manifest, Blade utility, theme, and motion scan
| helpers for UI Element test requirements.
|
*/

namespace Tests\Ui\Elements\Support;

use PHPUnit\Framework\Assert;

final class CssTokenAudit
{
    /**
     * @return list<string>
     */
    public static function cssFiles(string $path): array
    {
        $absolutePath = self::absolutePath($path);

        if (! file_exists($absolutePath)) {
            return [];
        }

        if (is_file($absolutePath)) {
            return [self::relativePath($absolutePath)];
        }

        $files = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($absolutePath, \FilesystemIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if (! $file instanceof \SplFileInfo || ! $file->isFile()) {
                continue;
            }

            if (strtolower($file->getExtension()) === 'css') {
                $files[] = self::relativePath($file->getPathname());
            }
        }

        sort($files);

        return $files;
    }

    public static function read(string $path): string
    {
        $absolutePath = self::absolutePath($path);

        Assert::assertFileExists($absolutePath, "{$path} must exist.");

        $contents = file_get_contents($absolutePath);

        Assert::assertIsString($contents, "Unable to read {$path}.");

        return $contents;
    }

    public static function assertStandardAndContractAreAligned(string $slug, string $standardPath): void
    {
        $contract = self::contract($slug);

        Assert::assertFileExists(
            self::absolutePath($standardPath),
            "{$slug} standard must exist before tests assert hard-coded role names."
        );

        Assert::assertSame(
            $slug,
            $contract['identity']['slug'] ?? null,
            "{$slug} runtime contract identity drifted from its test target."
        );

        Assert::assertContains(
            $standardPath,
            $contract['source']['docs'] ?? [],
            "{$slug} runtime contract must reference {$standardPath}; otherwise fail as contract drift instead of guessing."
        );
    }

    /**
     * @param list<string> $imports
     */
    public static function assertImports(string $path, array $imports): void
    {
        $actualImports = self::imports($path);

        foreach ($imports as $import) {
            Assert::assertContains(
                $import,
                $actualImports,
                "{$path} must import {$import}."
            );
        }
    }

    /**
     * @return list<string>
     */
    public static function imports(string $path): array
    {
        $css = self::read($path);

        preg_match_all(
            '/@import\s+(?:url\()?["\'](?P<import>[^"\']+)["\']\)?(?:\s+layer\([^)]+\))?\s*;/',
            $css,
            $matches
        );

        return $matches['import'] ?? [];
    }

    /**
     * @param list<string> $tokens
     */
    public static function assertDefinesTokens(string $path, array $tokens): void
    {
        $css = self::read($path);

        foreach ($tokens as $token) {
            Assert::assertMatchesRegularExpression(
                '/' . preg_quote($token, '/') . '\s*:/',
                $css,
                "{$path} must define {$token}."
            );
        }
    }

    /**
     * @param list<string> $tokens
     */
    public static function assertUsesTokens(string $path, array $tokens): void
    {
        $css = self::read($path);

        foreach ($tokens as $token) {
            Assert::assertMatchesRegularExpression(
                '/var\(\s*' . preg_quote($token, '/') . '(?:\s*[,\)])/',
                $css,
                "{$path} must consume {$token}."
            );
        }
    }

    /**
     * @param list<string> $paths
     * @param list<string> $extensions
     * @return list<string>
     */
    public static function files(array $paths, array $extensions): array
    {
        $files = [];
        $extensionMap = self::extensionMap($extensions);

        foreach ($paths as $path) {
            $absolutePath = self::absolutePath($path);

            if (! file_exists($absolutePath)) {
                continue;
            }

            if (is_file($absolutePath)) {
                $relativePath = self::relativePath($absolutePath);

                if (self::matchesExtension($relativePath, $extensionMap)) {
                    $files[] = $relativePath;
                }

                continue;
            }

            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($absolutePath, \FilesystemIterator::SKIP_DOTS)
            );

            foreach ($iterator as $file) {
                if (! $file instanceof \SplFileInfo || ! $file->isFile()) {
                    continue;
                }

                $relativePath = self::relativePath($file->getPathname());

                if (self::matchesExtension($relativePath, $extensionMap)) {
                    $files[] = $relativePath;
                }
            }
        }

        sort($files);

        return array_values(array_unique($files));
    }

    /**
     * @param list<string> $paths
     * @param list<string> $extensions
     * @return array<string, int>
     */
    public static function patternCountsByBucket(
        array $paths,
        string $pattern,
        array $extensions,
        int $bucketSegments = 3
    ): array {
        $counts = [];

        foreach (self::files($paths, $extensions) as $file) {
            $matchCount = preg_match_all($pattern, self::read($file));

            if ($matchCount === false || $matchCount === 0) {
                continue;
            }

            $bucket = self::bucket($file, $bucketSegments);
            $counts[$bucket] = ($counts[$bucket] ?? 0) + $matchCount;
        }

        ksort($counts);

        return $counts;
    }

    /**
     * @param array<string, int> $actualCounts
     */
    public static function assertNoNewReportOnlyCountFindings(
        string $baselinePath,
        array $actualCounts,
        string $label
    ): void {
        $baseline = self::baseline($baselinePath);

        $newFindings = [];

        foreach ($actualCounts as $bucket => $count) {
            $allowedCount = (int) ($baseline[$bucket] ?? 0);

            if ($count > $allowedCount) {
                $newFindings[] = "{$bucket}: {$count} found, {$allowedCount} baselined";
            }
        }

        Assert::assertSame(
            [],
            $newFindings,
            "{$label} introduced new unbaselined report-only findings. Update the source, or intentionally update the stable baseline artifact."
        );
    }

    /**
     * @param list<string> $actualItems
     */
    public static function assertNoNewReportOnlyItems(string $baselinePath, array $actualItems, string $label): void
    {
        $baselineItems = self::baselineList($baselinePath);

        $actualItems = array_values(array_unique($actualItems));
        sort($actualItems);

        Assert::assertSame(
            [],
            array_values(array_diff($actualItems, $baselineItems)),
            "{$label} introduced new unbaselined report-only findings. Update the source, or intentionally update the stable baseline artifact."
        );
    }

    /**
     * @param list<string> $actualItems
     * @return list<string>
     */
    public static function staleReportOnlyBaselineItems(string $baselinePath, array $actualItems): array
    {
        $baselineItems = self::baselineList($baselinePath);

        $actualItems = array_values(array_unique($actualItems));
        sort($actualItems);

        return array_values(array_diff($baselineItems, $actualItems));
    }

    /**
     * @param list<string> $paths
     * @return list<array{path:string,line:int,property:string,value:string}>
     */
    public static function declarations(array $paths): array
    {
        $declarations = [];

        foreach ($paths as $path) {
            foreach (self::cssFiles($path) as $cssFile) {
                $css = self::read($cssFile);
                $scanCss = self::stripCommentsPreservingLines($css);

                preg_match_all(
                    '/(?P<property>--[-a-zA-Z0-9]+|-?[a-zA-Z][-\w]*)\s*:\s*(?P<value>(?:[^;{}]|\([^)]*\))+);/m',
                    $scanCss,
                    $matches,
                    PREG_SET_ORDER | PREG_OFFSET_CAPTURE
                );

                foreach ($matches as $match) {
                    $declarations[] = [
                        'path' => $cssFile,
                        'line' => substr_count(substr($scanCss, 0, $match[0][1]), "\n") + 1,
                        'property' => strtolower($match['property'][0]),
                        'value' => self::normalizeValue($match['value'][0]),
                    ];
                }
            }
        }

        return $declarations;
    }

    /**
     * @param list<string> $paths
     * @return list<array{path:string,line:int,property:string,value:string}>
     */
    public static function rawColorDeclarations(array $paths): array
    {
        return array_values(array_filter(
            self::declarations($paths),
            static fn(array $declaration): bool => self::containsRawColorValue($declaration['value'])
        ));
    }

    /**
     * @param list<string> $paths
     * @return list<array{path:string,line:int,property:string,value:string}>
     */
    public static function primitivePaletteColorDeclarations(array $paths): array
    {
        return array_values(array_filter(
            self::declarations($paths),
            static fn(array $declaration): bool => preg_match(
                '/var\(\s*--ui-(?:white|black|gray|red|orange|yellow|green|blue|purple|cyan|magenta)(?:-[\w-]+)?(?:\s*[,\)])/',
                $declaration['value']
            ) === 1
        ));
    }

    /**
     * @param list<string> $paths
     * @return list<array{path:string,line:int,property:string,value:string}>
     */
    public static function rawTypeDeclarations(array $paths): array
    {
        $typeProperties = [
            'font' => true,
            'font-family' => true,
            'font-size' => true,
            'font-weight' => true,
            'line-height' => true,
            'letter-spacing' => true,
        ];

        return array_values(array_filter(
            self::declarations($paths),
            static function (array $declaration) use ($typeProperties): bool {
                if (! isset($typeProperties[$declaration['property']])) {
                    return false;
                }

                if (self::isAllowedTypeValue($declaration['value'])) {
                    return false;
                }

                if (self::usesApprovedTypeTokenWithoutRawFallback($declaration['value'])) {
                    return false;
                }

                return self::containsRawTypeValue($declaration['property'], $declaration['value']);
            }
        ));
    }

    /**
     * @param list<string> $paths
     * @return list<array{path:string,line:int,property:string,value:string}>
     */
    public static function rawMotionDeclarations(array $paths): array
    {
        return array_values(array_filter(
            self::declarations($paths),
            static function (array $declaration): bool {
                if (
                    ! str_starts_with($declaration['property'], 'animation')
                    && ! str_starts_with($declaration['property'], 'transition')
                ) {
                    return false;
                }

                if (
                    str_contains($declaration['value'], 'var(--ui-duration-')
                    || str_contains($declaration['value'], 'var(--ui-motion-')
                    || str_contains($declaration['value'], 'var(--ui-transition-')
                ) {
                    return false;
                }

                return preg_match(
                    '/\b\d+(?:\.\d+)?m?s\b|cubic-bezier\(|steps\(|ease(?:-in-out|-in|-out)?\b|linear\b/i',
                    $declaration['value']
                ) === 1;
            }
        ));
    }

    /**
     * @param list<string> $paths
     * @return list<array{path:string,line:int,property:string,value:string}>
     */
    public static function rawSpacingDeclarations(array $paths): array
    {
        $spacingProperties = [
            'gap' => true,
            'column-gap' => true,
            'row-gap' => true,
            'inset' => true,
            'inset-block' => true,
            'inset-block-start' => true,
            'inset-block-end' => true,
            'inset-inline' => true,
            'inset-inline-start' => true,
            'inset-inline-end' => true,
            'top' => true,
            'right' => true,
            'bottom' => true,
            'left' => true,
            'margin' => true,
            'margin-block' => true,
            'margin-block-start' => true,
            'margin-block-end' => true,
            'margin-inline' => true,
            'margin-inline-start' => true,
            'margin-inline-end' => true,
            'padding' => true,
            'padding-block' => true,
            'padding-block-start' => true,
            'padding-block-end' => true,
            'padding-inline' => true,
            'padding-inline-start' => true,
            'padding-inline-end' => true,
        ];

        return array_values(array_filter(
            self::declarations($paths),
            static function (array $declaration) use ($spacingProperties): bool {
                if (! isset($spacingProperties[$declaration['property']])) {
                    return false;
                }

                if (self::isAllowedStructuralSpacingValue($declaration['value'])) {
                    return false;
                }

                if (self::usesApprovedSpacingToken($declaration['value'])) {
                    return false;
                }

                return self::containsRawSpacingValue($declaration['value']);
            }
        ));
    }

    /**
     * @param list<string> $paths
     * @return list<string>
     */
    public static function mediaQueryFindings(array $paths): array
    {
        $findings = [];

        foreach (self::files($paths, ['.css']) as $file) {
            $css = self::read($file);

            preg_match_all(
                '/@media\s+[^{]*(?:min|max|width|inline-size)[^{]+/i',
                $css,
                $matches,
                PREG_OFFSET_CAPTURE,
            );

            foreach ($matches[0] as $match) {
                $matchedText = trim((string) ($match[0] ?? ''));
                $matchedOffset = (int) ($match[1] ?? 0);
                $line = substr_count(substr($css, 0, $matchedOffset), "\n") + 1;

                $findings[] = "{$file}:{$line} {$matchedText}";
            }
        }

        sort($findings);

        return array_values(array_unique($findings));
    }

    public static function assertAttributePresent(string $html, string $attribute, string $message = ''): void
    {
        Assert::assertMatchesRegularExpression(
            '/\s' . preg_quote($attribute, '/') . '(?:\s|=|>)/',
            $html,
            $message !== '' ? $message : "Expected rendered HTML to include [{$attribute}].",
        );
    }

    /**
     * @param list<string> $paths
     * @return list<string>
     */
    public static function javaScriptTimingFindings(array $paths): array
    {
        $findings = [];

        foreach (self::files($paths, ['.js', '.ts']) as $file) {
            $contents = self::read($file);
            $patterns = [
                '/\bsetTimeout\s*\([^,\n]+,\s*(?P<value>\d{2,6})\s*\)/',
                '/\bsetInterval\s*\([^,\n]+,\s*(?P<value>\d{2,6})\s*\)/',
                '/\b(?:delay|duration|timeout|interval|debounce|throttle)[A-Za-z0-9_]*\s*[:=]\s*(?P<value>\d{2,6})\b/',
                '/\b(?:enterDelayMs|leaveDelayMs)\s*[:=]\s*(?P<value>\d{2,6})\b/',
            ];

            foreach ($patterns as $pattern) {
                preg_match_all($pattern, $contents, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);

                foreach ($matches as $match) {
                    $line = substr_count(substr($contents, 0, $match[0][1]), "\n") + 1;
                    $value = $match['value'][0] ?? '';

                    $findings[] = "{$file}:{$line} timing {$value}ms";
                }
            }
        }

        sort($findings);

        return array_values(array_unique($findings));
    }

    /**
     * @param list<string> $paths
     * @return list<string>
     */
    public static function tailwindColorUtilityFindings(array $paths): array
    {
        return self::utilityClassFindings($paths, [
            '/^(?:text|bg|border|ring|outline|decoration|divide|from|via|to)-(?:slate|gray|zinc|neutral|stone|red|orange|amber|yellow|lime|green|emerald|teal|cyan|sky|blue|indigo|violet|purple|fuchsia|pink|rose|white|black)(?:-\d{2,3})?(?:\/\d+)?$/',
        ]);
    }

    /**
     * @param list<string> $paths
     * @return list<string>
     */
    public static function tailwindTypographyUtilityFindings(array $paths): array
    {
        return self::utilityClassFindings($paths, [
            '/^text-(?:xs|sm|base|lg|xl|[2-9]xl)$/',
            '/^font-(?:thin|extralight|light|normal|medium|semibold|bold|extrabold|black|\[[^\]]+\])$/',
            '/^leading-(?:none|tight|snug|normal|relaxed|loose|\d+|\[[^\]]+\])$/',
            '/^tracking-(?:tighter|tight|normal|wide|wider|widest|\[[^\]]+\])$/',
        ]);
    }

    /**
     * @param list<string> $paths
     * @return list<string>
     */
    public static function tailwindSpacingUtilityFindings(array $paths): array
    {
        return self::utilityClassFindings($paths, [
            '/^(?:m|mx|my|mt|mr|mb|ml|p|px|py|pt|pr|pb|pl|gap|gap-x|gap-y|space-x|space-y|inset|inset-x|inset-y|top|right|bottom|left)-(?:\d+|px|auto|\[[^\]]+\])$/',
            '/^(?:w|h|min-w|min-h|max-w|max-h|size)-(?:\d+|px|full|screen|min|max|fit|auto|\[[^\]]+\])$/',
        ]);
    }

    /**
     * @param list<string> $paths
     * @return list<string>
     */
    public static function dynamicIconApiFindings(array $paths): array
    {
        $findings = [];

        foreach (self::files($paths, ['.blade.php', '.php']) as $file) {
            $contents = self::read($file);

            $patterns = [
                'dynamic component icon' => '/<x-dynamic-component\b[^>]*:(?:component|is)=["\'][^"\']*(?:icon|Icon|chevronIcon|leadingIcon|trailingIcon)[^"\']*["\'][^>]*>/',
                'x-layouts.nav-icon' => '/<x-layouts\.nav-icon\b/',
                'x-icons usage' => '/<x-icons\.[\w.-]+/',
                'icons.* dynamic alias' => '/(?:^|\s)(?::?icon|chevron-icon|chevronIcon|leading-icon|trailing-icon)=["\']icons\.[^"\']+["\']/',
            ];

            foreach ($patterns as $label => $pattern) {
                preg_match_all($pattern, $contents, $matches, PREG_OFFSET_CAPTURE);

                foreach ($matches[0] as $match) {
                    $line = substr_count(substr($contents, 0, $match[1]), "\n") + 1;
                    $findings[] = "{$file}:{$line} {$label}";
                }
            }
        }

        sort($findings);

        return array_values(array_unique($findings));
    }

    /**
     * @param list<string> $paths
     * @param list<string> $classPatterns
     * @return list<string>
     */
    public static function utilityClassFindings(array $paths, array $classPatterns): array
    {
        $findings = [];

        foreach (self::files($paths, ['.blade.php', '.php']) as $file) {
            $contents = self::read($file);

            preg_match_all(
                '/(?P<quote>["\'])(?P<classes>(?:[^"\']|\{\{.*?\}\}|@\w+\(.*?\))+)(?P=quote)/s',
                $contents,
                $matches,
                PREG_SET_ORDER | PREG_OFFSET_CAPTURE
            );

            foreach ($matches as $match) {
                $rawValue = $match['classes'][0];

                if (! self::looksLikeClassList($rawValue)) {
                    continue;
                }

                $line = substr_count(substr($contents, 0, $match[0][1]), "\n") + 1;
                $classes = preg_split('/\s+/', trim($rawValue)) ?: [];

                foreach ($classes as $class) {
                    $class = trim($class, " \t\n\r\0\x0B,[]=>");

                    if ($class === '' || str_contains($class, '$') || str_contains($class, '{{')) {
                        continue;
                    }

                    foreach ($classPatterns as $pattern) {
                        if (preg_match($pattern, $class) === 1) {
                            $findings[] = "{$file}:{$line} {$class}";
                            break;
                        }
                    }
                }
            }
        }

        sort($findings);

        return array_values(array_unique($findings));
    }

    /**
     * @param list<array{path:string,line:int,property:string,value:string}> $declarations
     * @param list<array{label:string,path?:string,property?:string,value?:string}> $rules
     */
    public static function assertAllDeclarationsAreCategorized(array $declarations, array $rules): void
    {
        $uncategorized = [];

        foreach ($declarations as $declaration) {
            if (! self::isCategorized($declaration, $rules)) {
                $uncategorized[] = $declaration;
            }
        }

        Assert::assertSame(
            [],
            self::formatDeclarations($uncategorized),
            'Found uncategorized CSS token-governance drift. Add a narrow rule with a reason, or fix the source to use the correct token.'
        );
    }

    /**
     * @param list<array{path:string,line:int,property:string,value:string}> $declarations
     * @return list<string>
     */
    public static function formatDeclarations(array $declarations): array
    {
        return array_map(
            static fn(array $declaration): string => "{$declaration['path']}:{$declaration['line']} {$declaration['property']}: {$declaration['value']}",
            $declarations
        );
    }

    /**
     * @return array<string, mixed>
     */
    public static function contract(string $slug): array
    {
        $contract = require self::absolutePath("resources/views/elements/{$slug}/contract.php");

        Assert::assertIsArray($contract);

        return $contract;
    }

    /**
     * @return array<string, mixed>
     */
    public static function iconManifest(?string $manifestPath = null): array
    {
        $resolvedManifestPath = $manifestPath
            ?? (string) config('ui-icons.sets.' . config('ui-icons.default_set', 'carbon') . '.manifest');

        Assert::assertFileExists(
            self::absolutePath($resolvedManifestPath),
            'Generated icon manifest must exist.'
        );

        $manifest = require self::absolutePath($resolvedManifestPath);

        Assert::assertIsArray($manifest, 'Generated icon manifest must return an array.');

        return $manifest;
    }

    /**
     * @param list<string> $iconNames
     */
    public static function assertIconManifestContains(array $iconNames, ?string $manifestPath = null): void
    {
        $manifest = self::iconManifest($manifestPath);

        foreach ($iconNames as $iconName) {
            Assert::assertArrayHasKey(
                $iconName,
                $manifest,
                "Generated icon manifest must include [{$iconName}]."
            );

            Assert::assertIsArray($manifest[$iconName]);
            Assert::assertArrayHasKey('default', $manifest[$iconName]);
            Assert::assertArrayHasKey('sources', $manifest[$iconName]);
        }
    }

    public static function assertIconRuntimeConfigIsValid(): void
    {
        $defaultSet = (string) config('ui-icons.default_set', 'carbon');
        $setConfig = config("ui-icons.sets.{$defaultSet}");

        Assert::assertIsArray($setConfig, "Default icon set [{$defaultSet}] must be configured.");
        Assert::assertArrayHasKey('path', $setConfig);
        Assert::assertArrayHasKey('manifest', $setConfig);

        Assert::assertDirectoryExists(
            self::absolutePath((string) $setConfig['path']),
            "Icon source path for [{$defaultSet}] must exist."
        );

        Assert::assertFileExists(
            self::absolutePath((string) $setConfig['manifest']),
            "Icon manifest for [{$defaultSet}] must exist."
        );
    }

    /**
     * @param list<string> $themeFiles
     * @param list<string> $ignoredRoles
     */
    public static function assertThemeFilesExposeSameRoleKeys(array $themeFiles, array $ignoredRoles = []): void
    {
        $roleSets = [];
        $ignoredRoleMap = array_fill_keys($ignoredRoles, true);

        foreach ($themeFiles as $themeFile) {
            $roles = array_filter(
                self::customPropertyNames($themeFile),
                static fn(string $role): bool => ! isset($ignoredRoleMap[$role])
            );

            sort($roles);

            $roleSets[$themeFile] = array_values($roles);
        }

        $referenceFile = array_key_first($roleSets);

        Assert::assertIsString($referenceFile, 'At least one theme file is required for role-key comparison.');

        $referenceRoles = $roleSets[$referenceFile];

        foreach ($roleSets as $themeFile => $roles) {
            Assert::assertSame(
                $referenceRoles,
                $roles,
                "{$themeFile} role keys must match {$referenceFile}."
            );
        }
    }

    /**
     * @return list<string>
     */
    public static function customPropertyNames(string $path): array
    {
        $css = self::stripCommentsPreservingLines(self::read($path));

        preg_match_all('/(?P<property>--[-a-zA-Z0-9]+)\s*:/', $css, $matches);

        $properties = array_values(array_unique($matches['property'] ?? []));

        sort($properties);

        return $properties;
    }

    private static function containsRawColorValue(string $value): bool
    {
        if (preg_match('/(?<![\w-])#(?:[0-9a-fA-F]{3,8})\b/', $value) === 1) {
            return true;
        }

        if (preg_match('/(?<![\w-])(?:rgba?|hsla?|hwb|lab|lch|oklab|oklch|color-mix)\([^)]*\)/i', $value) === 1) {
            return true;
        }

        return preg_match('/(?<![\w-])(?:aliceblue|antiquewhite|aqua|aquamarine|azure|beige|bisque|black|blanchedalmond|blue|blueviolet|brown|burlywood|cadetblue|chartreuse|chocolate|coral|cornflowerblue|cornsilk|crimson|cyan|darkblue|darkcyan|darkgoldenrod|darkgray|darkgreen|darkgrey|darkkhaki|darkmagenta|darkolivegreen|darkorange|darkorchid|darkred|darksalmon|darkseagreen|darkslateblue|darkslategray|darkslategrey|darkturquoise|darkviolet|deeppink|deepskyblue|dimgray|dimgrey|dodgerblue|firebrick|floralwhite|forestgreen|fuchsia|gainsboro|ghostwhite|gold|goldenrod|gray|green|greenyellow|grey|honeydew|hotpink|indianred|indigo|ivory|khaki|lavender|lavenderblush|lawngreen|lemonchiffon|lightblue|lightcoral|lightcyan|lightgoldenrodyellow|lightgray|lightgreen|lightgrey|lightpink|lightsalmon|lightseagreen|lightskyblue|lightslategray|lightslategrey|lightsteelblue|lightyellow|lime|limegreen|linen|magenta|maroon|mediumaquamarine|mediumblue|mediumorchid|mediumpurple|mediumseagreen|mediumslateblue|mediumspringgreen|mediumturquoise|mediumvioletred|midnightblue|mintcream|mistyrose|moccasin|navajowhite|navy|oldlace|olive|olivedrab|orange|orangered|orchid|palegoldenrod|palegreen|paleturquoise|palevioletred|papayawhip|peachpuff|peru|pink|plum|powderblue|purple|rebeccapurple|red|rosybrown|royalblue|saddlebrown|salmon|sandybrown|seagreen|seashell|sienna|silver|skyblue|slateblue|slategray|slategrey|snow|springgreen|steelblue|tan|teal|thistle|tomato|turquoise|violet|wheat|white|whitesmoke|yellow|yellowgreen)(?![\w-])/i', $value) === 1;
    }

    private static function isAllowedTypeValue(string $value): bool
    {
        return preg_match('/^(?:inherit|normal|none|0)$/i', $value) === 1;
    }

    private static function usesApprovedTypeTokenWithoutRawFallback(string $value): bool
    {
        return preg_match('/^var\(\s*--ui-(?:type|font)-[\w-]+\s*\)$/', $value) === 1;
    }

    private static function isAllowedStructuralSpacingValue(string $value): bool
    {
        return preg_match(
            '/^(?:0|0px|0rem|auto|none|normal|inherit|initial|unset|100%|100vh|100vw|fit-content|max-content|min-content)$/i',
            $value
        ) === 1;
    }

    private static function usesApprovedSpacingToken(string $value): bool
    {
        return preg_match(
            '/var\(\s*--(?:ui-)?(?:spacing|fluid-spacing|layout|container|size|grid)-[\w-]+/',
            $value
        ) === 1;
    }

    private static function containsRawSpacingValue(string $value): bool
    {
        return preg_match(
            '/(?<![-\w])(?:-?\d+(?:\.\d+)?(?:px|rem|em|vh|vw|vmin|vmax|ch|ex)|calc\([^)]*\d+(?:\.\d+)?(?:px|rem|em|vh|vw|vmin|vmax|ch|ex)[^)]*\))(?![-\w])/i',
            $value
        ) === 1;
    }

    private static function containsRawTypeValue(string $property, string $value): bool
    {
        if ($property === 'font-family' || $property === 'font') {
            if (preg_match('/["\'][^"\']+["\']|(?<![-\w])(?:Arial|Helvetica|Inter|Roboto|Georgia|Times|Verdana|monospace|serif|sans-serif)(?![-\w])/i', $value) === 1) {
                return true;
            }
        }

        if ($property === 'font-weight' || $property === 'font') {
            if (preg_match('/(?<![-\w])(?:[1-9]00|bold|bolder|lighter)(?![-\w])/i', $value) === 1) {
                return true;
            }
        }

        if (in_array($property, ['font-size', 'line-height', 'letter-spacing', 'font'], true)) {
            if (preg_match('/(?<![-\w])\d+(?:\.\d+)?(?:px|rem|em|%|ch|ex|lh|rlh)?(?![-\w])/', $value) === 1) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array<string, mixed> $declaration
     * @param list<array{label:string,path?:string,property?:string,value?:string}> $rules
     */
    private static function isCategorized(array $declaration, array $rules): bool
    {
        foreach ($rules as $rule) {
            if (isset($rule['path']) && preg_match($rule['path'], (string) $declaration['path']) !== 1) {
                continue;
            }

            if (isset($rule['property']) && preg_match($rule['property'], (string) $declaration['property']) !== 1) {
                continue;
            }

            if (isset($rule['value']) && preg_match($rule['value'], (string) $declaration['value']) !== 1) {
                continue;
            }

            return true;
        }

        return false;
    }

    private static function stripCommentsPreservingLines(string $css): string
    {
        return (string) preg_replace_callback(
            '/\/\*.*?\*\//s',
            static fn(array $match): string => str_repeat("\n", substr_count($match[0], "\n")),
            $css
        );
    }

    private static function normalizeValue(string $value): string
    {
        return trim((string) preg_replace('/\s+/', ' ', $value));
    }

    /**
     * @param list<string> $extensions
     * @return array<string, bool>
     */
    private static function extensionMap(array $extensions): array
    {
        $map = [];

        foreach ($extensions as $extension) {
            $normalized = strtolower($extension);
            $normalized = str_starts_with($normalized, '.') ? $normalized : '.' . $normalized;

            $map[$normalized] = true;
        }

        return $map;
    }

    /**
     * @param array<string, bool> $extensionMap
     */
    private static function matchesExtension(string $path, array $extensionMap): bool
    {
        $lowerPath = strtolower($path);

        foreach (array_keys($extensionMap) as $extension) {
            if (str_ends_with($lowerPath, $extension)) {
                return true;
            }
        }

        return false;
    }

    private static function bucket(string $path, int $segments): string
    {
        $parts = explode('/', str_replace('\\', '/', $path));

        if (count($parts) < $segments) {
            return $path;
        }

        return implode('/', array_slice($parts, 0, $segments));
    }

    /**
     * @return array<string, mixed>
     */
    private static function baseline(string $baselinePath): array
    {
        $absolutePath = self::absolutePath($baselinePath);

        Assert::assertFileExists($absolutePath, "{$baselinePath} must exist as a stable report-only baseline artifact.");

        $baseline = require $absolutePath;

        Assert::assertIsArray($baseline, "{$baselinePath} must return a stable report-only baseline array.");

        return $baseline;
    }

    /**
     * @return list<string>
     */
    private static function baselineList(string $baselinePath): array
    {
        $baseline = self::baseline($baselinePath);

        $items = array_values(array_unique(array_map('strval', $baseline)));
        sort($items);

        return $items;
    }

    private static function looksLikeClassList(string $value): bool
    {
        return preg_match('/(?:^|\s)(?:[a-z0-9_-]+:)*[a-z][a-z0-9_-]*(?:-\[[^\]]+\])?(?:\s|$)/i', $value) === 1;
    }

    private static function absolutePath(string $path): string
    {
        if ($path === '') {
            return base_path();
        }

        if (str_starts_with($path, DIRECTORY_SEPARATOR) || preg_match('/^[A-Za-z]:[\\\\\/]/', $path) === 1) {
            return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
        }

        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, base_path($path));
    }

    private static function relativePath(string $path): string
    {
        $normalizedPath = str_replace('\\', '/', $path);
        $base = rtrim(str_replace('\\', '/', base_path()), '/') . '/';

        return str_starts_with($normalizedPath, $base)
            ? substr($normalizedPath, strlen($base))
            : $normalizedPath;
    }
}
