{{-- ==========================================================================
    File: Modules/Auth/resources/views/login-password.blade.php
    Purpose: Login password challenge step.

    Flow:
    - Step 1: identifier has already been collected.
    - Step 2: collect password for the current identifier.
    - Step 3: continue to MFA challenge when required.

    Notes:
    - Uses x-patterns.auth.challenge-form for the shared auth shell, panel,
      header, alerts, form wrapper, timezone field, context display, and help
      footer.
    - Keeps password field and submit action explicit in this view.
    - Password field action remains positioned in the field row until
      password-input or text-input supports a label action slot.
    ========================================================================== --}}
<x-layouts.app title="Log in" :grid="false">
    <x-patterns.auth.challenge-form
        title="Log in"
        description="Enter your password to finish signing in."
        :action="route('login.password.store')"
        :context="$identifier"
        context-label="User ID"
        :change-href="route('login')"
        change-label="Change"
        :include-timezone="true"
        actions-loading-text="Signing in..."
    >
        {{-- --------------------------------------------------------------
            Password field

            Forgot password remains positioned in the field row for now.
            Final cleanup should move this into a password-input or text-input
            label action slot once that component API is available.
            ----------------------------------------------------------- --}}
        <div class="mb-6">
            <div class="relative">
                <x-ui.password-input
                    id="password"
                    name="password"
                    label="Password"
                    class="ui-text-input--fluid"
                    required
                    autocomplete="current-password"
                    autofocus
                    :invalid="$errors->has('password')"
                    :invalid-text="$errors->first('password')"
                />

                <x-ui.link
                    text="Forgot password?"
                    variant="inline"
                    size="sm"
                    unavailable
                    class="absolute z-10"
                    style="
                        inset-block-start: 0.8125rem;
                        inset-inline-end: var(--ui-spacing-05);
                    "
                />
            </div>
        </div>

        {{-- --------------------------------------------------------------
        Form actions

        challenge-form wraps this button with common-actions.form-actions.
        ----------------------------------------------------------- --}}
        <x-slot:actions>
            <x-ui.button
                type="submit"
                kind="primary"
                icon="arrow--right"
                size="xl"
            >
                Log in
            </x-ui.button>
        </x-slot:actions>
    </x-patterns.auth.challenge-form>
</x-layouts.app>
