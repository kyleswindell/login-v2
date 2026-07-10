/* ==========================================================================
   Number input behavior
   ========================================================================== */

/**
 * Selector contract used by number-input.blade.php.
 */
const NUMBER_INPUT_WRAPPER_SELECTOR = "[data-ui-number-input-wrapper]";
const NUMBER_INPUT_CONTROL_SELECTOR = "[data-ui-number-input-control]";
const NUMBER_INPUT_STEPPER_SELECTOR = "[data-ui-number-input-stepper]";

/* ==========================================================================
   Numeric parsing helpers
   ========================================================================== */

/**
 * Normalize common Unicode minus characters to a standard hyphen-minus.
 */
const normalizeMinus = (value) => {
    return String(value).replace(
        /[\u2212\u2012\u2013\u2014\uFE63\uFF0D]/g,
        "-",
    );
};

/**
 * Return locale decimal/group separators for basic localized text input support.
 */
const getLocaleSeparators = (locale = "en-US") => {
    const parts = new Intl.NumberFormat(locale).formatToParts(1234567.89);

    return {
        group: parts.find((part) => part.type === "group")?.value ?? ",",
        decimal: parts.find((part) => part.type === "decimal")?.value ?? ".",
    };
};

/**
 * Parse a number from either a native number input or a localized text input.
 */
const parseNumberValue = (value, locale = "en-US") => {
    if (value === null || typeof value === "undefined" || value === "") {
        return Number.NaN;
    }

    const { group, decimal } = getLocaleSeparators(locale);

    let normalized = normalizeMinus(value)
        .replace(/[\u061C\u200E\u200F\u202A-\u202E\u2066-\u2069]/g, "")
        .trim();

    const isAccountingNegative =
        normalized.startsWith("(") && normalized.endsWith(")");

    if (group) {
        const escapedGroup = group.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
        normalized = normalized.replace(new RegExp(escapedGroup, "g"), "");
    }

    if (decimal && decimal !== ".") {
        const escapedDecimal = decimal.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
        normalized = normalized.replace(new RegExp(escapedDecimal, "g"), ".");
    }

    /*
     * Strip formatting tokens introduced by Intl.NumberFormat options such as
     * currency symbols, unit labels, percent signs, and spacing/literals.
     */
    normalized = normalized.replace(/[^0-9+\-.eE]/g, "");

    if (isAccountingNegative && normalized && !normalized.startsWith("-")) {
        normalized = `-${normalized}`;
    }

    return Number(normalized);
};

/**
 * Safely format a numeric value for text-mode number inputs.
 */
const formatNumberValue = (value, locale = "en-US", formatOptions = {}) => {
    if (!Number.isFinite(value)) {
        return "";
    }

    try {
        return new Intl.NumberFormat(locale, formatOptions).format(value);
    } catch {
        return new Intl.NumberFormat(locale).format(value);
    }
};

/**
 * Clamp a numeric value between optional min and max bounds.
 */
const clampNumber = (value, min, max) => {
    if (Number.isFinite(min) && value < min) {
        return min;
    }

    if (Number.isFinite(max) && value > max) {
        return max;
    }

    return value;
};

/**
 * Preserve decimal precision when adding/subtracting decimal step values.
 */
const getDecimalPlaces = (value) => {
    const valueString = String(value);

    if (!valueString.includes(".")) {
        return 0;
    }

    return valueString.split(".")[1]?.length ?? 0;
};

/* ==========================================================================
   Component lookup and config
   ========================================================================== */

/**
 * Find the number input wrapper for a given descendant element.
 */
const getNumberInputWrapper = (element) => {
    return element.closest(NUMBER_INPUT_WRAPPER_SELECTOR);
};

/**
 * Find the input controlled by a stepper button or wrapper.
 */
const getNumberInputControl = (element) => {
    const wrapper = getNumberInputWrapper(element);

    if (!wrapper) {
        return null;
    }

    const input = wrapper.querySelector(NUMBER_INPUT_CONTROL_SELECTOR);

    return input instanceof HTMLInputElement ? input : null;
};

/**
 * Read a finite number from an attribute/dataset value.
 */
const readFiniteNumber = (value, fallback = Number.NaN) => {
    if (value === null || typeof value === "undefined" || value === "") {
        return fallback;
    }

    const number = Number(value);

    return Number.isFinite(number) ? number : fallback;
};

/**
 * Read Intl.NumberFormat options from wrapper or input data attributes.
 */
const getFormatOptions = (input, wrapper) => {
    const rawFormatOptions =
        wrapper?.getAttribute("data-ui-number-input-format-options") ||
        input.getAttribute("data-ui-number-input-format-options");

    if (!rawFormatOptions) {
        return {};
    }

    try {
        const parsed = JSON.parse(rawFormatOptions);

        return parsed && typeof parsed === "object" && !Array.isArray(parsed)
            ? parsed
            : {};
    } catch {
        return {};
    }
};

