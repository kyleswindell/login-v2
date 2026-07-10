/**
 * File: resources/js/ui-controls/popover.js
 * Purpose: Popover behavior controller.
 *
 * Source: Ported from Carbon React Popover / PopoverContent behavior.
 *
 * Notes:
 * - Blade owns the static DOM render contract:
 *   .ui-popover-container > trigger + .ui-popover > .ui-popover-content
 * - This file owns client-side state and behavior:
 *   open/close, outside click, focusout, Escape, hover/focus/click interaction,
 *   optional auto-align, fallback placement, and caret positioning.
 */

import { enterMotion, exitMotion, setMotionState } from "./motion";

const POPOVER_SELECTOR = "[data-ui-popover]";
const TRIGGER_SELECTOR = "[data-ui-popover-trigger]";
const PANEL_SELECTOR = "[data-ui-popover-panel], [data-ui-popover-content]";
const CONTENT_SELECTOR = ".ui-popover-content, [data-ui-popover-content]";
const CARET_SELECTOR = "[data-ui-popover-caret], [data-ui-popover-tip-shape]";
const CLOSE_SELECTOR = "[data-ui-popover-close]";

const BOUND_ATTR = "data-ui-popover-bound";
const GLOBAL_BOUND_ATTR = "data-ui-popover-global-bound";

const OPEN_CLASSES = ["ui-popover-open", "ui-popover--open"];
const AUTO_ALIGN_CLASSES = ["ui-popover-auto-align", "ui-popover--auto-align"];
const AUTOALIGN_ALIAS_CLASS = "ui-autoalign";

const MOTION_STATE_OPEN = "open";
const MOTION_STATE_CLOSED = "closed";

const ALIGNMENTS = [
    "top",
    "bottom",
    "left",
    "right",
    "top-start",
    "top-end",
    "bottom-start",
    "bottom-end",
    "left-start",
    "left-end",
    "right-start",
    "right-end",
];

const DEPRECATED_ALIGNMENT_MAP = {
    "top-left": "top-start",
    "top-right": "top-end",
    "bottom-left": "bottom-start",
    "bottom-right": "bottom-end",
    "left-top": "left-start",
    "left-bottom": "left-end",
    "right-top": "right-start",
    "right-bottom": "right-end",
};

const ALIGNMENT_CLASS_PATTERN =
    /\bui-popover(?:--)?-(top|bottom|left|right)(?:-(start|end|left|right|top|bottom))?\b/g;

const popoverState = new WeakMap();

let globalEventsBound = false;
let updateFrame = null;

/* --------------------------------------------------------------------------
   Type guards
   -------------------------------------------------------------------------- */

function isElement(value) {
    return value instanceof Element;
}

function isHTMLElement(value) {
    return value instanceof HTMLElement;
}

function isHTMLButtonElement(value) {
    return value instanceof HTMLButtonElement;
}

/* --------------------------------------------------------------------------
   Element getters
   -------------------------------------------------------------------------- */

function getTrigger(popover) {
    return popover.querySelector(TRIGGER_SELECTOR);
}

function getPanel(popover) {
    return popover.querySelector(PANEL_SELECTOR);
}

function getContent(popover) {
    return popover.querySelector(CONTENT_SELECTOR);
}

function getCaret(popover) {
    return popover.querySelector(CARET_SELECTOR);
}

function isMotionPanel(panel) {
    return panel instanceof HTMLElement && Boolean(panel.dataset.uiMotion);
}

function syncPanelMotionState(panel, open) {
    if (!isMotionPanel(panel)) {
        return;
    }

    setMotionState(panel, open ? MOTION_STATE_OPEN : MOTION_STATE_CLOSED);
}

/* --------------------------------------------------------------------------
   Prop / data resolution
   -------------------------------------------------------------------------- */

function toBoolean(value, fallback = false) {
    if (value === true || value === "true" || value === "") {
        return true;
    }

    if (value === false || value === "false") {
        return false;
    }

    return fallback;
}

