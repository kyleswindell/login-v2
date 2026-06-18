import flatpickr from 'flatpickr';
import rangePlugin from 'flatpickr/dist/plugins/rangePlugin';
import 'flatpickr/dist/flatpickr.css';

const parseJsonList = (value) => {
    if (!value) {
        return [];
    }

    try {
        const parsed = JSON.parse(value);
        return Array.isArray(parsed) ? parsed : [parsed];
    } catch {
        return [value];
    }
};

const boolValue = (value, fallback = false) => {
    if (value === undefined || value === null || value === '') {
        return fallback;
    }

    return value === true || value === 'true' || value === '1';
};

const resolveAppendTarget = (selector) => {
    if (!selector) {
        return undefined;
    }

    return document.querySelector(selector) ?? undefined;
};

const setPickerState = (picker, instance, isOpen = false) => {
    picker.dataset.uiDatePickerOpen = isOpen ? 'true' : 'false';

    if (instance) {
        picker.dataset.uiDatePickerSelectedValue = JSON.stringify(instance.selectedDates.map((date) => date.toISOString()));
    }
};

const decorateCalendar = (picker, instance) => {
    if (!instance?.calendarContainer) {
        return;
    }

    instance.calendarContainer.classList.add('ui-date-picker-calendar');
    instance.calendarContainer.dataset.uiDatePickerCalendar = '';

    const prev = instance.calendarContainer.querySelector('.flatpickr-prev-month');
    const next = instance.calendarContainer.querySelector('.flatpickr-next-month');

    if (prev) {
        prev.setAttribute('aria-label', picker.dataset.uiDatePickerPrevMonthAriaLabel || 'Previous month');
    }

    if (next) {
        next.setAttribute('aria-label', picker.dataset.uiDatePickerNextMonthAriaLabel || 'Next month');
    }
};

const buildFlatpickrOptions = (picker, inputs) => {
    const type = picker.dataset.uiDatePickerType === 'range' ? 'range' : 'single';
    const defaultDate = parseJsonList(picker.dataset.uiDatePickerValue);
    const disabledDates = parseJsonList(picker.dataset.uiDatePickerDisable);
    const enabledDates = parseJsonList(picker.dataset.uiDatePickerEnable);
    const options = {
        mode: type,
        allowInput: boolValue(picker.dataset.uiDatePickerAllowInput, true),
        closeOnSelect: boolValue(picker.dataset.uiDatePickerCloseOnSelect, type !== 'range'),
        dateFormat: picker.dataset.uiDatePickerDateFormat || 'Y-m-d',
        ariaDateFormat: picker.dataset.uiDatePickerAriaDateFormat || 'F j, Y',
        inline: boolValue(picker.dataset.uiDatePickerInline, false),
        appendTo: resolveAppendTarget(picker.dataset.uiDatePickerAppendTo),
        onReady: [
            (_selectedDates, _dateStr, instance) => {
                decorateCalendar(picker, instance);
                setPickerState(picker, instance, false);
            },
        ],
        onOpen: [
            (_selectedDates, _dateStr, instance) => {
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
                setPickerState(picker, instance, instance.isOpen);
            },
        ],
        onValueUpdate: [
            (_selectedDates, _dateStr, instance) => {
                setPickerState(picker, instance, instance.isOpen);
            },
        ],
    };

    if (picker.dataset.uiDatePickerLocale) {
        options.locale = picker.dataset.uiDatePickerLocale;
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

    if (type === 'range' && inputs[1]) {
        options.plugins = [new rangePlugin({ input: inputs[1] })];
    }

    return options;
};

export function initDatePickers(root = document) {
    root.querySelectorAll('[data-ui-date-picker-flatpickr]').forEach((picker) => {
        const inputs = Array.from(picker.querySelectorAll('[data-ui-date-picker-input]'));
        const input = inputs[0];

        if (!input || input.disabled || input.readOnly) {
            return;
        }

        if (input._flatpickr) {
            input._flatpickr.destroy();
        }

        const instance = flatpickr(input, buildFlatpickrOptions(picker, inputs));
        picker.dataset.uiDatePickerInitialized = 'true';
        picker.uiDatePickerInstance = instance;
    });
}
