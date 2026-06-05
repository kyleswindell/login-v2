<x-layouts.app title="UI Reference · Inputs And Forms">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'components.forms'])
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div>
            <h1 class="ui-page-header-title">Inputs And Form Baseline</h1>
            <p class="ui-page-header-copy">Tier 1 contract for input, textarea, and select behavior including focus, error, disabled, and assistive context.</p>
        </div>

        <x-ui.patterns.proof-review-banner
            :items="[
                ['id' => 'P2-B-CQ-007', 'note' => 'Review the shared Tier 1 date and date-time baseline here; simple structured date entry should stay on the native control family.'],
            ]"
            :focus="[
                'This page remains the Tier 1 control baseline; the current pending-review target on this surface is the date/date-time contract.',
            ]"
        />

        <section class="ui-card" data-ui-guidance="form-field-standards" data-guidance-id="P2-F-CQ-010">
            <p class="ui-kicker">Form Field And Selection Guidance</p>
            <div class="mt-3 grid gap-4 lg:grid-cols-2">
                <div>
                    <h2 class="text-base font-semibold text-slate-100">Field composition rules</h2>
                    <dl class="mt-3 space-y-3 text-sm text-slate-300">
                        <div>
                            <dt class="font-semibold text-slate-100">G-FORM-01 - Required fields</dt>
                            <dd class="mt-1">Mark required fields in the visible label and describe the requirement in helper text when the reason is not obvious.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-slate-100">G-FORM-02 - Optional fields</dt>
                            <dd class="mt-1">Do not mark every optional field by default. Use optional copy only when omission has a meaningful workflow effect.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-slate-100">G-FORM-03 - Validation timing</dt>
                            <dd class="mt-1">Validate format on blur when helpful, validate required fields on submit, and keep server validation visible in the same field group.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-slate-100">G-FORM-04 - Field states</dt>
                            <dd class="mt-1">Show error, warning, disabled, read-only, and focused states with explicit copy; do not rely on color alone.</dd>
                        </div>
                    </dl>
                </div>

                <div data-ui-guidance="selection-control-usage">
                    <h2 class="text-base font-semibold text-slate-100">Selection control rules</h2>
                    <dl class="mt-3 space-y-3 text-sm text-slate-300">
                        <div>
                            <dt class="font-semibold text-slate-100">G-SEL-01 - Checkbox</dt>
                            <dd class="mt-1">Use a checkbox for independent yes/no choices, including multi-select lists where each option stands alone.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-slate-100">G-SEL-02 - Radio</dt>
                            <dd class="mt-1">Use radio controls for one required choice from a short, visible set.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-slate-100">G-SEL-03 - Toggle</dt>
                            <dd class="mt-1">Use a toggle only for immediate on/off settings where the saved state is understandable without another submit action.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-slate-100">Select / combo box / multi-select</dt>
                            <dd class="mt-1">Use select for short known lists, combo box or searchable select for long known lists, and multi-select only when multiple choices are expected and reviewable before save.</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </section>

        <section class="ui-card" data-ui-guidance="input-file-date-usage" data-guidance-id="P2-F-CQ-011">
            <p class="ui-kicker">Input, File, And Date Guidance</p>
            <div class="mt-3 grid gap-4 lg:grid-cols-3">
                <dl class="space-y-3 text-sm text-slate-300">
                    <div>
                        <dt class="font-semibold text-slate-100">G-INPUT-01 - Default vs fluid inputs</dt>
                        <dd class="mt-1">Use default input width inside normal form groups; use fluid full-width inputs only when the surrounding layout owns the full row or responsive region.</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-slate-100">G-INPUT-02 - Warning state</dt>
                        <dd class="mt-1">Use warning state for cautionary but still valid input, pair it with explicit helper copy, and do not reuse error styling unless submission is blocked.</dd>
                    </div>
                </dl>

                <dl class="space-y-3 text-sm text-slate-300">
                    <div>
                        <dt class="font-semibold text-slate-100">G-FILEUP-01 - File uploader variant</dt>
                        <dd class="mt-1">Use a button uploader for one-off attachments and drag-and-drop only when bulk upload or repeated file management is the main task.</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-slate-100">G-FILEUP-02 - Uploader sizing</dt>
                        <dd class="mt-1">Pair file uploader height and density with nearby form fields so upload controls do not dominate compact settings or account forms.</dd>
                    </div>
                </dl>

                <dl class="space-y-3 text-sm text-slate-300">
                    <div>
                        <dt class="font-semibold text-slate-100">G-DATEPICK-01 - Date picker variant</dt>
                        <dd class="mt-1">Use simple native date inputs for single dates, calendar/range controls for visible date comparison, and date-time controls only when time precision matters.</dd>
                    </div>
                    <div>
                        <dt class="font-semibold text-slate-100">G-DATEPICK-02 - Date format and locale</dt>
                        <dd class="mt-1">Display saved dates in the user's locale and timezone context, and keep machine-readable values in the native control value.</dd>
                    </div>
                </dl>
            </div>
        </section>

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
            <p class="ui-kicker">Date And Time Selection</p>
            <p class="mt-2 text-sm text-slate-400">Date and date-time controls stay in the Tier 1 native-control family. Use the shared field wrapper and input styling instead of inventing custom calendar chrome for simple structured date entry.</p>
            <x-ui.patterns.proof-review-target
                class="mt-4"
                :items="[
                    ['id' => 'P2-B-CQ-007', 'note' => 'This card is the review target for the Tier 1 date baseline. Confirm the proof keeps date and date-time entry in the shared native-control family instead of introducing ad hoc calendar UI.'],
                ]"
            />
            <div class="mt-4 grid gap-5 lg:grid-cols-2">
                <label class="block">
                    <span class="ui-control-label">Review Date</span>
                    <input type="date" value="2026-06-08" class="ui-input mt-2" />
                    <p class="ui-control-copy">Use for single-date deadlines, publish dates, or schedule anchors.</p>
                </label>

                <label class="block">
                    <span class="ui-control-label">Review Window Start</span>
                    <input type="datetime-local" value="2026-06-08T09:30" class="ui-input mt-2" />
                    <p class="ui-control-copy">Use date-time only when the workflow truly needs both calendar and time precision.</p>
                </label>
            </div>
        </section>

        <section class="ui-card" data-ui-guidance="field-state-examples">
            <p class="ui-kicker">Validation Block</p>
            <div class="mt-4 grid gap-5 lg:grid-cols-3">
                <x-ui.inline-alert semantic="danger" title="Form Validation Errors">
                    <ul class="list-disc space-y-1 pl-4 text-sm">
                        <li>Workspace name is required.</li>
                        <li>Owner scope must be selected.</li>
                    </ul>
                </x-ui.inline-alert>

                <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <label class="block">
                        <span class="ui-control-label">Example Error Field</span>
                        <input aria-invalid="true" aria-describedby="workspace-name-error" type="text" value="" placeholder="Required field" class="ui-input mt-2" />
                        <p id="workspace-name-error" class="ui-control-error">Workspace name cannot be empty.</p>
                    </label>
                </div>

                <div class="rounded-lg border border-[color:var(--ui-alert-warning-border)] bg-[color:var(--ui-alert-warning-bg)] p-4">
                    <label class="block">
                        <span class="ui-control-label">Example Warning Field</span>
                        <input aria-describedby="workspace-subdomain-warning" type="text" value="ops" class="ui-input mt-2 border-[color:var(--ui-alert-warning-border)] ring-1 ring-[color:var(--ui-alert-warning-border)]" />
                        <p id="workspace-subdomain-warning" class="mt-2 text-xs font-medium text-[color:var(--ui-alert-warning-text)]">This subdomain is available, but it is shorter than the recommended naming pattern.</p>
                    </label>
                </div>
            </div>

            <div class="mt-5 flex flex-wrap items-center gap-3">
                <x-ui.button variant="ghost">Cancel</x-ui.button>
                <x-ui.button semantic="danger">Delete</x-ui.button>
                <x-ui.button type="submit" semantic="primary">Save Workspace</x-ui.button>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Selectable Controls</p>
            <div class="mt-4 grid gap-6 lg:grid-cols-2">
                <div class="space-y-4 rounded-lg border border-slate-800 bg-slate-900/70 p-4">
                    <div>
                        <p class="ui-control-label">Checkbox</p>
                            <label class="ui-selectable-option is-selected mt-3 flex items-start gap-3 text-sm text-slate-200">
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
                            <label class="ui-selectable-option is-selected flex items-center gap-3 text-sm text-slate-200">
                                <input type="radio" checked name="visibility_mode" class="h-4 w-4 border-slate-600 bg-slate-950 text-sky-400 focus:ring-sky-400/40" />
                                <span>Internal only</span>
                            </label>
                            <label class="ui-selectable-option flex items-center gap-3 text-sm text-slate-200">
                                <input type="radio" name="visibility_mode" class="h-4 w-4 border-slate-600 bg-slate-950 text-sky-400 focus:ring-sky-400/40" />
                                <span>Shared with auditors</span>
                            </label>
                            <label class="ui-selectable-option flex items-center gap-3 text-sm text-slate-500">
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
                        <label class="ui-selectable-option is-selected mt-3 flex items-center gap-3 text-sm text-slate-200">
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
                                <x-heroicon-o-information-circle class="h-4 w-4" aria-hidden="true" />
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