function toNumber(value, fallback = null) {
    if (value === null || value === undefined || value === "") {
        return fallback;
    }

    const parsed = Number(value);

    return Number.isFinite(parsed) ? parsed : fallback;
}

function unique(values) {
    return values.filter(
        (value, index, array) => array.indexOf(value) === index,
    );
}

function mapPopoverAlign(align) {
    const mappedAlign = DEPRECATED_ALIGNMENT_MAP[align] ?? align;

    return ALIGNMENTS.includes(mappedAlign) ? mappedAlign : "bottom";
}

function extractAlignmentFromClasses(popover) {
    const className = popover.className || "";
    let match;
    let resolved = null;

    while ((match = ALIGNMENT_CLASS_PATTERN.exec(className)) !== null) {
        const base = match[1];
        const suffix = match[2];

        if (!suffix) {
            resolved = base;
            continue;
        }

        const candidate = mapPopoverAlign(`${base}-${suffix}`);

        if (ALIGNMENTS.includes(candidate)) {
            resolved = candidate;
        }
    }

    ALIGNMENT_CLASS_PATTERN.lastIndex = 0;

    return resolved;
}

function resolveInitialAlign(popover) {
    const isTabTip = isTabTipPopover(popover);
    const requestedAlign =
        popover.dataset.uiPopoverAlign ||
        extractAlignmentFromClasses(popover) ||
        (isTabTip ? "bottom-start" : "bottom");

    let resolvedAlign = mapPopoverAlign(requestedAlign);

    if (isTabTip && !["bottom-start", "bottom-end"].includes(resolvedAlign)) {
        resolvedAlign = "bottom-start";
    }

    return resolvedAlign;
}

function isOpen(popover) {
    return (
        popover.dataset.uiPopoverOpen === "true" ||
        popover.classList.contains("ui-popover-open") ||
        popover.classList.contains("ui-popover--open")
    );
}

function isCaretEnabled(popover) {
    return (
        popover.dataset.uiPopoverCaret === "true" ||
        popover.classList.contains("ui-popover-caret") ||
        popover.classList.contains("ui-popover--caret")
    );
}

function isAutoAlignEnabled(popover) {
    return (
        popover.dataset.uiPopoverAutoAlign === "true" ||
        popover.classList.contains("ui-popover-auto-align") ||
        popover.classList.contains("ui-popover--auto-align") ||
        popover.classList.contains("ui-autoalign")
    );
}

function isTabTipPopover(popover) {
    return (
        popover.dataset.uiPopoverTabTip === "true" ||
        popover.classList.contains("ui-popover-tab-tip") ||
        popover.classList.contains("ui-popover--tab-tip")
    );
}

function getInteraction(popover) {
    const interaction = popover.dataset.uiPopoverInteraction;

    return ["click", "hover", "focus"].includes(interaction)
        ? interaction
        : "click";
}

function getAlignmentAxisOffset(popover) {
    return toNumber(popover.dataset.uiPopoverAlignmentAxisOffset, null);
}

/* --------------------------------------------------------------------------
   CSS dimension helpers
   -------------------------------------------------------------------------- */

function getRootFontSize() {
    const size = window.getComputedStyle(document.documentElement).fontSize;
    const parsed = parseFloat(size);

    return Number.isFinite(parsed) ? parsed : 16;
}

function parseCssLength(value, fallbackPx = 0) {
    if (!value) {
        return fallbackPx;
    }

    const trimmed = String(value).trim();

    if (trimmed === "") {
        return fallbackPx;
    }

    if (trimmed.endsWith("rem")) {
        const number = parseFloat(trimmed);

        return Number.isFinite(number)
            ? number * getRootFontSize()
            : fallbackPx;
    }

    if (trimmed.endsWith("px")) {
        const number = parseFloat(trimmed);

        return Number.isFinite(number) ? number : fallbackPx;
    }

    const number = parseFloat(trimmed);

    return Number.isFinite(number) ? number : fallbackPx;
}

