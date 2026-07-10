/* ==========================================================================
   Date picker behavior
   ========================================================================== */

import flatpickr from "flatpickr";
import rangePlugin from "flatpickr/dist/plugins/rangePlugin";
import l10n from "flatpickr/dist/l10n/index";
import "flatpickr/dist/flatpickr.css";

/* ==========================================================================
   Data parsing helpers
   ========================================================================== */

/**
 * Parse a data attribute as a JSON list, falling back to a single string value.
 */
const parseJsonList = (value) => {
    if (!value) {
        return [];
    }

    try {
        const parsed = JSON.parse(value);

        if (Array.isArray(parsed)) {
            return parsed.filter((item) => item !== null && item !== "");
        }

        return parsed === null || parsed === "" ? [] : [parsed];
    } catch {
        return [value];
    }
};

/**
 * Parse a boolean-like data attribute.
 */
const boolValue = (value, fallback = false) => {
    if (value === undefined || value === null || value === "") {
        return fallback;
    }

    return value === true || value === "true" || value === "1";
};

/**
 * Resolve a selector-based append target for flatpickr.
 */
const resolveAppendTarget = (selector) => {
    if (!selector) {
        return undefined;
    }

    return document.querySelector(selector) ?? undefined;
};

/**
 * Resolve a flatpickr locale from a locale code.
 */
const resolveLocale = (locale) => {
    if (!locale || locale === "en") {
        return undefined;
    }

    return l10n?.[locale] ?? locale;
};

/**
 * Resolve date picker type.
 */
const resolveDatePickerType = (picker) => {
    const type = picker.dataset.uiDatePickerType;

    if (type === "simple" || type === "single" || type === "range") {
        return type;
    }

    return "single";
};

/**
 * Return the flatpickr calendar mode for a date picker type.
 */
const resolveFlatpickrMode = (type) => {
    return type === "range" ? "range" : "single";
};

/* ==========================================================================
   State helpers
   ========================================================================== */

/**
 * Write open and selected state back to the picker wrapper.
 */
const setPickerState = (picker, instance, isOpen = false) => {
    picker.dataset.uiDatePickerOpen = isOpen ? "true" : "false";

    if (!instance) {
        picker.dataset.uiDatePickerSelectedValue = "[]";
        return;
    }

    picker.dataset.uiDatePickerSelectedValue = JSON.stringify(
        instance.selectedDates.map((date) => date.toISOString()),
    );
};

/**
 * Update read-only state on all picker inputs.
 */
const syncReadOnlyInputs = (picker, inputs) => {
    const isReadOnly = boolValue(picker.dataset.uiDatePickerReadonly, false);

    inputs.forEach((input) => {
        if (input instanceof HTMLInputElement) {
            input.readOnly = isReadOnly || input.readOnly;
            input.setAttribute("aria-readonly", isReadOnly ? "true" : "false");
        }
    });
};

/* ==========================================================================
   Calendar decoration
   ========================================================================== */

/**
 * Apply app-owned date picker classes to flatpickr generated calendar DOM.
 */
const decorateCalendar = (picker, instance) => {
    if (!instance?.calendarContainer) {
        return;
    }

    const calendar = instance.calendarContainer;

    calendar.classList.add("ui-date-picker__calendar");
    calendar.classList.add("ui-date-picker-calendar");
    calendar.dataset.uiDatePickerCalendar = "";

    const month = calendar.querySelector(".flatpickr-month");
    const weekdays = calendar.querySelector(".flatpickr-weekdays");
    const days = calendar.querySelector(".flatpickr-days");

    if (month) {
        month.classList.add("ui-date-picker__month");
    }

    if (weekdays) {
        weekdays.classList.add("ui-date-picker__weekdays");
    }

    if (days) {
        days.classList.add("ui-date-picker__days");
    }

    calendar.querySelectorAll(".flatpickr-weekday").forEach((weekday) => {
        weekday.textContent = weekday.textContent?.replace(/\s+/g, "") ?? "";
        weekday.classList.add("ui-date-picker__weekday");
    });

    calendar.querySelectorAll(".flatpickr-day").forEach((day) => {
        day.classList.add("ui-date-picker__day");
        day.setAttribute("role", "button");

        if (
            day.classList.contains("today") &&
            instance.selectedDates.length > 0
        ) {
            day.classList.add("no-border");
        }

        if (
            day.classList.contains("today") &&
            instance.selectedDates.length === 0
        ) {
            day.classList.remove("no-border");
        }
    });

    const previousMonthLabel =
        picker.dataset.uiDatePickerPrevMonthLabel ||
        picker.dataset.uiDatePickerPrevMonthAriaLabel ||
        "Previous month";

    const nextMonthLabel =
        picker.dataset.uiDatePickerNextMonthLabel ||
        picker.dataset.uiDatePickerNextMonthAriaLabel ||
        "Next month";

    const previousButton = calendar.querySelector(".flatpickr-prev-month");
    const nextButton = calendar.querySelector(".flatpickr-next-month");

    if (previousButton) {
        previousButton.setAttribute("aria-label", previousMonthLabel);
    }

    if (nextButton) {
        nextButton.setAttribute("aria-label", nextMonthLabel);
    }
};

/* ==========================================================================
   Flatpickr configuration
   ========================================================================== */

/**
 * Build flatpickr options from the date picker wrapper data attributes.
 */
