<x-layouts.app title="Set Up MFA" :grid="false">
    <section class="w-full space-y-6">
        <x-patterns.page-title-actions-row
            title="Set Up MFA"
            description="Add an authenticator app to your account."
        />

        @if ($errors->any())
            <x-patterns.validation-summary :errors="$errors->all()" />
        @endif

        <x-patterns.form-section
            title="Authenticator App"
            description="Scan the QR code or use the manual key, then enter a current code."
            kicker="Account security"
        >
            <div class="grid gap-6 lg:grid-cols-[16rem_1fr]">
                <div class="rounded-md border border-slate-200 bg-white p-4">
                    <img src="{{ $qrSvg }}" alt="MFA setup QR code" class="mx-auto size-56">
                </div>

                <form method="POST" action="{{ route('platform.account.mfa.confirm') }}" class="space-y-5">
                    @csrf

                    <x-patterns.form-group for="manual_key" label="Manual Key">
                        <input id="manual_key" type="text" value="{{ $manualKey }}" readonly class="ui-input w-full font-mono text-sm">
                    </x-patterns.form-group>

                    <x-patterns.form-group for="code" label="Authenticator Code">
                        <input id="code" name="code" type="text" required inputmode="numeric" autocomplete="one-time-code" class="ui-input w-full">
                    </x-patterns.form-group>

                    <x-patterns.forms.actions>
                        <x-ui.button type="submit" semantic="primary">Enable MFA</x-ui.button>
                        <x-ui.button :href="route('platform.account.index')" semantic="tertiary">Cancel</x-ui.button>
                    </x-patterns.forms.actions>
                </form>
            </div>
        </x-patterns.form-section>
    </section>
</x-layouts.app>
