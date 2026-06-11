const focusableSelector = 'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])';
const viewportMargin = 16;

const getParts = (tooltip) => {
    const triggerWrapper = tooltip.querySelector('[data-ui-tooltip-trigger]');
    const content = tooltip.querySelector('[data-ui-tooltip-content]');
    const trigger = triggerWrapper?.querySelector(focusableSelector) ?? triggerWrapper;

    if (!(triggerWrapper instanceof HTMLElement) || !(content instanceof HTMLElement) || !(trigger instanceof HTMLElement)) {
        return null;
    }

    return { triggerWrapper, trigger, content };
};

const setState = (tooltip, open) => {
    const parts = getParts(tooltip);

    if (!parts) {
        return;
    }

    const state = open ? 'open' : 'closed';

    tooltip.dataset.uiTooltipState = state;
    parts.content.dataset.uiTooltipState = state;
    parts.content.hidden = !open;
    parts.content.setAttribute('aria-hidden', open ? 'false' : 'true');

    if (open) {
        resolvePlacement(tooltip, parts);
    }
};

const fitsViewport = (rect) => (
    rect.top >= viewportMargin
    && rect.left >= viewportMargin
    && rect.bottom <= window.innerHeight - viewportMargin
    && rect.right <= window.innerWidth - viewportMargin
);

const resolvePlacement = (tooltip, parts = getParts(tooltip)) => {
    if (!parts) {
        return;
    }

    const requested = tooltip.dataset.uiTooltipPlacement || 'auto';

    if (window.innerWidth < 640) {
        tooltip.dataset.uiTooltipResolvedPlacement = 'bottom';
        return;
    }

    if (requested !== 'auto') {
        tooltip.dataset.uiTooltipResolvedPlacement = requested;
        return;
    }

    const placements = ['top', 'bottom', 'right', 'left'];

    for (const placement of placements) {
        tooltip.dataset.uiTooltipResolvedPlacement = placement;

        if (fitsViewport(parts.content.getBoundingClientRect())) {
            return;
        }
    }

    tooltip.dataset.uiTooltipResolvedPlacement = placements[0] ?? 'bottom';
};

const openTooltip = (tooltip) => setState(tooltip, true);
const closeTooltip = (tooltip) => setState(tooltip, false);

export function initTooltips(root = document) {
    root.querySelectorAll('[data-ui-tooltip]').forEach((tooltip) => {
        if (!(tooltip instanceof HTMLElement) || tooltip.dataset.uiTooltipInitialized === 'true') {
            return;
        }

        const parts = getParts(tooltip);

        if (!parts) {
            return;
        }

        tooltip.dataset.uiTooltipInitialized = 'true';

        const tooltipId = parts.content.id || parts.content.dataset.uiTooltipId;

        if (tooltipId) {
            parts.trigger.setAttribute('aria-describedby', tooltipId);
        }

        if (tooltip.dataset.uiTooltipState === 'open') {
            parts.content.hidden = false;
            parts.content.setAttribute('aria-hidden', 'false');
            parts.content.dataset.uiTooltipState = 'open';
            resolvePlacement(tooltip, parts);
        }

        parts.triggerWrapper.addEventListener('pointerenter', () => openTooltip(tooltip));
        tooltip.addEventListener('pointerleave', () => closeTooltip(tooltip));
        parts.trigger.addEventListener('focus', () => openTooltip(tooltip));
        parts.trigger.addEventListener('blur', () => closeTooltip(tooltip));

        tooltip.addEventListener('keydown', (event) => {
            if (event.key !== 'Escape') {
                return;
            }

            event.preventDefault();
            closeTooltip(tooltip);
        });
    });
}
