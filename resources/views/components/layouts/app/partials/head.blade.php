{{-- ==========================================================================
    File: resources/views/components/layouts/app/partials/head.blade.php
    Purpose: Shared document head for the global app layout.

    Notes:
    - Owns document metadata, theme boot payload, first-paint theme resolution,
      Livewire styles, Vite assets, and stacked page styles.
    - Theme boot must run before CSS loads so the resolved light/dark state is
      available for first paint.
    - Runtime theme changes after boot are owned by the app JavaScript layer.
    - Grid CSS is loaded through resources/css/app.css via Vite; this partial
      does not enable or configure grid behavior directly.
    ========================================================================== --}}

<head>
    {{-- ----------------------------------------------------------------------
        Document metadata
        ---------------------------------------------------------------------- --}}
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ $title ?? config("app.name") }}</title>

    {{-- ----------------------------------------------------------------------
        Theme boot payload
        ----------------------------------------------------------------------
        The parent app layout prepares this JSON payload from the authenticated
        user preference or the default system setting.
        ---------------------------------------------------------------------- --}}
    <script id="theme-boot-payload" type="application/json">
        {!! $themeBootPayload !!}
    </script>

    {{-- ----------------------------------------------------------------------
        First-paint theme boot
        ----------------------------------------------------------------------
        This script intentionally avoids framework dependencies and runs before
        the CSS bundle is loaded. It resolves the requested theme mode to the
        active light/dark theme and sets document-level data attributes.
        ---------------------------------------------------------------------- --}}
    <script>
        (() => {
            const root = document.documentElement;
            const allowedModes = new Set(["system", "dark", "light"]);
            const bootPayload = document.getElementById("theme-boot-payload");

            const readPersistedMode = () => {
                try {
                    return window.localStorage.getItem("platform.theme.mode");
                } catch {
                    return null;
                }
            };

            const readServerMode = () => {
                try {
                    const payload = bootPayload
                        ? JSON.parse(bootPayload.textContent || "{}")
                        : {};

                    return payload.mode || "system";
                } catch {
                    return "system";
                }
            };

            const persistedMode = readPersistedMode();
            const serverMode = readServerMode();
            const fallbackMode = allowedModes.has(serverMode)
                ? serverMode
                : "system";
            const themeMode = allowedModes.has(persistedMode)
                ? persistedMode
                : fallbackMode;
            const prefersDark = window.matchMedia
                ? window.matchMedia("(prefers-color-scheme: dark)").matches
                : false;
            const resolved =
                themeMode === "system"
                    ? prefersDark
                        ? "dark"
                        : "light"
                    : themeMode;

            root.dataset.themeMode = themeMode;
            root.dataset.themeResolved = resolved;
            root.dataset.themeBooted = "true";
            root.classList.toggle("dark", resolved === "dark");
        })();
    </script>

    {{-- ----------------------------------------------------------------------
        Styles and assets
        ---------------------------------------------------------------------- --}}
    @livewireStyles
    @vite (["resources/css/app.css", "resources/js/app.js"])
    @stack ("styles")
</head>
