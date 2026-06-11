const closePopover = (component, returnFocus = false) => {
    const trigger = component.querySelector('[data-ui-popover-trigger]');
    const panel = component.querySelector('[data-ui-popover-panel]');

    if (!trigger || !panel) {
        return;
    }

    trigger.setAttribute('aria-expanded', 'false');
    panel.hidden = true;

    if (returnFocus) {
        trigger.focus();
    }
};

const openPopover = (component) => {
    const trigger = component.querySelector('[data-ui-popover-trigger]');
    const panel = component.querySelector('[data-ui-popover-panel]');

    if (!trigger || !panel) {
        return;
    }

    trigger.setAttribute('aria-expanded', 'true');
    panel.hidden = false;
    panel.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])')?.focus();
};

export function initPopovers(root = document) {
    root.querySelectorAll('[data-ui-popover]').forEach((component) => {
        if (component.dataset.uiPopoverInitialized === 'true') {
            return;
        }

        component.dataset.uiPopoverInitialized = 'true';

        component.querySelector('[data-ui-popover-trigger]')?.addEventListener('click', () => {
            const trigger = component.querySelector('[data-ui-popover-trigger]');

            if (trigger?.getAttribute('aria-expanded') === 'true') {
                closePopover(component);
            } else {
                openPopover(component);
            }
        });

        component.querySelector('[data-ui-popover-close]')?.addEventListener('click', () => {
            closePopover(component, true);
        });

        component.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closePopover(component, true);
            }
        });
    });

    if (document.documentElement.dataset.uiPopoversDocumentListener !== 'true') {
        document.documentElement.dataset.uiPopoversDocumentListener = 'true';

        document.addEventListener('click', (event) => {
            document.querySelectorAll('[data-ui-popover]').forEach((component) => {
                if (!component.contains(event.target)) {
                    closePopover(component);
                }
            });
        });
    }
}
