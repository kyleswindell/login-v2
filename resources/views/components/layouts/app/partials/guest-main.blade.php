{{-- ==========================================================================
    File: resources/views/components/layouts/app/partials/guest-main.blade.php
    Purpose: Guest application main shell.

    Notes:
    - Owns unauthenticated main content layout and auth background behavior.
    - Keeps the existing centered guest layout by default.
    - Supports the same Grid handoff used by authenticated pages.
    - Guest auth screens opt out because they require their own constrained
      layout until guest layout review.
    - Grid-enabled guest pages must render x-ui.grid-column as direct slot
      children.
    ========================================================================== --}}

@php
    /*
    |--------------------------------------------------------------------------
    | Auth Background Tokens
    |--------------------------------------------------------------------------
    |
    | Auth background colors intentionally shift by resolved theme so guest auth
    | pages remain visually distinct from authenticated app surfaces.
    |
    */

    $authBackgroundTokenMap = [
        'light' => 'var(--ui-gray-10)',
        'white' => 'var(--ui-gray-10)',
        'gray-10' => 'var(--ui-white)',
        'dark' => 'var(--ui-gray-100)',
        'gray-90' => 'var(--ui-gray-100)',
        'gray-100' => 'var(--ui-gray-90)',
    ];

    /*
    |--------------------------------------------------------------------------
    | App Grid Handoff
    |--------------------------------------------------------------------------
    */

    $usesGrid = (bool) ($usesGrid ?? false);
    $usesGridFullWidth = (bool) ($usesGridFullWidth ?? false);
    $usesGridRowGap = (bool) ($usesGridRowGap ?? true);

    $gridMode = is_string($gridMode ?? null) && in_array($gridMode, ['default', 'narrow', 'condensed'], true)
        ? $gridMode
        : 'default';

    $gridAlign = is_string($gridAlign ?? null) && in_array($gridAlign, ['start', 'end'], true)
        ? $gridAlign
        : null;
@endphp

<div
    class="min-h-screen"
    data-auth-background-shell
    data-auth-background-map='@json($authBackgroundTokenMap)'
    style="background-color: var(--ui-auth-background, var(--ui-gray-10))"
>
    {{-- ----------------------------------------------------------------------
        Guest main content
        ---------------------------------------------------------------------- --}}

    @if ($usesGrid)
        <main
            id="{{ $mainContentId }}"
            class="min-h-screen w-full py-10"
            data-ui-guest-main
        >
            <x-ui.grid
                :full-width="$usesGridFullWidth"
                :row-gap="$usesGridRowGap"
                :mode="$gridMode"
                :align="$gridAlign"
                data-ui-app-grid
                data-ui-app-grid-region="guest-main"
            >
                {{ $slot }}
            </x-ui.grid>
        </main>
    @else
        <main
            id="{{ $mainContentId }}"
            class="mx-auto flex min-h-screen w-full max-w-5xl flex-col px-6 py-10"
            data-ui-guest-main
        >
            {{ $slot }}
        </main>
    @endif
</div>

{{-- --------------------------------------------------------------------------
    Auth background theme sync
    --------------------------------------------------------------------------
    Keeps the guest auth background aligned with runtime theme changes after
    the initial document theme has already been booted in the head.
    -------------------------------------------------------------------------- --}}

<script>
    (() => {
        const root = document.documentElement;
        const shell = document.querySelector("[data-auth-background-shell]");

        if (!shell) {
            return;
        }

        const readTokenMap = () => {
            try {
                return JSON.parse(shell.dataset.authBackgroundMap || "{}");
            } catch {
                return {};
            }
        };

        const tokenMap = readTokenMap();
        const fallback = tokenMap.light || "var(--ui-gray-10)";

        const applyAuthBackground = () => {
            shell.style.setProperty(
                "--ui-auth-background",
                tokenMap[root.dataset.themeResolved] || fallback,
            );
        };

        applyAuthBackground();

        new MutationObserver(applyAuthBackground).observe(root, {
            attributes: true,
            attributeFilter: ["data-theme-resolved"],
        });
    })();
</script>
