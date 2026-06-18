<div class="space-y-6" data-component-live-layout="code-snippet-matrix">
    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-code-snippet-live-section="anatomy">
        <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
            <div>
                <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Anatomy and variants</h3>
                <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Snippet text owns exact syntax. Copy and show-more controls are optional component controls, not local page utilities.</p>
            </div>
            <span class="inline-flex w-fit items-center rounded-full border px-2.5 py-1 text-xs font-semibold" style="border-color: var(--ui-border-subtle-01); color: var(--ui-text-secondary);">Grid-aligned max width</span>
        </div>

        <div class="mt-4 grid gap-4">
            <article class="max-w-3xl rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Inline</h4>
                <p class="mt-3 text-sm leading-6" style="color: var(--ui-text-secondary);">
                    Use <x-ui.code-snippet variant="inline" copyable><span class="ui-code-token-function">php artisan</span> <span class="ui-code-token-keyword">migrate</span></x-ui.code-snippet> inline when a short command or token belongs inside body copy.
                </p>
            </article>

            <article class="max-w-3xl rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Single line with horizontal overflow</h4>
                <div class="mt-3">
                    <x-ui.code-snippet variant="single" language="Command" copyable><span class="ui-code-token-function">docker compose</span> <span class="ui-code-token-keyword">exec</span> <span class="ui-code-token-property">-T</span> <span class="ui-code-token-property">app</span> <span class="ui-code-token-function">php artisan</span> <span class="ui-code-token-keyword">test</span> <span class="ui-code-token-string">tests/Feature/Platform/PlatformUiReferenceTest.php</span> <span class="ui-code-token-property">--filter</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">code_snippet_component_recovery_page_renders_required_examples</span></x-ui.code-snippet>
                </div>
            </article>

            <article class="max-w-3xl rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Multi-line with show more</h4>
                <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Collapsed multi-line examples use a ghost show-more button and preserve horizontal scrolling for long syntax.</p>
                <div class="mt-3">
                    <x-ui.code-snippet variant="multi" language="Blade" copyable expandable collapsed-lines="5"><span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.data-table</span>
    <span class="ui-code-token-property">title</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"Workspace users"</span>
    <span class="ui-code-token-property">:columns</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"$columns"</span>
    <span class="ui-code-token-property">:rows</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"$users"</span>
    <span class="ui-code-token-property">sortable</span>
    <span class="ui-code-token-property">filterable</span>
<span class="ui-code-token-punctuation">&gt;</span>
    <span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-slot:toolbar</span><span class="ui-code-token-punctuation">&gt;</span>
        <span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.search</span> <span class="ui-code-token-property">name</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"query"</span> <span class="ui-code-token-property">label</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"Search users"</span> <span class="ui-code-token-punctuation">/&gt;</span>
        <span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.button</span> <span class="ui-code-token-property">semantic</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"primary"</span> <span class="ui-code-token-property">icon</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"heroicon-o-plus"</span><span class="ui-code-token-punctuation">&gt;</span>Invite user<span class="ui-code-token-punctuation">&lt;/</span><span class="ui-code-token-keyword">x-ui.button</span><span class="ui-code-token-punctuation">&gt;</span>
    <span class="ui-code-token-punctuation">&lt;/</span><span class="ui-code-token-keyword">x-slot:toolbar</span><span class="ui-code-token-punctuation">&gt;</span>
<span class="ui-code-token-punctuation">&lt;/</span><span class="ui-code-token-keyword">x-ui.data-table</span><span class="ui-code-token-punctuation">&gt;</span></x-ui.code-snippet>
                </div>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-code-snippet-live-section="copy-controls">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Copy controls</h3>
        <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Copy uses an icon-only ghost button with a tooltip. Hover/focus labels describe the action; activation changes the tooltip and live text to “Copied to clipboard”.</p>
        <div class="mt-4 grid gap-4 md:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Copy feedback</h4>
                <div class="mt-3">
                    <x-ui.code-snippet variant="single" language="Blade" copyable copy-state="copied"><span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.button</span> <span class="ui-code-token-property">semantic</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"primary"</span><span class="ui-code-token-punctuation">&gt;</span>Save<span class="ui-code-token-punctuation">&lt;/</span><span class="ui-code-token-keyword">x-ui.button</span><span class="ui-code-token-punctuation">&gt;</span></x-ui.code-snippet>
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Copy button states</h4>
                <div class="mt-4 flex flex-wrap items-center gap-3">
                    <x-ui.copy-button label="Enabled" size="sm" class="ui-code-snippet-state-button" />
                    <x-ui.copy-button label="Hover" size="sm" class="ui-code-snippet-state-button is-hover" />
                    <x-ui.copy-button label="Focus" size="sm" class="ui-code-snippet-state-button is-focus" />
                    <x-ui.copy-button label="Active" size="sm" class="ui-code-snippet-state-button is-active" />
                    <x-ui.copy-button label="Disabled" size="sm" class="ui-code-snippet-state-button" disabled />
                </div>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-code-snippet-live-section="syntax-and-modifiers">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Syntax, modifiers, and toggle states</h3>
        <div class="mt-4 grid gap-4 lg:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Highlighted syntax tokens</h4>
                <div class="mt-3">
                    <x-ui.code-snippet variant="multi" language="HTML" copyable><span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">button</span> <span class="ui-code-token-property">type</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"button"</span><span class="ui-code-token-punctuation">&gt;</span>
    <span class="ui-code-token-comment">&lt;!-- Token colors remain accessible in app themes. --&gt;</span>
    <span class="ui-code-token-keyword">Save</span>
<span class="ui-code-token-punctuation">&lt;/</span><span class="ui-code-token-keyword">button</span><span class="ui-code-token-punctuation">&gt;</span></x-ui.code-snippet>
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Light modifier</h4>
                <div class="mt-3">
                    <x-ui.code-snippet variant="single" language="Token" light>--ui-layer-02</x-ui.code-snippet>
                </div>
            </article>
        </div>

        <div class="mt-4 rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
            <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Show toggle states</h4>
            <div class="mt-4 flex flex-wrap items-center gap-3">
                <button type="button" class="ui-action ui-action-ghost ui-code-snippet-toggle">Show more</button>
                <button type="button" class="ui-action ui-action-ghost ui-code-snippet-toggle is-hover">Show more</button>
                <button type="button" class="ui-action ui-action-ghost ui-code-snippet-toggle is-focus">Show more</button>
                <button type="button" class="ui-action ui-action-ghost ui-code-snippet-toggle" aria-expanded="true">Show less</button>
            </div>
        </div>
    </section>
</div>
