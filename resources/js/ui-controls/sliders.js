/* ==========================================================================
   Slider behavior
   ========================================================================== */

/**
 * Selector contract used by slider.blade.php.
 */
const SLIDER_SELECTOR = "[data-ui-slider]";
const SLIDER_CONTAINER_SELECTOR = "[data-ui-slider-container]";
const SLIDER_INPUT_SELECTOR = "[data-ui-slider-input]";
const SLIDER_THUMB_SELECTOR = "[data-ui-slider-thumb]";
const SLIDER_THUMB_WRAPPER_SELECTOR = "[data-ui-slider-thumb-wrapper]";
const SLIDER_FILLED_TRACK_SELECTOR = "[data-ui-slider-filled-track]";
const SLIDER_STATUS_MESSAGE_SELECTOR = "[data-ui-slider-status-message]";

/* ==========================================================================
   Numeric helpers
   ========================================================================== */

/**
 * Clamp a number between min and max.
 */
const clamp = (value, min, max) => {
    return Math.min(Math.max(value, min), max);
};

/**
 * Read a finite number from a value, with fallback.
 */
const readNumber = (value, fallback = 0) => {
    const number = Number(value);

    return Number.isFinite(number) ? number : fallback;
};

/**
 * Preserve decimal precision when stepping.
 */
const getDecimalPlaces = (value) => {
    const valueString = String(value);

    if (!valueString.includes(".")) {
        return 0;
    }

    return valueString.split(".")[1]?.length ?? 0;
};

/**
 * Snap a value to the slider step.
 */
const snapToStep = (value, min, step, max) => {
    const stepCount = Math.round((value - min) / step);
    const steppedValue = min + stepCount * step;
    const precision = Math.max(getDecimalPlaces(step), getDecimalPlaces(min));
    const roundedValue = Number(steppedValue.toFixed(precision));

    return clamp(roundedValue, min, max);
};

/**
 * Convert a slider value to a 0-100 percentage.
 */
const valueToPercent = (value, min, max) => {
    const range = max - min;

    if (range === 0) {
        return 0;
    }

    return clamp(((value - min) / range) * 100, 0, 100);
};

/**
 * Convert a pointer position to a snapped slider value.
 */
const pointerToValue = (slider, clientX, min, max, step, isRtl) => {
    const rect = slider.getBoundingClientRect();
    const width = rect.width || 1;

    const rawPercent = isRtl
        ? (rect.right - clientX) / width
        : (clientX - rect.left) / width;

    const clampedPercent = clamp(rawPercent, 0, 1);
    const rawValue = min + (max - min) * clampedPercent;

    return snapToStep(rawValue, min, step, max);
};

/**
 * Calculate the absolute distance from a pointer to a thumb.
 */
const distanceToThumb = (thumb, clientX) => {
    const rect = thumb.getBoundingClientRect();
    const thumbCenter = rect.left + rect.width / 2;

    return Math.abs(clientX - thumbCenter);
};

/* ==========================================================================
   Component lookup helpers
   ========================================================================== */

/**
 * Find the slider container for a slider track.
 */
const getSliderContainer = (slider) => {
    return slider.closest(SLIDER_CONTAINER_SELECTOR);
};

/**
 * Find all slider text inputs.
 */
const getSliderInputs = (container) => {
    return Array.from(container.querySelectorAll(SLIDER_INPUT_SELECTOR)).filter(
        (input) => input instanceof HTMLInputElement,
    );
};

/**
 * Find input by handle position.
 */
const getInputByHandle = (container, handlePosition) => {
    return getSliderInputs(container).find(
        (input) =>
            input.getAttribute("data-ui-slider-handle-position") ===
            handlePosition,
    );
};

/**
 * Find thumb by handle position.
 */
const getThumbByHandle = (container, handlePosition) => {
    return Array.from(container.querySelectorAll(SLIDER_THUMB_SELECTOR)).find(
        (thumb) =>
            thumb.getAttribute("data-ui-slider-handle-position") ===
            handlePosition,
    );
};

