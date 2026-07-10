{{-- ==========================================================================
    File: Modules/Account/resources/views/partials/security/mfa.blade.php
    Purpose: Security MFA tab panel.

    Notes:
    - Rendered inside the Security page local x-ui.tabs panel.
    - Uses simple account card structure to match the Profile tab setup.
    - Uses x-patterns.key-value-display for compact MFA facts.
    - MFA enrollment and recovery remain dedicated flows.
    ========================================================================== --}}

@php
    $mfaDetails = [
        [
            'label' => 'Authenticator app',
            'value' => $hasMfa ? 'Enabled' : 'Not enabled',
            'status' => $hasMfa ? 'Enabled' : 'Not enabled',
            'statusType' => $hasMfa ? 'green' : 'cool-gray',
        ],
        [
            'label' => 'Recovery codes',
            'value' => $hasMfa ? 'Available' : 'Created after MFA setup',
        ],
    ];
@endphp

<section
    class="border border-[color:var(--ui-border-subtle-01)] bg-[color:var(--ui-layer)] p-6"
    aria-labelledby="account-security-mfa-heading"
    data-account-security-mfa-pane
>
    <header class="mb-6">
        <h2 id="account-security-mfa-heading" class="ui-card-title">
            Multi-factor authentication
        </h2>

        <p class="ui-card-copy mt-2">Set up an authenticator app and manage recovery codes.</p>
    </header>

    <x-patterns.key-value-display :items="$mfaDetails" :columns="2" />

    <footer class="mt-6 flex justify-end">
        @if ($hasMfa)
            <x-ui.button
                :href="route('platform.account.mfa.recovery-codes')"
                kind="primary"
                size="sm"
                icon="arrow--right"
            >
                View recovery codes
            </x-ui.button>
        @else
            <x-ui.button
                :href="route('platform.account.mfa.enroll')"
                kind="primary"
                size="sm"
                icon="arrow--right"
            >
                Start MFA setup
            </x-ui.button>
        @endif
    </footer>
</section>