/**
 * Read behavior configuration from the wrapper and input.
 */
const getNumberInputConfig = (input) => {
    const wrapper = getNumberInputWrapper(input);

    return {
        wrapper,
        type:
            input.getAttribute("data-ui-number-input-type") ||
            input.type ||
            "number",
        min: readFiniteNumber(
            input.getAttribute("data-ui-number-input-min") ??
                input.getAttribute("min"),
        ),
        max: readFiniteNumber(
            input.getAttribute("data-ui-number-input-max") ??
                input.getAttribute("max"),
        ),
        step: readFiniteNumber(
            input.getAttribute("data-ui-number-input-step") ??
                input.getAttribute("step"),
            1,
        ),
        stepStartValue: readFiniteNumber(
            input.getAttribute("data-ui-number-input-step-start-value"),
            0,
        ),
        allowEmpty:
            wrapper?.getAttribute("data-ui-number-input-allow-empty") ===
            "true",
        disableWheel:
            wrapper?.getAttribute("data-ui-number-input-disable-wheel") ===
            "true",
        locale: wrapper?.getAttribute("data-ui-number-input-locale") || "en-US",
        formatOptions: getFormatOptions(input, wrapper),
    };
};

/**
 * Determine whether user-driven value changes should be blocked.
 */
const isNumberInputLocked = (input) => {
    return (
        input.disabled ||
        input.readOnly ||
        input.getAttribute("aria-readonly") === "true"
    );
};

/* ==========================================================================
   Value updates
   ========================================================================== */

/**
 * Dispatch native events so app-level listeners can respond to programmatic
 * stepper changes the same way they respond to typed input.
 */
const dispatchNumberInputEvents = (input) => {
    input.dispatchEvent(new Event("input", { bubbles: true }));
    input.dispatchEvent(new Event("change", { bubbles: true }));
};

/**
 * Choose the starting value when the current input value is empty or invalid.
 */
const getFallbackStepValue = (config, direction) => {
    if (Number.isFinite(config.stepStartValue) && config.stepStartValue !== 0) {
        return config.stepStartValue;
    }

    if (Number.isFinite(config.min) && config.min > 0) {
        return config.min;
    }

    if (direction === "up") {
        return config.step;
    }

    return -config.step;
};

/**
 * Set the visible input value after stepping.
 */
const setInputNumericValue = (input, value, config) => {
    if (config.type === "text") {
        input.value = formatNumberValue(
            value,
            config.locale,
            config.formatOptions,
        );
        return;
    }

    input.value = String(value);
};

/**
 * Step the number input up or down.
 */
const stepNumberInput = (input, direction) => {
    if (!(input instanceof HTMLInputElement) || isNumberInputLocked(input)) {
        return;
    }

    const config = getNumberInputConfig(input);
    const currentValue = parseNumberValue(input.value, config.locale);

    let nextValue;

    if (!Number.isFinite(currentValue)) {
        nextValue = getFallbackStepValue(config, direction);
    } else {
        const rawValue =
            direction === "up"
                ? currentValue + config.step
                : currentValue - config.step;

        const precision = Math.max(
            getDecimalPlaces(currentValue),
            getDecimalPlaces(config.step),
        );

        nextValue = Number(rawValue.toFixed(precision));
    }

    nextValue = clampNumber(nextValue, config.min, config.max);

    setInputNumericValue(input, nextValue, config);
    dispatchNumberInputEvents(input);
};

/* ==========================================================================
   Client-side validity sync
   ========================================================================== */

/**
 * Sync basic min/max/required validity without overriding server-rendered
 * validation text.
 */
const syncNumberInputClientValidity = (input) => {
    const config = getNumberInputConfig(input);
    const wrapper = config.wrapper;

    if (!wrapper) {
        return;
    }

    const value = input.value;
    const numericValue = parseNumberValue(value, config.locale);

    const isEmpty = value === "";
    const isInvalidEmpty = input.required && isEmpty && !config.allowEmpty;
    const isInvalidNumber = !isEmpty && !Number.isFinite(numericValue);
    const isBelowMin =
        Number.isFinite(config.min) &&
        Number.isFinite(numericValue) &&
        numericValue < config.min;
    const isAboveMax =
        Number.isFinite(config.max) &&
        Number.isFinite(numericValue) &&
        numericValue > config.max;

    const isClientInvalid =
        isInvalidEmpty || isInvalidNumber || isBelowMin || isAboveMax;

    input.toggleAttribute(
        "data-ui-number-input-client-invalid",
        isClientInvalid,
    );

    if (isClientInvalid) {
        input.setAttribute("aria-invalid", "true");
        wrapper.setAttribute("data-ui-number-input-client-invalid", "true");
        return;
    }

    input.removeAttribute("data-ui-number-input-client-invalid");
    wrapper.removeAttribute("data-ui-number-input-client-invalid");

    if (!input.hasAttribute("data-invalid")) {
        input.removeAttribute("aria-invalid");
    }
};

