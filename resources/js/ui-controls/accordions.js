const prefersReducedMotion = () => window.matchMedia?.('(prefers-reduced-motion: reduce)').matches ?? false;

let accordionFocusClearRegistered = false;

const clearPersistedAccordionFocus = (root = document) => {
    root.querySelectorAll('[data-ui-accordion-trigger][data-ui-accordion-focus="true"]').forEach((trigger) => {
        delete trigger.dataset.uiAccordionFocus;
    });
};

const registerAccordionFocusClear = () => {
    if (accordionFocusClearRegistered) {
        return;
    }

    document.addEventListener('pointerdown', () => clearPersistedAccordionFocus(), true);
    document.addEventListener('keydown', () => clearPersistedAccordionFocus(), true);
    accordionFocusClearRegistered = true;
};

const finishPanelOpen = (panel) => {
    panel.style.blockSize = '';
    panel.dataset.uiAccordionAnimating = 'false';
};

const finishPanelClose = (panel) => {
    if (panel.dataset.uiAccordionPanelOpen === 'false') {
        panel.hidden = true;
    }

    panel.style.blockSize = '';
    panel.dataset.uiAccordionAnimating = 'false';
};

const setAccordionPanelOpen = (trigger, panel, open, animate = true) => {
    trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
    panel.closest('[data-ui-accordion-item]')?.setAttribute('data-ui-accordion-item-open', open ? 'true' : 'false');

    if (open) {
        panel.hidden = false;
        panel.dataset.uiAccordionAnimating = 'true';

        if (!animate || prefersReducedMotion()) {
            panel.dataset.uiAccordionPanelOpen = 'true';
            finishPanelOpen(panel);
            return;
        }

        panel.style.blockSize = '0px';
        panel.dataset.uiAccordionPanelOpen = 'false';

        window.requestAnimationFrame(() => {
            panel.style.blockSize = `${panel.scrollHeight}px`;
            panel.dataset.uiAccordionPanelOpen = 'true';
        });

        panel.addEventListener('transitionend', () => finishPanelOpen(panel), { once: true });
        window.setTimeout(() => finishPanelOpen(panel), 260);

        return;
    }

    panel.dataset.uiAccordionAnimating = 'true';
    panel.style.blockSize = `${panel.scrollHeight}px`;
    panel.dataset.uiAccordionPanelOpen = 'false';

    if (!animate || prefersReducedMotion()) {
        finishPanelClose(panel);
        return;
    }

    const finalizeClose = () => {
        finishPanelClose(panel);
    };

    window.requestAnimationFrame(() => {
        panel.style.blockSize = '0px';
    });

    panel.addEventListener('transitionend', finalizeClose, { once: true });
    window.setTimeout(finalizeClose, 240);
};

export const initAccordions = (root = document) => {
    registerAccordionFocusClear();

    root.querySelectorAll('[data-ui-accordion]').forEach((accordion) => {
        if (accordion.dataset.uiAccordionInit === '1') {
            return;
        }

        accordion.dataset.uiAccordionInit = '1';

        accordion.querySelectorAll('[data-ui-accordion-trigger]').forEach((trigger) => {
            const panelId = trigger.getAttribute('aria-controls');
            const panel = panelId ? accordion.querySelector(`#${CSS.escape(panelId)}`) : null;

            if (!(trigger instanceof HTMLButtonElement) || !(panel instanceof HTMLElement)) {
                return;
            }

            setAccordionPanelOpen(trigger, panel, trigger.getAttribute('aria-expanded') === 'true', false);

            trigger.addEventListener('click', () => {
                if (trigger.disabled) {
                    return;
                }

                clearPersistedAccordionFocus(accordion.ownerDocument);
                trigger.dataset.uiAccordionFocus = 'true';

                const nextOpen = trigger.getAttribute('aria-expanded') !== 'true';

                if (nextOpen && accordion.dataset.uiAccordionMode === 'single') {
                    accordion.querySelectorAll('[data-ui-accordion-trigger][aria-expanded="true"]').forEach((openTrigger) => {
                        const openPanelId = openTrigger.getAttribute('aria-controls');
                        const openPanel = openPanelId ? accordion.querySelector(`#${CSS.escape(openPanelId)}`) : null;

                        if (openTrigger instanceof HTMLButtonElement && openPanel instanceof HTMLElement && openTrigger !== trigger) {
                            setAccordionPanelOpen(openTrigger, openPanel, false);
                        }
                    });
                }

                setAccordionPanelOpen(trigger, panel, nextOpen);
            });
        });
    });
};
