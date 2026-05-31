<x-layouts.app title="My Account">
    <section class="w-full space-y-6">
        <x-ui.patterns.page-title-actions-row
            title="My Account"
            description="Manage your profile identity and personal preferences."
        >
            <x-slot:actions>
                <x-ui.button :href="route('platform.account.settings')" variant="outline">Edit Profile</x-ui.button>
                <x-ui.button :href="route('platform.account.preferences')" semantic="primary">Preferences</x-ui.button>
            </x-slot:actions>
        </x-ui.patterns.page-title-actions-row>

        <x-ui.patterns.content-section-block
            title="Profile Summary"
            description="Read-only account detail uses the shared key-value display rather than bespoke field stacks."
            kicker="Account archetype proof"
        >
            <x-ui.patterns.key-value-display
                :items="[
                    ['label' => 'Name', 'value' => e($user->name)],
                    ['label' => 'Email', 'value' => e($user->email)],
                    ['label' => 'Phone', 'value' => e($user->phone ?: 'Not set')],
                    ['label' => 'Timezone', 'value' => e($user->timezone ?: 'Not set')],
                ]"
            />
        </x-ui.patterns.content-section-block>
    </section>
</x-layouts.app>
