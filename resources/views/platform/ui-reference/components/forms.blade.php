<x-layouts.app title="UI Reference · Inputs And Forms">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'components.forms'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div>
            <h1 class="ui-page-header-title">Inputs And Form Baseline</h1>
            <p class="ui-page-header-copy">Tier 1 contract for input, textarea, and select behavior including focus, error, disabled, and assistive context.</p>
        </div>

        <section class="ui-card">
            <p class="ui-kicker">Field States</p>
            <form class="mt-4 grid gap-5 lg:grid-cols-2" action="#" method="POST" onsubmit="event.preventDefault()">
                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Workspace Name <span class="text-rose-300">*</span></span>
                    <input type="text" value="Platform Operations Workspace" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 placeholder:text-slate-500 focus:border-slate-500 focus:outline-none" />
                    <p class="mt-2 text-xs text-slate-500">Required. Visible across shared platform navigation.</p>
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Owner Scope</span>
                    <select class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-slate-500 focus:outline-none">
                        <option>Administrator</option>
                        <option>Base Operator</option>
                        <option>Read-Only Auditor</option>
                    </select>
                </label>

                <label class="block lg:col-span-2">
                    <span class="text-sm font-semibold text-slate-200">Description</span>
                    <textarea rows="4" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 placeholder:text-slate-500 focus:border-slate-500 focus:outline-none">Reusable baseline references for phase implementation reviews.</textarea>
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Read-only Identifier</span>
                    <input type="text" value="ui-reference-v1" readonly class="mt-2 w-full rounded-md border border-slate-700 bg-slate-900/40 px-4 py-3 text-slate-400" />
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Disabled Example</span>
                    <input type="text" value="Locked by policy" disabled class="mt-2 w-full rounded-md border border-slate-700 bg-slate-900/40 px-4 py-3 text-slate-500" />
                </label>
            </form>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Validation Block</p>
            <div class="mt-4 grid gap-5 lg:grid-cols-2">
                <div class="rounded-lg border border-rose-500/40 bg-rose-500/10 p-4" role="alert" aria-live="polite">
                    <h2 class="text-sm font-semibold uppercase tracking-[0.15em] text-rose-200">Form Validation Errors</h2>
                    <ul class="mt-2 list-disc space-y-1 pl-4 text-sm text-rose-100">
                        <li>Workspace name is required.</li>
                        <li>Owner scope must be selected.</li>
                    </ul>
                </div>

                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <label class="block">
                        <span class="text-sm font-semibold text-slate-200">Example Error Field</span>
                        <input aria-invalid="true" aria-describedby="workspace-name-error" type="text" value="" placeholder="Required field" class="mt-2 w-full rounded-md border border-rose-500/60 bg-slate-950 px-4 py-3 text-slate-100 placeholder:text-slate-500 focus:border-rose-400 focus:outline-none" />
                        <p id="workspace-name-error" class="mt-2 text-xs text-rose-300">Workspace name cannot be empty.</p>
                    </label>
                </div>
            </div>

            <div class="mt-5 flex flex-wrap items-center gap-3">
                <button type="button" class="ui-action ui-action-ghost">Cancel</button>
                <button type="button" class="ui-action ui-action-danger">Delete</button>
                <button type="submit" class="ui-action ui-action-primary">Save Workspace</button>
            </div>
        </section>
    </section>
</x-layouts.app>
