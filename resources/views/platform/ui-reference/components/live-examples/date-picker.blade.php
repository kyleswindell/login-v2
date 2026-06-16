@php
    $periods = [
        ['value' => 'AM', 'label' => 'AM'],
        ['value' => 'PM', 'label' => 'PM'],
    ];

    $timeZones = [
        ['value' => 'America/New_York', 'label' => 'Eastern Time (ET)'],
        ['value' => 'America/Chicago', 'label' => 'Central Time (CT)'],
        ['value' => 'America/Denver', 'label' => 'Mountain Time (MT)'],
        ['value' => 'America/Los_Angeles', 'label' => 'Pacific Time (PT)'],
    ];

    $dateStates = [
        ['Enabled', 'Report date', 'date_picker_state_default', ['value' => '2026-06-08', 'helper' => 'Format: yyyy-mm-dd.']],
        ['Focus', 'Focused date', 'date_picker_state_focus', ['value' => '2026-06-10', 'class' => 'is-focus', 'helper' => 'Focus remains visible after click or keyboard entry until another interaction.']],
        ['Error', 'Expiration date', 'date_picker_state_error', ['invalid' => true, 'invalid-text' => 'Choose an expiration date before saving.', 'required' => true]],
        ['Warning', 'Review date', 'date_picker_state_warning', ['value' => '2026-12-24', 'warn' => true, 'warn-text' => 'Review dates near holidays need owner confirmation.']],
        ['Disabled', 'Locked until', 'date_picker_state_disabled', ['value' => '2026-06-30', 'disabled' => true, 'helper' => 'This date is controlled by tenant policy.']],
        ['Read-only', 'Created on', 'date_picker_state_readonly', ['value' => '2026-06-08', 'readonly' => true, 'helper' => 'Created date is system-managed.']],
        ['Skeleton', 'Available date', 'date_picker_state_loading', ['skeleton' => true]],
    ];

    $calendarStart = \Carbon\CarbonImmutable::parse('2026-06-01');
    $calendarEnd = \Carbon\CarbonImmutable::parse('2026-07-05');
    $calendarDays = [];

    for ($day = $calendarStart; $day->lte($calendarEnd); $day = $day->addDay()) {
        $calendarDays[] = $day;
    }
@endphp

