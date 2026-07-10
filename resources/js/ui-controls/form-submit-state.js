/**
 * File: resources/js/ui-controls/form-submit-state.js
 * Purpose: Native form submit-state initializer.
 *
 * Notes:
 * - Converts forms marked with data-ui-form-submit-state into immediate local
 *   loading feedback on native submit.
 * - Preserves Button Set and Modal Footer geometry by replacing the active
 *   submit button slot with Inline Loading-compatible DOM instead of replacing
 *   the whole action row.
 * - Treats both Form Actions regions and Modal Footers as action roots.
 * - Disables related actions during loading by default.
 * - Does not submit forms, perform AJAX, intercept successful responses, or own
 *   validation recovery.
 */

const FORM_SELECTOR =
    'form[data-ui-form-submit-state]:not([data-ui-form-submit-state="false"])';

const FORM_ACTIONS_SELECTOR = [
    "[data-ui-form-actions]",
    "[data-ui-modal-footer]",
    "[data-ui-dialog-footer]",
].join(",");

const ACTION_SELECTOR = [
    "[data-ui-form-action]",
    "[data-ui-dialog-primary]",
    "[data-ui-dialog-secondary]",
    "[data-ui-modal-primary]",
    "[data-ui-modal-secondary]",
    "[data-ui-notification-modal-confirm]",
    "[data-ui-notification-modal-cancel]",
    "[data-ui-notification-modal-close]",
    "button",
    'input[type="submit"]',
    'input[type="button"]',
    'input[type="reset"]',
    "a[href]",
    '[role="button"]',
].join(",");

const SUBMITTER_SELECTOR = [
    'button[type="submit"]',
    'input[type="submit"]',
    "[data-ui-dialog-primary]",
    "[data-ui-modal-primary]",
    "[data-ui-notification-modal-confirm]",
    '[data-ui-form-action-role="submit"]',
    '[data-ui-form-action-role="save"]',
    '[data-ui-form-action-role="create"]',
    '[data-ui-form-action-role="update"]',
    '[data-ui-form-action-role="continue"]',
    '[data-ui-form-action-role="send"]',
].join(",");

const STATE_ALIASES = {
    active: "loading",
    busy: "loading",
    finished: "success",
    complete: "success",
    completed: "success",
    failed: "error",
    failure: "error",
};

const INLINE_LOADING_STATUS = {
    idle: "inactive",
    loading: "active",
    success: "finished",
    error: "error",
};

const DEFAULT_STATUS_TEXT = {
    loading: "Processing...",
    success: "Success!",
    error: "Action failed.",
};

const actionRootState = new WeakMap();
const lastSubmitterByForm = new WeakMap();

const normalizeState = (state) => {
    if (typeof state !== "string") {
        return "idle";
    }

    const requestedState = STATE_ALIASES[state] || state;

    return ["idle", "loading", "success", "error"].includes(requestedState)
        ? requestedState
        : "idle";
};

