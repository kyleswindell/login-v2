<x-layouts.app title="Account Settings">
    <section class="w-full space-y-6">
        <x-ui.patterns.page-title-actions-row
            title="Account Settings"
            description="Update your profile details and security credentials."
        />

        @if (session('success'))
            <x-ui.inline-alert semantic="success" title="Account settings saved">
                {{ session('success') }}
            </x-ui.inline-alert>
        @endif

        @if ($errors->any())
            <x-ui.patterns.validation-summary :errors="$errors->all()" />
        @endif

        <form method="POST" action="{{ route('platform.account.settings.update') }}" class="space-y-6">
            @csrf

            <x-ui.patterns.form-section
                title="Profile Details"
                description="Shared identity fields align to the same grouped form contract used elsewhere in the internal app."
                kicker="Account archetype proof"
            >
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-ui.patterns.form-group class="sm:col-span-2" for="name" label="Name">
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" class="ui-input w-full">
                    </x-ui.patterns.form-group>
                    <x-ui.patterns.form-group class="sm:col-span-2" for="email" label="Email">
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="ui-input w-full">
                    </x-ui.patterns.form-group>
                    <x-ui.patterns.form-group class="sm:col-span-2" for="phone" label="Phone">
                        <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}" class="ui-input w-full" data-ui-phone-input inputmode="tel" autocomplete="tel" placeholder="(555) 555-5555">
                    </x-ui.patterns.form-group>
                </div>
            </x-ui.patterns.form-section>

            <x-ui.patterns.form-section
                title="Password And Security"
                description="Provide your current password to set a new password."
                kicker="Credential update"
            >
                <div class="grid gap-5 sm:grid-cols-2">
                    <x-ui.patterns.form-group class="sm:col-span-2" for="current_password" label="Current Password">
                        <input id="current_password" name="current_password" type="password" autocomplete="current-password" class="ui-input w-full">
                    </x-ui.patterns.form-group>
                    <x-ui.patterns.form-group for="new_password" label="New Password">
                        <input id="new_password" name="new_password" type="password" autocomplete="new-password" class="ui-input w-full">
                    </x-ui.patterns.form-group>
                    <x-ui.patterns.form-group for="new_password_confirmation" label="Confirm New Password">
                        <input id="new_password_confirmation" name="new_password_confirmation" type="password" autocomplete="new-password" class="ui-input w-full">
                    </x-ui.patterns.form-group>
                </div>

                <x-ui.patterns.form-actions-bar class="mt-6">
                    <x-ui.button type="submit" semantic="primary">Save Settings</x-ui.button>
                </x-ui.patterns.form-actions-bar>
            </x-ui.patterns.form-section>
        </form>
    </section>
</x-layouts.app>