function hasSlugLikeContent(popover) {
    return Boolean(
        popover.querySelector(
            '[class*="slug"], [class*="ai-label"], [class*="ai_label"]',
        ),
    );
}

function getPopoverDimensions(popover) {
    const computedStyle = window.getComputedStyle(popover);
    const fallbackCaretHeight = hasSlugLikeContent(popover) ? 7 : 6;

    const offset = parseCssLength(
        computedStyle.getPropertyValue("--ui-popover-offset"),
        10,
    );

    const caretHeight = parseCssLength(
        computedStyle.getPropertyValue("--ui-popover-caret-height"),
        fallbackCaretHeight,
    );

    const caretWidth = parseCssLength(
        computedStyle.getPropertyValue("--ui-popover-caret-width"),
        12,
    );

    return {
        offset,
        caretHeight,
        caretWidth,
    };
}

/* --------------------------------------------------------------------------
   Alignment class handling
   -------------------------------------------------------------------------- */

function clearAlignmentClasses(popover) {
    ALIGNMENTS.forEach((alignment) => {
        popover.classList.remove(`ui-popover-${alignment}`);
        popover.classList.remove(`ui-popover--${alignment}`);
    });

    Object.keys(DEPRECATED_ALIGNMENT_MAP).forEach((alignment) => {
        popover.classList.remove(`ui-popover-${alignment}`);
        popover.classList.remove(`ui-popover--${alignment}`);
    });
}

function setAlignmentClasses(popover, alignment) {
    clearAlignmentClasses(popover);

    popover.classList.add(`ui-popover-${alignment}`);
    popover.classList.add(`ui-popover--${alignment}`);
    popover.dataset.uiPopoverCurrentAlign = alignment;
}

/* --------------------------------------------------------------------------
   Open / close state
   -------------------------------------------------------------------------- */

function setOpenState(popover, open, options = {}) {
    const trigger = getTrigger(popover);
    const panel = getPanel(popover);

    const syncPanelHidden = options.syncPanelHidden !== false;
    const syncMotionState = options.syncMotionState !== false;
    const clearAutoAlignOnClose = options.clearAutoAlignOnClose !== false;

    OPEN_CLASSES.forEach((className) => {
        popover.classList.toggle(className, open);
    });

    popover.dataset.uiPopoverOpen = open ? "true" : "false";

    if (isHTMLElement(trigger)) {
        trigger.setAttribute("aria-expanded", open ? "true" : "false");

        if (panel instanceof HTMLElement && panel.id) {
            trigger.setAttribute("aria-controls", panel.id);
        }
    }

    if (panel instanceof HTMLElement) {
        if (syncPanelHidden) {
            panel.hidden = !open;
        }

        panel.setAttribute("aria-hidden", open ? "false" : "true");

        if (syncMotionState) {
            syncPanelMotionState(panel, open);
        }
    }

    if (!open && clearAutoAlignOnClose) {
        clearAutoAlignStyles(popover);
    }
}

function openPopover(popover, { focusPanel = false } = {}) {
    if (!(popover instanceof HTMLElement)) {
        return;
    }

    const trigger = getTrigger(popover);
    const panel = getPanel(popover);
    const hasPanelMotion = isMotionPanel(panel);

    if (isHTMLButtonElement(trigger) && trigger.disabled) {
        return;
    }

    setOpenState(popover, true, {
        syncPanelHidden: !hasPanelMotion,
        syncMotionState: !hasPanelMotion,
    });

    if (hasPanelMotion) {
        void enterMotion(panel);
    }

    if (isAutoAlignEnabled(popover)) {
        window.requestAnimationFrame(() => {
            updatePopoverPosition(popover);
        });
    }

    if (focusPanel) {
        if (panel instanceof HTMLElement) {
            window.requestAnimationFrame(() => {
                panel.focus({ preventScroll: true });
            });
        }
    }
}