/* ==========================================================================
   Event handlers
   ========================================================================== */

/**
 * Handle stepper button clicks.
 */
const handleNumberInputStepperClick = (event) => {
    const button = event.currentTarget;

    if (!(button instanceof HTMLButtonElement) || button.disabled) {
        return;
    }

    const direction = button.getAttribute("data-ui-number-input-direction");

    if (direction !== "up" && direction !== "down") {
        return;
    }

    const input = getNumberInputControl(button);

    if (!input) {
        return;
    }

    event.preventDefault();

    stepNumberInput(input, direction);
    syncNumberInputClientValidity(input);
    input.focus();
};

/**
 * Handle keyboard stepping for text-mode number inputs.
 */
const handleNumberInputKeyDown = (event) => {
    const input = event.currentTarget;

    if (!(input instanceof HTMLInputElement) || isNumberInputLocked(input)) {
        return;
    }

    const config = getNumberInputConfig(input);

    if (config.type !== "text") {
        return;
    }

    if (event.key === "ArrowUp") {
        event.preventDefault();
        stepNumberInput(input, "up");
        syncNumberInputClientValidity(input);
    }

    if (event.key === "ArrowDown") {
        event.preventDefault();
        stepNumberInput(input, "down");
        syncNumberInputClientValidity(input);
    }
};

/**
 * Prevent focused wheel changes when disableWheel is enabled.
 */
const handleNumberInputWheel = (event) => {
    const input = event.currentTarget;

    if (!(input instanceof HTMLInputElement)) {
        return;
    }

    const config = getNumberInputConfig(input);

    if (!config.disableWheel) {
        return;
    }

    event.preventDefault();
};

/**
 * Sync validity while the user types.
 */
const handleNumberInputInput = (event) => {
    const input = event.currentTarget;

    if (!(input instanceof HTMLInputElement)) {
        return;
    }

    syncNumberInputClientValidity(input);
};

/**
 * Format text-mode values on blur and sync validity.
 */
const handleNumberInputBlur = (event) => {
    const input = event.currentTarget;

    if (!(input instanceof HTMLInputElement)) {
        return;
    }

    const config = getNumberInputConfig(input);

    if (config.type === "text" && input.value !== "") {
        const parsedValue = parseNumberValue(input.value, config.locale);

        if (Number.isFinite(parsedValue)) {
            const clampedValue = clampNumber(
                parsedValue,
                config.min,
                config.max,
            );
            setInputNumericValue(input, clampedValue, config);
            dispatchNumberInputEvents(input);
        }
    }

    syncNumberInputClientValidity(input);
};

/* ==========================================================================
   Initialization
   ========================================================================== */

/**
 * Initialize one number input control.
 */
const initNumberInputControl = (input) => {
    if (
        !(input instanceof HTMLInputElement) ||
        input.dataset.uiNumberInputInit === "1"
    ) {
        return;
    }

    input.dataset.uiNumberInputInit = "1";

    input.addEventListener("keydown", handleNumberInputKeyDown);
    input.addEventListener("input", handleNumberInputInput);
    input.addEventListener("blur", handleNumberInputBlur);

    /*
     * Wheel listener must be non-passive so preventDefault can stop accidental
     * native number input changes while the field is focused.
     */
    input.addEventListener("wheel", handleNumberInputWheel, { passive: false });

    syncNumberInputClientValidity(input);
};

/**
 * Initialize stepper buttons.
 */
const initNumberInputStepper = (button) => {
    if (
        !(button instanceof HTMLButtonElement) ||
        button.dataset.uiNumberInputStepperInit === "1"
    ) {
        return;
    }

    button.dataset.uiNumberInputStepperInit = "1";
    button.addEventListener("click", handleNumberInputStepperClick);
};

/**
 * Initialize Number Input behavior.
 */
export const initNumberInputs = (root = document) => {
    root.querySelectorAll(NUMBER_INPUT_CONTROL_SELECTOR).forEach((input) => {
        initNumberInputControl(input);
    });

    root.querySelectorAll(NUMBER_INPUT_STEPPER_SELECTOR).forEach((button) => {
        initNumberInputStepper(button);
    });
};

export default initNumberInputs;
