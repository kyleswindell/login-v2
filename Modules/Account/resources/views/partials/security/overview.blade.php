{{-- ==========================================================================
    File: Modules/Account/resources/views/partials/security/overview.blade.php
    Purpose: Security overview tab panel.

    Notes:
    - Rendered inside the Security page local x-ui.tabs panel.
    - Uses simple account card structure to match the Profile tab setup.
    - Uses x-patterns.key-value-display for compact security facts.
    ========================================================================== --}}

@php
    $securityDetails = [
        [
            'label' => 'Password',
            'value' => 'Configured',
        ],
        [
            'label' => 'Multi-factor authentication',
            'value' => $hasMfa ? 'Enabled' : 'Not enabled',
            'status' => $hasMfa ? 'Protected' : 'Available',
            'statusType' => $hasMfa ? 'green' : 'cool-gray',
        ],
        [
            'label' => 'Sensitive changes',
            'value' => 'Fresh verification may be required',
            'span' => 'full',
        ],
    ];
@endphp

<section
    class="border border-[color:var(--ui-border-subtle-01)] bg-[color:var(--ui-layer)] p-6"
    aria-labelledby="account-security-overview-heading"
    data-account-security-overview-pane
>
    <header class="mb-6">
        <h2 id="account-security-overview-heading" class="ui-card-title">
            Security overview
        </h2>

        <p class="ui-card-copy mt-2">Review how your account is protected.</p>
    </header>

    <x-patterns.key-value-display :items="$securityDetails" :columns="2" />
</section>