function closePopover(popover, { returnFocus = false } = {}) {
    if (!(popover instanceof HTMLElement)) {
        return;
    }

    const trigger = getTrigger(popover);
    const panel = getPanel(popover);
    const hasPanelMotion = isMotionPanel(panel);

    setOpenState(popover, false, {
        syncPanelHidden: !hasPanelMotion,
        syncMotionState: !hasPanelMotion,
        clearAutoAlignOnClose: !hasPanelMotion,
    });

    if (hasPanelMotion) {
        void exitMotion(panel).then(() => {
            if (!isOpen(popover)) {
                clearAutoAlignStyles(popover);
            }
        });
    }

    if (returnFocus && trigger instanceof HTMLElement) {
        window.requestAnimationFrame(() => {
            trigger.focus({ preventScroll: true });
        });
    }
}

function togglePopover(popover) {
    if (isOpen(popover)) {
        closePopover(popover, { returnFocus: true });
        return;
    }

    openPopover(popover);
}

/* --------------------------------------------------------------------------
   DatePicker exception from Carbon behavior
   -------------------------------------------------------------------------- */

function isTargetInDatePickerInsidePopover(popover, target) {
    if (!(target instanceof Element)) {
        return false;
    }

    const calendar = target.closest(".flatpickr-calendar");

    if (!calendar) {
        return false;
    }

    const inputs = popover.querySelectorAll("input");

    for (const input of inputs) {
        if (!("_flatpickr" in input)) {
            continue;
        }

        const flatpickr = input._flatpickr;

        if (
            flatpickr &&
            typeof flatpickr === "object" &&
            "calendarContainer" in flatpickr &&
            flatpickr.calendarContainer === calendar
        ) {
            return true;
        }
    }

    return false;
}

/* --------------------------------------------------------------------------
   Auto-align placement
   -------------------------------------------------------------------------- */

function getBasePlacement(alignment) {
    return alignment.split("-")[0];
}

function getPlacementSuffix(alignment) {
    return alignment.split("-")[1] || null;
}

function getFallbackPlacements(alignment, isTabTip) {
    const base = getBasePlacement(alignment);

    if (isTabTip) {
        return unique(
            base === "bottom"
                ? [
                      alignment,
                      "bottom-start",
                      "bottom-end",
                      "top-start",
                      "top-end",
                  ]
                : [
                      alignment,
                      "top-start",
                      "top-end",
                      "bottom-start",
                      "bottom-end",
                  ],
        );
    }

    if (base === "bottom") {
        return unique([
            alignment,
            "bottom",
            "bottom-start",
            "bottom-end",
            "right",
            "right-start",
            "right-end",
            "left",
            "left-start",
            "left-end",
            "top",
            "top-start",
            "top-end",
        ]);
    }

    return unique([
        alignment,
        "top",
        "top-start",
        "top-end",
        "left",
        "left-start",
        "left-end",
        "right",
        "right-start",
        "right-end",
        "bottom",
        "bottom-start",
        "bottom-end",
    ]);
}

function getCoordinates(referenceRect, panelRect, alignment, options = {}) {
    const base = getBasePlacement(alignment);
    const suffix = getPlacementSuffix(alignment);
    const offset = options.offset ?? 0;
    const alignmentAxisOffset = options.alignmentAxisOffset ?? 0;

    let top = 0;
    let left = 0;

    if (base === "bottom") {
        top = referenceRect.bottom + offset;

        if (suffix === "start") {
            left = referenceRect.left;
        } else if (suffix === "end") {
            left = referenceRect.right - panelRect.width;
        } else {
            left =
                referenceRect.left +
                referenceRect.width / 2 -
                panelRect.width / 2;
        }

        left += alignmentAxisOffset;
    }

    if (base === "top") {
        top = referenceRect.top - panelRect.height - offset;

        if (suffix === "start") {
            left = referenceRect.left;
        } else if (suffix === "end") {
            left = referenceRect.right - panelRect.width;
        } else {
            left =
                referenceRect.left +
                referenceRect.width / 2 -
                panelRect.width / 2;
        }

        left += alignmentAxisOffset;
    }

    if (base === "right") {
        left = referenceRect.right + offset;

        if (suffix === "start") {
            top = referenceRect.top;
        } else if (suffix === "end") {
            top = referenceRect.bottom - panelRect.height;
        } else {
            top =
                referenceRect.top +
                referenceRect.height / 2 -
                panelRect.height / 2;
        }

        top += alignmentAxisOffset;
    }

    if (base === "left") {
        left = referenceRect.left - panelRect.width - offset;

        if (suffix === "start") {
            top = referenceRect.top;
        } else if (suffix === "end") {
            top = referenceRect.bottom - panelRect.height;
        } else {
            top =
                referenceRect.top +
                referenceRect.height / 2 -
                panelRect.height / 2;
        }

        top += alignmentAxisOffset;
    }

    return { top, left };
}

