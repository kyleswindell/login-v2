@php
    $multiLineExample = <<<'CODE'
<x-ui.data-table
    title="Workspace users"
    :columns="$columns"
    :rows="$users"
    sortable
    filterable
>
    <x-slot:toolbar>
        <x-ui.search name="query" label="Search users" />
        <x-ui.button semantic="primary" icon="heroicon-o-plus">Invite user</x-ui.button>
    </x-slot:toolbar>
</x-ui.data-table>
CODE;

    $longCommand = 'docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=code_snippet_component_recovery_page_renders_required_examples';
@endphp

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
                    Use <x-ui.code-snippet variant="inline" copyable>php artisan migrate</x-ui.code-snippet> inline when a short command or token belongs inside body copy.
                </p>
            </article>

            <article class="max-w-3xl rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Single line with horizontal overflow</h4>
                <div class="mt-3">
                    <x-ui.code-snippet variant="single" language="Command" copyable>{{ $longCommand }}</x-ui.code-snippet>
                </div>
            </article>

            <article class="max-w-3xl rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Multi-line with show more</h4>
                <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Collapsed multi-line examples use a ghost show-more button and preserve horizontal scrolling for long syntax.</p>
                <div class="mt-3">
                    <x-ui.code-snippet variant="multi" language="Blade" copyable expandable collapsed-lines="5">{{ $multiLineExample }}</x-ui.code-snippet>
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
                    <x-ui.code-snippet variant="single" language="Blade" copyable copy-state="copied">&lt;x-ui.button semantic="primary"&gt;Save&lt;/x-ui.button&gt;</x-ui.code-snippet>
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Copy button states</h4>
                <div class="mt-4 flex flex-wrap items-center gap-3">
                    <x-ui.icon-button icon="heroicon-o-clipboard-document" label="Enabled" tooltip="Copy to clipboard" size="sm" semantic="ghost" class="ui-code-snippet-state-button" />
                    <x-ui.icon-button icon="heroicon-o-clipboard-document" label="Hover" tooltip="Copy to clipboard" size="sm" semantic="ghost" class="ui-code-snippet-state-button is-hover" />
                    <x-ui.icon-button icon="heroicon-o-clipboard-document" label="Focus" tooltip="Copy to clipboard" size="sm" semantic="ghost" class="ui-code-snippet-state-button is-focus" />
                    <x-ui.icon-button icon="heroicon-o-clipboard-document" label="Active" tooltip="Copy to clipboard" size="sm" semantic="ghost" class="ui-code-snippet-state-button is-active" />
                    <x-ui.icon-button icon="heroicon-o-clipboard-document" label="Disabled" tooltip="Copy to clipboard" size="sm" semantic="ghost" class="ui-code-snippet-state-button" disabled />
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
