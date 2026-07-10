{{-- ==========================================================================
    File: Modules/Account/resources/views/partials/profile/contact-methods.blade.php
    Purpose: Contact methods tab panel.

    Notes:
    - Rendered inside the Profile page local x-ui.tabs panel.
    - Uses simple account cards to match the working Profile tab setup.
    - Uses x-patterns.key-value-display for compact read-only facts.
    - Uses x-ui.contained-list for repeated contact email rows.
    - Edit/add flows open focused modal dialogs.
    ========================================================================== --}}

@php
    $contactDetails = [
        ['label' => 'Sign-in email', 'value' => $user->email],
        ['label' => 'Phone', 'value' => $user->phone ?: 'Not provided'],
    ];
@endphp

<x-ui.v-stack :gap="5" data-account-contact-methods-pane>
    {{-- ----------------------------------------------------------------------
        Sign-in contact
        ---------------------------------------------------------------------- --}}

    <section
        class="border border-[color:var(--ui-border-subtle-01)] bg-[color:var(--ui-layer)] p-6"
        aria-labelledby="account-sign-in-contact-heading"
        data-account-sign-in-contact-card
    >
        <header class="mb-6">
            <h2 id="account-sign-in-contact-heading" class="ui-card-title">
                Sign-in contact
            </h2>

            <p class="ui-card-copy mt-2">Your sign-in email and primary phone number.</p>
        </header>

        <x-patterns.key-value-display :items="$contactDetails" :columns="2" />

        <footer class="mt-6 flex justify-end">
            <x-ui.button
                type="button"
                kind="primary"
                size="sm"
                icon="edit"
                aria-controls="account-profile-modal"
                data-ui-dialog-trigger="account-profile-modal"
            >
                Edit phone
            </x-ui.button>
        </footer>
    </section>

    {{-- ----------------------------------------------------------------------
        Contact-only emails
        ---------------------------------------------------------------------- --}}

    <section
        class="border border-[color:var(--ui-border-subtle-01)] bg-[color:var(--ui-layer)] p-6"
        aria-labelledby="account-contact-emails-heading"
        data-account-contact-email-card
    >
        <header class="mb-6">
            <h2 id="account-contact-emails-heading" class="ui-card-title">
                Contact-only emails
            </h2>

            <p class="ui-card-copy mt-2">Additional emails can receive notifications, but cannot be used to sign in.</p>
        </header>

        @if ($contactEmails->isEmpty())
            <p class="ui-platform-text-muted text-sm">No contact-only emails have been added.</p>
        @else
            <x-ui.contained-list
                aria-label="Contact-only emails"
                variant="on-page"
                size="sm"
                data-account-contact-email-list
            >
                @foreach ($contactEmails as $contactEmail)
                    @php
                        $contactEmailMeta = $contactEmail->label ?: 'Contact only';

                        $contactEmailStatus = $contactEmail->verified_at
                            ? 'Verified '.$contactEmail->verified_at->format('M j, Y')
                            : 'Not verified';
                    @endphp

                    <x-ui.contained-list-item
                        :title="$contactEmail->email"
                        :description="$contactEmailMeta"
                        :meta="$contactEmailStatus"
                    >
                        <x-slot:actions>
                            <x-ui.form
                                method="DELETE"
                                :action="route('platform.account.contact-emails.destroy', $contactEmail)"
                                data-ui-form-submit-state
                                data-ui-form-submit-state-loading-text="Removing contact email..."
                                data-ui-form-actions
                                data-ui-form-actions-loading-text="Removing contact email..."
                            >
                                <x-ui.button
                                    type="submit"
                                    kind="danger--ghost"
                                    size="sm"
                                    data-ui-form-action
                                    data-ui-form-action-role="delete"
                                    data-ui-form-action-allow-during-busy="false"
                                >
                                    Remove
                                </x-ui.button>
                            </x-ui.form>
                        </x-slot:actions>
                    </x-ui.contained-list-item>
                @endforeach
            </x-ui.contained-list>
        @endif

        <footer class="mt-6 flex justify-end">
            <x-ui.button
                type="button"
                kind="primary"
                size="sm"
                icon="add"
                aria-controls="account-contact-email-modal"
                data-ui-dialog-trigger="account-contact-email-modal"
            >
                Add email
            </x-ui.button>
        </footer>
    </section>
</x-ui.v-stack>