function getOverflowScore(coordinates, panelRect) {
    const viewportWidth = window.innerWidth;
    const viewportHeight = window.innerHeight;
    const margin = 4;

    const overflowLeft = Math.max(margin - coordinates.left, 0);
    const overflowTop = Math.max(margin - coordinates.top, 0);
    const overflowRight = Math.max(
        coordinates.left + panelRect.width - viewportWidth + margin,
        0,
    );
    const overflowBottom = Math.max(
        coordinates.top + panelRect.height - viewportHeight + margin,
        0,
    );

    return overflowLeft + overflowTop + overflowRight + overflowBottom;
}

function isReferenceHidden(referenceRect) {
    return (
        referenceRect.bottom < 0 ||
        referenceRect.right < 0 ||
        referenceRect.top > window.innerHeight ||
        referenceRect.left > window.innerWidth
    );
}

function choosePlacement(popover, trigger, panel, initialAlignment) {
    const referenceRect = trigger.getBoundingClientRect();
    const panelRect = panel.getBoundingClientRect();
    const isTabTip = isTabTipPopover(popover);
    const dimensions = getPopoverDimensions(popover);

    const caretEnabled = isCaretEnabled(popover);
    const offset = isTabTip ? 0 : caretEnabled ? dimensions.offset : 4;
    const alignmentAxisOffset = getAlignmentAxisOffset(popover) ?? 0;

    const fallbackPlacements = getFallbackPlacements(
        initialAlignment,
        isTabTip,
    );

    let bestPlacement = initialAlignment;
    let bestCoordinates = getCoordinates(
        referenceRect,
        panelRect,
        bestPlacement,
        {
            offset,
            alignmentAxisOffset,
        },
    );
    let bestScore = getOverflowScore(bestCoordinates, panelRect);

    for (const placement of fallbackPlacements) {
        const coordinates = getCoordinates(
            referenceRect,
            panelRect,
            placement,
            {
                offset,
                alignmentAxisOffset,
            },
        );

        const score = getOverflowScore(coordinates, panelRect);

        if (score < bestScore) {
            bestPlacement = placement;
            bestCoordinates = coordinates;
            bestScore = score;
        }

        if (score === 0) {
            break;
        }
    }

    return {
        placement: bestPlacement,
        coordinates: bestCoordinates,
        referenceRect,
        panelRect,
        referenceHidden: isReferenceHidden(referenceRect),
    };
}

function applyAutoAlignStyles(popover, placementData) {
    const panel = getPanel(popover);

    if (!(panel instanceof HTMLElement)) {
        return;
    }

    panel.style.position = "fixed";
    panel.style.inset = "auto";
    panel.style.insetBlockStart = "auto";
    panel.style.insetBlockEnd = "auto";
    panel.style.insetInlineStart = "auto";
    panel.style.insetInlineEnd = "auto";
    panel.style.top = `${Math.round(placementData.coordinates.top)}px`;
    panel.style.left = `${Math.round(placementData.coordinates.left)}px`;
    panel.style.right = "";
    panel.style.bottom = "";
    panel.style.transform = "none";
    panel.style.visibility = placementData.referenceHidden
        ? "hidden"
        : "visible";

    setAlignmentClasses(popover, placementData.placement);
}

