@php
    $stateRows = [
        ['Default', 'Report date', 'date_picker_state_default', ['value' => '2026-06-08', 'helper' => 'Format: yyyy-mm-dd.']],
        ['Hover', 'Hover date', 'date_picker_state_hover', ['value' => '2026-06-09', 'helper' => 'Hover uses the shared field hover token.']],
        ['Focus', 'Focused date', 'date_picker_state_focus', ['value' => '2026-06-10', 'class' => 'is-focus', 'helper' => 'Focus is visible on keyboard and click focus.']],
        ['Error', 'Expiration date', 'date_picker_state_error', ['invalid' => true, 'invalid-text' => 'Choose an expiration date before saving.', 'required' => true]],
        ['Warning', 'Review date', 'date_picker_state_warning', ['value' => '2026-12-24', 'warn' => true, 'warn-text' => 'Review dates near holidays need owner confirmation.']],
        ['Disabled', 'Locked until', 'date_picker_state_disabled', ['value' => '2026-06-30', 'disabled' => true, 'helper' => 'This date is controlled by tenant policy.']],
        ['Read-only', 'Created on', 'date_picker_state_readonly', ['value' => '2026-06-08', 'readonly' => true, 'helper' => 'Created date is system-managed.']],
        ['Skeleton', 'Available date', 'date_picker_state_loading', ['skeleton' => true]],
    ];

    $timeZones = [
        ['value' => 'America/New_York', 'label' => 'Eastern Time'],
        ['value' => 'America/Chicago', 'label' => 'Central Time'],
        ['value' => 'America/Denver', 'label' => 'Mountain Time'],
        ['value' => 'America/Los_Angeles', 'label' => 'Pacific Time'],
    ];

    $periods = [
        ['value' => 'AM', 'label' => 'AM'],
        ['value' => 'PM', 'label' => 'PM'],
    ];

    $calendarStart = \Carbon\CarbonImmutable::parse('2026-06-01');
    $calendarEnd = \Carbon\CarbonImmutable::parse('2026-07-05');
    $calendarDays = [];

    for ($day = $calendarStart; $day->lte($calendarEnd); $day = $day->addDay()) {
        $calendarDays[] = $day;
    }
@endphp

