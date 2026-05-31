<x-layouts.app title="Account Preferences">
    <section class="w-full space-y-6">
        <x-ui.patterns.page-title-actions-row
            title="Account Preferences"
            description="Set your personal defaults for timezone, language, and theme mode."
        />

        @if (session('success'))
            <x-ui.inline-alert semantic="success" title="Preferences saved">
                {{ session('success') }}
            </x-ui.inline-alert>
        @endif

        @if ($errors->any())
            <x-ui.patterns.validation-summary :errors="$errors->all()" />
        @endif

        <form method="POST" action="{{ route('platform.account.preferences.update') }}" class="space-y-6">
            @csrf

            <x-ui.patterns.form-section
                title="Personal Defaults"
                description="Account preference forms reuse the same Tier 2 form scaffolding as settings pages."
                kicker="Account archetype proof"
            >
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-ui.patterns.form-group for="timezone" label="Timezone">
                        <input id="timezone" name="timezone" type="text" value="{{ old('timezone', $user->timezone) }}" class="ui-input w-full">
                    </x-ui.patterns.form-group>
                    <x-ui.patterns.form-group for="default_language" label="Default Language">
                        <input id="default_language" name="default_language" type="text" value="{{ old('default_language', $user->default_language) }}" class="ui-input w-full">
                    </x-ui.patterns.form-group>
                    <x-ui.patterns.form-group for="theme_preference" label="Theme Mode">
                        <select id="theme_preference" name="theme_preference" class="ui-select w-full">
                            <option value="system" @selected(old('theme_preference', $user->theme_preference ?? 'system') === 'system')>System</option>
                            <option value="dark" @selected(old('theme_preference', $user->theme_preference ?? 'system') === 'dark')>Dark</option>
                            <option value="light" @selected(old('theme_preference', $user->theme_preference ?? 'system') === 'light')>Light</option>
                        </select>
                    </x-ui.patterns.form-group>
                </div>

                <x-ui.patterns.form-actions-bar class="mt-6">
                    <x-ui.button type="submit" semantic="primary">Save Preferences</x-ui.button>
                </x-ui.patterns.form-actions-bar>
            </x-ui.patterns.form-section>
        </form>
    </section>
</x-layouts.app>