function clearAutoAlignStyles(popover) {
    const panel = getPanel(popover);
    const caret = getCaret(popover);

    if (panel instanceof HTMLElement) {
        panel.style.position = "";
        panel.style.inset = "";
        panel.style.insetBlockStart = "";
        panel.style.insetBlockEnd = "";
        panel.style.insetInlineStart = "";
        panel.style.insetInlineEnd = "";
        panel.style.top = "";
        panel.style.left = "";
        panel.style.right = "";
        panel.style.bottom = "";
        panel.style.transform = "";
        panel.style.visibility = "";
    }

    if (caret instanceof HTMLElement) {
        caret.style.top = "";
        caret.style.right = "";
        caret.style.bottom = "";
        caret.style.left = "";
    }
}

function clamp(value, min, max) {
    if (max < min) {
        return min;
    }

    return Math.min(Math.max(value, min), max);
}

function updateCaretPosition(popover, placementData) {
    const caret = getCaret(popover);
    const panel = getPanel(popover);

    if (!(caret instanceof HTMLElement) || !(panel instanceof HTMLElement)) {
        return;
    }

    if (!isCaretEnabled(popover)) {
        return;
    }

    const base = getBasePlacement(placementData.placement);
    const dimensions = getPopoverDimensions(popover);
    const panelRect = panel.getBoundingClientRect();
    const referenceRect = placementData.referenceRect;

    const caretRect = caret.getBoundingClientRect();
    const caretWidth = caretRect.width || dimensions.caretWidth;
    const caretHeight = caretRect.height || dimensions.caretHeight;
    const padding = 16;

    caret.style.top = "";
    caret.style.right = "";
    caret.style.bottom = "";
    caret.style.left = "";

    if (base === "bottom" || base === "top") {
        const referenceCenter =
            referenceRect.left + referenceRect.width / 2 - panelRect.left;

        const left = clamp(
            referenceCenter - caretWidth / 2,
            padding,
            panelRect.width - padding - caretWidth,
        );

        caret.style.left = `${Math.round(left)}px`;

        if (base === "bottom") {
            caret.style.top = `${-dimensions.caretHeight}px`;
        } else {
            caret.style.bottom = `${-dimensions.caretHeight}px`;
        }
    }

    if (base === "right" || base === "left") {
        const referenceCenter =
            referenceRect.top + referenceRect.height / 2 - panelRect.top;

        const top = clamp(
            referenceCenter - caretHeight / 2,
            padding,
            panelRect.height - padding - caretHeight,
        );

        caret.style.top = `${Math.round(top)}px`;

        if (base === "right") {
            caret.style.left = `${-dimensions.caretHeight}px`;
        } else {
            caret.style.right = `${-dimensions.caretHeight}px`;
        }
    }
}

function updatePopoverPosition(popover) {
    if (!(popover instanceof HTMLElement)) {
        return;
    }

    if (!isOpen(popover) || !isAutoAlignEnabled(popover)) {
        return;
    }

    const trigger = getTrigger(popover);
    const panel = getPanel(popover);

    if (!(trigger instanceof HTMLElement) || !(panel instanceof HTMLElement)) {
        return;
    }

    const state = popoverState.get(popover);
    const initialAlignment =
        state?.initialAlign || resolveInitialAlign(popover) || "bottom";

    const placementData = choosePlacement(
        popover,
        trigger,
        panel,
        initialAlignment,
    );

    applyAutoAlignStyles(popover, placementData);
    updateCaretPosition(popover, placementData);
}

/* --------------------------------------------------------------------------
   Event handling
   -------------------------------------------------------------------------- */

