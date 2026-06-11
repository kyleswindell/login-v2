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
                    <h2 class="text-base font-semibold ui-reference-text-strong">Field composition rules</h2>
                    <dl class="mt-3 space-y-3 text-sm ui-reference-text">
                        <div>
                            <dt class="font-semibold ui-reference-text-strong">G-FORM-01 - Required fields</dt>
                            <dd class="mt-1">Mark required fields in the visible label and describe the requirement in helper text when the reason is not obvious.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold ui-reference-text-strong">G-FORM-02 - Optional fields</dt>
                            <dd class="mt-1">Do not mark every optional field by default. Use optional copy only when omission has a meaningful workflow effect.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold ui-reference-text-strong">G-FORM-03 - Validation timing</dt>
                            <dd class="mt-1">Validate format on blur when helpful, validate required fields on submit, and keep server validation visible in the same field group.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold ui-reference-text-strong">G-FORM-04 - Field states</dt>
                            <dd class="mt-1">Show error, warning, disabled, read-only, and focused states with explicit copy; do not rely on color alone.</dd>
                        </div>
                    </dl>
                </div>

                <div data-ui-guidance="selection-control-usage">
                    <h2 class="text-base font-semibold ui-reference-text-strong">Selection control rules</h2>
                    <dl class="mt-3 space-y-3 text-sm ui-reference-text">
                        <div>
                            <dt class="font-semibold ui-reference-text-strong">G-SEL-01 - Checkbox</dt>
                            <dd class="mt-1">Use a checkbox for independent yes/no choices, including multi-select lists where each option stands alone.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold ui-reference-text-strong">G-SEL-02 - Radio</dt>
                            <dd class="mt-1">Use radio controls for one required choice from a short, visible set.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold ui-reference-text-strong">G-SEL-03 - Toggle</dt>
                            <dd class="mt-1">Use a toggle only for immediate on/off settings where the saved state is understandable without another submit action.</dd>
                        </div>
                        <div>
                            <dt class="font-semibold ui-reference-text-strong">Select / combo box / multi-select</dt>
                            <dd class="mt-1">Use select for short known lists, combo box or searchable select for long known lists, and multi-select only when multiple choices are expected and reviewable before save.</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </section>

        <section class="ui-card" data-ui-reference-example="form-field-state-contract" data-guidance-id="P2-F-CQ-010">
            <p class="ui-kicker">Component Field Reference Matrix</p>
            <h2 class="ui-card-title mt-2">Field states and native control families</h2>
            <p class="ui-card-copy">These examples show the shared field wrapper, visible label policy, helper copy, validation copy, disabled/read-only treatment, and native input choices that later pages should reuse.</p>

            <div class="mt-5 grid gap-5 lg:grid-cols-2">
                <label class="block ui-reference-example-surface p-4">
                    <span class="ui-control-label">Workspace Name <span class="ui-field-required">*</span></span>
                    <input type="text" value="Platform Operations" class="ui-input mt-2" />
                    <span class="ui-control-copy">Required field. Use the asterisk only for required fields.</span>
                    <code class="mt-3 block rounded-md ui-reference-code-surface px-3 py-2 text-xs ui-reference-text">class=&quot;ui-input&quot; + required label marker</code>
                </label>

                <label class="block ui-reference-example-surface p-4">
                    <span class="ui-control-label">Reference Note <span class="font-normal ui-reference-text-muted">(optional)</span></span>
                    <input type="text" placeholder="Add internal note" class="ui-input mt-2" />
                    <span class="ui-control-copy">Optional copy appears only when omission changes the workflow.</span>
                </label>

                <label class="block ui-reference-example-surface p-4">
                    <span class="ui-control-label">Focused Field</span>
                    <input type="text" value="Visible keyboard focus" class="ui-input mt-2 ring-2 is-focus" />
                    <span class="ui-control-copy">Focus examples must be visible in dark and light themes.</span>
                </label>

                <label class="block ui-reference-example-surface p-4">
                    <span class="ui-control-label">Read-only Identifier</span>
                    <input type="text" value="workspace-ops-001" readonly class="ui-input mt-2" />
                    <span class="ui-control-copy">Read-only means selectable text, not an editable field.</span>
                </label>

                <label class="block ui-reference-example-surface p-4">
                    <span class="ui-control-label">Disabled Policy Field</span>
                    <input type="text" value="Locked by tenant policy" disabled class="ui-input mt-2" />
                    <span class="ui-control-copy">Disabled controls remain readable but cannot be submitted as a choice.</span>
                </label>

                <label class="block rounded-lg border border-[color:var(--ui-alert-danger-border)] bg-[color:var(--ui-alert-danger-bg)] p-4">
                    <span class="ui-control-label">Support Email <span class="ui-field-required">*</span></span>
                    <input type="email" value="ops@" aria-invalid="true" aria-describedby="t1-email-error" class="ui-input mt-2" />
                    <span id="t1-email-error" class="ui-control-error">Enter a complete email address before saving.</span>
                </label>

                <label class="block rounded-lg border border-[color:var(--ui-alert-warning-border)] bg-[color:var(--ui-alert-warning-bg)] p-4">
                    <span class="ui-control-label">Subdomain</span>
                    <input type="text" value="ops" aria-describedby="t1-subdomain-warning" class="ui-input mt-2 border-[color:var(--ui-alert-warning-border)] ring-1 ring-[color:var(--ui-alert-warning-border)]" />
                    <span id="t1-subdomain-warning" class="mt-2 block text-xs font-medium text-[color:var(--ui-alert-warning-text)]">Valid but short. Prefer a clearer tenant subdomain.</span>
                </label>

                <label class="block ui-reference-example-surface p-4">
                    <span class="ui-control-label">Description</span>
                    <textarea rows="4" class="ui-textarea mt-2">Textarea uses the shared control label and helper copy.</textarea>
                    <span class="ui-control-copy">Use textarea for multi-line free entry only.</span>
                </label>

                <label class="block ui-reference-example-surface p-4">
                    <span class="ui-control-label">Owner Scope</span>
                    <select class="ui-select mt-2">
                        <option>Platform Administrator</option>
                        <option>Base Operator</option>
                    </select>
                    <span class="ui-control-copy">Use select for short known lists.</span>
                </label>

                <div class="ui-reference-example-surface p-4">
                    <span class="ui-control-label">Attachment</span>
                    <input type="file" class="ui-input mt-2" />
                    <p class="ui-control-copy">Button uploader baseline for one-off attachments. Drag-drop uploader remains a queued gap for bulk upload surfaces.</p>
                </div>

                <label class="block ui-reference-example-surface p-4">
                    <span class="ui-control-label">Review Date</span>
                    <input type="date" value="2026-06-08" class="ui-input mt-2" />
                    <span class="ui-control-copy">Use native date for single-date entry.</span>
                </label>

                <label class="block ui-reference-example-surface p-4">
                    <span class="ui-control-label">Review Starts</span>
                    <input type="datetime-local" value="2026-06-08T09:30" class="ui-input mt-2" />
                    <span class="ui-control-copy">Use date-time only when time precision matters.</span>
                </label>
            </div>
        </section>

        <section class="ui-card" data-ui-reference-example="selection-control-contract" data-guidance-id="P2-F-CQ-010">
            <p class="ui-kicker">Component Selection Control Examples</p>
            <div class="mt-5 grid gap-5 lg:grid-cols-2">
                <fieldset class="ui-reference-example-surface p-4">
                    <legend class="ui-control-label">Checkbox: independent choices</legend>
                    <label class="mt-3 flex items-start gap-3 text-sm ui-reference-text-strong">
                        <input type="checkbox" checked class="mt-0.5 h-4 w-4 rounded ui-platform-checkbox" />
                        <span>Email me when review notes are added.</span>
                    </label>
                    <label class="mt-2 flex items-start gap-3 text-sm ui-reference-text-strong">
                        <input type="checkbox" class="mt-0.5 h-4 w-4 rounded ui-platform-checkbox" />
                        <span>Include archived records.</span>
                    </label>
                </fieldset>

                <fieldset class="ui-reference-example-surface p-4">
                    <legend class="ui-control-label">Radio: one visible required choice</legend>
                    <label class="mt-3 flex items-center gap-3 text-sm ui-reference-text-strong">
                        <input type="radio" checked name="t1-review-mode" class="h-4 w-4 ui-platform-checkbox" />
                        <span>Guided review</span>
                    </label>
                    <label class="mt-2 flex items-center gap-3 text-sm ui-reference-text-strong">
                        <input type="radio" name="t1-review-mode" class="h-4 w-4 ui-platform-checkbox" />
                        <span>Manual review</span>
                    </label>
                </fieldset>

                <div class="ui-reference-example-surface p-4">
                    <p class="ui-control-label">Toggle: immediate setting</p>
                    <label class="mt-3 flex items-center justify-between gap-4 ui-reference-subtle-surface px-4 py-3">
                        <span class="text-sm ui-reference-text-strong">Lock session after inactivity</span>
                        <span class="ui-switch">
                            <input type="checkbox" checked role="switch" aria-label="Lock session after inactivity" class="ui-switch-input" />
                            <span class="ui-switch-track"></span>
                            <span class="ui-switch-thumb"></span>
                        </span>
                    </label>
                </div>

                <div class="ui-reference-example-surface p-4">
                    <p class="ui-control-label">Searchable select / combo</p>
                    <div class="mt-3">
                        <x-ui.searchable-select
                            id="component-timezone-example"
                            name="component_timezone_example"
                            :options="App\Support\UiOptionCatalog::timezoneOptions()"
                            selected="America/New_York"
                            placeholder="Choose a timezone"
                            search-placeholder="Search timezones"
                        />
                    </div>
                    <p class="ui-control-copy">Use <code>x-ui.searchable-select</code> for long known-option lists. Queued gap: multi-select component for multiple reviewable choices.</p>
                </div>
            </div>
        </section>

        <section class="ui-card" data-ui-implementation-guide="forms" data-guidance-id="P2-F-CQ-010">
            <p class="ui-kicker">Form Implementation Guide</p>
            <div class="mt-4 ui-reference-table-shell overflow-x-auto">
                <table class="w-full min-w-[780px] text-left text-sm">
                    <thead class="ui-reference-table-head text-xs uppercase tracking-[0.16em]">
                        <tr>
                            <th class="px-4 py-3">Use</th>
                            <th class="px-4 py-3">Component or class</th>
                            <th class="px-4 py-3">Placement contract</th>
                            <th class="px-4 py-3">Owner routes</th>
                        </tr>
                    </thead>
                    <tbody class="ui-reference-table-body">
                        <tr>
                            <td class="px-4 py-3 ui-reference-text-strong">Field wrapper</td>
                            <td class="px-4 py-3"><code>x-ui.patterns.form-group</code>, <code>ui-control-label</code>, <code>ui-control-copy</code>, <code>ui-control-error</code></td>
                            <td class="px-4 py-3">Label first, control second, helper or validation below. Field errors stay in the same group as the affected input.</td>
                            <td class="px-4 py-3">/components/forms, /patterns/forms</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 ui-reference-text-strong">Text controls</td>
                            <td class="px-4 py-3"><code>ui-input</code>, <code>ui-textarea</code>, <code>ui-select</code></td>
                            <td class="px-4 py-3">Use native type attributes for email, tel, date, datetime-local, and file before introducing custom controls.</td>
                            <td class="px-4 py-3">/components/forms, /patterns/navigation</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 ui-reference-text-strong">Selection controls</td>
                            <td class="px-4 py-3"><code>input[type=checkbox]</code>, <code>input[type=radio]</code>, <code>ui-switch</code>, <code>x-ui.searchable-select</code></td>
                            <td class="px-4 py-3">Checkbox for independent choices, radio for short exclusive choices, toggle for immediate on/off settings, searchable select for long known lists.</td>
                            <td class="px-4 py-3">/components/forms, /patterns/forms</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="ui-card" data-ui-guidance="input-file-date-usage" data-guidance-id="P2-F-CQ-011">
            <p class="ui-kicker">Input, File, And Date Guidance</p>
            <div class="mt-3 grid gap-4 lg:grid-cols-3">
                <dl class="space-y-3 text-sm ui-reference-text">
                    <div>
                        <dt class="font-semibold ui-reference-text-strong">G-INPUT-01 - Default vs fluid inputs</dt>
                        <dd class="mt-1">Use default input width inside normal form groups; use fluid full-width inputs only when the surrounding layout owns the full row or responsive region.</dd>
                    </div>
                    <div>
                        <dt class="font-semibold ui-reference-text-strong">G-INPUT-02 - Warning state</dt>
                        <dd class="mt-1">Use warning state for cautionary but still valid input, pair it with explicit helper copy, and do not reuse error styling unless submission is blocked.</dd>
                    </div>
                </dl>

                <dl class="space-y-3 text-sm ui-reference-text">
                    <div>
                        <dt class="font-semibold ui-reference-text-strong">G-FILEUP-01 - File uploader variant</dt>
                        <dd class="mt-1">Use a button uploader for one-off attachments and drag-and-drop only when bulk upload or repeated file management is the main task.</dd>
                    </div>
                    <div>
                        <dt class="font-semibold ui-reference-text-strong">G-FILEUP-02 - Uploader sizing</dt>
                        <dd class="mt-1">Pair file uploader height and density with nearby form fields so upload controls do not dominate compact settings or account forms.</dd>
                    </div>
                </dl>

                <dl class="space-y-3 text-sm ui-reference-text">
                    <div>
                        <dt class="font-semibold ui-reference-text-strong">G-DATEPICK-01 - Date picker variant</dt>
                        <dd class="mt-1">Use simple native date inputs for single dates, calendar/range controls for visible date comparison, and date-time controls only when time precision matters.</dd>
                    </div>
                    <div>
                        <dt class="font-semibold ui-reference-text-strong">G-DATEPICK-02 - Date format and locale</dt>
                        <dd class="mt-1">Display saved dates in the user's locale and timezone context, and keep machine-readable values in the native control value.</dd>
                    </div>
                </dl>
            </div>
        </section>

        <section class="ui-card" data-ui-reference-example="input-file-date-contract" data-guidance-id="P2-F-CQ-011">
            <p class="ui-kicker">Concrete Input, File, And Date Examples</p>
            <div class="mt-5 grid gap-5 lg:grid-cols-2">
                <label class="block ui-reference-example-surface p-4">
                    <span class="ui-control-label">Default width input</span>
                    <input type="text" value="Default form field" class="ui-input mt-2 max-w-md" />
                    <span class="ui-control-copy">Default width belongs inside normal form groups.</span>
                </label>

                <label class="block ui-reference-example-surface p-4">
                    <span class="ui-control-label">Fluid search input</span>
                    <input type="search" value="Full-row search" class="ui-input mt-2 w-full" />
                    <span class="ui-control-copy">Fluid input is allowed when the layout owns the full row.</span>
                </label>

                <div class="ui-reference-example-surface p-4">
                    <span class="ui-control-label">Button file uploader</span>
                    <input type="file" class="ui-input mt-2" />
                    <p class="ui-control-copy">Use for one-off attachments. Queued gap: drag-and-drop uploader for bulk upload and repeated file management.</p>
                </div>

                <div class="ui-reference-example-surface p-4">
                    <span class="ui-control-label">Date picker family</span>
                    <div class="mt-2 grid gap-3 sm:grid-cols-2">
                        <input type="date" value="2026-06-08" class="ui-input" aria-label="Review date" />
                        <input type="datetime-local" value="2026-06-08T09:30" class="ui-input" aria-label="Review date and time" />
                    </div>
                    <p class="ui-control-copy">Native date/date-time are the current Component implementation. Queued gap: calendar range control for comparison-heavy reporting.</p>
                </div>
            </div>
        </section>

        <section class="ui-card" data-ui-implementation-guide="inputs-file-date" data-guidance-id="P2-F-CQ-011">
            <p class="ui-kicker">Input Implementation Guide</p>
            <p class="ui-card-copy mt-2">Owner route: <code>/platform/ui-reference/components/forms</code>. Use <code>ui-input</code>, <code>ui-textarea</code>, and <code>ui-select</code> with native HTML types before creating a custom control. File drag-drop, calendar range picker, and multi-select remain queued gaps until a consumer needs the behavior and component contract.</p>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Field States</p>
            <form class="mt-4 grid gap-5 lg:grid-cols-2" action="#" method="POST" onsubmit="event.preventDefault()">
                <label class="block">
                    <span class="ui-control-label">Workspace Name <span class="ui-field-required">*</span></span>
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
            <p class="mt-2 text-sm ui-reference-text-muted">Focus, selected, disabled, and validation states are rendered explicitly for review.</p>
            <div class="mt-4 grid gap-4 lg:grid-cols-2">
                <div class="ui-reference-example-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Focused Text Input</p>
                    <input type="text" value="Focused workspace name" class="ui-input mt-3 ring-2 is-focus" />
                </div>
                <div class="ui-reference-example-surface p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.15em] ui-reference-text-muted">Focused Select</p>
                    <select class="ui-select mt-3 ring-2 is-focus">
                        <option selected>Administrator</option>
                        <option>Base Operator</option>
                    </select>
                </div>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Date And Time Selection</p>
            <p class="mt-2 text-sm ui-reference-text-muted">Date and date-time controls stay in the Tier 1 native-control family. Use the shared field wrapper and input styling instead of inventing custom calendar chrome for simple structured date entry.</p>
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

                <div class="ui-reference-example-surface p-4">
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
                <div class="space-y-4 ui-reference-example-surface p-4">
                    <div>
                        <p class="ui-control-label">Checkbox</p>
                            <label class="ui-selectable-option is-selected mt-3 flex items-start gap-3 text-sm ui-reference-text-strong">
                                <input type="checkbox" checked class="mt-0.5 h-4 w-4 rounded ui-platform-checkbox" />
                                <span>
                                    Enable workspace notifications
                                    <span class="block text-xs ui-reference-text-muted">Helper text remains visible for binary settings.</span>
                                </span>
                        </label>
                    </div>

                    <div>
                        <p class="ui-control-label">Radio Group</p>
                        <fieldset class="mt-3 space-y-2">
                            <legend class="sr-only">Default review mode</legend>
                            <label class="flex items-center gap-3 text-sm ui-reference-text-strong">
                                <input type="radio" checked name="review_mode" class="h-4 w-4 ui-platform-checkbox" />
                                <span>Guided review</span>
                            </label>
                            <label class="flex items-center gap-3 text-sm ui-reference-text-strong">
                                <input type="radio" name="review_mode" class="h-4 w-4 ui-platform-checkbox" />
                                <span>Manual review</span>
                            </label>
                        </fieldset>
                    </div>
                    <div>
                        <p class="ui-control-label">Single-Select Group</p>
                        <fieldset class="mt-3 space-y-2">
                            <legend class="sr-only">Workspace visibility mode</legend>
                            <label class="ui-selectable-option is-selected flex items-center gap-3 text-sm ui-reference-text-strong">
                                <input type="radio" checked name="visibility_mode" class="h-4 w-4 ui-platform-checkbox" />
                                <span>Internal only</span>
                            </label>
                            <label class="ui-selectable-option flex items-center gap-3 text-sm ui-reference-text-strong">
                                <input type="radio" name="visibility_mode" class="h-4 w-4 ui-platform-checkbox" />
                                <span>Shared with auditors</span>
                            </label>
                            <label class="ui-selectable-option flex items-center gap-3 text-sm ui-reference-text-muted">
                                <input type="radio" disabled name="visibility_mode" class="h-4 w-4 ui-reference-border-strong ui-reference-table-head ui-reference-text-muted" />
                                <span>Tenant-facing preview disabled by policy</span>
                            </label>
                        </fieldset>
                    </div>
                    <div>
                        <p class="ui-control-label">Focused Checkbox</p>
                        <label class="mt-3 flex items-start gap-3 text-sm ui-reference-text-strong">
                            <input type="checkbox" checked class="mt-0.5 h-4 w-4 rounded-sm ui-platform-checkbox" />
                            <span>Selected state with visible focus treatment.</span>
                        </label>
                    </div>
                </div>

                <div class="space-y-4 ui-reference-example-surface p-4">
                    <div>
                        <p class="ui-control-label">Switch And Toggle</p>
                        <label class="mt-3 flex items-center justify-between gap-4 ui-reference-subtle-surface px-4 py-3">
                            <span>
                                <span class="block text-sm font-semibold ui-reference-text-strong">Lock after 15 minutes</span>
                                <span class="block text-xs ui-reference-text-muted">Toggle uses the base variant only.</span>
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
                        <label class="mt-3 flex items-center justify-between gap-4 ui-reference-subtle-surface px-4 py-3">
                            <span>
                                <span class="block text-sm font-semibold ui-reference-text-strong">Require operator acknowledgment</span>
                                <span class="block text-xs ui-reference-text-muted">Use keyboard focus and click/tap to verify state changes on the real control.</span>
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
                        <label class="mt-3 flex items-start gap-3 text-sm ui-reference-text-muted">
                            <input type="checkbox" disabled checked class="mt-0.5 h-4 w-4 rounded ui-reference-border-strong ui-reference-table-head ui-reference-text-muted" />
                            <span>Policy-enforced option remains readable while disabled.</span>
                        </label>
                    </div>
                    <div>
                        <p class="ui-control-label">Selected Radio Snapshot</p>
                        <label class="ui-selectable-option is-selected mt-3 flex items-center gap-3 text-sm ui-reference-text-strong">
                            <input type="radio" checked class="h-4 w-4 ui-platform-checkbox" />
                            <span>Selected option remains explicit without relying on color only.</span>
                        </label>
                    </div>
                </div>
            </div>
        </section>

        <section class="ui-card">
            <p class="ui-kicker">Utility Primitives</p>
            <div class="mt-4 grid gap-6 lg:grid-cols-2">
                <div class="ui-reference-example-surface p-4">
                    <p class="ui-control-label">Label, Link, And Divider</p>
                    <div class="mt-3 space-y-3">
                        <label for="utility-label-target" class="ui-control-label">Support Contact</label>
                        <input id="utility-label-target" type="text" value="platform-support@parasolutions.com" readonly class="ui-input mt-2" />
                        <a href="#" class="ui-link" onclick="event.preventDefault()">Open support runbook</a>
                        <hr class="ui-divider" />
                        <p class="text-sm ui-reference-text-muted">Divider separates related utility content without acting as a spacing substitute.</p>
                    </div>
                </div>

                <div class="ui-reference-example-surface p-4">
                    <p class="ui-control-label">Tooltip, Spinner, And Icon</p>
                    <div class="mt-3 flex flex-wrap items-center gap-4">
                        <div class="group relative inline-flex">
                            <button type="button" class="ui-icon-button" aria-describedby="tooltip-non-interactive">
                                <x-heroicon-o-information-circle class="h-4 w-4" aria-hidden="true" />
                            </button>
                            <span id="tooltip-non-interactive" role="tooltip" class="pointer-events-none absolute left-1/2 top-full z-10 mt-2 hidden -translate-x-1/2 whitespace-nowrap rounded-md border ui-reference-border-strong ui-reference-code-surface px-3 py-2 text-xs ui-reference-text-strong shadow-xl group-hover:block">
                                Non-interactive tooltip only
                            </span>
                        </div>

                        <span class="ui-spinner" aria-hidden="true"></span>

                        <span class="inline-flex items-center gap-2 text-sm ui-reference-text">
                            <x-ui.status-icon icon="information-circle" class="h-4 w-4 ui-reference-text" />
                            Icon baseline follows the shared icon taxonomy.
                        </span>
                    </div>
                </div>
            </div>
        </section>
    </section>
</x-layouts.app>
