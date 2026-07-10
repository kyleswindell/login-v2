@php
    $codes = is_array($codes ?? null) ? $codes : [];
    $downloadText = "MFA recovery codes\n\n".implode("\n", $codes)."\n";
    $downloadHref = 'data:text/plain;charset=utf-8,'.rawurlencode($downloadText);
@endphp

<x-layouts.app
    title="MFA Recovery Codes"
    :grid="false"
    :page-title="null"
    :page-subtitle="null"
>
    <section
        class="flex min-h-[32rem] w-full items-start justify-center px-4 py-8 md:items-center"
        data-mfa-recovery-codes-surface
    >
        <article
            class="w-full max-w-[31.25rem] rounded-sm shadow-xl"
            style="background: var(--ui-layer-01); color: var(--ui-text-primary);"
            aria-labelledby="mfa-recovery-codes-title"
        >
            <div class="flex items-start justify-between gap-4 px-5 pb-2 pt-6">
                <h1
                    id="mfa-recovery-codes-title"
                    class="text-xl font-semibold leading-7"
                    style="color: var(--ui-text-primary);"
                >
                    Save your recovery codes
                </h1>

                <x-ui.icon-button
                    :href="$continueUrl"
                    icon="close"
                    label="Close recovery codes"
                    semantic="ghost"
                    size="md"
                    data-mfa-recovery-codes-close
                />
            </div>

            <div class="px-5 pb-5">
                <div class="max-w-[28rem] space-y-5 text-base leading-6" style="color: var(--ui-text-secondary);">
                    <p>
                        Recovery codes can be used to access your account in the event you lose access to your account or do not have access to your phone. Each code can only be used once.
                    </p>

                    <p>
                        Keep them somewhere safe so you do not get locked out of your account
                    </p>
                </div>

                <ul
                    class="mt-4 grid list-disc gap-x-8 gap-y-1 pl-8 font-mono text-sm leading-5 sm:grid-cols-2"
                    style="color: var(--ui-text-primary);"
                    aria-label="One-time MFA recovery codes"
                    data-mfa-recovery-codes-list
                >
                    @foreach ($codes as $code)
                        <li>
                            <code class="font-mono">{{ $code }}</code>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-6 flex flex-col-reverse items-stretch justify-end gap-3 sm:flex-row sm:items-center">
                    <x-ui.button
                        semantic="ghost"
                        size="lg"
                        disabled
                        data-mfa-recovery-codes-create
                    >
                        Create New Codes
                    </x-ui.button>

                    <x-ui.button
                        :href="$downloadHref"
                        semantic="primary"
                        size="lg"
                        download="mfa-recovery-codes.txt"
                        data-mfa-recovery-codes-download
                    >
                        Download
                    </x-ui.button>
                </div>
            </div>
        </article>
    </section>
</x-layouts.app>
