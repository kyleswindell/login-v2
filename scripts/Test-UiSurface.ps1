param(
    [string] $Component,
    [switch] $Components,
    [string] $Element,
    [switch] $Elements,
    [switch] $All,
    [ValidateSet('php', 'browser', 'all')]
    [string] $Kind = 'all',
    [switch] $ContinueOnFailure,
    [switch] $List
)

Set-StrictMode -Version Latest
$ErrorActionPreference = 'Stop'
$env:DOCKER_CLI_HINTS = 'false'

trap {
    [Console]::Error.WriteLine($_.Exception.Message)
    exit 1
}

$scriptPath = if ($PSCommandPath) { $PSCommandPath } else { $MyInvocation.MyCommand.Path }
$scriptRoot = Split-Path -Parent $scriptPath
$repoRoot = Resolve-Path (Join-Path $scriptRoot '..')
$repoRootPath = $repoRoot.ProviderPath
Set-Location $repoRootPath

function Convert-ToRepoPath {
    param([string] $Path)

    if (Test-Path $Path) {
        $resolvedPath = (Resolve-Path $Path).ProviderPath
    } elseif ([System.IO.Path]::IsPathRooted($Path)) {
        $resolvedPath = $Path
    } else {
        $resolvedPath = Join-Path $repoRootPath $Path
    }

    $normalizedRoot = ($repoRootPath -replace '^[^:]+::', '').TrimEnd('\', '/')
    $normalizedPath = $resolvedPath -replace '^[^:]+::', ''

    if ($normalizedPath -match '(resources[\\/]views[\\/](?:components[\\/]ui|elements)[\\/].*)$') {
        return $Matches[1] -replace '\\', '/'
    }

    if ($normalizedPath.ToLowerInvariant().StartsWith($normalizedRoot.ToLowerInvariant())) {
        return $normalizedPath.Substring($normalizedRoot.Length).TrimStart('\', '/') -replace '\\', '/'
    }

    return $normalizedPath -replace '\\', '/'
}

function Get-TestKind {
    param([string] $Path)

    $hasPhp = @(Get-ChildItem -Path $Path -Recurse -File -Filter '*Test.php' -ErrorAction SilentlyContinue).Count -gt 0
    $hasBrowser = @(Get-ChildItem -Path $Path -Recurse -File -Filter '*.spec.js' -ErrorAction SilentlyContinue).Count -gt 0

    [pscustomobject]@{
        Php = $hasPhp
        Browser = $hasBrowser
    }
}

function Get-BrowserSpecPaths {
    param([string] $Path)

    @(Get-ChildItem -Path $Path -Recurse -File -Filter '*.spec.js' -ErrorAction SilentlyContinue |
        Sort-Object FullName |
        ForEach-Object { Convert-ToRepoPath $_.FullName })
}

function Get-UiTestFolder {
    param(
        [string] $Base,
        [string] $Name
    )

    $path = Join-Path $Base (Join-Path $Name '__tests__')

    if (-not (Test-Path $path)) {
        throw "No co-located UI test folder exists at $(Convert-ToRepoPath $path)."
    }

    Get-Item $path
}

function Get-UiTestFolders {
    param([string] $Base)

    if (-not (Test-Path $Base)) {
        return @()
    }

    Get-ChildItem -Path $Base -Directory |
        Sort-Object Name |
        ForEach-Object {
            $testPath = Join-Path $_.FullName '__tests__'

            if (Test-Path $testPath) {
                Get-Item $testPath
            }
        }
}

function Invoke-Docker {
    param(
        [string] $Label,
        [string[]] $Arguments
    )

    Write-Host ""
    Write-Host "==> $Label"
    & docker @Arguments

    if ($LASTEXITCODE -ne 0) {
        throw "$Label failed with exit code $LASTEXITCODE."
    }
}

$componentBase = Join-Path $repoRoot 'resources/views/components/ui'
$elementBase = Join-Path $repoRoot 'resources/views/elements'

$targetModes = @(
    @($Component, $Components.IsPresent, $Element, $Elements.IsPresent, $All.IsPresent) |
        Where-Object { $_ }
)

if ($targetModes.Count -ne 1) {
    throw 'Choose exactly one target: -Component <name>, -Components, -Element <name>, -Elements, or -All.'
}

$folders = @()

if ($Component) {
    $folders += Get-UiTestFolder -Base $componentBase -Name $Component
} elseif ($Components) {
    $folders += Get-UiTestFolders -Base $componentBase
} elseif ($Element) {
    $folders += Get-UiTestFolder -Base $elementBase -Name $Element
} elseif ($Elements) {
    $folders += Get-UiTestFolders -Base $elementBase
} elseif ($All) {
    $folders += Get-UiTestFolders -Base $componentBase
    $folders += Get-UiTestFolders -Base $elementBase
}

if ($folders.Count -eq 0) {
    Write-Host 'No co-located UI test folders found.'
    exit 0
}

$failures = New-Object System.Collections.Generic.List[string]

foreach ($folder in $folders) {
    $relativePath = Convert-ToRepoPath $folder.FullName
    $testKind = Get-TestKind -Path $folder.FullName

    if ($List) {
        $available = @()

        if ($testKind.Php) {
            $available += 'php'
        }

        if ($testKind.Browser) {
            $available += 'browser'
        }

        if ($available.Count -eq 0) {
            $available += 'none'
        }

        Write-Host "$relativePath [$($available -join ', ')]"
        continue
    }

    try {
        if (($Kind -eq 'php' -or $Kind -eq 'all') -and $testKind.Php) {
            Invoke-Docker -Label "PHP tests: $relativePath" -Arguments @('compose', 'exec', '-T', 'app', 'php', 'artisan', 'test', $relativePath)
        } elseif ($Kind -eq 'php' -or $Kind -eq 'all') {
            Write-Host "Skipping PHP tests for $relativePath; no *Test.php files found."
        }

        if (($Kind -eq 'browser' -or $Kind -eq 'all') -and $testKind.Browser) {
            $browserSpecs = Get-BrowserSpecPaths -Path $folder.FullName
            $browserArguments = @('compose', 'exec', '-T', 'playwright', 'npm', 'run', 'test:browser', '--') + $browserSpecs + @('--project=chromium')

            Invoke-Docker -Label "Browser tests: $relativePath" -Arguments $browserArguments
        } elseif ($Kind -eq 'browser' -or $Kind -eq 'all') {
            Write-Host "Skipping browser tests for $relativePath; no *.spec.js files found."
        }
    } catch {
        $failures.Add("$relativePath - $($_.Exception.Message)")

        if (-not $ContinueOnFailure) {
            throw
        }
    }
}

if ($failures.Count -gt 0) {
    Write-Host ''
    Write-Host 'UI surface test failures:'
    $failures | ForEach-Object { Write-Host "- $_" }
    exit 1
}

if (-not $List) {
    Write-Host ''
    Write-Host 'UI surface tests completed.'
}
