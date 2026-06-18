<div class="space-y-8" data-component-live-layout="loading-matrix" data-ui-reference-sample-type="loading">
    <section class="ui-reference-layer-section" data-loading-live-section="large-loading">
        <div class="ui-reference-section-heading">
            <h3>Large loading</h3>
            <p>Large loading is centered in the unavailable page, section, modal, side-panel, tile, or component region and usually uses an overlay to block interaction.</p>
        </div>

        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <article class="ui-loading-demo-region ui-loading-demo-region--section" aria-label="Loading section example">
                <div class="ui-loading-demo-region__content" aria-hidden="true">
                    <h4>Account summary</h4>
                    <p>Region controls are visually present but blocked by the loading overlay.</p>
                    <button type="button" class="ui-action ui-action-secondary" disabled>Refresh</button>
                </div>
                <x-ui.loading active size="lg" placement="section" label="Loading account summary" overlay />
            </article>

            <article class="ui-loading-demo-region ui-loading-demo-region--tile" aria-label="Loading tile example">
                <div class="ui-loading-demo-region__content" aria-hidden="true">
                    <h4>Workspace tile</h4>
                    <p>Tile content keeps its dimensions while data is pending.</p>
                </div>
                <x-ui.loading active size="lg" placement="tile" label="Loading workspace tile" overlay />
            </article>
        </div>
    </section>

    <section class="ui-reference-layer-section" data-loading-live-section="placements">
        <div class="ui-reference-section-heading">
            <h3>Placement examples</h3>
            <p>Placement changes the loading boundary without changing the indicator. Page loading centers in the viewport; modal and side-panel loading center inside their owning surface.</p>
        </div>

        <div class="mt-4 grid gap-4 xl:grid-cols-3">
            <article class="ui-loading-demo-surface ui-loading-demo-surface--page" data-ui-loading-review-boundary="page-preview">
                <h4>Page placement</h4>
                <x-ui.loading active size="lg" placement="page" label="Loading page data" overlay />
            </article>

            <article class="ui-loading-demo-surface">
                <h4>Modal placement</h4>
                <div class="ui-loading-demo-modal">
                    <p>Saving modal changes</p>
                    <x-ui.loading active size="lg" placement="modal" label="Saving changes" overlay />
                </div>
            </article>

            <article class="ui-loading-demo-surface">
                <h4>Side panel placement</h4>
                <div class="ui-loading-demo-panel">
                    <p>Loading panel content</p>
                    <x-ui.loading active size="lg" placement="side-panel" label="Loading panel" overlay />
                </div>
            </article>
        </div>
    </section>

    <section class="ui-reference-layer-section" data-loading-live-section="small-loading">
        <div class="ui-reference-section-heading">
            <h3>Small loading</h3>
            <p>Small loading stays inline with the triggering context, avoids overlays, and pairs with disabled related actions when it prevents duplicate work.</p>
        </div>

        <div class="mt-4 grid gap-4 xl:grid-cols-3">
            <article class="ui-reference-example-card">
                <h4 class="ui-reference-example-title">Inline status</h4>
                <div class="mt-4">
                    <x-ui.loading active size="sm" placement="inline" label="Checking invitation status" :overlay="false" />
                </div>
            </article>

            <article class="ui-reference-example-card">
                <h4 class="ui-reference-example-title">Button-adjacent loading</h4>
                <div class="mt-4">
                    <x-ui.button disabled>
                        <x-ui.loading active size="sm" placement="inline" aria-label="Saving" :overlay="false" />
                        Saving
                    </x-ui.button>
                </div>
            </article>

            <article class="ui-reference-example-card">
                <h4 class="ui-reference-example-title">Inactive state</h4>
                <div class="mt-4 ui-loading-inactive-proof" data-ui-loading-active="false">
                    <x-ui.loading :active="false" size="sm" placement="inline" aria-label="Inactive loading" />
                    <span>No indicator is rendered when loading is inactive.</span>
                </div>
            </article>
        </div>
    </section>

    <section class="ui-reference-layer-section" data-loading-live-section="states-and-boundaries">
        <div class="ui-reference-section-heading">
            <h3>States and boundaries</h3>
            <p>Loading has active and inactive states. Skeleton, inline loading, progress bar, and progress indicator handle nearby but different pending states.</p>
        </div>

        <div class="mt-4 overflow-x-auto rounded-md border" style="border-color: var(--ui-border-subtle-01);">
            <table class="min-w-full text-left text-sm">
                <thead style="background-color: var(--ui-layer-02); color: var(--ui-text-secondary);">
                    <tr>
                        <th class="px-3 py-2 font-medium">Need</th>
                        <th class="px-3 py-2 font-medium">Use</th>
                        <th class="px-3 py-2 font-medium">Reason</th>
                    </tr>
                </thead>
                <tbody style="color: var(--ui-text-primary);">
                    <tr class="border-t" style="border-color: var(--ui-border-subtle-01);">
                        <td class="px-3 py-2">Unknown wait in a major region</td>
                        <td class="px-3 py-2">Loading</td>
                        <td class="px-3 py-2">Spinner plus optional overlay communicates pending work without implying progress.</td>
                    </tr>
                    <tr class="border-t" style="border-color: var(--ui-border-subtle-01);">
                        <td class="px-3 py-2">Known final content shape</td>
                        <td class="px-3 py-2">Skeleton state</td>
                        <td class="px-3 py-2">Skeletons preserve layout better than a spinner for progressive content.</td>
                    </tr>
                    <tr class="border-t" style="border-color: var(--ui-border-subtle-01);">
                        <td class="px-3 py-2">Button-level save/upload</td>
                        <td class="px-3 py-2">Inline loading</td>
                        <td class="px-3 py-2">Inline loading owns local action handoff and completion states.</td>
                    </tr>
                    <tr class="border-t" style="border-color: var(--ui-border-subtle-01);">
                        <td class="px-3 py-2">Measured completion</td>
                        <td class="px-3 py-2">Progress bar or progress indicator</td>
                        <td class="px-3 py-2">Measured or step-based progress should not be represented by an indeterminate spinner.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>
