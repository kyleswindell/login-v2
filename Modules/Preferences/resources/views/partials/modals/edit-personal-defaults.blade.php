<x-ui.modal
    id="account-preferences-modal"
    title="Edit preferences"
    label="Preferences"
    size="md"
    :open="$preferenceErrors->any()"
    has-scrolling-content
    secondary-button-text="Cancel"
    primary-button-text="Save preferences"
    primary-button-type="submit"
    primary-button-form="account-preferences-form"
    :close-on-backdrop="false"
>
    <x-ui.form
        id="account-preferences-form"
        method="POST"
        :action="route('platform.account.preferences.update')"
        data-account-preferences-form
        data-ui-form-submit-state
        data-ui-form-submit-state-loading-text="Saving preferences..."
    >
        <x-ui.grid subgrid row-gap>
            <x-ui.grid-column span="100">
                <x-ui.searchable-select
                    id="timezone"
                    name="timezone"
                    label="Timezone"
                    :options="$timezoneOptions"
                    :selected="old('timezone', $user->timezone)"
                    placeholder="Choose a timezone"
                    search-placeholder="Search timezones"
                    :invalid="$preferenceErrors->has('timezone')"
                    data-ui-dialog-primary-focus
                />

                @if ($preferenceErrors->has('timezone'))
                    <p class="mt-2 text-sm" data-ui-field-error>
                        {{ $preferenceErrors->first('timezone') }}
                    </p>
                @endif
            </x-ui.grid-column>

            <x-ui.grid-column span="100">
                <x-ui.searchable-select
                    id="default_language"
                    name="default_language"
                    label="Default language"
                    :options="$localeOptions"
                    :selected="old('default_language', $user->default_language)"
                    placeholder="Choose a language"
                    search-placeholder="Search languages"
                    :invalid="$preferenceErrors->has('default_language')"
                />

                @if ($preferenceErrors->has('default_language'))
                    <p class="mt-2 text-sm" data-ui-field-error>
                        {{ $preferenceErrors->first('default_language') }}
                    </p>
                @endif
            </x-ui.grid-column>

            <x-ui.grid-column span="100">
                <x-ui.select
                    id="theme_preference"
                    name="theme_preference"
                    label="Theme mode"
                    :value="old('theme_preference', $user->theme_preference ?? 'system')"
                    :items="[
                        ['value' => 'system', 'label' => 'System'],
                        ['value' => 'dark', 'label' => 'Dark'],
                        ['value' => 'light', 'label' => 'Light'],
                    ]"
                    :invalid="$preferenceErrors->has('theme_preference')"
                    :invalid-text="$preferenceErrors->first('theme_preference')"
                />
            </x-ui.grid-column>
        </x-ui.grid>
    </x-ui.form>
</x-ui.modal>