const cssEscape = (value) => {
    const text = String(value ?? "");

    if (window.CSS && typeof window.CSS.escape === "function") {
        return window.CSS.escape(text);
    }

    return text.replace(/["\\]/g, "\\$&");
};

const getAssociatedForm = (element) => {
    if (!(element instanceof HTMLElement)) {
        return null;
    }

    if ("form" in element && element.form instanceof HTMLFormElement) {
        return element.form;
    }

    const form = element.closest("form");

    return form instanceof HTMLFormElement ? form : null;
};

const resolveStatusText = (form, actionRoot, state, options = {}) => {
    if (typeof options.text === "string" && options.text.trim() !== "") {
        return options.text;
    }

    const optionKey = `${state}Text`;

    if (
        typeof options[optionKey] === "string" &&
        options[optionKey].trim() !== ""
    ) {
        return options[optionKey];
    }

    const formText =
        state === "loading"
            ? form.dataset.uiFormSubmitStateLoadingText
            : state === "success"
              ? form.dataset.uiFormSubmitStateSuccessText
              : state === "error"
                ? form.dataset.uiFormSubmitStateErrorText
                : null;

    if (typeof formText === "string" && formText.trim() !== "") {
        return formText;
    }

    const actionText =
        state === "loading"
            ? actionRoot?.dataset.uiFormActionsLoadingText
            : state === "success"
              ? actionRoot?.dataset.uiFormActionsSuccessText
              : state === "error"
                ? actionRoot?.dataset.uiFormActionsErrorText
                : null;

    if (typeof actionText === "string" && actionText.trim() !== "") {
        return actionText;
    }

    return DEFAULT_STATUS_TEXT[state] || "";
};

const resolveAssociatedActionRoot = (form) => {
    if (!(form instanceof HTMLFormElement) || !form.id) {
        return null;
    }

    const selector = [
        `[data-ui-form-actions] [form="${cssEscape(form.id)}"]`,
        `[data-ui-modal-footer] [form="${cssEscape(form.id)}"]`,
        `[data-ui-dialog-footer] [form="${cssEscape(form.id)}"]`,
    ].join(",");

    const submitter = document.querySelector(selector);

    if (!(submitter instanceof HTMLElement)) {
        return null;
    }

    const actionRoot = submitter.closest(FORM_ACTIONS_SELECTOR);

    return actionRoot instanceof HTMLElement ? actionRoot : null;
};

const resolveActionRoot = (form, submitter = null) => {
    const submitterActionRoot = submitter?.closest?.(FORM_ACTIONS_SELECTOR);

    if (submitterActionRoot instanceof HTMLElement) {
        return submitterActionRoot;
    }

    const formActionRoot = form.querySelector(FORM_ACTIONS_SELECTOR);

    if (formActionRoot instanceof HTMLElement) {
        return formActionRoot;
    }

    return resolveAssociatedActionRoot(form);
};

const resolveSubmitter = (form, actionRoot, submitter = null) => {
    if (submitter instanceof HTMLElement) {
        return submitter;
    }

    const lastSubmitter = lastSubmitterByForm.get(form);

    if (
        lastSubmitter instanceof HTMLElement &&
        actionRoot.contains(lastSubmitter)
    ) {
        return lastSubmitter;
    }

    const submitLikeAction = actionRoot.querySelector(SUBMITTER_SELECTOR);

    return submitLikeAction instanceof HTMLElement ? submitLikeAction : null;
};

const getActionElements = (actionRoot) =>
    Array.from(actionRoot.querySelectorAll(ACTION_SELECTOR)).filter(
        (action) => action instanceof HTMLElement,
    );

const isNativeDisableable = (element) =>
    element instanceof HTMLButtonElement ||
    element instanceof HTMLInputElement ||
    element instanceof HTMLSelectElement ||
    element instanceof HTMLTextAreaElement;

const disableAction = (element) => {
    if (isNativeDisableable(element)) {
        element.disabled = true;
        return;
    }

    element.setAttribute("aria-disabled", "true");
    element.setAttribute("tabindex", "-1");
    element.dataset.uiFormSubmitStateDisabled = "true";
};

const restoreActionDisabledState = (element, state) => {
    if (isNativeDisableable(element)) {
        element.disabled = state.disabled;
        return;
    }

    if (state.ariaDisabled === null) {
        element.removeAttribute("aria-disabled");
    } else {
        element.setAttribute("aria-disabled", state.ariaDisabled);
    }

    if (state.tabIndex === null) {
        element.removeAttribute("tabindex");
    } else {
        element.setAttribute("tabindex", state.tabIndex);
    }

    delete element.dataset.uiFormSubmitStateDisabled;
};

const getActionDisabledState = (element) => ({
    disabled: isNativeDisableable(element) ? element.disabled : false,
    ariaDisabled: element.getAttribute("aria-disabled"),
    tabIndex: element.getAttribute("tabindex"),
});

const actionAllowsDuringBusy = (element) =>
    element.dataset.uiFormActionAllowDuringBusy === "true" ||
    element.dataset.uiFormSubmitStateAllowDuringBusy === "true";

/* --------------------------------------------------------------------------
   Inline Loading markup
   -------------------------------------------------------------------------- */

/**
 * Create a Carbon-aligned small Loading component.
 *
 * @param {string} description
 * @returns {HTMLDivElement}
 */
const createLoadingIndicator = (description) => {
    const svgNamespace = "http://www.w3.org/2000/svg";
    const loading = document.createElement("div");
    const svg = document.createElementNS(svgNamespace, "svg");
    const title = document.createElementNS(svgNamespace, "title");
    const background = document.createElementNS(svgNamespace, "circle");
    const stroke = document.createElementNS(svgNamespace, "circle");

    loading.className = "ui-loading ui-loading--small";
    loading.setAttribute("aria-atomic", "true");
    loading.setAttribute("aria-live", "assertive");
    loading.setAttribute("data-ui-component", "loading");
    loading.setAttribute("data-ui-loading", "");
    loading.setAttribute("data-ui-loading-active", "true");
    loading.setAttribute("data-ui-loading-size", "sm");

    svg.classList.add("ui-loading__svg");
    svg.setAttribute("viewBox", "0 0 100 100");
    svg.setAttribute("role", "img");
    svg.setAttribute("aria-label", description);

    title.textContent = description;

    background.classList.add("ui-loading__background");
    background.setAttribute("cx", "50%");
    background.setAttribute("cy", "50%");
    background.setAttribute("r", "42");

    stroke.classList.add("ui-loading__stroke");
    stroke.setAttribute("cx", "50%");
    stroke.setAttribute("cy", "50%");
    stroke.setAttribute("r", "42");

    svg.append(title, background, stroke);
    loading.append(svg);

    return loading;
};

/**
 * Create an Inline Loading status icon.
 *
 * @param {"finished"|"error"} status
 * @returns {HTMLSpanElement}
 */
const createStatusIcon = (status) => {
    const svgNamespace = "http://www.w3.org/2000/svg";
    const container = document.createElement("span");
    const svg = document.createElementNS(svgNamespace, "svg");
    const path = document.createElementNS(svgNamespace, "path");

    container.className = [
        "ui-inline-loading__status-icon",
        `ui-inline-loading__status-icon--${status}`,
    ].join(" ");
    container.setAttribute("role", "img");
    container.setAttribute(
        "aria-label",
        status === "finished" ? "finished" : "error",
    );
    container.setAttribute("data-ui-inline-loading-indicator", status);

    svg.setAttribute("viewBox", "0 0 32 32");
    svg.setAttribute("aria-hidden", "true");
    svg.setAttribute("focusable", "false");

    if (status === "finished") {
        svg.classList.add("ui-inline-loading__checkmark-container");
        path.setAttribute(
            "d",
            "M16 2a14 14 0 1 0 14 14A14.0158 14.0158 0 0 0 16 2Zm-2 19.5908-5-5L10.5908 15 14 18.4092 21.4092 11 23 12.5908Z",
        );
    } else {
        svg.classList.add("ui-inline-loading__error");
        path.setAttribute(
            "d",
            "M16 2a14 14 0 1 0 14 14A14.0158 14.0158 0 0 0 16 2Zm1 21h-2v-2h2Zm0-5h-2V9h2Z",
        );
    }

    svg.append(path);
    container.append(svg);

    return container;
};

/**
 * Create Carbon-aligned Inline Loading markup.
 *
 * @param {"idle"|"loading"|"success"|"error"} state
 * @param {string} description
 * @param {string|null} ariaLive
 * @returns {HTMLDivElement}
 */
const createInlineLoading = (state, description, ariaLive = null) => {
    const status = INLINE_LOADING_STATUS[state] || "inactive";
    const textValue = String(description ?? "").trim();
    const root = document.createElement("div");
    const animation = document.createElement("div");

    root.className = "ui-inline-loading";
    root.setAttribute(
        "aria-live",
        ariaLive || (status === "inactive" ? "off" : "assertive"),
    );
    root.setAttribute("data-ui-component", "inline-loading");
    root.setAttribute("data-ui-inline-loading", "");
    root.setAttribute("data-ui-inline-loading-status", status);
    root.setAttribute("data-ui-inline-loading-success-delay", "1500");
    root.setAttribute("data-ui-inline-loading-initialized", "true");

    animation.className = "ui-inline-loading__animation";
    animation.setAttribute("data-ui-inline-loading-animation", "");

    if (status === "inactive") {
        animation.hidden = true;
    } else if (status === "active") {
        const indicator = document.createElement("span");

        indicator.setAttribute("data-ui-inline-loading-indicator", "active");
        indicator.append(createLoadingIndicator(textValue || "loading"));

        animation.append(indicator);
    } else {
        animation.append(createStatusIcon(status));
    }

    root.append(animation);

    if (textValue !== "") {
        const text = document.createElement("div");

        text.className = "ui-inline-loading__text";
        text.textContent = textValue;

        root.append(text);
    }

    return root;
};

/* --------------------------------------------------------------------------
   Submitter slot metrics
   -------------------------------------------------------------------------- */

const getCssValue = (styles, logicalProperty, fallbackProperty) =>
    styles.getPropertyValue(logicalProperty) ||
    styles.getPropertyValue(fallbackProperty) ||
    "0px";

const getSubmitterSlotMetrics = (submitter) => {
    if (!(submitter instanceof HTMLElement)) {
        return null;
    }

    const rect = submitter.getBoundingClientRect();
    const styles = window.getComputedStyle(submitter);
    const justifyContent =
        styles.justifyContent === "normal"
            ? "flex-start"
            : styles.justifyContent;
    const alignItems =
        styles.alignItems === "normal" ? "center" : styles.alignItems;
    const flexValue =
        styles.flex && styles.flex !== "0 1 auto"
            ? styles.flex
            : `${styles.flexGrow} ${styles.flexShrink} ${styles.flexBasis}`;

    return {
        inlineSize: `${Math.max(0, rect.width)}px`,
        blockSize: `${Math.max(0, rect.height)}px`,
        minInlineSize: styles.minInlineSize || styles.minWidth || "0px",
        maxInlineSize: styles.maxInlineSize || styles.maxWidth || "none",
        flex: flexValue,
        alignSelf: styles.alignSelf,
        paddingInlineStart: getCssValue(
            styles,
            "padding-inline-start",
            "padding-left",
        ),
        paddingInlineEnd: getCssValue(
            styles,
            "padding-inline-end",
            "padding-right",
        ),
        paddingBlockStart: getCssValue(
            styles,
            "padding-block-start",
            "padding-top",
        ),
        paddingBlockEnd: getCssValue(
            styles,
            "padding-block-end",
            "padding-bottom",
        ),
        justifyContent,
        alignItems,
    };
};

const applySubmitterSlotMetrics = (status, metrics) => {
    if (!(status instanceof HTMLElement) || !metrics) {
        return;
    }

    status.classList.add("ui-form-actions__status--button-slot");
    status.dataset.uiFormActionsStatusReplacement = "button";

    status.style.boxSizing = "border-box";
    status.style.display = "inline-flex";
    status.style.inlineSize = metrics.inlineSize;
    status.style.blockSize = metrics.blockSize;
    status.style.minInlineSize = metrics.minInlineSize;
    status.style.maxInlineSize = metrics.maxInlineSize;
    status.style.flex = metrics.flex;
    status.style.alignSelf = metrics.alignSelf;
    status.style.alignItems = metrics.alignItems;
    status.style.justifyContent = metrics.justifyContent;

    status.style.setProperty(
        "--ui-form-actions-status-inline-size",
        metrics.inlineSize,
    );
    status.style.setProperty(
        "--ui-form-actions-status-block-size",
        metrics.blockSize,
    );
    status.style.setProperty(
        "--ui-form-actions-status-min-inline-size",
        metrics.minInlineSize,
    );
    status.style.setProperty(
        "--ui-form-actions-status-max-inline-size",
        metrics.maxInlineSize,
    );
    status.style.setProperty("--ui-form-actions-status-flex", metrics.flex);
    status.style.setProperty(
        "--ui-form-actions-status-padding-inline-start",
        metrics.paddingInlineStart,
    );
    status.style.setProperty(
        "--ui-form-actions-status-padding-inline-end",
        metrics.paddingInlineEnd,
    );
    status.style.setProperty(
        "--ui-form-actions-status-padding-block-start",
        metrics.paddingBlockStart,
    );
    status.style.setProperty(
        "--ui-form-actions-status-padding-block-end",
        metrics.paddingBlockEnd,
    );
    status.style.setProperty(
        "--ui-form-actions-status-justify-content",
        metrics.justifyContent,
    );
    status.style.setProperty(
        "--ui-form-actions-status-align-items",
        metrics.alignItems,
    );
};

const createFormActionsStatus = (
    state,
    text,
    ariaLive = null,
    submitterMetrics = null,
) => {
    const status = document.createElement("span");

    status.className = `ui-form-actions__status ui-form-actions__status--${state}`;
    status.setAttribute("data-ui-form-actions-status", "");
    status.setAttribute("data-ui-form-actions-status-state", state);
    status.setAttribute("data-ui-form-actions-status-text", text);
    status.append(createInlineLoading(state, text, ariaLive));

    applySubmitterSlotMetrics(status, submitterMetrics);

    return status;
};

const syncActionRootState = (actionRoot, state) => {
    ["idle", "loading", "success", "error"].forEach((stateName) => {
        actionRoot.classList.remove(`ui-form-actions--state-${stateName}`);
    });

    actionRoot.classList.add(`ui-form-actions--state-${state}`);
    actionRoot.classList.toggle("ui-form-actions--busy", state === "loading");
    actionRoot.classList.toggle(
        "ui-form-actions--has-status",
        state !== "idle",
    );

    actionRoot.dataset.uiFormActionsState = state;
    actionRoot.dataset.uiFormActionsBusy =
        state === "loading" ? "true" : "false";
    actionRoot.dataset.uiFormActionsHasStatus =
        state === "idle" ? "false" : "true";
};

const preserveIdleState = (actionRoot, submitter) => {
    if (actionRootState.has(actionRoot)) {
        return;
    }

    actionRootState.set(actionRoot, {
        submitter,
        replacement: null,
        submitterParent: submitter?.parentNode || null,
        submitterNextSibling: submitter?.nextSibling || null,
        submitterMetrics: getSubmitterSlotMetrics(submitter),
        actionStates: getActionElements(actionRoot).map((element) => ({
            element,
            state: getActionDisabledState(element),
        })),
    });
};

const restoreIdleState = (actionRoot) => {
    const savedState = actionRootState.get(actionRoot);

    if (!savedState) {
        return;
    }

    savedState.actionStates.forEach(({ element, state }) => {
        restoreActionDisabledState(element, state);
        element.removeAttribute("aria-busy");
        element.dataset.uiFormActionLoading = "false";
    });

    if (savedState.submitter instanceof HTMLElement) {
        savedState.submitter.removeAttribute("aria-busy");
        savedState.submitter.dataset.uiFormActionLoading = "false";
        delete savedState.submitter.dataset.uiFormSubmitStateActive;

        if (savedState.replacement?.isConnected) {
            savedState.replacement.replaceWith(savedState.submitter);
        } else if (savedState.submitterParent) {
            savedState.submitterParent.insertBefore(
                savedState.submitter,
                savedState.submitterNextSibling,
            );
        }
    }

    actionRootState.delete(actionRoot);
};

const disableRelatedActions = (actionRoot, submitter) => {
    getActionElements(actionRoot).forEach((action) => {
        if (action === submitter) {
            action.dataset.uiFormSubmitStateActive = "true";
            action.setAttribute("aria-busy", "true");
            return;
        }

        if (actionAllowsDuringBusy(action)) {
            return;
        }

        disableAction(action);
    });
};

const updateSubmitterStatus = (
    actionRoot,
    submitter,
    state,
    text,
    ariaLive = null,
) => {
    const savedState = actionRootState.get(actionRoot);

    if (!submitter || !savedState) {
        return;
    }

    const replacement = createFormActionsStatus(
        state,
        text,
        ariaLive,
        savedState.submitterMetrics,
    );

    if (savedState.replacement?.isConnected) {
        savedState.replacement.replaceWith(replacement);
    } else if (submitter.isConnected) {
        submitter.replaceWith(replacement);
    }

    savedState.replacement = replacement;
};

export const setFormSubmitState = (form, state, options = {}) => {
    if (!(form instanceof HTMLFormElement)) {
        return;
    }

    const resolvedState = normalizeState(state);
    const explicitSubmitter =
        options.submitter instanceof HTMLElement ? options.submitter : null;
    const actionRoot =
        options.actionRoot instanceof HTMLElement
            ? options.actionRoot
            : resolveActionRoot(form, explicitSubmitter);

    if (!actionRoot) {
        return;
    }

    const savedState = actionRootState.get(actionRoot);
    const submitter =
        resolveSubmitter(form, actionRoot, explicitSubmitter) ||
        savedState?.submitter ||
        null;

    form.dataset.uiFormSubmitStateCurrent = resolvedState;
    syncActionRootState(actionRoot, resolvedState);

    if (resolvedState === "idle") {
        restoreIdleState(actionRoot);
        return;
    }

    if (!submitter) {
        return;
    }

    const statusText = resolveStatusText(
        form,
        actionRoot,
        resolvedState,
        options,
    );
    const ariaLive =
        typeof options.ariaLive === "string" ? options.ariaLive : null;

    preserveIdleState(actionRoot, submitter);
    disableRelatedActions(actionRoot, submitter);
    updateSubmitterStatus(
        actionRoot,
        submitter,
        resolvedState,
        statusText,
        ariaLive,
    );
};

export const resetFormSubmitState = (form, options = {}) => {
    setFormSubmitState(form, "idle", options);
};

const handleSubmit = (event) => {
    const form = event.currentTarget;

    if (!(form instanceof HTMLFormElement)) {
        return;
    }

    if (form.dataset.uiFormSubmitStateCurrent === "loading") {
        event.preventDefault();
        return;
    }

    if (!form.noValidate && typeof form.checkValidity === "function") {
        if (!form.checkValidity()) {
            return;
        }
    }

    const submitter =
        event.submitter instanceof HTMLElement
            ? event.submitter
            : lastSubmitterByForm.get(form) || null;

    if (submitter?.hasAttribute("data-ui-form-submit-state-ignore")) {
        return;
    }

    setFormSubmitState(form, "loading", {
        submitter,
    });
};

const handleDocumentClick = (event) => {
    const target = event.target;

    if (!(target instanceof Element)) {
        return;
    }

    const submitter = target.closest(SUBMITTER_SELECTOR);

    if (!(submitter instanceof HTMLElement)) {
        return;
    }

    const form = getAssociatedForm(submitter);

    if (form instanceof HTMLFormElement) {
        lastSubmitterByForm.set(form, submitter);
    }
};

const resolveFormFromEvent = (eventTarget, detail = {}) => {
    if (detail.form instanceof HTMLFormElement) {
        return detail.form;
    }

    if (typeof detail.formId === "string" && detail.formId.trim() !== "") {
        const form = document.getElementById(detail.formId);

        if (form instanceof HTMLFormElement) {
            return form;
        }
    }

    if (eventTarget instanceof HTMLFormElement) {
        return eventTarget;
    }

    if (eventTarget instanceof Element) {
        const submitter = eventTarget.closest(SUBMITTER_SELECTOR);
        const associatedForm = getAssociatedForm(submitter);

        if (associatedForm instanceof HTMLFormElement) {
            return associatedForm;
        }

        const form = eventTarget.closest("form");

        if (form instanceof HTMLFormElement) {
            return form;
        }
    }

    return null;
};

const handleManualStateEvent = (event) => {
    const detail = event.detail || {};
    const form = resolveFormFromEvent(event.target, detail);

    if (!form) {
        return;
    }

    setFormSubmitState(form, detail.state || "loading", detail);
};

export function initFormSubmitState(root = document) {
    const forms = [];

    if (root instanceof HTMLFormElement && root.matches(FORM_SELECTOR)) {
        forms.push(root);
    }

    root.querySelectorAll?.(FORM_SELECTOR).forEach((form) => {
        if (form instanceof HTMLFormElement) {
            forms.push(form);
        }
    });

    forms.forEach((form) => {
        if (form.dataset.uiFormSubmitStateBound === "true") {
            return;
        }

        form.dataset.uiFormSubmitStateBound = "true";
        form.addEventListener("submit", handleSubmit);
        form.addEventListener("reset", () => resetFormSubmitState(form));
    });

    if (
        document.documentElement.dataset.uiFormSubmitStateDocumentListener !==
        "true"
    ) {
        document.documentElement.dataset.uiFormSubmitStateDocumentListener =
            "true";

        document.addEventListener("click", handleDocumentClick, true);
        document.addEventListener(
            "ui:form-submit-state",
            handleManualStateEvent,
        );

        window.LoginAppFormSubmitState = {
            initialize: initFormSubmitState,
            set: setFormSubmitState,
            reset: resetFormSubmitState,
        };
    }
}
