@php
    $comparisonRows = [
        ['Link', 'Navigate to another route, section, resource, email address, or phone number.', '<x-ui.link href="/platform/docs">Open documentation</x-ui.link>'],
        ['Button', 'Save, submit, confirm, cancel, delete, reveal a menu, or change state.', '<x-ui.button semantic="primary">Save changes</x-ui.button>'],
        ['Tile', 'Represent a richer destination card, especially when imagery or a whole card is the link.', '<x-ui.tile href="/platform/workspaces" title="Workspace" />'],
    ];
@endphp

<div class="space-y-6" data-component-live-layout="link-matrix" data-ui-reference-sample-type="links">
    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-link-live-section="variant-purpose-matrix">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Variant purpose matrix</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Inline links live inside prose and are always underlined. Standalone links sit outside sentence flow and may use a trailing icon when it clarifies the destination.</p>

        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-link-example="inline-content-link">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Inline content link</h4>
                <p class="mt-3 text-sm leading-6" style="color: var(--ui-text-secondary);">
                    Review the
                    <x-ui.link href="#link-destination-proof" variant="inline">billing policy section</x-ui.link>
                    before changing tenant billing settings.
                </p>
                <p class="mt-3 text-xs" style="color: var(--ui-text-helper);">No icon is rendered for inline links, even when an icon prop is passed.</p>
                <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">
                    This inline proof passes an icon prop but renders text only:
                    <x-ui.link href="#link-destination-proof" variant="inline" icon="heroicon-o-arrow-top-right-on-square">policy notes</x-ui.link>.
                </p>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-link-example="standalone-internal-link">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Standalone internal link</h4>
                <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Standalone links follow supporting copy and do not look like command buttons.</p>
                <div class="mt-4 flex flex-col items-start gap-3">
                    <p class="text-xs font-semibold uppercase" style="color: var(--ui-text-helper);">Icon trailing</p>
                    <x-ui.link href="/platform/ui-reference/components/button" navigate icon="heroicon-o-arrow-right">
                        Compare Button rules
                    </x-ui.link>
                    <x-ui.link href="#link-destination-proof" icon="heroicon-o-arrow-down">
                        Jump to destination proof
                    </x-ui.link>
                </div>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-link-live-section="destination-types">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Destination types</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">A link destination can be internal, external, same-page, email, phone, or a file resource. These examples use real link semantics, not pseudo-links.</p>

        <div class="mt-4 grid gap-3 md:grid-cols-2 xl:grid-cols-3">
            <div class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <p class="text-xs font-semibold uppercase" style="color: var(--ui-text-helper);">External/help link</p>
                <x-ui.link class="mt-3" href="https://carbondesignsystem.com/components/link/usage/" external new-tab icon="heroicon-o-arrow-top-right-on-square">
                    Open Carbon Link guidance
                </x-ui.link>
            </div>
            <div class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <p class="text-xs font-semibold uppercase" style="color: var(--ui-text-helper);">Email link</p>
                <x-ui.link class="mt-3" href="mailto:support@example.com" icon="heroicon-o-envelope">
                    Email support
                </x-ui.link>
            </div>
            <div class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <p class="text-xs font-semibold uppercase" style="color: var(--ui-text-helper);">Phone link</p>
                <x-ui.link class="mt-3" href="tel:+15555551212" icon="heroicon-o-phone">
                    Call support
                </x-ui.link>
            </div>
            <div class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <p class="text-xs font-semibold uppercase" style="color: var(--ui-text-helper);">Download link</p>
                <x-ui.link class="mt-3" href="/platform/ui-reference" download="ui-reference.html" icon="heroicon-o-arrow-down-tray">
                    Download reference
                </x-ui.link>
            </div>
            <div class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <p class="text-xs font-semibold uppercase" style="color: var(--ui-text-helper);">Current navigation link</p>
                <x-ui.link class="mt-3" href="/platform/ui-reference/components/link" current="page">
                    Link component
                </x-ui.link>
            </div>
            <div class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <p class="text-xs font-semibold uppercase" style="color: var(--ui-text-helper);">Unavailable treatment</p>
                <x-ui.link class="mt-3" href="/platform/billing" unavailable>
                    Billing unavailable
                </x-ui.link>
            </div>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-link-live-section="sizes-and-states">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Size scale and states</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Sizes map to Link-owned typography roles. Visited styling is opt-in proof, not a global browser-history policy.</p>

        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Size scale</h4>
                <div class="mt-4 flex flex-col items-start gap-3">
                    <x-ui.link href="#link-destination-proof" size="sm">Small helper link</x-ui.link>
                    <x-ui.link href="#link-destination-proof" size="md">Medium body link</x-ui.link>
                    <x-ui.link href="#link-destination-proof" size="lg" icon="heroicon-o-arrow-right">Large resource link</x-ui.link>
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">State examples</h4>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    <x-ui.link href="#link-destination-proof">Enabled link</x-ui.link>
                    <x-ui.link href="#link-destination-proof" class="is-hover">Hover state</x-ui.link>
                    <x-ui.link href="#link-destination-proof" class="is-focus">Focus state</x-ui.link>
                    <x-ui.link href="#link-destination-proof" class="is-active">Active state</x-ui.link>
                    <x-ui.link href="#link-destination-proof" visited>Visited policy</x-ui.link>
                    <x-ui.link href="#link-destination-proof" disabled>Disabled link</x-ui.link>
                </div>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-link-live-section="link-versus-actions">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Link versus Button versus Tile</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Links navigate. Buttons perform commands. Tiles own richer destination cards.</p>
        <div class="mt-4 overflow-x-auto rounded-lg border" style="border-color: var(--ui-border-subtle-01);">
            <table class="min-w-full text-left text-sm">
                <thead style="background-color: var(--ui-layer-accent-01); color: var(--ui-text-secondary);">
                    <tr>
                        <th class="px-4 py-3">Use</th>
                        <th class="px-4 py-3">Purpose</th>
                        <th class="px-4 py-3">Example</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comparisonRows as [$component, $purpose, $example])
                        <tr class="border-t" style="border-color: var(--ui-border-subtle-01);">
                            <td class="px-4 py-3 font-semibold" style="color: var(--ui-text-primary);">{{ $component }}</td>
                            <td class="max-w-xl px-4 py-3 leading-6" style="color: var(--ui-text-secondary);">{{ $purpose }}</td>
                            <td class="px-4 py-3"><code>{{ $example }}</code></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section id="link-destination-proof" tabindex="-1" class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-link-live-section="same-page-anchor">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Same-page anchor destination</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Same-page links point to a real destination section and do not use fake `href="#"` behavior.</p>
    </section>
</div>
