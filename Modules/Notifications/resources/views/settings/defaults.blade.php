{{-- ==========================================================================
    File: Modules/Notifications/resources/views/settings/defaults.blade.php
    Purpose: Notifications settings page.

    Notes:
    - The app layout owns the installed Grid container through the grid prop.
    - The shell content layout owns the page header and reserved page-tabs space.
    - Settings page body content must render as x-ui.grid-column direct children
      when grid is enabled.
    - The settings sidebar remains supplied through the layout sidebar slot.
    ========================================================================== --}}

<x-layouts.app
    grid
    title="Notification Settings"
    page-title="Notification Defaults"
    page-subtitle="Configure default severity and per-user notification retention limits."
    :reserve-page-tabs="true"
>
    {{-- ------------------------------------------------------------------
        Notification defaults form
        ------------------------------------------------------------------ --}}

    <x-ui.grid-column
        tag="section"
        span="100"
        lg="10"
        xlg="8"
        data-notifications-settings-page
    >
        @if (session("success"))
            <div
                class="ui-platform-surface p-4 text-sm font-medium"
                role="status"
                data-notifications-settings-success
            >
                {{
                    session(
                        "success",
                    )
                }}
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('platform.settings.notifications.update') }}"
            class="ui-platform-surface p-8"
            data-notifications-settings-form
        >
            @csrf

            {{-- ----------------------------------------------------------
                Settings fields
                ---------------------------------------------------------- --}}

            <x-ui.grid subgrid row-gap>
                <x-ui.grid-column
                    span="100"
                    md="4"
                    lg="8"
                    data-notifications-default-severity-field
                >
                    <label
                        for="default_severity"
                        class="block text-sm font-semibold ui-platform-text-strong"
                    >
                        Default Severity
                    </label>

                    <p class="mt-1 text-sm leading-6 ui-platform-text-muted">Applied when a notification is created without an explicit severity.</p>

                    <select
                        id="default_severity"
                        name="default_severity"
                        class="mt-3 w-full"
                    >
                        @foreach (["info", "notice", "success", "warning", "error", "urgent"]
                            as $option)
                            <option
                                value="{{ $option }}"
                                @selected (old("default_severity", $defaultSeverity) === $option)
                            >
                                {{
                                    ucfirst(
                                        $option,
                                    )
                                }}
                            </option>
                        @endforeach
                    </select>

                    @error ("default_severity")
                        <p class="mt-2 text-sm" data-ui-field-error>
                            {{ $message }}
                        </p>
                    @enderror
                </x-ui.grid-column>

                <x-ui.grid-column
                    span="100"
                    md="4"
                    lg="8"
                    data-notifications-max-per-user-field
                >
                    <label
                        for="max_per_user"
                        class="block text-sm font-semibold ui-platform-text-strong"
                    >
                        Max Notifications Per User
                    </label>

                    <p class="mt-1 text-sm leading-6 ui-platform-text-muted">Oldest notifications are pruned when this limit is exceeded. Min 10, max 10000.</p>

                    <input
                        id="max_per_user"
                        type="number"
                        name="max_per_user"
                        value="{{ old('max_per_user', $maxPerUser) }}"
                        min="10"
                        max="10000"
                        class="mt-3 w-full"
                    />

                    @error ("max_per_user")
                        <p class="mt-2 text-sm" data-ui-field-error>
                            {{ $message }}
                        </p>
                    @enderror
                </x-ui.grid-column>
            </x-ui.grid>

            {{-- ----------------------------------------------------------
                Form actions
                ---------------------------------------------------------- --}}

            <div class="mt-8 border-t pt-6">
                <x-ui.button type="submit" kind="primary" size="md">
                    Save Notification Settings
                </x-ui.button>
            </div>
        </form>
    </x-ui.grid-column>
</x-layouts.app>
