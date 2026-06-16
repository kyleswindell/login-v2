const daySelector = '[data-ui-date-range-day]';
const inputSelector = '[data-ui-date-range-input]';

const parseDate = (value) => {
    if (!value) {
        return null;
    }

    const parsed = new Date(`${value}T00:00:00`);

    return Number.isNaN(parsed.getTime()) ? null : parsed;
};

const formatDate = (date) => {
    if (!(date instanceof Date) || Number.isNaN(date.getTime())) {
        return '';
    }

    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');

    return `${year}-${month}-${day}`;
};

const compareDates = (left, right) => {
    const leftDate = parseDate(left);
    const rightDate = parseDate(right);

    if (!leftDate || !rightDate) {
        return 0;
    }

    return leftDate.getTime() - rightDate.getTime();
};

const dateBetween = (date, start, end) => compareDates(date, start) >= 0 && compareDates(date, end) <= 0;

const state = (picker) => ({
    start: picker.dataset.uiDateRangeStart || '',
    end: picker.dataset.uiDateRangeEnd || '',
    hover: picker.dataset.uiDateRangeHover || '',
    active: picker.dataset.uiDateRangeActive || 'start',
});

const setState = (picker, nextState) => {
    Object.entries(nextState).forEach(([key, value]) => {
        const dataKey = `uiDateRange${key.charAt(0).toUpperCase()}${key.slice(1)}`;

        if (value) {
            picker.dataset[dataKey] = value;
        } else {
            delete picker.dataset[dataKey];
        }
    });
};

const updateInputs = (picker, nextState) => {
    picker.querySelectorAll(inputSelector).forEach((input) => {
        const role = input.dataset.uiDateRangeInput;
        input.value = nextState[role] || '';
        input.dataset.uiDateRangeInputActive = nextState.active === role ? 'true' : 'false';
    });
};

const updateStatus = (picker, nextState) => {
    const status = picker.querySelector('[data-ui-date-range-status]');

    if (!status) {
        return;
    }

    if (nextState.start && nextState.end) {
        status.textContent = `Selected range: ${nextState.start} to ${nextState.end}.`;
    } else if (nextState.start && nextState.hover) {
        status.textContent = `Preview range: ${nextState.start} to ${nextState.hover}.`;
    } else if (nextState.start) {
        status.textContent = 'Choose an end date.';
    } else {
        status.textContent = 'Choose a start date.';
    }
};

const updateCalendar = (picker, nextState) => {
    const previewEnd = nextState.end || nextState.hover;
    const hasPreviewRange = nextState.start && previewEnd && compareDates(nextState.start, previewEnd) <= 0;

    picker.querySelectorAll(daySelector).forEach((button) => {
        const date = button.dataset.date;
        const isStart = date === nextState.start;
        const isEnd = date === nextState.end;
        const isHoverEnd = !nextState.end && date === nextState.hover;
        const inRange = hasPreviewRange && dateBetween(date, nextState.start, previewEnd);

        button.dataset.uiDateRangeInRange = inRange ? 'true' : 'false';
        button.dataset.uiDateRangeStart = isStart ? 'true' : 'false';
        button.dataset.uiDateRangeEnd = isEnd ? 'true' : 'false';
        button.dataset.uiDateRangePreviewEnd = isHoverEnd ? 'true' : 'false';
        button.setAttribute('aria-selected', isStart || isEnd ? 'true' : 'false');
    });
};

const render = (picker) => {
    const nextState = state(picker);

    updateInputs(picker, nextState);
    updateStatus(picker, nextState);
    updateCalendar(picker, nextState);
};

const applyInputValue = (picker, input) => {
    const nextState = state(picker);
    const role = input.dataset.uiDateRangeInput;
    const value = formatDate(parseDate(input.value));

    if (!value) {
        setState(picker, { [role]: '', active: role, hover: '' });
        render(picker);
        return;
    }

    if (role === 'start' && nextState.end && compareDates(value, nextState.end) > 0) {
        setState(picker, { start: value, end: '', active: 'end', hover: '' });
    } else if (role === 'end' && nextState.start && compareDates(value, nextState.start) < 0) {
        setState(picker, { start: value, end: nextState.start, active: 'end', hover: '' });
    } else {
        setState(picker, { [role]: value, active: role === 'start' ? 'end' : 'start', hover: '' });
    }

    render(picker);
};

const chooseDate = (picker, date) => {
    const nextState = state(picker);

    if (nextState.active === 'end' && nextState.start) {
        if (compareDates(date, nextState.start) < 0) {
            setState(picker, { start: date, end: nextState.start, active: 'start', hover: '' });
        } else {
            setState(picker, { end: date, active: 'start', hover: '' });
        }
    } else {
        setState(picker, { start: date, end: '', active: 'end', hover: '' });
    }

    render(picker);
};

export function initDateRangePickers(root = document) {
    root.querySelectorAll('[data-ui-date-range-picker]').forEach((picker) => {
        if (picker.dataset.uiDateRangePickerInitialized === 'true') {
            render(picker);
            return;
        }

        picker.dataset.uiDateRangePickerInitialized = 'true';

        picker.querySelectorAll(inputSelector).forEach((input) => {
            input.addEventListener('focus', () => {
                setState(picker, { active: input.dataset.uiDateRangeInput, hover: '' });
                render(picker);
            });

            input.addEventListener('change', () => applyInputValue(picker, input));
        });

        picker.querySelectorAll(daySelector).forEach((button) => {
            button.addEventListener('click', () => chooseDate(picker, button.dataset.date));
            button.addEventListener('pointerenter', () => {
                const nextState = state(picker);

                if (nextState.start && nextState.active === 'end' && compareDates(button.dataset.date, nextState.start) >= 0) {
                    setState(picker, { hover: button.dataset.date });
                    render(picker);
                }
            });
        });

        picker.addEventListener('pointerleave', (event) => {
            if (!event.relatedTarget || !picker.contains(event.relatedTarget)) {
                setState(picker, { hover: '' });
                render(picker);
            }
        });

        render(picker);
    });
}
