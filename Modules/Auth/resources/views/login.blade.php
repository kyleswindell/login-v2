{{-- ==========================================================================
    File: Modules/Auth/resources/views/login.blade.php
    Purpose: Login identifier step.

    Flow:
    - Step 1: collect email or username.
    - Step 2: continue to password challenge.
    - Step 3: continue to MFA challenge when required.

    Notes:
    - Uses x-patterns.auth.challenge-form for the shared auth shell, panel,
      header, alerts, form wrapper, timezone field, and help footer.
    - Keeps identifier field, remember user ID behavior, and submit action
      explicit in this view.
    - The remember user ID help text is rendered directly with x-ui.toggletip.
    - Forgot ID remains positioned in the field row until text-input supports
      a label action slot.
    ========================================================================== --}}

<x-layouts.app title="Log in" :grid="false">
    <x-patterns.auth.challenge-form
        title="Log in"
        description="Enter your user ID to continue."
        :action="route('login.identify')"
        :include-timezone="true"
        actions-loading-text="Checking account..."
    >
        {{-- --------------------------------------------------------------
            Identifier field

            Forgot ID remains positioned in the field row for now.
            Final cleanup should move this into a text-input label action
            slot once that component API is available.
            ----------------------------------------------------------- --}}
        <div class="relative">
            <x-ui.text-input
                id="identifier"
                name="identifier"
                label="Email or username"
                class="ui-text-input--fluid"
                :value="old('identifier', $rememberedIdentifier ?? '')"
                required
                autocomplete="username"
                autofocus
                :invalid="$errors->has('identifier')"
                :invalid-text="$errors->first('identifier')"
            />

            <x-ui.link
                text="Forgot ID?"
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

        {{-- --------------------------------------------------------------
            Remember user ID

            Uses the checkbox decorator slot with the approved toggletip
            component. The helper opens below the icon so it remains visually
            attached to the trigger in this compact form row.
            ----------------------------------------------------------- --}}
        <div class="px-4 py-6">
            <x-ui.checkbox
                id="remember_identifier"
                name="remember_identifier"
                value="1"
                label="Remember user ID"
                :checked="old('remember_identifier') || filled($rememberedIdentifier ?? '')"
            >
                <x-slot:decorator>
                    <x-ui.toggletip
                        label="About remembered user ID"
                        align="bottom"
                    >
                        <p>Stores only your user ID on this browser. It does not keep you signed in.</p>
                    </x-ui.toggletip>
                </x-slot:decorator>
            </x-ui.checkbox>
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
                Continue
            </x-ui.button>
        </x-slot:actions>
    </x-patterns.auth.challenge-form>
</x-layouts.app>
