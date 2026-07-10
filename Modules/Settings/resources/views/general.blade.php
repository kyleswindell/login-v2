<x-layouts.app
    title="General Settings"
    page-title="General"
    page-subtitle="Configure the app display name plus the shared searchable timezone and locale defaults."
>
    <x-slot:pageTabs>
        @include('settings::_general-tabs', ['generalTab' => 'general'])
    </x-slot:pageTabs>

    <x-ui.grid-column
        tag="section"
        span="100"
        lg="12"
        xlg="12"
    >
        @if (session('success'))
            <x-ui.notification.inline kind="success" title="General settings saved">
                {{ session('success') }}
            </x-ui.notification.inline>
        @endif

        <form method="POST" action="{{ route('platform.settings.general.update') }}" class="space-y-6">
            @csrf

            <x-patterns.form-section
                title="General Platform Defaults"
                description="These fields establish the baseline app-facing identity and localization defaults."
                kicker="Settings archetype proof"
            >
                <div class="grid gap-6 md:grid-cols-2">
                    <x-patterns.form-group
                        for="display_name"
                        label="Display Name"
                        helper="The name shown in the platform header and emails."
                        :error="$errors->first('display_name')"
                    >
                        <input
                            id="display_name"
                            type="text"
                            name="display_name"
                            value="{{ old('display_name', $displayName) }}"
                            class="ui-input w-full"
                        >
                    </x-patterns.form-group>

                    <x-patterns.form-group
                        for="timezone"
                        label="Default Timezone"
                        helper="Search the approved timezone list inside the shared Inputs And Forms dropdown, then choose the platform default used when no user preference is set."
                        :error="$errors->first('timezone')"
                    >
                        <x-ui.searchable-select
                            id="timezone"
                            name="timezone"
                            :options="$timezoneOptions"
                            :selected="old('timezone', $timezone)"
                            placeholder="Choose a timezone"
                            search-placeholder="Search timezones"
                            :required="true"
                            :invalid="$errors->has('timezone')"
                        />
                    </x-patterns.form-group>

                    <x-patterns.form-group
                        for="locale"
                        label="Default Locale"
                        helper="Locale stays option-backed and uses the same shared searchable dropdown shell as timezone."
                        :error="$errors->first('locale')"
                    >
                        <x-ui.searchable-select
                            id="locale"
                            name="locale"
                            :options="$localeOptions"
                            :selected="old('locale', $locale)"
                            placeholder="Choose a locale"
                            search-placeholder="Search locales"
                            :required="true"
                            :invalid="$errors->has('locale')"
                        />
                    </x-patterns.form-group>
                </div>

                <x-patterns.forms.actions class="mt-6">
                    <x-ui.button type="submit" semantic="primary">Save General Settings</x-ui.button>
                </x-patterns.forms.actions>
            </x-patterns.form-section>
        </form>
    </x-ui.grid-column>
</x-layouts.app>