/**
 * Find thumb wrapper by handle position.
 */
const getThumbWrapperByHandle = (container, handlePosition) => {
    return Array.from(
        container.querySelectorAll(SLIDER_THUMB_WRAPPER_SELECTOR),
    ).find(
        (wrapper) =>
            wrapper.getAttribute("data-ui-slider-handle-position") ===
            handlePosition,
    );
};

/**
 * Determine whether this slider has two handles.
 */
const hasTwoHandles = (container) => {
    return container.getAttribute("data-ui-slider-two-handles") === "true";
};

/**
 * Determine whether interaction is locked.
 */
const isLocked = (container) => {
    return (
        container.getAttribute("data-ui-slider-disabled") === "true" ||
        container.getAttribute("data-ui-slider-readonly") === "true"
    );
};

/**
 * Read the static slider configuration.
 */
const getSliderConfig = (container) => {
    const min = readNumber(container.getAttribute("data-ui-slider-min"), 0);
    const max = readNumber(container.getAttribute("data-ui-slider-max"), 100);
    const step = readNumber(container.getAttribute("data-ui-slider-step"), 1);
    const stepMultiplier = readNumber(
        container.getAttribute("data-ui-slider-step-multiplier"),
        4,
    );

    return {
        min,
        max,
        step,
        stepMultiplier,
        twoHandles: hasTwoHandles(container),
        isRtl:
            container.classList.contains("ui-slider-container--rtl") ||
            document.dir === "rtl",
    };
};

/**
 * Resolve the nearest handle to a pointer.
 */
const getNearestHandle = (container, clientX) => {
    const lowerThumb = getThumbByHandle(container, "lower");
    const upperThumb = getThumbByHandle(container, "upper");

    if (!upperThumb || !lowerThumb) {
        return "lower";
    }

    return distanceToThumb(lowerThumb, clientX) <=
        distanceToThumb(upperThumb, clientX)
        ? "lower"
        : "upper";
};

/* ==========================================================================
   Value state
   ========================================================================== */

/**
 * Get the current numeric value for a handle.
 */
const getHandleValue = (container, handlePosition) => {
    const input = getInputByHandle(container, handlePosition);

    if (!input) {
        return Number.NaN;
    }

    return Number(input.value);
};

/**
 * Get both lower and upper values.
 */
const getSliderValues = (container, config) => {
    const lowerValue = getHandleValue(container, "lower");

    if (!config.twoHandles) {
        return {
            lower: Number.isFinite(lowerValue) ? lowerValue : config.min,
            upper: undefined,
        };
    }

    const upperValue = getHandleValue(container, "upper");

    return {
        lower: Number.isFinite(lowerValue) ? lowerValue : config.min,
        upper: Number.isFinite(upperValue) ? upperValue : config.max,
    };
};

/**
 * Constrain a new handle value against min/max and the opposite handle.
 */
const constrainHandleValue = (container, handlePosition, value, config) => {
    const values = getSliderValues(container, config);

    let nextValue = clamp(value, config.min, config.max);

    if (
        config.twoHandles &&
        handlePosition === "lower" &&
        Number.isFinite(values.upper)
    ) {
        nextValue = Math.min(nextValue, values.upper);
    }

    if (
        config.twoHandles &&
        handlePosition === "upper" &&
        Number.isFinite(values.lower)
    ) {
        nextValue = Math.max(nextValue, values.lower);
    }

    return nextValue;
};

/**
 * Dispatch input/change events from a synchronized input.
 */
const dispatchSliderInputEvents = (input) => {
    input.dispatchEvent(new Event("input", { bubbles: true }));
    input.dispatchEvent(new Event("change", { bubbles: true }));
};

/**
 * Update legacy value output, if present.
 */
const updateLegacySliderValue = (container) => {
    const formItem =
        container.closest('[data-ui-component="slider"]') ||
        container.parentElement;
    const valueOutput = formItem?.querySelector("[data-ui-slider-value]");
    const inputs = getSliderInputs(container);

    if (!valueOutput || inputs.length === 0) {
        return;
    }

    if (hasTwoHandles(container) && inputs.length > 1) {
        valueOutput.textContent = `${inputs[0].value} - ${inputs[1].value}`;
        return;
    }

    valueOutput.textContent = inputs[0].value;
};

