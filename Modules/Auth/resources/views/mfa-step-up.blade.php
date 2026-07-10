{{-- ==========================================================================
    File: Modules/Auth/resources/views/mfa-step-up.blade.php
    Purpose: MFA step-up verification challenge.

    Flow:
    - Step 1: user is authenticated.
    - Step 2: user attempts a security-sensitive action.
    - Step 3: user confirms MFA before continuing.

    Notes:
    - Uses x-patterns.auth.challenge-form for the shared auth shell, panel,
      header, alerts, form wrapper, account context, and help footer.
    - Uses x-patterns.auth.challenge-form for the shared auth shell.
    - Keeps the authenticator code field and action controls explicit in this
      view.
    ========================================================================== --}}

<x-layouts.app title="Verify MFA" :grid="false">
    <x-patterns.auth.challenge-form
        title="Verify MFA"
        description="Confirm MFA before continuing with this security-sensitive action."
        :action="route('mfa.step-up.verify')"
        :context="$user->email"
        context-label="User ID"
        :help-centered="true"
        actions-width="full"
        actions-alignment="stretch"
        :actions-auto-stack="false"
        actions-loading-text="Verifying code..."
    >
        >
        {{-- --------------------------------------------------------------
            Authenticator code
            ----------------------------------------------------------- --}}
        <div class="mb-6">
            <x-ui.text-input
                id="code"
                name="code"
                label="Authenticator code"
                class="ui-text-input--fluid"
                required
                inputmode="numeric"
                autocomplete="one-time-code"
                autofocus
                :invalid="$errors->has('code')"
                :invalid-text="$errors->first('code')"
            />
        </div>

        {{-- --------------------------------------------------------------
            Form actions

            challenge-form wraps these buttons with common-actions.form-actions.
            ----------------------------------------------------------- --}}
        <x-slot:actions>
            <x-ui.button type="button" kind="ghost" size="xl" disabled>
                Alternate verification
            </x-ui.button>

            <x-ui.button
                type="submit"
                kind="primary"
                size="xl"
                icon="arrow--right"
            >
                Verify code
            </x-ui.button>
        </x-slot:actions>
    </x-patterns.auth.challenge-form>
</x-layouts.app>