function getPopoverState(popover) {
    let state = popoverState.get(popover);

    if (!state) {
        state = {
            initialAlign: resolveInitialAlign(popover),
            lastPointerDownInsideContent: false,
            suppressFocusOutCloseUntil: 0,
            hoverCloseTimer: null,
        };

        popoverState.set(popover, state);
    }

    return state;
}

function suppressFocusOutClose(popover, duration = 500) {
    const state = getPopoverState(popover);

    state.lastPointerDownInsideContent = true;
    state.suppressFocusOutCloseUntil = window.performance.now() + duration;

    window.setTimeout(() => {
        if (
            window.performance.now() >= (state.suppressFocusOutCloseUntil || 0)
        ) {
            state.lastPointerDownInsideContent = false;
        }
    }, duration);
}

function shouldSuppressFocusOutClose(popover) {
    const state = getPopoverState(popover);

    return (
        state.lastPointerDownInsideContent ||
        window.performance.now() <= (state.suppressFocusOutCloseUntil || 0)
    );
}

function isTargetInsidePopoverContent(popover, target) {
    const panel = getPanel(popover);

    return (
        target instanceof Node &&
        panel instanceof HTMLElement &&
        panel.contains(target)
    );
}

function handlePointerDown(popover, event) {
    if (!isTargetInsidePopoverContent(popover, event.target)) {
        return;
    }

    suppressFocusOutClose(popover);
}

function handleContentClick(popover, event) {
    if (!isTargetInsidePopoverContent(popover, event.target)) {
        return;
    }

    suppressFocusOutClose(popover);
}

function handleFocusOut(popover, event) {
    if (!isOpen(popover)) {
        return;
    }

    const relatedTarget = event.relatedTarget;

    if (shouldSuppressFocusOutClose(popover)) {
        return;
    }

    if (!relatedTarget) {
        closePopover(popover);
        return;
    }

    if (!(relatedTarget instanceof Node)) {
        closePopover(popover);
        return;
    }

    if (popover.contains(relatedTarget)) {
        return;
    }

    if (isTargetInDatePickerInsidePopover(popover, relatedTarget)) {
        return;
    }

    const panel = getPanel(popover);

    const isOutsideFloating =
        isAutoAlignEnabled(popover) && panel instanceof HTMLElement
            ? !panel.contains(relatedTarget)
            : true;

    const isFocusableWrapper =
        relatedTarget instanceof Element &&
        typeof relatedTarget.contains === "function" &&
        relatedTarget.contains(popover);

    if (isOutsideFloating && !isFocusableWrapper) {
        closePopover(popover);
    }
}

function handleKeyDown(popover, event) {
    if (event.key !== "Escape") {
        return;
    }

    if (!isOpen(popover)) {
        return;
    }

    event.preventDefault();
    closePopover(popover, { returnFocus: true });
}

function bindTrigger(popover, trigger) {
    const interaction = getInteraction(popover);

    if (interaction === "click") {
        trigger.addEventListener("click", (event) => {
            event.preventDefault();
            togglePopover(popover);
        });

        return;
    }

    if (interaction === "hover") {
        const state = getPopoverState(popover);

        popover.addEventListener("pointerenter", () => {
            if (state.hoverCloseTimer) {
                window.clearTimeout(state.hoverCloseTimer);
                state.hoverCloseTimer = null;
            }

            openPopover(popover);
        });

        popover.addEventListener("pointerleave", () => {
            state.hoverCloseTimer = window.setTimeout(() => {
                closePopover(popover);
            }, 100);
        });

        trigger.addEventListener("focus", () => {
            openPopover(popover);
        });

        return;
    }

    if (interaction === "focus") {
        trigger.addEventListener("focus", () => {
            openPopover(popover);
        });
    }
}

function bindCloseButtons(popover) {
    popover.addEventListener("click", (event) => {
        const target = event.target;

        if (!(target instanceof Element)) {
            return;
        }

        const closeButton = target.closest(CLOSE_SELECTOR);

        if (!closeButton || !popover.contains(closeButton)) {
            return;
        }

        event.preventDefault();
        closePopover(popover, { returnFocus: true });
    });
}