<div class="space-y-8" data-component-live-layout="date-picker-matrix" data-ui-reference-sample-type="date-picker">
    <section class="ui-reference-layer-section" data-date-picker-live-section="single-date-entry">
        <div class="ui-reference-section-heading">
            <h3>Single date entry</h3>
            <p>Simple date input uses the canonical date picker API for visible labels, helper text, min/max constraints, and normalized submitted values.</p>
        </div>

        <div class="grid gap-4 xl:grid-cols-3">
            <article class="ui-reference-example-card">
                <h4 class="ui-reference-example-title">Required date</h4>
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

            <article class="ui-reference-example-card">
                <h4 class="ui-reference-example-title">Bounded date</h4>
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

            <article class="ui-reference-example-card">
                <h4 class="ui-reference-example-title">Date-time entry</h4>
                <div class="mt-4 max-w-sm">
                    <x-ui.date-picker
                        name="date_picker_scheduled_at"
                        label="Scheduled activation"
                        type="datetime-local"
                        value="2026-06-08T09:30"
                        helper="Times use the workspace time zone."
                    />
                </div>
            </article>
        </div>
    </section>

    <section class="ui-reference-layer-section" data-date-picker-live-section="date-range-picker">
        <div class="ui-reference-section-heading">
            <h3>Date range picker</h3>
            <p>Range selection uses paired start and end fields plus one calendar menu. Selecting from either field updates the same range and previews the hovered endpoint.</p>
        </div>

        <div
            class="ui-date-range-picker"
            data-ui-component="date-range-picker"
            data-ui-date-range-picker
            data-ui-date-range-start="2026-06-10"
            data-ui-date-range-end="2026-06-18"
        >
            <div class="ui-date-range-picker-fields">
                <label class="ui-field ui-date-range-picker-field" for="date-range-start">
                    <span class="ui-field-label">Start date</span>
                    <span class="ui-date-range-picker-input-shell">
                        <input
                            id="date-range-start"
                            name="date_range_start"
                            type="text"
                            value="2026-06-10"
                            inputmode="numeric"
                            autocomplete="off"
                            class="ui-input ui-input-date"
                            data-ui-date-range-input="start"
                            aria-describedby="date-range-status"
                        >
                        <x-heroicon-o-calendar-days class="ui-date-range-picker-input-icon" aria-hidden="true" />
                    </span>
                </label>

                <label class="ui-field ui-date-range-picker-field" for="date-range-end">
                    <span class="ui-field-label">End date</span>
                    <span class="ui-date-range-picker-input-shell">
                        <input
                            id="date-range-end"
                            name="date_range_end"
                            type="text"
                            value="2026-06-18"
                            inputmode="numeric"
                            autocomplete="off"
                            class="ui-input ui-input-date"
                            data-ui-date-range-input="end"
                            aria-describedby="date-range-status"
                        >
                        <x-heroicon-o-calendar-days class="ui-date-range-picker-input-icon" aria-hidden="true" />
                    </span>
                </label>
            </div>

            <div class="ui-date-range-calendar" role="dialog" aria-label="Choose reporting date range" data-ui-date-range-calendar>
                <div class="ui-date-range-calendar-header">
                    <button type="button" class="ui-icon-button ui-date-range-calendar-nav" aria-label="Previous month" disabled>
                        <x-heroicon-o-chevron-left aria-hidden="true" />
                    </button>
                    <p>June 2026</p>
                    <button type="button" class="ui-icon-button ui-date-range-calendar-nav" aria-label="Next month" disabled>
                        <x-heroicon-o-chevron-right aria-hidden="true" />
                    </button>
                </div>

                <div class="ui-date-range-calendar-weekdays" aria-hidden="true">
                    <span>Mon</span>
                    <span>Tue</span>
                    <span>Wed</span>
                    <span>Thu</span>
                    <span>Fri</span>
                    <span>Sat</span>
                    <span>Sun</span>
                </div>

                <div class="ui-date-range-calendar-grid" role="grid" aria-label="June 2026 calendar">
                    @foreach ($calendarDays as $day)
                        @php
                            $date = $day->format('Y-m-d');
                            $isCurrentMonth = $day->month === 6;
                        @endphp
                        <button
                            type="button"
                            class="ui-date-range-day"
                            data-ui-date-range-day
                            data-date="{{ $date }}"
                            role="gridcell"
                            aria-label="{{ $day->format('F j, Y') }}"
                            @if(! $isCurrentMonth) data-ui-date-range-adjacent-month="true" @endif
                        >
                            {{ $day->format('j') }}
                        </button>
                    @endforeach
                </div>
            </div>

            <p id="date-range-status" class="ui-field-helper" data-ui-date-range-status aria-live="polite">
                Selected range: 2026-06-10 to 2026-06-18.
            </p>
        </div>
    </section>

    <section class="ui-reference-layer-section" data-date-picker-live-section="time-picker">
        <div class="ui-reference-section-heading">
            <h3>Time picker anatomy</h3>
            <p>Time picker combines a time text field, AM/PM select, and timezone select. The selects use the Select component contract because time picker is a composed field.</p>
        </div>

        <div class="ui-time-picker" data-ui-component="time-picker" data-ui-time-picker>
            <div class="ui-field ui-time-picker-time-field">
                <label id="time-picker-meeting-time-label" for="time-picker-meeting-time" class="ui-field-label">Meeting time</label>
                <input
                    id="time-picker-meeting-time"
                    name="meeting_time"
                    type="text"
                    value="11:30"
                    inputmode="numeric"
                    pattern="[0-9]{1,2}:[0-9]{2}"
                    class="ui-input ui-time-picker-input"
                    aria-describedby="time-picker-helper"
                    data-ui-time-picker-input
                >
            </div>

            <x-ui.select
                name="meeting_period"
                label="Period"
                :options="$periods"
                value="AM"
                data-ui-time-picker-period
            />

            <x-ui.select
                name="meeting_timezone"
                label="Timezone"
                :options="$timeZones"
                value="America/New_York"
                data-ui-time-picker-timezone
            />

            <p id="time-picker-helper" class="ui-field-helper ui-time-picker-helper">Use uppercase AM or PM and include the timezone for scheduled events.</p>
        </div>
    </section>

    <section class="ui-reference-layer-section" data-date-picker-live-section="styles-and-fluid">
        <div class="ui-reference-section-heading">
            <h3>Styles and fluid versions</h3>
            <p>Default date fields support small, medium, and large heights. Fluid fields use the single 64px expressive height and apply focus/error treatment to the full field shell.</p>
        </div>

        <div class="grid gap-4 xl:grid-cols-3">
            <x-ui.date-picker name="date_picker_sm" label="Small" size="sm" value="2026-06-08" />
            <x-ui.date-picker name="date_picker_md" label="Medium" size="md" value="2026-06-08" />
            <x-ui.date-picker name="date_picker_lg" label="Large" size="lg" value="2026-06-08" />
        </div>

        <div class="mt-4 grid gap-4 xl:grid-cols-2">
            <x-ui.date-picker name="date_picker_fluid" label="Fluid date" style="fluid" value="2026-06-08" helper="Fluid fields are reserved for expressive or contained contexts." />
            <x-ui.date-picker name="date_picker_fluid_error" label="Fluid expiration date" style="fluid" invalid invalid-text="Choose an expiration date before saving." required />
        </div>
    </section>

    <section class="ui-reference-layer-section" data-date-picker-live-section="states">
        <div class="ui-reference-section-heading">
            <h3>States</h3>
            <p>Date picker fields use the same text input state model, with calendar-open and range-selecting states added only for calendar picker variants.</p>
        </div>

        <div class="ui-date-picker-state-grid">
            @foreach ($stateRows as [$stateLabel, $fieldLabel, $fieldName, $stateProps])
                <article class="ui-reference-example-card">
                    <span class="ui-state-badge">{{ $stateLabel }}</span>
                    <div class="mt-4">
                        <x-ui.date-picker
                            :name="$fieldName"
                            :label="$fieldLabel"
                            :value="$stateProps['value'] ?? null"
                            :helper="$stateProps['helper'] ?? null"
                            :invalid="$stateProps['invalid'] ?? false"
                            :invalid-text="$stateProps['invalid-text'] ?? null"
                            :warn="$stateProps['warn'] ?? false"
                            :warn-text="$stateProps['warn-text'] ?? null"
                            :disabled="$stateProps['disabled'] ?? false"
                            :readonly="$stateProps['readonly'] ?? false"
                            :required="$stateProps['required'] ?? false"
                            :skeleton="$stateProps['skeleton'] ?? false"
                            :class="$stateProps['class'] ?? null"
                        />
                    </div>
                </article>
            @endforeach
        </div>
    </section>
</div>