/* ==========================================================================
   DOM sync
   ========================================================================== */

/**
 * Update a thumb position and ARIA state.
 */
const syncThumb = (container, handlePosition, value, config) => {
    const thumb = getThumbByHandle(container, handlePosition);
    const wrapper = getThumbWrapperByHandle(container, handlePosition);

    if (!thumb || !wrapper) {
        return;
    }

    const percent = valueToPercent(value, config.min, config.max);
    const values = getSliderValues(container, config);

    wrapper.style.insetInlineStart = `${percent}%`;

    thumb.setAttribute("aria-valuenow", String(value));
    thumb.setAttribute("aria-valuetext", String(value));

    if (
        config.twoHandles &&
        handlePosition === "lower" &&
        Number.isFinite(values.upper)
    ) {
        thumb.setAttribute("aria-valuemax", String(values.upper));
    } else {
        thumb.setAttribute("aria-valuemax", String(config.max));
    }

    if (
        config.twoHandles &&
        handlePosition === "upper" &&
        Number.isFinite(values.lower)
    ) {
        thumb.setAttribute("aria-valuemin", String(values.lower));
    } else {
        thumb.setAttribute("aria-valuemin", String(config.min));
    }
};

/**
 * Update filled track transform.
 */
const syncFilledTrack = (container, config) => {
    const track = container.querySelector(SLIDER_FILLED_TRACK_SELECTOR);

    if (!(track instanceof HTMLElement)) {
        return;
    }

    const values = getSliderValues(container, config);

    const lowerPercent = valueToPercent(values.lower, config.min, config.max);
    const upperPercent =
        config.twoHandles && Number.isFinite(values.upper)
            ? valueToPercent(values.upper, config.min, config.max)
            : lowerPercent;

    if (config.twoHandles) {
        const translate = config.isRtl ? 100 - upperPercent : lowerPercent;
        const scale = Math.max(0, (upperPercent - lowerPercent) / 100);

        track.style.transform = `translate(${translate}%, -50%) scaleX(${scale})`;
        return;
    }

    if (config.isRtl) {
        track.style.transform = `translate(100%, -50%) scaleX(-${lowerPercent / 100})`;
        return;
    }

    track.style.transform = `translate(0%, -50%) scaleX(${lowerPercent / 100})`;
};

/**
 * Update input, thumb, track, and optional legacy value.
 */
const syncSliderDom = (container) => {
    const config = getSliderConfig(container);
    const values = getSliderValues(container, config);

    syncThumb(container, "lower", values.lower, config);

    if (config.twoHandles && Number.isFinite(values.upper)) {
        syncThumb(container, "upper", values.upper, config);
    }

    syncFilledTrack(container, config);
    updateLegacySliderValue(container);
};

/**
 * Set a handle value across input and visual DOM.
 */
const setHandleValue = (
    container,
    handlePosition,
    value,
    { dispatchEvents = true, correctInput = true } = {},
) => {
    const config = getSliderConfig(container);
    const input = getInputByHandle(container, handlePosition);

    if (!input) {
        return;
    }

    const nextValue = constrainHandleValue(
        container,
        handlePosition,
        value,
        config,
    );

    if (correctInput) {
        input.value = String(nextValue);
    }

    syncThumb(container, handlePosition, nextValue, config);
    syncFilledTrack(container, config);
    updateLegacySliderValue(container);

    if (dispatchEvents) {
        dispatchSliderInputEvents(input);
    }
};

/**
 * Set status correction message.
 */
const setStatusMessage = (container, message) => {
    const formItem =
        container.closest('[data-ui-component="slider"]') ||
        container.parentElement;
    const status = formItem?.querySelector(SLIDER_STATUS_MESSAGE_SELECTOR);

    if (!status) {
        return;
    }

    if (!message) {
        status.textContent = "";
        status.hidden = true;
        return;
    }

    status.textContent = message;
    status.hidden = false;
};

