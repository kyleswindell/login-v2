<#
===============================================================================
File: scripts/generate-ui-icon-blades.ps1
Purpose: Generate app-owned Blade icon components from local SVG source files.

Notes:
- Reads raw SVG files from resources/views/components/ui/icons/src/svg.
- Writes Blade icon components directly to resources/views/components/ui/icons.
- Generated icons use neutral app-owned naming.
- Generated icons use .ui-icon only.
- Generated files do not include vendor/source-library labels.
- Cleans SVG export artifacts before writing Blade components.
- Use -IconListPath to generate a curated subset.
===============================================================================
#>

param(
    # Raw SVG source folder.
    [string] $SourceRoot = "resources/views/components/ui/icons/src/svg",

    # Output folder for generated Blade icon components.
    [string] $OutputRoot = "resources/views/components/ui/icons",

    # Optional plain-text list of icon source names to generate, one per line.
    # Example line: chevron--down
    [string] $IconListPath = "resources/views/components/ui/icons/icon-list.txt",

    # Generate additional size-specific files such as chevron-down-20.blade.php.
    [switch] $IncludeSizeVariants,

    # Overwrite existing generated Blade files.
    [switch] $Force
)

Set-StrictMode -Version Latest
$ErrorActionPreference = "Stop"

# -----------------------------------------------------------------------------
# Resolve paths
# -----------------------------------------------------------------------------

$ProjectRoot = (Get-Location).Path
$ResolvedSourceRoot = Join-Path $ProjectRoot $SourceRoot
$ResolvedOutputRoot = Join-Path $ProjectRoot $OutputRoot

if (-not (Test-Path $ResolvedSourceRoot)) {
    throw "Source SVG folder not found: $ResolvedSourceRoot"
}

if (-not (Test-Path $ResolvedOutputRoot)) {
    New-Item -ItemType Directory -Path $ResolvedOutputRoot -Force | Out-Null
}

# -----------------------------------------------------------------------------
# Optional curated icon list
# -----------------------------------------------------------------------------

$RequestedNames = $null

if ($IconListPath) {
    $ResolvedIconListPath = Join-Path $ProjectRoot $IconListPath
    $IconListWasExplicitlyProvided = $PSBoundParameters.ContainsKey("IconListPath")

    if (Test-Path $ResolvedIconListPath) {
        $RequestedNames = Get-Content $ResolvedIconListPath |
            ForEach-Object { $_.Trim() } |
            Where-Object { $_ -and -not $_.StartsWith("#") } |
            Sort-Object -Unique
    } elseif ($IconListWasExplicitlyProvided) {
        throw "Icon list file not found: $ResolvedIconListPath"
    }
}

# -----------------------------------------------------------------------------
# Naming helpers
# -----------------------------------------------------------------------------

function Convert-IconNameToBladeName {
    param(
        [Parameter(Mandatory = $true)]
        [string] $Name
    )

    # Source names may use double hyphens for modifiers. Blade component names
    # are cleaner with single-hyphen names.
    $BladeName = $Name.ToLowerInvariant()
    $BladeName = $BladeName -replace "--", "-"
    $BladeName = $BladeName -replace "[^a-z0-9\-]", "-"
    $BladeName = $BladeName -replace "-+", "-"
    $BladeName = $BladeName.Trim("-")

    # Blade component names should not start with a number.
    if ($BladeName -match "^[0-9]") {
        $BladeName = "icon-$BladeName"
    }

    return $BladeName
}

function Convert-IconNameToPurpose {
    param(
        [Parameter(Mandatory = $true)]
        [string] $BladeName
    )

    $Text = $BladeName -replace "-", " "
    return (Get-Culture).TextInfo.ToTitleCase($Text)
}