function syncInitialState(popover) {
    const state = getPopoverState(popover);

    state.initialAlign = resolveInitialAlign(popover);

    setAlignmentClasses(popover, state.initialAlign);

    if (isAutoAlignEnabled(popover)) {
        AUTO_ALIGN_CLASSES.forEach((className) => {
            popover.classList.add(className);
        });

        popover.classList.add(AUTOALIGN_ALIAS_CLASS);
    }

    setOpenState(popover, isOpen(popover), {
        syncPanelHidden: true,
        syncMotionState: true,
        clearAutoAlignOnClose: true,
    });

    if (isOpen(popover) && isAutoAlignEnabled(popover)) {
        window.requestAnimationFrame(() => {
            updatePopoverPosition(popover);
        });
    }
}

function bindPopover(popover) {
    if (!(popover instanceof HTMLElement)) {
        return;
    }

    if (popover.hasAttribute(BOUND_ATTR)) {
        syncInitialState(popover);
        return;
    }

    popover.setAttribute(BOUND_ATTR, "true");

    const trigger = getTrigger(popover);
    const panel = getPanel(popover);

    if (trigger instanceof HTMLElement && panel instanceof HTMLElement) {
        if (!panel.id) {
            panel.id = `popover-content-${Math.random()
                .toString(36)
                .slice(2, 10)}`;
        }

        trigger.setAttribute("aria-controls", panel.id);
        bindTrigger(popover, trigger);
    }

    popover.addEventListener("pointerdown", (event) => {
        handlePointerDown(popover, event);
    });

    popover.addEventListener(
        "click",
        (event) => {
            handleContentClick(popover, event);
        },
        true,
    );

    popover.addEventListener("focusout", (event) => {
        handleFocusOut(popover, event);
    });

    popover.addEventListener("keydown", (event) => {
        handleKeyDown(popover, event);
    });

    bindCloseButtons(popover);
    syncInitialState(popover);
}

/* --------------------------------------------------------------------------
   Global listeners
   -------------------------------------------------------------------------- */

function handleDocumentClick(event) {
    const target = event.target;

    if (!(target instanceof Node)) {
        return;
    }

    document.querySelectorAll(POPOVER_SELECTOR).forEach((popover) => {
        if (!(popover instanceof HTMLElement)) {
            return;
        }

        if (!isOpen(popover)) {
            return;
        }

        if (popover.contains(target)) {
            return;
        }

        if (isTargetInDatePickerInsidePopover(popover, target)) {
            return;
        }

        closePopover(popover);
    });
}

function scheduleOpenPopoverUpdates() {
    if (updateFrame !== null) {
        return;
    }

    updateFrame = window.requestAnimationFrame(() => {
        updateFrame = null;

        document.querySelectorAll(POPOVER_SELECTOR).forEach((popover) => {
            if (
                popover instanceof HTMLElement &&
                isOpen(popover) &&
                isAutoAlignEnabled(popover)
            ) {
                updatePopoverPosition(popover);
            }
        });
    });
}

function bindGlobalEvents() {
    if (globalEventsBound) {
        return;
    }

    globalEventsBound = true;
    document.documentElement.setAttribute(GLOBAL_BOUND_ATTR, "true");

    document.addEventListener("click", handleDocumentClick);
    window.addEventListener("resize", scheduleOpenPopoverUpdates);
    window.addEventListener("scroll", scheduleOpenPopoverUpdates, true);
}

/* --------------------------------------------------------------------------
   Public initializer
   -------------------------------------------------------------------------- */

export function initPopovers(root = document) {
    root.querySelectorAll(POPOVER_SELECTOR).forEach(bindPopover);
    bindGlobalEvents();
}

export function openPopoverElement(popover) {
    openPopover(popover);
}

export function closePopoverElement(popover, options = {}) {
    closePopover(popover, options);
}

export function updatePopoverElement(popover) {
    updatePopoverPosition(popover);
}
