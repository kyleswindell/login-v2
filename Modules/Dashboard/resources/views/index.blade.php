{{-- ==========================================================================
    File: Modules/Dashboard/resources/views/index.blade.php
    Purpose: Dashboard module landing page.

    Notes:
    - The app layout owns the installed Grid container through the grid prop.
    - The shell content layout owns the page header and reserved page-tabs space.
    - Dashboard body content must render as x-ui.grid-column direct children
      when grid is enabled.
    - Do not add page-level max-width/container wrappers here. Grid margins,
      columns, and responsive behavior are owned by the layout grid.
    - The title prop is required for the app security/header metadata path.
    ========================================================================== --}}

<x-layouts.app
    grid
    :title="__('dashboard::dashboard.title')"
    :page-title="__('dashboard::dashboard.title')"
    :page-subtitle="__('dashboard::dashboard.description')"
    :reserve-page-tabs="true"
>
    @can (\App\Modules\Notifications\Services\NotificationPermissions::VIEW)
        {{-- --------------------------------------------------------------
            Platform notification test tile
            -------------------------------------------------------------- --}}

        <x-ui.grid-column
            tag="article"
            span="100"
            md="4"
            lg="6"
            xlg="5"
            class="ui-platform-surface p-6"
            data-dashboard-test-notification-tile
        >
            <div class="space-y-3">
                <h2 class="text-lg font-semibold ui-platform-text-strong">
                    {{
                        __(
                            "dashboard::dashboard.test_notification.tile_title",
                        )
                    }}
                </h2>

                <p class="text-sm leading-6 ui-platform-text-muted">
                    {{
                        __(
                            "dashboard::dashboard.test_notification.tile_description",
                        )
                    }}
                </p>
            </div>

            <form
                method="POST"
                action="{{ route('dashboard.test-notification') }}"
                class="mt-5"
                data-dashboard-test-notification-form
            >
                @csrf

                <x-ui.button
                    type="submit"
                    kind="primary"
                    size="md"
                    data-dashboard-test-notification-submit
                >
                    {{
                        __(
                            "dashboard::dashboard.test_notification.action",
                        )
                    }}
                </x-ui.button>
            </form>
        </x-ui.grid-column>

        {{-- --------------------------------------------------------------
            Modal action pattern test tile
            --------------------------------------------------------------
            Visual inspection only. No persistence or destructive actions are
            performed by the examples in this tile.
            -------------------------------------------------------------- --}}

        <x-ui.grid-column
            tag="article"
            span="100"
            md="4"
            lg="6"
            xlg="7"
            class="ui-platform-surface p-6"
            data-dashboard-modal-action-pattern-test-tile
        >
            @include ("dashboard::partials.modal-action-pattern-tests")
        </x-ui.grid-column>
    @endcan
</x-layouts.app>
