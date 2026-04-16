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
                    <span class="ui-control-label">Workspace Name <span class="text-red-300">*</span></span>
                    <input type="text" value="Platform Operations Workspace" class="ui-input mt-2" />
                    <p class="ui-control-copy">Required. Visible across shared platform navigation.</p>
                </label>

                <label class="block">
                    <span class="ui-control-label">Owner Scope</span>
                    <select class="ui-select mt-2">
                        <option>Administrator</option>
                        <option>Base Operator</option>
                        <option>Read-Only Auditor</option>
                    </select>
                </label>

                <label class="block lg:col-span-2">
                    <span class="ui-control-label">Description</span>
                    <textarea rows="4" class="ui-textarea mt-2">Reusable baseline references for phase implementation reviews.</textarea>
                </label>

                <label class="block">
                    <span class="ui-control-label">Read-only Identifier</span>
                    <input type="text" value="ui-reference-v1" readonly class="ui-input mt-2" />
                </label>

                <label class="block">
                    <span class="ui-control-label">Disabled Example</span>
                    <input type="text" value="Locked by policy" disabled class="ui-input mt-2" />
                </label>
            </form>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">State Visibility</p>
            <p class="mt-2 text-sm text-slate-400">Focus, selected, disabled, and validation states are rendered explicitly for review.</p>
            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Focused Text Input</p>
                    <input type="text" value="Focused workspace name" class="ui-input mt-3 ring-2 ring-sky-400/50 ring-offset-2 ring-offset-slate-900" />
                </div>
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Focused Select</p>
                    <select class="ui-select mt-3 ring-2 ring-sky-400/50 ring-offset-2 ring-offset-slate-900">
                        <option selected>Administrator</option>
                        <option>Base Operator</option>
                    </select>
                </div>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Validation Block</p>
            <div class="mt-4 grid gap-5 lg:grid-cols-2">
                <div class="ui-inline-alert ui-inline-alert-danger" role="alert" aria-live="polite">
                    <h2 class="text-sm font-semibold uppercase tracking-[0.15em]">Form Validation Errors</h2>
                    <ul class="mt-2 list-disc space-y-1 pl-4 text-sm">
                        <li>Workspace name is required.</li>
                        <li>Owner scope must be selected.</li>
                    </ul>
                </div>

                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <label class="block">
                        <span class="ui-control-label">Example Error Field</span>
                        <input aria-invalid="true" aria-describedby="workspace-name-error" type="text" value="" placeholder="Required field" class="ui-input mt-2" />
                        <p id="workspace-name-error" class="ui-control-error">Workspace name cannot be empty.</p>
                    </label>
                </div>
            </div>

            <div class="mt-5 flex flex-wrap items-center gap-3">
                <button type="button" class="ui-action ui-action-ghost">Cancel</button>
                <button type="button" class="ui-action ui-action-danger">Delete</button>
                <button type="submit" class="ui-action ui-action-primary">Save Workspace</button>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Selectable Controls</p>
            <div class="mt-4 grid gap-6 lg:grid-cols-2">
                <div class="space-y-4 rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <div>
                        <p class="ui-control-label">Checkbox</p>
                        <label class="mt-3 flex items-start gap-3 text-sm text-slate-200">
                            <input type="checkbox" checked class="mt-0.5 h-4 w-4 rounded border-slate-600 bg-slate-950 text-sky-400 focus:ring-sky-400/40" />
                            <span>
                                Enable workspace notifications
                                <span class="block text-xs text-slate-500">Helper text remains visible for binary settings.</span>
                            </span>
                        </label>
                    </div>

                    <div>
                        <p class="ui-control-label">Radio Group</p>
                        <fieldset class="mt-3 space-y-2">
                            <legend class="sr-only">Default review mode</legend>
                            <label class="flex items-center gap-3 text-sm text-slate-200">
                                <input type="radio" checked name="review_mode" class="h-4 w-4 border-slate-600 bg-slate-950 text-sky-400 focus:ring-sky-400/40" />
                                <span>Guided review</span>
                            </label>
                            <label class="flex items-center gap-3 text-sm text-slate-200">
                                <input type="radio" name="review_mode" class="h-4 w-4 border-slate-600 bg-slate-950 text-sky-400 focus:ring-sky-400/40" />
                                <span>Manual review</span>
                            </label>
                        </fieldset>
                    </div>
                    <div>
                        <p class="ui-control-label">Single-Select Group</p>
                        <fieldset class="mt-3 space-y-2">
                            <legend class="sr-only">Workspace visibility mode</legend>
                            <label class="flex items-center gap-3 rounded-lg border border-slate-800 bg-slate-950/70 px-4 py-3 text-sm text-slate-200">
                                <input type="radio" checked name="visibility_mode" class="h-4 w-4 border-slate-600 bg-slate-950 text-sky-400 focus:ring-sky-400/40" />
                                <span>Internal only</span>
                            </label>
                            <label class="flex items-center gap-3 rounded-lg border border-slate-800 bg-slate-950/70 px-4 py-3 text-sm text-slate-200">
                                <input type="radio" name="visibility_mode" class="h-4 w-4 border-slate-600 bg-slate-950 text-sky-400 focus:ring-sky-400/40" />
                                <span>Shared with auditors</span>
                            </label>
                            <label class="flex items-center gap-3 rounded-lg border border-slate-800 bg-slate-950/70 px-4 py-3 text-sm text-slate-500">
                                <input type="radio" disabled name="visibility_mode" class="h-4 w-4 border-slate-700 bg-slate-900 text-slate-500" />
                                <span>Tenant-facing preview disabled by policy</span>
                            </label>
                        </fieldset>
                    </div>
                    <div>
                        <p class="ui-control-label">Focused Checkbox</p>
                        <label class="mt-3 flex items-start gap-3 text-sm text-slate-200">
                            <input type="checkbox" checked class="mt-0.5 h-4 w-4 rounded-sm border-slate-600 bg-slate-950 text-sky-400 ring-2 ring-sky-400/40 ring-offset-2 ring-offset-slate-900" />
                            <span>Selected state with visible focus treatment.</span>
                        </label>
                    </div>
                </div>

                <div class="space-y-4 rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <div>
                        <p class="ui-control-label">Switch And Toggle</p>
                        <label class="mt-3 flex items-center justify-between gap-4 rounded-lg border border-slate-800 bg-slate-950/70 px-4 py-3">
                            <span>
                                <span class="block text-sm font-semibold text-slate-100">Lock after 15 minutes</span>
                                <span class="block text-xs text-slate-500">Toggle uses the base variant only.</span>
                            </span>
                            <label class="ui-switch">
                                <input type="checkbox" checked role="switch" aria-label="Lock after 15 minutes" class="ui-switch-input" />
                                <span class="ui-switch-track"></span>
                                <span class="ui-switch-thumb"></span>
                            </label>
                        </label>
                    </div>

                    <div>
                        <p class="ui-control-label">Toggle Baseline</p>
                        <label class="mt-3 flex items-center justify-between gap-4 rounded-lg border border-slate-800 bg-slate-950/70 px-4 py-3">
                            <span>
                                <span class="block text-sm font-semibold text-slate-100">Require operator acknowledgment</span>
                                <span class="block text-xs text-slate-500">Use keyboard focus and click/tap to verify state changes on the real control.</span>
                            </span>
                            <label class="ui-switch">
                                <input type="checkbox" role="switch" aria-label="Require operator acknowledgment" class="ui-switch-input" />
                                <span class="ui-switch-track"></span>
                                <span class="ui-switch-thumb"></span>
                            </label>
                        </label>
                    </div>

                    <div>
                        <p class="ui-control-label">Disabled Selectable State</p>
                        <label class="mt-3 flex items-start gap-3 text-sm text-slate-500">
                            <input type="checkbox" disabled checked class="mt-0.5 h-4 w-4 rounded border-slate-700 bg-slate-900 text-slate-500" />
                            <span>Policy-enforced option remains readable while disabled.</span>
                        </label>
                    </div>
                    <div>
                        <p class="ui-control-label">Selected Radio Snapshot</p>
                        <label class="mt-3 flex items-center gap-3 rounded-lg border border-sky-400/30 bg-slate-950/70 px-4 py-3 text-sm text-slate-200">
                            <input type="radio" checked class="h-4 w-4 border-slate-600 bg-slate-950 text-sky-400" />
                            <span>Selected option remains explicit without relying on color only.</span>
                        </label>
                    </div>
                </div>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Utility Primitives</p>
            <div class="mt-4 grid gap-6 lg:grid-cols-2">
                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="ui-control-label">Label, Link, And Divider</p>
                    <div class="mt-3 space-y-3">
                        <label for="utility-label-target" class="ui-control-label">Support Contact</label>
                        <input id="utility-label-target" type="text" value="platform-support@parasolutions.com" readonly class="ui-input mt-2" />
                        <a href="#" class="ui-link" onclick="event.preventDefault()">Open support runbook</a>
                        <hr class="ui-divider" />
                        <p class="text-sm text-slate-400">Divider separates related utility content without acting as a spacing substitute.</p>
                    </div>
                </div>

                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <p class="ui-control-label">Tooltip, Spinner, And Icon</p>
                    <div class="mt-3 flex flex-wrap items-center gap-4">
                        <div class="group relative inline-flex">
                            <button type="button" class="ui-icon-button" aria-describedby="tooltip-non-interactive">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                    <path fill-rule="evenodd" d="M18 10A8 8 0 1 1 2 10a8 8 0 0 1 16 0Zm-7-3a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm-2 2.25a.75.75 0 0 0 0 1.5h.25v2.5H9a.75.75 0 0 0 0 1.5h2a.75.75 0 0 0 .75-.75v-3.25A.75.75 0 0 0 11 9.25H9Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <span id="tooltip-non-interactive" role="tooltip" class="pointer-events-none absolute left-1/2 top-full z-10 mt-2 hidden -translate-x-1/2 whitespace-nowrap rounded-md border border-slate-700 bg-slate-950 px-3 py-2 text-xs text-slate-200 shadow-xl group-hover:block">
                                Non-interactive tooltip only
                            </span>
                        </div>

                        <span class="ui-spinner" aria-hidden="true"></span>

                        <span class="inline-flex items-center gap-2 text-sm text-slate-300">
                            <x-ui.status-icon icon="information-circle" class="h-4 w-4 text-sky-300" />
                            Icon baseline follows the shared icon taxonomy.
                        </span>
                    </div>
                </div>
            </div>
        </section>
    </section>
</x-layouts.app>
