@php
    $initials = collect(preg_split('/\s+/', trim($user->name)) ?: [])
        ->filter()
        ->map(fn (string $part) => mb_strtoupper(mb_substr($part, 0, 1)))
        ->take(2)
        ->implode('');
@endphp

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
            description="Read-only account detail uses the shared identity summary and read-only detail patterns rather than bespoke field stacks."
            kicker="Account archetype proof"
        >
            <x-ui.patterns.identity-summary-card
                variant="detailed"
                :name="$user->name"
                subtitle="Internal account profile"
                :initials="$initials ?: 'NA'"
                :meta="[
                    $user->email,
                    $user->phone ?: 'No phone on file',
                    $user->timezone ?: 'No timezone set',
                ]"
                status-label="Active"
                status-semantic="success"
            >
                <x-slot:actions>
                    <x-ui.button :href="route('platform.account.settings')" variant="outline" size="sm">Edit details</x-ui.button>
                </x-slot:actions>

                <x-ui.patterns.key-value-display
                    :items="[
                        ['label' => 'Name', 'value' => e($user->name)],
                        ['label' => 'Email', 'value' => e($user->email)],
                        ['label' => 'Phone', 'value' => e($user->phone ?: 'Not set')],
                        ['label' => 'Timezone', 'value' => e($user->timezone ?: 'Not set')],
                    ]"
                />
            </x-ui.patterns.identity-summary-card>
        </x-ui.patterns.content-section-block>
    </section>
</x-layouts.app>