<div class="space-y-8" data-component-live-layout="date-picker-matrix" data-ui-reference-sample-type="date-picker">
    <section class="ui-reference-layer-section">
        <div class="ui-reference-section-heading">
            <h3>Approved variants</h3>
            <p>Date picker is split into simple date input, calendar picker, and time picker. Date + Time combo picker is not an approved component option.</p>
        </div>

        <div class="ui-tabs ui-tabs-contained mt-4" data-ui-tabs data-ui-tabs-activation="manual" data-date-picker-tabs>
            <div class="ui-tabs-list" role="tablist" aria-label="Date picker variants">
                <button id="date-picker-simple-tab" type="button" class="ui-tabs-tab" role="tab" aria-selected="true" aria-controls="date-picker-simple-panel" data-ui-tabs-tab>
                    Simple date input
                </button>
                <button id="date-picker-calendar-tab" type="button" class="ui-tabs-tab" role="tab" aria-selected="false" aria-controls="date-picker-calendar-panel" tabindex="-1" data-ui-tabs-tab>
                    Calendar picker
                </button>
                <button id="date-picker-time-tab" type="button" class="ui-tabs-tab" role="tab" aria-selected="false" aria-controls="date-picker-time-panel" tabindex="-1" data-ui-tabs-tab>
                    Time picker
                </button>
            </div>

            <div class="ui-tabs-panels">
                <section id="date-picker-simple-panel" class="ui-tabs-panel space-y-6" role="tabpanel" aria-labelledby="date-picker-simple-tab" data-ui-tabs-panel>
                    <div class="ui-reference-section-heading">
                        <h3>Simple date input</h3>
                        <p>Simple date input uses one native date field with a visible label and explicit format guidance. Default style applies the field layer to the entry field only.</p>
                    </div>

                    <div class="grid gap-4 xl:grid-cols-2">
                        <article class="ui-reference-example-card">
                            <h4 class="ui-reference-example-title">Default simple date input</h4>
                            <div class="mt-4 max-w-sm">
                                <x-ui.date-picker
                                    name="date_picker_start_date"
                                    label="Start date"
                                    value="2026-06-08"
                                    helper="Format: yyyy-mm-dd. Use the first date this setting should apply."
                                    min-date="2026-01-01"
                                    max-date="2026-12-31"
                                    required
                                />
                            </div>
                        </article>

                        <article class="ui-reference-example-card">
                            <h4 class="ui-reference-example-title">Fluid simple date input</h4>
                            <div class="mt-4 max-w-sm">
                                <x-ui.date-picker
                                    name="date_picker_fluid"
                                    label="Activation date"
                                    style="fluid"
                                    value="2026-06-08"
                                    helper="Fluid style uses a 64px shell and applies the layer to the full field surface."
                                />
                            </div>
                        </article>
                    </div>

                    <div class="ui-reference-example-card">
                        <h4 class="ui-reference-example-title">Default input sizes</h4>
                        <div class="mt-4 grid gap-4 xl:grid-cols-3">
                            <x-ui.date-picker name="date_picker_sm" label="Small date input, 32px" size="sm" value="2026-06-08" helper="Use in dense forms." />
                            <x-ui.date-picker name="date_picker_md" label="Medium date input, 40px" size="md" value="2026-06-08" helper="Default size." />
                            <x-ui.date-picker name="date_picker_lg" label="Large date input, 48px" size="lg" value="2026-06-08" helper="Use with more vertical room." />
                        </div>
                    </div>

                    <div class="ui-reference-example-card">
                        <h4 class="ui-reference-example-title">Simple date input states</h4>
                        <div class="ui-date-picker-state-grid mt-4">
                            @foreach ($dateStates as [$stateLabel, $fieldLabel, $fieldName, $stateProps])
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
                    </div>
                </section>

                <section id="date-picker-calendar-panel" class="ui-tabs-panel space-y-6" role="tabpanel" aria-labelledby="date-picker-calendar-tab" data-ui-tabs-panel hidden>
                    <div class="ui-reference-section-heading">
                        <h3>Calendar picker</h3>
                        <p>Calendar picker adds a calendar affordance and range selection when choosing from a calendar menu is required. The calendar menu dimensions do not change with input size.</p>
                    </div>

                    <div class="grid gap-4 xl:grid-cols-2">
                        <article class="ui-reference-example-card">
                            <h4 class="ui-reference-example-title">Default calendar picker</h4>
                            <div class="mt-4 max-w-sm">
                                <x-ui.date-picker
                                    name="date_picker_calendar_default"
                                    label="Policy start date"
                                    value="2026-06-08"
                                    helper="Format: yyyy-mm-dd. Calendar picker automates the selected date format."
                                />
                            </div>
                        </article>

                        <article class="ui-reference-example-card">
                            <h4 class="ui-reference-example-title">Fluid calendar picker</h4>
                            <div class="mt-4 max-w-sm">
                                <x-ui.date-picker
                                    name="date_picker_calendar_fluid"
                                    label="Renewal date"
                                    style="fluid"
                                    value="2026-06-18"
                                    helper="Fluid calendar fields use the full shell for the field layer and focus state."
                                />
                            </div>
                        </article>
                    </div>

                    <article
                        class="ui-date-range-picker"
                        data-ui-component="date-range-picker"
                        data-ui-date-range-picker
                        data-ui-date-range-start="2026-06-10"
                        data-ui-date-range-end="2026-06-18"
                    >
                        <div class="ui-reference-section-heading">
                            <h3>Date range picker</h3>
                            <p>Range inputs are labeled independently as start and end dates. Selecting either field updates the same range and previews the hovered endpoint.</p>
                        </div>

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
                    </article>

                    <div class="ui-reference-example-card">
                        <h4 class="ui-reference-example-title">Calendar picker states</h4>
                        <div class="mt-4 grid gap-4 xl:grid-cols-3">
                            <x-ui.date-picker name="date_picker_calendar_focus" label="Focused date" value="2026-06-10" class="is-focus" helper="Calendar icon inherits the field state." />
                            <x-ui.date-picker name="date_picker_calendar_error" label="End date" invalid invalid-text="Required field" required />
                            <x-ui.date-picker name="date_picker_calendar_disabled" label="Disabled date" value="2026-06-08" disabled helper="Disabled date fields are visibly muted and not focusable." />
                        </div>
                    </div>
                </section>

                <section id="date-picker-time-panel" class="ui-tabs-panel space-y-6" role="tabpanel" aria-labelledby="date-picker-time-tab" data-ui-tabs-panel hidden>
                    <div class="ui-reference-section-heading">
                        <h3>Time picker</h3>
                        <p>Time picker is a composed control: one text input for hour and minute, one AM/PM select for 12-hour time, and one timezone select.</p>
                    </div>

                    <div class="grid gap-4 xl:grid-cols-2">
                        <article class="ui-time-picker" data-ui-component="time-picker" data-ui-time-picker data-time-picker-example="default">
                            <h4 class="ui-reference-example-title">Default time picker</h4>
                            <div class="ui-time-picker-row mt-4">
                                <div class="ui-field ui-time-picker-time-field">
                                    <label id="time-picker-default-label" for="time-picker-default" class="ui-field-label">Set time</label>
                                    <input id="time-picker-default" name="meeting_time" type="text" value="03:30" inputmode="numeric" pattern="[0-9]{1,2}:[0-9]{2}" class="ui-input ui-time-picker-input" aria-describedby="time-picker-default-helper" data-ui-time-picker-input>
                                </div>

                                <x-ui.select name="meeting_period" label="Clock" :options="$periods" value="AM" class="ui-time-picker-period" data-ui-time-picker-period />

                                <x-ui.select name="meeting_timezone" label="Timezone" :options="$timeZones" value="America/New_York" class="ui-time-picker-timezone" data-ui-time-picker-timezone />
                            </div>
                            <p id="time-picker-default-helper" class="ui-field-helper ui-time-picker-helper">Use uppercase AM or PM and include the timezone for scheduled events.</p>
                        </article>

                        <article class="ui-time-picker ui-time-picker-fluid" data-ui-component="time-picker" data-ui-time-picker data-time-picker-example="fluid">
                            <h4 class="ui-reference-example-title">Fluid time picker</h4>
                            <div class="ui-time-picker-row mt-4">
                                <div class="ui-field ui-time-picker-time-field ui-time-picker-time-field-shell">
                                    <label id="time-picker-fluid-label" for="time-picker-fluid" class="ui-field-label">Time</label>
                                    <input id="time-picker-fluid" name="meeting_time_fluid" type="text" value="03:30" inputmode="numeric" pattern="[0-9]{1,2}:[0-9]{2}" class="ui-input ui-time-picker-input" aria-describedby="time-picker-fluid-helper" data-ui-time-picker-input>
                                </div>

                                <x-ui.select name="meeting_period_fluid" label="Clock" :options="$periods" value="PM" style="fluid" class="ui-time-picker-period" data-ui-time-picker-period />

                                <x-ui.select name="meeting_timezone_fluid" label="Timezone" :options="$timeZones" value="America/New_York" style="fluid" class="ui-time-picker-timezone" data-ui-time-picker-timezone />
                            </div>
                            <p id="time-picker-fluid-helper" class="ui-field-helper ui-time-picker-helper">Fluid style uses one 64px row treatment across the time field and selects.</p>
                        </article>
                    </div>

                    <div class="ui-reference-example-card">
                        <h4 class="ui-reference-example-title">Default time picker sizes</h4>
                        <div class="mt-4 grid gap-4">
                            @foreach ([['sm', 'Small time picker, 32px'], ['md', 'Medium time picker, 40px'], ['lg', 'Large time picker, 48px']] as [$size, $label])
                                <div class="ui-time-picker ui-time-picker-{{ $size }}" data-ui-component="time-picker" data-ui-time-picker data-time-picker-size="{{ $size }}">
                                    <h5 class="ui-reference-example-title">{{ $label }}</h5>
                                    <div class="ui-time-picker-row mt-4">
                                        <div class="ui-field ui-time-picker-time-field">
                                            <label for="time-picker-size-{{ $size }}" class="ui-field-label">Time</label>
                                            <input id="time-picker-size-{{ $size }}" name="time_picker_size_{{ $size }}" type="text" value="09:15" class="ui-input ui-time-picker-input" data-ui-time-picker-input>
                                        </div>
                                        <x-ui.select :name="'time_picker_size_period_'.$size" label="Clock" :options="$periods" value="AM" :size="$size" class="ui-time-picker-period" data-ui-time-picker-period />
                                        <x-ui.select :name="'time_picker_size_timezone_'.$size" label="Timezone" :options="$timeZones" value="America/New_York" :size="$size" class="ui-time-picker-timezone" data-ui-time-picker-timezone />
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="ui-reference-example-card">
                        <h4 class="ui-reference-example-title">Time picker states</h4>
                        <div class="mt-4 grid gap-4 xl:grid-cols-3">
                            <div class="ui-time-picker" data-ui-component="time-picker" data-ui-time-picker>
                                <span class="ui-state-badge">Focus</span>
                                <div class="ui-time-picker-row mt-4">
                                    <div class="ui-field ui-time-picker-time-field">
                                        <label for="time-picker-focus" class="ui-field-label">Time</label>
                                        <input id="time-picker-focus" name="time_picker_focus" type="text" value="10:45" class="ui-input ui-time-picker-input is-focus" data-ui-time-picker-input>
                                    </div>
                                    <x-ui.select name="time_picker_focus_period" label="Clock" :options="$periods" value="AM" class="ui-time-picker-period" data-ui-time-picker-period />
                                </div>
                            </div>

                            <div class="ui-time-picker ui-time-picker-invalid" data-ui-component="time-picker" data-ui-time-picker>
                                <span class="ui-state-badge">Error</span>
                                <div class="ui-time-picker-row mt-4">
                                    <div class="ui-field ui-time-picker-time-field">
                                        <label for="time-picker-error" class="ui-field-label">Time</label>
                                        <input id="time-picker-error" name="time_picker_error" type="text" value="" class="ui-input ui-time-picker-input" aria-invalid="true" data-ui-time-picker-input>
                                    </div>
                                    <x-ui.select name="time_picker_error_period" label="Clock" :options="$periods" placeholder="Choose" invalid invalid-text="Required field" class="ui-time-picker-period" data-ui-time-picker-period />
                                </div>
                                <p class="ui-field-error">Required field</p>
                            </div>

                            <div class="ui-time-picker ui-time-picker-disabled" data-ui-component="time-picker" data-ui-time-picker>
                                <span class="ui-state-badge">Disabled</span>
                                <div class="ui-time-picker-row mt-4">
                                    <div class="ui-field ui-time-picker-time-field">
                                        <label for="time-picker-disabled" class="ui-field-label">Time</label>
                                        <input id="time-picker-disabled" name="time_picker_disabled" type="text" value="02:00" class="ui-input ui-time-picker-input" disabled data-ui-time-picker-input>
                                    </div>
                                    <x-ui.select name="time_picker_disabled_period" label="Clock" :options="$periods" value="PM" disabled class="ui-time-picker-period" data-ui-time-picker-period />
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>
