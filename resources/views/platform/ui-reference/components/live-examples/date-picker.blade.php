@php
    $boundaryRows = [
        ['Native date', 'One date value submitted with a form.', '<x-ui.date-picker type="date" />', 'Installed here'],
        ['Native date-time', 'One local date-time value; parent copy owns the time-zone context.', '<x-ui.date-picker type="datetime-local" />', 'Installed here'],
        ['Range picker', 'Coordinated start/end calendar selection, previews, and keyboard range behavior.', 'Use two fields or a Pattern today', 'Gated'],
        ['Time picker', 'Time-only selection, time zones, or complex scheduling.', 'Separate API required', 'Gated'],
        ['Custom calendar', 'Calendar menu, unavailable dates, and month navigation.', 'Separate API required', 'Gated'],
    ];
@endphp

<div class="space-y-6" data-component-live-layout="date-picker-matrix" data-ui-reference-sample-type="date-picker">
    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-date-picker-live-section="native-date-entry">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Native date entry</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">The installed component uses native browser date controls. The app owns the label, helper copy, validation, sizing, and token-backed field shell.</p>

        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Required date</h4>
                <div class="mt-4 max-w-sm">
                    <x-ui.date-picker
                        name="date_picker_start_date"
                        label="Start date"
                        value="2026-06-08"
                        helper="Use the first date this setting should apply."
                        date-format="yyyy-mm-dd"
                        required
                    />
                </div>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Bounded date</h4>
                <div class="mt-4 max-w-sm">
                    <x-ui.date-picker
                        name="date_picker_policy_start"
                        label="Policy start date"
                        value="2026-06-08"
                        min-date="2026-01-01"
                        max-date="2026-12-31"
                        helper="Allowed dates run from January 1 through December 31, 2026."
                    />
                </div>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-date-picker-live-section="date-time-entry">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Date-time entry</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Use native date-time only for simple local scheduling. The surrounding form or pattern must explain which time zone interprets the value.</p>
        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Date-time</h4>
                <div class="mt-4">
                    <x-ui.date-picker
                        name="date_picker_scheduled_at"
                        label="Scheduled activation"
                        type="datetime-local"
                        value="2026-06-08T09:30"
                        helper="Times use the workspace time zone."
                    />
                </div>
            </article>
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Minute step</h4>
                <div class="mt-4">
                    <x-ui.date-picker
                        name="date_picker_maintenance_start"
                        label="Maintenance start"
                        type="datetime-local"
                        value="2026-06-08T09:30"
                        step="60"
                        helper="Minute precision is allowed for this scheduling workflow."
                    />
                </div>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-date-picker-live-section="styles-and-sizes">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Styles and sizes</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Date picker supports small, medium, and large field heights. Fluid uses the 64px expressive field treatment.</p>
        <div class="mt-4 grid gap-4 xl:grid-cols-3">
            <x-ui.date-picker name="date_picker_sm" label="Small" size="sm" value="2026-06-08" />
            <x-ui.date-picker name="date_picker_md" label="Medium" size="md" value="2026-06-08" />
            <x-ui.date-picker name="date_picker_lg" label="Large" size="lg" value="2026-06-08" />
        </div>
        <div class="mt-4 max-w-sm">
            <x-ui.date-picker name="date_picker_fluid" label="Fluid date" style="fluid" value="2026-06-08" helper="Fluid fields are reserved for high-emphasis form contexts." />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-date-picker-live-section="validation-states">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Validation states</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Error and warning states replace helper text, associate the message by ID, and include visible status treatment.</p>
        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Error</h4>
                <div class="mt-4">
                    <x-ui.date-picker
                        name="date_picker_expires_on"
                        label="Expiration date"
                        invalid
                        invalid-text="Choose an expiration date before saving."
                        required
                    />
                </div>
            </article>
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Warning state</h4>
                <div class="mt-4">
                    <x-ui.date-picker
                        name="date_picker_review_date"
                        label="Review date"
                        value="2026-12-24"
                        warn
                        warn-text="Review dates near holidays need owner confirmation."
                    />
                </div>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-date-picker-live-section="disabled-readonly-loading">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Disabled, read-only, and loading</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Disabled fields are unavailable. Read-only renders a value summary plus hidden submitted value. Loading keeps the field disabled and exposes status copy.</p>
        <div class="mt-4 grid gap-4 xl:grid-cols-3">
            <x-ui.date-picker name="date_picker_disabled" label="Locked until" value="2026-06-30" helper="This date is controlled by tenant policy." disabled />
            <x-ui.date-picker name="date_picker_readonly" label="Created on" value="2026-06-08" helper="Created date is system-managed." readonly />
            <x-ui.date-picker name="date_picker_loading" label="Available date" skeleton />
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-date-picker-live-section="range-and-calendar-boundaries">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Range and calendar boundaries</h3>
        <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Range relationships are pattern-owned today. Custom calendar panels, unavailable-date rules, range previews, and time-only controls remain gated until those APIs are installed.</p>

        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Pattern-owned range composition</h4>
                <div class="mt-4 grid gap-4 md:grid-cols-2">
                    <x-ui.date-picker name="date_picker_range_start" label="Start date" value="2026-06-01" />
                    <x-ui.date-picker name="date_picker_range_end" label="End date" value="2026-06-30" />
                </div>
                <p class="mt-3 text-xs leading-5" style="color: var(--ui-text-helper);">The parent form or Date range filter Pattern owns cross-field validation and recovery copy.</p>
            </article>

            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Deferred capabilities</h4>
                <ul class="mt-4 space-y-2 text-sm leading-6" style="color: var(--ui-text-secondary);">
                    <li>Calendar popover requires keyboard navigation, focus management, month navigation, and dismissal behavior.</li>
                    <li>Range picker requires coordinated start/end semantics, range preview, and server validation.</li>
                    <li>Time picker requires a separate standard for time format, localization, step behavior, and time-zone context.</li>
                </ul>
            </article>
        </div>

        <div class="mt-4 overflow-x-auto rounded-lg border" style="border-color: var(--ui-border-subtle-01);">
            <table class="min-w-full text-left text-sm">
                <thead style="background-color: var(--ui-layer-02); color: var(--ui-text-secondary);">
                    <tr>
                        <th class="px-3 py-2 font-medium">Capability</th>
                        <th class="px-3 py-2 font-medium">Owns</th>
                        <th class="px-3 py-2 font-medium">Example</th>
                        <th class="px-3 py-2 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody style="color: var(--ui-text-primary);">
                    @foreach ($boundaryRows as [$capability, $owns, $example, $status])
                        <tr class="border-t" style="border-color: var(--ui-border-subtle-01);">
                            <td class="px-3 py-2 font-medium">{{ $capability }}</td>
                            <td class="px-3 py-2">{{ $owns }}</td>
                            <td class="px-3 py-2"><code>{{ $example }}</code></td>
                            <td class="px-3 py-2">{{ $status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