const buildFlatpickrOptions = (picker, inputs) => {
    const type = resolveDatePickerType(picker);
    const mode = resolveFlatpickrMode(type);

    const defaultDate = parseJsonList(picker.dataset.uiDatePickerValue);
    const disabledDates = parseJsonList(picker.dataset.uiDatePickerDisable);
    const enabledDates = parseJsonList(picker.dataset.uiDatePickerEnable);

    const isReadOnly = boolValue(picker.dataset.uiDatePickerReadonly, false);

    const options = {
        mode,
        allowInput: boolValue(picker.dataset.uiDatePickerAllowInput, true),
        closeOnSelect: boolValue(
            picker.dataset.uiDatePickerCloseOnSelect,
            mode !== "range",
        ),
        dateFormat: picker.dataset.uiDatePickerDateFormat || "m/d/Y",
        ariaDateFormat:
            picker.dataset.uiDatePickerAriaDateFormat || "l, F j, Y",
        inline: boolValue(picker.dataset.uiDatePickerInline, false),
        appendTo: resolveAppendTarget(picker.dataset.uiDatePickerAppendTo),
        disableMobile: true,
        clickOpens: !isReadOnly,
        noCalendar: isReadOnly,
        onReady: [
            (_selectedDates, _dateStr, instance) => {
                syncReadOnlyInputs(picker, inputs);
                decorateCalendar(picker, instance);
                setPickerState(picker, instance, false);
            },
        ],
        onOpen: [
            (_selectedDates, _dateStr, instance) => {
                syncReadOnlyInputs(picker, inputs);
                decorateCalendar(picker, instance);
                setPickerState(picker, instance, true);
            },
        ],
        onClose: [
            (_selectedDates, _dateStr, instance) => {
                setPickerState(picker, instance, false);
            },
        ],
        onChange: [
            (_selectedDates, _dateStr, instance) => {
                decorateCalendar(picker, instance);
                setPickerState(picker, instance, instance.isOpen);
            },
        ],
        onValueUpdate: [
            (_selectedDates, _dateStr, instance) => {
                decorateCalendar(picker, instance);
                setPickerState(picker, instance, instance.isOpen);
            },
        ],
        onMonthChange: [
            (_selectedDates, _dateStr, instance) => {
                decorateCalendar(picker, instance);
            },
        ],
        onYearChange: [
            (_selectedDates, _dateStr, instance) => {
                decorateCalendar(picker, instance);
            },
        ],
    };

    const locale = resolveLocale(picker.dataset.uiDatePickerLocale);

    if (locale) {
        options.locale = locale;
    }

    if (defaultDate.length > 0) {
        options.defaultDate = defaultDate;
    }

    if (disabledDates.length > 0) {
        options.disable = disabledDates;
    }

    if (enabledDates.length > 0) {
        options.enable = enabledDates;
    }

    if (picker.dataset.uiDatePickerMinDate) {
        options.minDate = picker.dataset.uiDatePickerMinDate;
    }

    if (picker.dataset.uiDatePickerMaxDate) {
        options.maxDate = picker.dataset.uiDatePickerMaxDate;
    }

    if (mode === "range" && inputs[1] instanceof HTMLInputElement) {
        options.plugins = [
            new rangePlugin({
                input: inputs[1],
            }),
        ];
    }

    return options;
};

/* ==========================================================================
   Keyboard behavior
   ========================================================================== */

/**
 * Close the flatpickr calendar on Escape.
 */
const handleDatePickerInputKeyDown = (event) => {
    const input = event.currentTarget;

    if (!(input instanceof HTMLInputElement)) {
        return;
    }

    const instance = input._flatpickr;

    if (!instance) {
        return;
    }

    if (event.key === "Escape" && instance.isOpen) {
        instance.close();
    }
};

/**
 * Attach input-level handlers.
 */
const bindInputHandlers = (input) => {
    if (
        !(input instanceof HTMLInputElement) ||
        input.dataset.uiDatePickerInputInit === "1"
    ) {
        return;
    }

    input.dataset.uiDatePickerInputInit = "1";
    input.addEventListener("keydown", handleDatePickerInputKeyDown);
};

/* ==========================================================================
   Initialization
   ========================================================================== */

/**
 * Initialize one date picker.
 */
const initDatePicker = (picker) => {
    if (
        !(picker instanceof HTMLElement) ||
        picker.dataset.uiDatePickerInitialized === "true"
    ) {
        return;
    }

    const inputs = Array.from(
        picker.querySelectorAll("[data-ui-date-picker-input]"),
    ).filter((input) => input instanceof HTMLInputElement);

    const startInput = inputs[0];

    if (!(startInput instanceof HTMLInputElement)) {
        picker.dataset.uiDatePickerInitialized = "true";
        return;
    }

    const type = resolveDatePickerType(picker);

    syncReadOnlyInputs(picker, inputs);

    inputs.forEach((input) => {
        bindInputHandlers(input);
    });

    /*
     * Simple date picker is plain input-only. It does not initialize flatpickr.
     */
    if (type === "simple") {
        picker.dataset.uiDatePickerInitialized = "true";
        setPickerState(picker, null, false);
        return;
    }

    /*
     * Read-only date pickers should remain non-opening inputs.
     */
    if (boolValue(picker.dataset.uiDatePickerReadonly, false)) {
        picker.dataset.uiDatePickerInitialized = "true";
        setPickerState(picker, null, false);
        return;
    }

    if (startInput.disabled) {
        picker.dataset.uiDatePickerInitialized = "true";
        setPickerState(picker, null, false);
        return;
    }

    if (startInput._flatpickr) {
        startInput._flatpickr.destroy();
    }

    const instance = flatpickr(
        startInput,
        buildFlatpickrOptions(picker, inputs),
    );

    picker.dataset.uiDatePickerInitialized = "true";
    picker.uiDatePickerInstance = instance;
};

/**
 * Initialize Date Picker behavior.
 */
export function initDatePickers(root = document) {
    root.querySelectorAll(
        "[data-ui-date-picker], [data-ui-date-picker-flatpickr]",
    ).forEach((picker) => {
        initDatePicker(picker);
    });
}

export default initDatePickers;
