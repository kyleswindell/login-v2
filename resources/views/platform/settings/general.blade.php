<x-layouts.app title="Platform General Settings">
    <x-slot:sidebar>
        @include('platform.settings._sidebar', ['active' => 'general'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <x-ui.patterns.page-title-actions-row
            title="Platform General"
            description="Configure the platform display name, default timezone, and locale."
        />

        @include('platform.settings._general-tabs', ['generalTab' => 'general'])

        @if (session('success'))
            <x-ui.inline-alert semantic="success" title="General settings saved">
                {{ session('success') }}
            </x-ui.inline-alert>
        @endif

        <form method="POST" action="{{ route('platform.settings.general.update') }}" class="space-y-6">
            @csrf

            <x-ui.patterns.form-section
                title="General Platform Defaults"
                description="These fields establish the baseline shell-facing identity and localization defaults for the internal app."
                kicker="Settings archetype proof"
            >
                <div class="grid gap-6 md:grid-cols-2">
                    <x-ui.patterns.form-group
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
                    </x-ui.patterns.form-group>

                    <x-ui.patterns.form-group
                        for="timezone"
                        label="Default Timezone"
                        helper="Search the approved timezone list inside the shared selector, then choose the platform default used when no user preference is set."
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
                    </x-ui.patterns.form-group>

                    <x-ui.patterns.form-group
                        for="locale"
                        label="Default Locale"
                        helper="Locale stays option-backed so formatting defaults come from the approved app locale set."
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
                    </x-ui.patterns.form-group>
                </div>

                <x-ui.patterns.form-actions-bar class="mt-6">
                    <x-ui.button type="submit" semantic="primary">Save General Settings</x-ui.button>
                </x-ui.patterns.form-actions-bar>
            </x-ui.patterns.form-section>
        </form>
    </section>
</x-layouts.app>
