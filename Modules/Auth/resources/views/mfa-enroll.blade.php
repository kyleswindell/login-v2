{{-- ==========================================================================
    File: Modules/Auth/resources/views/mfa-enroll.blade.php
    Purpose: MFA enrollment step.

    Flow:
    - Step 1: user has authenticated with identifier and password.
    - Step 2: user scans the QR code or copies the manual setup key.
    - Step 3: user enters an authenticator app code to enable MFA.

    Notes:
    - Uses x-patterns.auth.challenge-form for the shared auth shell, panel,
      header, alerts, form wrapper, and help footer.
    - Keeps QR code, manual key, copy behavior, verification code field, and
      action controls explicit in this view.
    - The manual key remains a read-only fluid input because users may need to
      copy it into an authenticator app.
    - The manual key copy action is handled by a small temporary inline script
      until shared clipboard behavior exists.
    ========================================================================== --}}

<x-layouts.app title="Set up MFA" :grid="false">
    <x-patterns.auth.challenge-form
        title="Secure your account"
        description="Your organization requires multifactor authentication to continue. Scan the QR code with an authenticator app, then enter the 6-digit code it generates."
        :action="$action"
    >
        {{-- --------------------------------------------------------------
            Enrollment content
            ----------------------------------------------------------- --}}
        <div class="mb-6 space-y-5">
            {{-- ----------------------------------------------------------
                Authenticator app guidance
                ------------------------------------------------------- --}}
            <div class="px-4">
                <p class="ui-platform-text-muted text-sm leading-6">Use your preferred authenticator app or install

                <x-ui.link href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" text="Google Authenticator for Android" variant="inline" target="_blank" rel="noopener noreferrer" />

                or

                <x-ui.link href="https://apps.apple.com/us/app/google-authenticator/id388497605" text="iPhone" variant="inline" target="_blank" rel="noopener noreferrer" />.</p>
            </div>

            {{-- ----------------------------------------------------------
                QR code
                ------------------------------------------------------- --}}
            <div class="px-4">
                <div class="bg-white p-4">
                    <img
                        src="{{ $qrSvg }}"
                        alt="MFA setup QR code"
                        class="mx-auto size-56"
                    />
                </div>
            </div>

            {{-- ----------------------------------------------------------
                Manual setup key
                ------------------------------------------------------- --}}
            <div class="space-y-2">
                <div class="relative">
                    <x-ui.text-input
                        id="manual_key"
                        label="Manual key"
                        class="ui-text-input--fluid"
                        :value="$manualKey"
                        :read-only="true"
                        aria-readonly="true"
                        autocomplete="off"
                    />

                    <button
                        type="button"
                        class="ui-link ui-link-inline ui-link-sm absolute z-10"
                        style="
                            inset-block-start: 0.8125rem;
                            inset-inline-end: var(--ui-spacing-05);
                        "
                        data-auth-copy-key-trigger
                        data-auth-copy-key-target="manual_key"
                    >
                        <span data-auth-copy-key-text>Copy key</span>
                    </button>
                </div>

                <p class="ui-platform-text-muted px-4 text-sm leading-6">Trouble scanning? Use this key to set up MFA manually.</p>

                <span
                    class="ui-assistive-text"
                    role="status"
                    aria-live="polite"
                    data-auth-copy-key-status
                ></span>
            </div>

            {{-- ----------------------------------------------------------
                Step divider
                ------------------------------------------------------- --}}
            <div class="flex items-center gap-4 px-4">
                <span class="ui-platform-border flex-1 border-t"></span>

                <span
                    class="ui-platform-text-muted text-xs font-medium uppercase tracking-normal"
                >
                    Then
                </span>

                <span class="ui-platform-border flex-1 border-t"></span>
            </div>

            {{-- ----------------------------------------------------------
                Verification code
                ------------------------------------------------------- --}}
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
            ----------------------------------------------------------- --}}
        <x-slot:actions>
            <x-ui.button-set
                fluid
                width="full"
                align="stretch"
                :auto-stack="false"
                class="w-full"
            >
                <x-ui.button type="button" kind="ghost" size="xl" disabled>
                    Alternate verification
                </x-ui.button>

                <x-ui.button
                    type="submit"
                    kind="primary"
                    size="xl"
                    icon="arrow--right"
                >
                    Enable MFA
                </x-ui.button>
            </x-ui.button-set>
        </x-slot:actions>
    </x-patterns.auth.challenge-form>

    {{-- ------------------------------------------------------------------
        Temporary manual-key copy initializer
        ------------------------------------------------------------------ --}}
    <script>
        (() => {
            const trigger = document.querySelector(
                "[data-auth-copy-key-trigger]",
            );
            const status = document.querySelector(
                "[data-auth-copy-key-status]",
            );

            if (!trigger) {
                return;
            }

            const targetId = trigger.dataset.authCopyKeyTarget;
            const target = targetId ? document.getElementById(targetId) : null;
            const textNode = trigger.querySelector("[data-auth-copy-key-text]");
            const defaultText = textNode?.textContent || "Copy key";

            const setStatus = (message) => {
                if (status) {
                    status.textContent = message;
                }

                if (textNode) {
                    textNode.textContent = message || defaultText;
                }
            };

            const fallbackCopy = () => {
                if (!(target instanceof HTMLInputElement)) {
                    return false;
                }

                target.focus();
                target.select();

                try {
                    return document.execCommand("copy");
                } catch {
                    return false;
                }
            };

            trigger.addEventListener("click", async () => {
                const value =
                    target instanceof HTMLInputElement ? target.value : "";

                if (!value) {
                    setStatus("Nothing to copy");

                    window.setTimeout(() => setStatus(""), 2000);
                    return;
                }

                let copied = false;

                if (navigator.clipboard?.writeText) {
                    try {
                        await navigator.clipboard.writeText(value);
                        copied = true;
                    } catch {
                        copied = fallbackCopy();
                    }
                } else {
                    copied = fallbackCopy();
                }

                setStatus(copied ? "Copied" : "Copy failed");

                window.setTimeout(() => setStatus(""), 2000);
            });
        })();
    </script>
</x-layouts.app>