/* ==========================================================================
   Interaction handlers
   ========================================================================== */

/**
 * Handle direct text input changes.
 */
const handleSliderInput = (event) => {
    const input = event.currentTarget;

    if (!(input instanceof HTMLInputElement)) {
        return;
    }

    const container = input.closest(SLIDER_CONTAINER_SELECTOR);

    if (!container || isLocked(container)) {
        return;
    }

    const handlePosition =
        input.getAttribute("data-ui-slider-handle-position") || "lower";
    const parsedValue = Number(input.value);

    if (!Number.isFinite(parsedValue)) {
        return;
    }

    setHandleValue(container, handlePosition, parsedValue, {
        dispatchEvents: false,
        correctInput: false,
    });
};

/**
 * Correct text input values on blur or Enter.
 */
const correctSliderInputValue = (input) => {
    const container = input.closest(SLIDER_CONTAINER_SELECTOR);

    if (!container || isLocked(container)) {
        return;
    }

    const handlePosition =
        input.getAttribute("data-ui-slider-handle-position") || "lower";
    const config = getSliderConfig(container);
    const parsedValue = Number(input.value);

    if (!Number.isFinite(parsedValue)) {
        setStatusMessage(container, null);
        return;
    }

    const snappedValue = snapToStep(
        parsedValue,
        config.min,
        config.step,
        config.max,
    );
    const correctedValue = constrainHandleValue(
        container,
        handlePosition,
        snappedValue,
        config,
    );

    if (correctedValue !== parsedValue) {
        setStatusMessage(
            container,
            `The inputted value "${parsedValue}" was corrected to the nearest allowed digit.`,
        );
    } else {
        setStatusMessage(container, null);
    }

    setHandleValue(container, handlePosition, correctedValue, {
        dispatchEvents: true,
        correctInput: true,
    });
};

/**
 * Handle input blur correction.
 */
const handleSliderInputBlur = (event) => {
    const input = event.currentTarget;

    if (input instanceof HTMLInputElement) {
        correctSliderInputValue(input);
    }
};

/**
 * Handle input keydown correction.
 */
const handleSliderInputKeyDown = (event) => {
    const input = event.currentTarget;

    if (!(input instanceof HTMLInputElement)) {
        return;
    }

    if (event.key === "Enter") {
        correctSliderInputValue(input);
    }
};

/**
 * Step a focused thumb with keyboard controls.
 */
const handleSliderThumbKeyDown = (event) => {
    const thumb = event.currentTarget;

    if (!(thumb instanceof HTMLElement)) {
        return;
    }

    const container = thumb.closest(SLIDER_CONTAINER_SELECTOR);

    if (!container || isLocked(container)) {
        return;
    }

    const config = getSliderConfig(container);
    const handlePosition =
        thumb.getAttribute("data-ui-slider-handle-position") || "lower";
    const input = getInputByHandle(container, handlePosition);

    if (!input) {
        return;
    }

    let delta = 0;

    if (event.key === "ArrowDown" || event.key === "ArrowLeft") {
        delta = -config.step;
    }

    if (event.key === "ArrowUp" || event.key === "ArrowRight") {
        delta = config.step;
    }

    if (delta === 0) {
        return;
    }

    if (event.shiftKey) {
        delta *= config.stepMultiplier;
    }

    event.preventDefault();

    const currentValue = Number(input.value);
    const nextValue = snapToStep(
        (Number.isFinite(currentValue) ? currentValue : config.min) + delta,
        config.min,
        config.step,
        config.max,
    );

    setHandleValue(container, handlePosition, nextValue);
};

/**
 * Choose active handle and update value on pointer interaction.
 */
const updateSliderFromPointer = (slider, clientX, handlePosition = null) => {
    const container = getSliderContainer(slider);

    if (!container || isLocked(container)) {
        return;
    }

    const config = getSliderConfig(container);
    const activeHandle = handlePosition || getNearestHandle(container, clientX);
    const nextValue = pointerToValue(
        slider,
        clientX,
        config.min,
        config.max,
        config.step,
        config.isRtl,
    );

    setHandleValue(container, activeHandle, nextValue);

    const thumb = getThumbByHandle(container, activeHandle);

    if (thumb instanceof HTMLElement) {
        thumb.focus({ preventScroll: true });
    }
};