function Get-IconSizeFromPath {
    param(
        [Parameter(Mandatory = $true)]
        [System.IO.FileInfo] $File
    )

    # Size is usually the parent folder: 16, 20, 24, or 32.
    $ParentName = Split-Path $File.DirectoryName -Leaf

    if ($ParentName -match "^\d+$") {
        return [int] $ParentName
    }

    # Root-level SVGs usually declare their size in the viewBox.
    $RawSvg = Get-Content $File.FullName -Raw

    if ($RawSvg -match 'viewBox="0 0 (\d+) \d+"') {
        return [int] $Matches[1]
    }

    return 32
}

# -----------------------------------------------------------------------------
# SVG cleanup helpers
# -----------------------------------------------------------------------------

function Remove-EmptySvgGroups {
    param(
        [Parameter(Mandatory = $true)]
        [string] $Markup
    )

    # -------------------------------------------------------------------------
    # Remove empty groups
    # -------------------------------------------------------------------------
    #
    # Empty groups are commonly left behind after transparent rectangles,
    # embedded styles, IDs, or duplicate geometry have been removed.
    #

    do {
        $Before = $Markup

        $Markup = [regex]::Replace(
            $Markup,
            "<g\b[^>]*>\s*</g>",
            "",
            [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
        )
    } while ($Markup -ne $Before)

    return $Markup
}

function Remove-EmptySvgDefinitions {
    param(
        [Parameter(Mandatory = $true)]
        [string] $Markup
    )

    # -------------------------------------------------------------------------
    # Remove empty definition blocks
    # -------------------------------------------------------------------------
    #
    # Some source icons include empty <defs> blocks after export cleanup.
    #

    return [regex]::Replace(
        $Markup,
        "<defs\b[^>]*>\s*</defs>",
        "",
        [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
    )
}

function Remove-TransparentSvgGroups {
    param(
        [Parameter(Mandatory = $true)]
        [string] $Markup
    )

    # -------------------------------------------------------------------------
    # Remove transparent rectangle groups
    # -------------------------------------------------------------------------
    #
    # Some source icons wrap transparent canvas rectangles in a named group
    # instead of applying the marker directly to the rect.
    #

    $Markup = [regex]::Replace(
        $Markup,
        '<g\b[^>]*(data-name|id)=["''][^"'']*Transparent[^"'']*["''][^>]*>[\s\S]*?</g>',
        "",
        [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
    )

    return $Markup
}

function Remove-DuplicateSvgPathSubpaths {
    param(
        [Parameter(Mandatory = $true)]
        [string] $Markup
    )

    # -------------------------------------------------------------------------
    # Remove duplicate path sub-shapes
    # -------------------------------------------------------------------------
    #
    # Some filled icons include one full path containing the whole icon and then
    # a second path repeating an inner mark. When both are currentColor, the
    # repeated inner mark is redundant and should be removed.
    #
    # This function supports multiline path data.
    #

    $SeenPathData = New-Object System.Collections.Generic.List[string]

    $Evaluator = [System.Text.RegularExpressions.MatchEvaluator]{
        param([System.Text.RegularExpressions.Match] $Match)

        $Path = $Match.Value

        $DMatch = [regex]::Match(
            $Path,
            '\bd\s*=\s*(["''])(?<d>[\s\S]*?)\1',
            [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
        )

        if (-not $DMatch.Success) {
            return $Path
        }

        $D = $DMatch.Groups["d"].Value

        # Normalize aggressively so multiline path data and spacing differences
        # do not prevent duplicate/subpath detection.
        $NormalizedD = $D -replace "\s+", ""
        $NormalizedD = $NormalizedD.Trim()

        foreach ($Existing in $SeenPathData) {
            if ($Existing.Contains($NormalizedD)) {
                return ""
            }

            if ($NormalizedD.Contains($Existing)) {
                return ""
            }
        }

        $SeenPathData.Add($NormalizedD)

        return $Path
    }

    return [regex]::Replace(
        $Markup,
        "<path\b[\s\S]*?\/>",
        $Evaluator,
        [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
    )
}
function Remove-NoAttributeSvgGroups {
    param(
        [Parameter(Mandatory = $true)]
        [string] $Markup
    )

    # -------------------------------------------------------------------------
    # Remove no-attribute group wrappers
    # -------------------------------------------------------------------------
    #
    # After source/export IDs are removed, many SVGs are left with plain <g>
    # wrappers that do not affect rendering. Remove only matching no-attribute
    # <g>...</g> wrappers. Groups with transform, clip-path, mask, fill-rule,
    # etc. are preserved.
    #

    do {
        $Before = $Markup

        $Markup = [regex]::Replace(
            $Markup,
            "<g\s*>\s*([\s\S]*?)\s*</g>",
            '$1',
            [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
        )
    } while ($Markup -ne $Before)

    return $Markup
}

function Get-NormalizedPolygonKey {
    param(
        [Parameter(Mandatory = $true)]
        [string] $Points
    )

    # -------------------------------------------------------------------------
    # Normalize polygon point lists
    # -------------------------------------------------------------------------
    #
    # Some source files include the same polygon twice with the point pairs in
    # a different order, or with the starting point repeated as the closing
    # point. Normalize both cases to the same key.
    #

    $Normalized = $Points.Trim()
    $Normalized = $Normalized -replace "\s*,\s*", ","
    $Normalized = $Normalized -replace "\s+", " "

    $Pairs = @($Normalized -split " " | Where-Object { $_ })

    if ($Pairs.Count -gt 1 -and $Pairs[0] -eq $Pairs[$Pairs.Count - 1]) {
        $Pairs = $Pairs[0..($Pairs.Count - 2)]
    }

    $UniquePairs = $Pairs | Select-Object -Unique

    return ($UniquePairs | Sort-Object) -join "|"
}

function Remove-DuplicateSvgPolygons {
    param(
        [Parameter(Mandatory = $true)]
        [string] $Markup
    )

    # -------------------------------------------------------------------------
    # Remove duplicate polygons
    # -------------------------------------------------------------------------
    #
    # Uses normalized point lists instead of raw element text, so duplicate
    # polygons are removed even when point order differs or a closing point is
    # repeated.
    #

    $SeenPolygons = @{}

    $Evaluator = [System.Text.RegularExpressions.MatchEvaluator]{
        param([System.Text.RegularExpressions.Match] $Match)

        $Polygon = $Match.Value

        $PointsMatch = [regex]::Match(
            $Polygon,
            '\bpoints\s*=\s*(["''])(?<points>.*?)\1',
            [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
        )

        if (-not $PointsMatch.Success) {
            return $Polygon
        }

        $PointKey = Get-NormalizedPolygonKey $PointsMatch.Groups["points"].Value

        if ($SeenPolygons.ContainsKey($PointKey)) {
            return ""
        }

        $SeenPolygons[$PointKey] = $true

        return $Polygon
    }

    return [regex]::Replace(
        $Markup,
        "<polygon\b[^>]*\/?>",
        $Evaluator,
        [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
    )
}

function Remove-DuplicateExactSvgShapes {
    param(
        [Parameter(Mandatory = $true)]
        [string] $Markup
    )

    # -------------------------------------------------------------------------
    # Remove duplicate exact single-line shapes
    # -------------------------------------------------------------------------
    #
    # Handles exact duplicate paths, circles, rects, lines, polylines, and
    # ellipses. Polygons are handled separately by point-list comparison.
    #

    $SeenElements = @{}
    $Lines = $Markup -split "`r?`n"
    $CleanLines = New-Object System.Collections.Generic.List[string]

    foreach ($Line in $Lines) {
        $Trimmed = $Line.Trim()

        if (-not $Trimmed) {
            continue
        }

        $IsSimpleShape = $Trimmed -match "^<(path|circle|rect|line|polyline|ellipse)\b"

        if ($IsSimpleShape) {
            if ($SeenElements.ContainsKey($Trimmed)) {
                continue
            }

            $SeenElements[$Trimmed] = $true
        }

        $CleanLines.Add($Line.TrimEnd())
    }

    return ($CleanLines -join "`n").Trim()
}

function Get-SvgInnerMarkup {
    param(
        [Parameter(Mandatory = $true)]
        [string] $Svg
    )

    # -------------------------------------------------------------------------
    # Extract inner SVG markup
    # -------------------------------------------------------------------------
    #
    # The generated Blade component owns the outer <svg> element so every icon
    # has a consistent attribute contract.
    #

    $Match = [regex]::Match(
        $Svg,
        "<svg\b[^>]*>(?<inner>[\s\S]*?)</svg>",
        [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
    )

    if (-not $Match.Success) {
        throw "Unable to parse SVG markup."
    }

    $InnerMarkup = $Match.Groups["inner"].Value.Trim()
    # -------------------------------------------------------------------------
    # Remove source/export comments
    # -------------------------------------------------------------------------
    #
    # Source SVGs may include editor/export comments. Component icons should
    # emit only the SVG geometry needed to render the icon.
    #

    $InnerMarkup = [regex]::Replace(
        $InnerMarkup,
        "<!--[\s\S]*?-->",
        "",
        [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
    )

    # -------------------------------------------------------------------------
    # Remove embedded style blocks
    # -------------------------------------------------------------------------
    #
    # Component icons should not emit inline <style> blocks.
    #

    $InnerMarkup = [regex]::Replace(
        $InnerMarkup,
        "<style\b[^>]*>[\s\S]*?</style>",
        "",
        [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
    )

    # -------------------------------------------------------------------------
    # Normalize source helper classes and inner-path markers
    # -------------------------------------------------------------------------
    #
    # Source SVGs may include exported classes like st0/st1 or cls-1/cls-2.
    # Known transparent helpers are converted to fill="none"; remaining helper
    # classes are stripped so generated icons do not depend on missing embedded
    # styles.
    #
    # Some icons also use data-name="<inner-path>" for the inner shape. Normalize
    # that marker to data-icon-path="inner-path" for component CSS compatibility.
    #

    $InnerMarkup = [regex]::Replace(
        $InnerMarkup,
        '\s+data-name=["''](?:&amp;lt;|&lt;|<)?inner-path(?:&amp;gt;|&gt;|>)?["'']',
        ' data-icon-path="inner-path"',
        [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
    )

    $InnerMarkup = $InnerMarkup -replace '\sclass="st0"', ' fill="none"'
    $InnerMarkup = $InnerMarkup -replace "\sclass='st0'", " fill='none'"

    $InnerMarkup = [regex]::Replace(
        $InnerMarkup,
        '\s+class=["''](?:st|cls)-?\d+["'']',
        "",
        [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
    )

    $InnerMarkup = [regex]::Replace(
        $InnerMarkup,
        "\s+class='st\d+'",
        "",
        [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
    )

    # -------------------------------------------------------------------------
    # Remove transparent canvas rectangles
    # -------------------------------------------------------------------------
    #
    # These are source/export artifacts and should not be emitted in component
    # icons.
    #

    $InnerMarkup = [regex]::Replace(
        $InnerMarkup,
        '<rect\b[^>]*(id="[^"]*Transparent[^"]*"|id=''[^'']*Transparent[^'']*'')[^>]*/?>',
        "",
        [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
    )

    $InnerMarkup = [regex]::Replace(
        $InnerMarkup,
        '<rect\b[^>]*fill="none"[^>]*(width="(16|20|24|32)"|height="(16|20|24|32)")[^>]*/?>',
        "",
        [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
    )

    $InnerMarkup = [regex]::Replace(
        $InnerMarkup,
        "<rect\b[^>]*fill='none'[^>]*(width='(16|20|24|32)'|height='(16|20|24|32)')[^>]*/?>",
        "",
        [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
    )

    # -------------------------------------------------------------------------
    # Remove title and description metadata
    # -------------------------------------------------------------------------
    #
    # Generated Blade icons control accessibility through label / labelledby props.
    # Source <title> and <desc> nodes should not be emitted by default.
    #

    $InnerMarkup = [regex]::Replace(
        $InnerMarkup,
        '<rect\b[^>]*(width="(16|20|24|32)"|height="(16|20|24|32)")[^>]*(fill="none"|class="cls-\d+"|class=''cls-\d+'')[^>]*/?>',
        "",
        [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
    )

    $InnerMarkup = [regex]::Replace(
        $InnerMarkup,
        "<title\b[^>]*>[\s\S]*?</title>",
        "",
        [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
    )

    $InnerMarkup = [regex]::Replace(
        $InnerMarkup,
        "<desc\b[^>]*>[\s\S]*?</desc>",
        "",
        [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
    )

    # -------------------------------------------------------------------------
    # Remove source/export IDs
    # -------------------------------------------------------------------------
    #
    # Generated component icons should not carry editor/export IDs.
    #

    $InnerMarkup = [regex]::Replace(
        $InnerMarkup,
        '\s+id="[^"]*"',
        "",
        [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
    )

    $InnerMarkup = [regex]::Replace(
        $InnerMarkup,
        "\s+id='[^']*'",
        "",
        [System.Text.RegularExpressions.RegexOptions]::IgnoreCase
    )

    # -------------------------------------------------------------------------
    # Normalize hard-coded black fills
    # -------------------------------------------------------------------------
    #
    # Parent components should control icon color through currentColor.
    #

    $InnerMarkup = $InnerMarkup -replace 'fill="black"', 'fill="currentColor"'
    $InnerMarkup = $InnerMarkup -replace 'fill="#000"', 'fill="currentColor"'
    $InnerMarkup = $InnerMarkup -replace 'fill="#000000"', 'fill="currentColor"'

    # -------------------------------------------------------------------------
    # Remove unnecessary wrappers and duplicates
    # -------------------------------------------------------------------------

    $InnerMarkup = Remove-EmptySvgDefinitions $InnerMarkup
    $InnerMarkup = Remove-TransparentSvgGroups $InnerMarkup
    $InnerMarkup = Remove-EmptySvgGroups $InnerMarkup
    $InnerMarkup = Remove-NoAttributeSvgGroups $InnerMarkup
    $InnerMarkup = Remove-DuplicateSvgPolygons $InnerMarkup
    $InnerMarkup = Remove-DuplicateSvgPathSubpaths $InnerMarkup
    $InnerMarkup = Remove-DuplicateExactSvgShapes $InnerMarkup
    $InnerMarkup = Remove-EmptySvgDefinitions $InnerMarkup
    $InnerMarkup = Remove-TransparentSvgGroups $InnerMarkup
    $InnerMarkup = Remove-EmptySvgGroups $InnerMarkup
    $InnerMarkup = Remove-NoAttributeSvgGroups $InnerMarkup

    # -------------------------------------------------------------------------
    # Normalize self-closing SVG element spacing
    # -------------------------------------------------------------------------

    $InnerMarkup = [regex]::Replace(
        $InnerMarkup,
        "\s*/>",
        " />"
    )

    # -------------------------------------------------------------------------
    # Normalize indentation
    # -------------------------------------------------------------------------

    $Lines = $InnerMarkup -split "`r?`n" |
        ForEach-Object { $_.Trim() } |
        Where-Object { $_ }

    $InnerMarkup = ($Lines | ForEach-Object { "    $_" }) -join "`n"

    return $InnerMarkup
}

function New-BladeIconFileContent {
    param(
        [Parameter(Mandatory = $true)]
        [string] $OutputRelativePath,

        [Parameter(Mandatory = $true)]
        [string] $PurposeName,

        [Parameter(Mandatory = $true)]
        [int] $Size,

        [Parameter(Mandatory = $true)]
        [string] $InnerMarkup
    )

@"
{{-- ==========================================================================
    File: $OutputRelativePath
    Purpose: $PurposeName icon.

    Notes:
    - Generated from the local SVG source library.
    - Uses currentColor so parent components control icon color.
    - Accepts caller-provided classes through Blade attributes.
    - Defaults to decorative output unless label or labelledby is provided.
    - Intended for component UI, not decorative illustration.
    - Regenerate with scripts/generate-ui-icon-blades.ps1.
    ========================================================================== --}}

@props([
    'label' => null,
    'labelledby' => null,
])

@php
    /*
    |--------------------------------------------------------------------------
    | Accessibility mode
    |--------------------------------------------------------------------------
    |
    | Icons are decorative by default. If a label or labelledby value is
    | provided, the icon is exposed as an image to assistive technology.
    |
    */

    `$hasAccessibleName = filled(`$label) || filled(`$labelledby);

    /*
    |--------------------------------------------------------------------------
    | Focus handling
    |--------------------------------------------------------------------------
    |
    | SVG focusability is disabled by default. If the caller explicitly passes
    | tabindex, focusable is enabled to match browser SVG behavior.
    |
    */

    `$hasTabIndex = `$attributes->has('tabindex') || `$attributes->has('tabIndex');

    /*
    |--------------------------------------------------------------------------
    | SVG attributes
    |--------------------------------------------------------------------------
    |
    | Caller-provided attributes are merged last by Blade, while protected
    | accessibility defaults are resolved here.
    |
    */

    `$svgAttributes = [
        'viewBox' => '0 0 $Size $Size',
        'focusable' => `$hasTabIndex ? 'true' : 'false',
        'preserveAspectRatio' => 'xMidYMid meet',
        'fill' => 'currentColor',
        'xmlns' => 'http://www.w3.org/2000/svg',
    ];

    if (`$hasAccessibleName) {
        `$svgAttributes['role'] = 'img';

        if (filled(`$label)) {
            `$svgAttributes['aria-label'] = `$label;
        }

        if (filled(`$labelledby)) {
            `$svgAttributes['aria-labelledby'] = `$labelledby;
        }
    } else {
        `$svgAttributes['aria-hidden'] = 'true';
    }
@endphp

<svg
    {{-- Merge caller attributes with the standard icon class and SVG defaults. --}}
    {{ `$attributes->class('ui-icon')->merge(`$svgAttributes) }}
>
    {{-- Cleaned icon geometry is emitted from the source SVG. --}}
$InnerMarkup
</svg>
"@
}

# -----------------------------------------------------------------------------
# Collect source SVG files
# -----------------------------------------------------------------------------

$SvgFiles = Get-ChildItem $ResolvedSourceRoot -Recurse -File -Filter "*.svg"

if ($RequestedNames) {
    $SvgFiles = $SvgFiles | Where-Object {
        $RequestedNames -contains $_.BaseName
    }
}

if (-not $SvgFiles) {
    throw "No SVG files matched the requested input."
}

# -----------------------------------------------------------------------------
# Generate icons
# -----------------------------------------------------------------------------

$PreferredSizes = @(16, 20, 24, 32)
$Groups = $SvgFiles | Group-Object BaseName

$Generated = New-Object System.Collections.Generic.List[string]
$Skipped = New-Object System.Collections.Generic.List[string]
$Collisions = New-Object System.Collections.Generic.List[string]

$BladeNamesSeen = @{}

foreach ($Group in $Groups) {
    $SourceName = $Group.Name
    $BladeName = Convert-IconNameToBladeName $SourceName
    $PurposeName = Convert-IconNameToPurpose $BladeName

    if ($BladeNamesSeen.ContainsKey($BladeName) -and $BladeNamesSeen[$BladeName] -ne $SourceName) {
        $Collisions.Add("$SourceName conflicts with $($BladeNamesSeen[$BladeName]) as $BladeName")
        continue
    }

    $BladeNamesSeen[$BladeName] = $SourceName

    $FilesWithSize = $Group.Group | ForEach-Object {
        [pscustomobject]@{
            File = $_
            Size = Get-IconSizeFromPath $_
        }
    }

    # Pick the smallest standard component size available first.
    $DefaultCandidate = $null

    foreach ($PreferredSize in $PreferredSizes) {
        $DefaultCandidate = $FilesWithSize |
            Where-Object { $_.Size -eq $PreferredSize } |
            Select-Object -First 1

        if ($DefaultCandidate) {
            break
        }
    }

    if (-not $DefaultCandidate) {
        $DefaultCandidate = $FilesWithSize | Sort-Object Size | Select-Object -First 1
    }

    # -------------------------------------------------------------------------
    # Generate default component: chevron-down.blade.php
    # -------------------------------------------------------------------------

    $DefaultOutputPath = Join-Path $ResolvedOutputRoot "$BladeName.blade.php"
    $DefaultRelativePath = "$OutputRoot/$BladeName.blade.php" -replace "\\", "/"

    if ((Test-Path $DefaultOutputPath) -and -not $Force) {
        $Skipped.Add($DefaultRelativePath)
    } else {
        $RawSvg = Get-Content $DefaultCandidate.File.FullName -Raw
        $InnerMarkup = Get-SvgInnerMarkup $RawSvg

        $Content = New-BladeIconFileContent `
            -OutputRelativePath $DefaultRelativePath `
            -PurposeName $PurposeName `
            -Size $DefaultCandidate.Size `
            -InnerMarkup $InnerMarkup

        Set-Content -Path $DefaultOutputPath -Value $Content -Encoding UTF8
        $Generated.Add($DefaultRelativePath)
    }

    # -------------------------------------------------------------------------
    # Generate optional size variant components: chevron-down-20.blade.php
    # -------------------------------------------------------------------------

    if ($IncludeSizeVariants) {
        foreach ($Item in ($FilesWithSize | Sort-Object Size)) {
            $VariantName = "$BladeName-$($Item.Size)"
            $VariantPurposeName = Convert-IconNameToPurpose $VariantName

            $VariantOutputPath = Join-Path $ResolvedOutputRoot "$VariantName.blade.php"
            $VariantRelativePath = "$OutputRoot/$VariantName.blade.php" -replace "\\", "/"

            if ((Test-Path $VariantOutputPath) -and -not $Force) {
                $Skipped.Add($VariantRelativePath)
                continue
            }

            $RawSvg = Get-Content $Item.File.FullName -Raw
            $InnerMarkup = Get-SvgInnerMarkup $RawSvg

            $Content = New-BladeIconFileContent `
                -OutputRelativePath $VariantRelativePath `
                -PurposeName $VariantPurposeName `
                -Size $Item.Size `
                -InnerMarkup $InnerMarkup

            Set-Content -Path $VariantOutputPath -Value $Content -Encoding UTF8
            $Generated.Add($VariantRelativePath)
        }
    }
}

# -----------------------------------------------------------------------------
# Summary
# -----------------------------------------------------------------------------

Write-Host ""
Write-Host "Generated icon Blade files: $($Generated.Count)"
Write-Host "Skipped existing files:       $($Skipped.Count)"
Write-Host "Name collisions:              $($Collisions.Count)"
Write-Host ""

if ($Collisions.Count -gt 0) {
    Write-Host "Collisions:"
    $Collisions | ForEach-Object { Write-Host " - $_" }
    Write-Host ""
}

Write-Host "Output folder:"
Write-Host " $ResolvedOutputRoot"
Write-Host ""