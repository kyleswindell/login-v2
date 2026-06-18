@php
    $disabledCalendarDates = ['2019-03-05', '2019-03-06', '2019-03-07', '2019-03-08', '2019-03-09', '2019-03-10', '2019-03-11', '2019-03-12'];
@endphp

<div class="space-y-8" data-component-live-layout="date-picker-matrix" data-ui-reference-sample-type="date-picker">
    <section class="ui-reference-layer-section" data-date-picker-live-section="approved-variants">
        <div class="ui-reference-section-heading">
            <p class="text-xs font-semibold uppercase tracking-[0.18em]" style="color: var(--ui-text-secondary);">Approved variants</p>
            <h3 class="mt-2 text-lg font-semibold" style="color: var(--ui-text-primary);">Date Picker</h3>
            <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Simple input remains first-party. Single and range calendar behavior is provided by Flatpickr through the app-owned Date Picker API.</p>
        </div>

        <div class="ui-tabs ui-tabs-contained mt-4" data-ui-tabs data-ui-tabs-activation="manual" data-date-picker-tabs>
            <div class="ui-tabs-list" role="tablist" aria-label="Date picker variants">
                <button id="date-picker-simple-tab" type="button" class="ui-tabs-tab" role="tab" aria-selected="true" aria-controls="date-picker-simple-panel" data-ui-tabs-tab>
                    Simple
                </button>
                <button id="date-picker-single-tab" type="button" class="ui-tabs-tab" role="tab" aria-selected="false" aria-controls="date-picker-single-panel" tabindex="-1" data-ui-tabs-tab>
                    Single
                </button>
                <button id="date-picker-range-tab" type="button" class="ui-tabs-tab" role="tab" aria-selected="false" aria-controls="date-picker-range-panel" tabindex="-1" data-ui-tabs-tab>
                    Range
                </button>
                <button id="date-picker-skeleton-tab" type="button" class="ui-tabs-tab" role="tab" aria-selected="false" aria-controls="date-picker-skeleton-panel" tabindex="-1" data-ui-tabs-tab>
                    Skeleton
                </button>
            </div>

            <div class="ui-tabs-panels">
                <section id="date-picker-simple-panel" class="ui-tabs-panel space-y-6" role="tabpanel" aria-labelledby="date-picker-simple-tab" data-ui-tabs-panel>
                    <div>
                        <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Simple date input</h4>
                        <p class="mt-1 text-sm" style="color: var(--ui-text-secondary);">Simple date input does not initialize Flatpickr or render a calendar toggle.</p>
                    </div>

                    <div class="grid gap-4 md:grid-cols-3">
                        <x-ui.date-picker date-picker-type="simple">
                            <x-ui.date-picker-input name="date_simple_sm" label-text="Small date input" size="sm" value="03/15/2019" helper-text="month/day/year" />
                        </x-ui.date-picker>
                        <x-ui.date-picker date-picker-type="simple">
                            <x-ui.date-picker-input name="date_simple_md" label-text="Medium date input" size="md" value="03/15/2019" helper-text="month/day/year" />
                        </x-ui.date-picker>
                        <x-ui.date-picker date-picker-type="simple">
                            <x-ui.date-picker-input name="date_simple_lg" label-text="Large date input" size="lg" value="03/15/2019" helper-text="month/day/year" />
                        </x-ui.date-picker>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <x-ui.date-picker date-picker-type="simple">
                            <x-ui.date-picker-input name="date_simple_error" label-text="Required date" invalid invalid-text="Enter a valid date." placeholder="mm/dd/yyyy" />
                        </x-ui.date-picker>
                        <x-ui.date-picker date-picker-type="simple">
                            <x-ui.date-picker-input name="date_simple_warning" label-text="Review date" warn warn-text="This date is outside the recommended window." value="03/15/2019" />
                        </x-ui.date-picker>
                        <x-ui.date-picker date-picker-type="simple">
                            <x-ui.date-picker-input name="date_simple_disabled" label-text="Disabled date" value="03/15/2019" disabled helper-text="Disabled fields are unavailable." />
                        </x-ui.date-picker>
                        <x-ui.date-picker date-picker-type="simple">
                            <x-ui.date-picker-input name="date_simple_readonly" label-text="Read-only date" value="03/15/2019" read-only helper-text="Read-only fields stay readable." />
                        </x-ui.date-picker>
                    </div>

                    <x-ui.date-picker date-picker-type="simple" class="max-w-md">
                        <x-ui.date-picker-input name="date_simple_fluid" label-text="Fluid simple date" style="fluid" value="03/15/2019" helper-text="Fluid simple input keeps label text inside the field." />
                    </x-ui.date-picker>
                </section>

                <section id="date-picker-single-panel" class="ui-tabs-panel space-y-6" role="tabpanel" aria-labelledby="date-picker-single-tab" data-ui-tabs-panel hidden>
                    <div>
                        <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Single calendar picker</h4>
                        <p class="mt-1 text-sm" style="color: var(--ui-text-secondary);">Single calendar examples initialize Flatpickr with min/max, date format, locale, and open/close hooks.</p>
                    </div>

                    <div class="grid gap-4 md:grid-cols-3">
                        <x-ui.date-picker date-picker-type="single" value="2019-03-15" date-format="m/d/Y">
                            <x-ui.date-picker-input name="date_single_sm" label-text="Small calendar picker" size="sm" value="03/15/2019" calendar />
                        </x-ui.date-picker>
                        <x-ui.date-picker date-picker-type="single" value="2019-03-15" date-format="m/d/Y">
                            <x-ui.date-picker-input name="date_single_md" label-text="Medium calendar picker" size="md" value="03/15/2019" calendar />
                        </x-ui.date-picker>
                        <x-ui.date-picker date-picker-type="single" value="2019-03-15" date-format="m/d/Y">
                            <x-ui.date-picker-input name="date_single_lg" label-text="Large calendar picker" size="lg" value="03/15/2019" calendar />
                        </x-ui.date-picker>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <x-ui.date-picker date-picker-type="single" value="2019-03-15" date-format="m/d/Y" min-date="2019-03-13" max-date="2019-03-31" :disable="$disabledCalendarDates">
                            <x-ui.date-picker-input name="date_single_min_max" label-text="Bounded calendar" value="03/15/2019" helper-text="Available dates start March 13, 2019." calendar />
                        </x-ui.date-picker>
                        <x-ui.date-picker date-picker-type="single" value="2026-06-08" date-format="Y-m-d" locale="default">
                            <x-ui.date-picker-input name="date_single_iso" label-text="ISO date format" value="2026-06-08" helper-text="Format: yyyy-mm-dd." calendar />
                        </x-ui.date-picker>
                        <x-ui.date-picker date-picker-type="single" value="2019-03-15" date-format="m/d/Y">
                            <x-ui.date-picker-input name="date_single_error" label-text="Calendar error" value="03/15/2019" invalid invalid-text="Choose a valid date." calendar />
                        </x-ui.date-picker>
                        <x-ui.date-picker date-picker-type="single" value="2019-03-15" date-format="m/d/Y">
                            <x-ui.date-picker-input name="date_single_fluid" label-text="Fluid calendar picker" style="fluid" value="03/15/2019" calendar />
                        </x-ui.date-picker>
                    </div>
                </section>

                <section id="date-picker-range-panel" class="ui-tabs-panel space-y-6" role="tabpanel" aria-labelledby="date-picker-range-tab" data-ui-tabs-panel hidden>
                    <div>
                        <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Range calendar picker</h4>
                        <p class="mt-1 text-sm" style="color: var(--ui-text-secondary);">Range picker uses Flatpickr range mode plus the documented rangePlugin bridge for two inputs.</p>
                    </div>

                    <x-ui.date-picker date-picker-type="range" :value="['2019-03-12', '2019-03-16']" date-format="m/d/Y" min-date="2019-03-13" max-date="2019-03-31">
                        <div class="ui-date-picker-range-fields">
                            <x-ui.date-picker-input name="date_range_start" label-text="Start date" value="03/12/2019" role="start" calendar />
                            <x-ui.date-picker-input name="date_range_end" label-text="End date" value="03/16/2019" role="end" calendar />
                        </div>
                    </x-ui.date-picker>

                    <x-ui.date-picker date-picker-type="range" :value="['2019-03-12']" date-format="m/d/Y">
                        <div class="ui-date-picker-range-fields">
                            <x-ui.date-picker-input name="date_range_validation_start" label-text="Start date" value="03/12/2019" role="start" calendar helper-text="month/day/year" />
                            <x-ui.date-picker-input name="date_range_validation_end" label-text="End date" role="end" calendar invalid invalid-text="Required field" />
                        </div>
                    </x-ui.date-picker>

                    <x-ui.date-picker date-picker-type="range" :value="['2019-03-15', '2019-03-20']" date-format="m/d/Y">
                        <div class="ui-date-picker-range-fields">
                            <x-ui.date-picker-input name="date_range_fluid_start" label-text="Start date" value="03/15/2019" role="start" style="fluid" calendar />
                            <x-ui.date-picker-input name="date_range_fluid_end" label-text="End date" value="03/20/2019" role="end" style="fluid" calendar />
                        </div>
                    </x-ui.date-picker>
                </section>

                <section id="date-picker-skeleton-panel" class="ui-tabs-panel space-y-6" role="tabpanel" aria-labelledby="date-picker-skeleton-tab" data-ui-tabs-panel hidden>
                    <div>
                        <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Skeleton loading</h4>
                        <p class="mt-1 text-sm" style="color: var(--ui-text-secondary);">Skeleton examples represent pending single and range date picker fields without initializing Flatpickr.</p>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <x-ui.date-picker-skeleton />
                        <x-ui.date-picker-skeleton range />
                        <x-ui.date-picker-skeleton style="fluid" />
                        <x-ui.date-picker-skeleton range style="fluid" />
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>
