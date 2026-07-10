{{-- ==========================================================================
    File: Modules/Account/resources/views/partials/security/password.blade.php
    Purpose: Security password tab panel.

    Notes:
    - Rendered inside the Security page local x-ui.tabs panel.
    - Uses simple account card structure to match the Profile tab setup.
    - Uses x-patterns.key-value-display for compact password facts.
    - Password update opens a focused modal dialog.
    ========================================================================== --}}

@php
    $passwordDetails = [
        ['label' => 'Password status', 'value' => 'Configured'],
        ['label' => 'Update requirement', 'value' => 'Current password required'],
        ['label' => 'Sensitive change verification', 'value' => 'MFA step-up may be required', 'span' => 'full'],
    ];
@endphp

<section
    class="border border-[color:var(--ui-border-subtle-01)] bg-[color:var(--ui-layer)] p-6"
    aria-labelledby="account-security-password-heading"
    data-account-security-password-pane
>
    <header class="mb-6">
        <h2 id="account-security-password-heading" class="ui-card-title">
            Password
        </h2>

        <p class="ui-card-copy mt-2">Update your password using your current password.</p>
    </header>

    <x-patterns.key-value-display :items="$passwordDetails" :columns="2" />

    <footer class="mt-6 flex justify-end">
        <x-ui.button
            type="button"
            kind="primary"
            size="sm"
            icon="edit"
            aria-controls="account-password-modal"
            data-ui-dialog-trigger="account-password-modal"
        >
            Update password
        </x-ui.button>
    </footer>
</section>