/**
 * Start drag interaction.
 */
const handleSliderPointerDown = (event) => {
    const slider = event.currentTarget;

    if (!(slider instanceof HTMLElement)) {
        return;
    }

    const container = getSliderContainer(slider);

    if (!container || isLocked(container)) {
        return;
    }

    const targetThumb = event.target.closest?.(SLIDER_THUMB_SELECTOR);
    const requestedHandle =
        targetThumb?.getAttribute?.("data-ui-slider-handle-position") || null;

    event.preventDefault();

    slider.dataset.uiSliderDragging = "true";
    slider.dataset.uiSliderActiveHandle =
        requestedHandle || getNearestHandle(container, event.clientX);

    updateSliderFromPointer(
        slider,
        event.clientX,
        slider.dataset.uiSliderActiveHandle,
    );

    slider.setPointerCapture?.(event.pointerId);
};

/**
 * Continue drag interaction.
 */
const handleSliderPointerMove = (event) => {
    const slider = event.currentTarget;

    if (!(slider instanceof HTMLElement)) {
        return;
    }

    if (slider.dataset.uiSliderDragging !== "true") {
        return;
    }

    updateSliderFromPointer(
        slider,
        event.clientX,
        slider.dataset.uiSliderActiveHandle || null,
    );
};

/**
 * Stop drag interaction.
 */
const handleSliderPointerUp = (event) => {
    const slider = event.currentTarget;

    if (!(slider instanceof HTMLElement)) {
        return;
    }

    slider.dataset.uiSliderDragging = "false";
    delete slider.dataset.uiSliderActiveHandle;

    slider.releasePointerCapture?.(event.pointerId);
};

/* ==========================================================================
   Initialization
   ========================================================================== */

/**
 * Initialize one slider input.
 */
const initSliderInput = (input) => {
    if (
        !(input instanceof HTMLInputElement) ||
        input.dataset.uiSliderInputInit === "true"
    ) {
        return;
    }

    input.dataset.uiSliderInputInit = "true";
    input.addEventListener("input", handleSliderInput);
    input.addEventListener("blur", handleSliderInputBlur);
    input.addEventListener("keydown", handleSliderInputKeyDown);
};

/**
 * Initialize one slider thumb.
 */
const initSliderThumb = (thumb) => {
    if (
        !(thumb instanceof HTMLElement) ||
        thumb.dataset.uiSliderThumbInit === "true"
    ) {
        return;
    }

    thumb.dataset.uiSliderThumbInit = "true";
    thumb.addEventListener("keydown", handleSliderThumbKeyDown);
};

/**
 * Initialize one slider track.
 */
const initSliderTrack = (slider) => {
    if (
        !(slider instanceof HTMLElement) ||
        slider.dataset.uiSliderInitialized === "true"
    ) {
        return;
    }

    slider.dataset.uiSliderInitialized = "true";

    slider.addEventListener("pointerdown", handleSliderPointerDown);
    slider.addEventListener("pointermove", handleSliderPointerMove);
    slider.addEventListener("pointerup", handleSliderPointerUp);
    slider.addEventListener("pointercancel", handleSliderPointerUp);

    const container = getSliderContainer(slider);

    if (container) {
        syncSliderDom(container);
    }
};

/**
 * Initialize Slider behavior.
 */
export function initSliders(root = document) {
    root.querySelectorAll(SLIDER_SELECTOR).forEach((slider) => {
        initSliderTrack(slider);
    });

    root.querySelectorAll(SLIDER_INPUT_SELECTOR).forEach((input) => {
        initSliderInput(input);
    });

    root.querySelectorAll(SLIDER_THUMB_SELECTOR).forEach((thumb) => {
        initSliderThumb(thumb);
    });
}

export default initSliders;
