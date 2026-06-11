import { initFilterPanels, initTableSearchInputs } from './ui-controls';
import { initAuditLogDrawer, initErrorLogDrawer } from './log-drawers';

export const initUiReferenceSidebarDisclosures = () => {
    document.querySelectorAll('[data-ui-reference-sidebar-disclosure]').forEach((group) => {
        const trigger = group.querySelector('[data-ui-reference-sidebar-disclosure-trigger]');
        const panel = group.querySelector('[data-ui-reference-sidebar-disclosure-panel]');

        if (!(trigger instanceof HTMLButtonElement) || !(panel instanceof HTMLElement)) {
            return;
        }

        const setOpen = (open) => {
            const state = open ? 'open' : 'closed';

            group.dataset.uiReferenceSidebarDisclosureState = state;
            panel.dataset.uiReferenceSidebarDisclosureState = state;
            panel.hidden = !open;
            trigger.setAttribute('aria-expanded', open ? 'true' : 'false');

            if (group.hasAttribute('data-ui-reference-element-dropdown')) {
                group.dataset.uiReferenceElementDropdownOpen = open ? 'true' : 'false';
            }
        };

        const initialOpen = group.dataset.uiReferenceSidebarDisclosureState === 'open'
            || trigger.getAttribute('aria-expanded') === 'true'
            || !panel.hidden;

        setOpen(initialOpen);

        if (trigger.dataset.uiReferenceSidebarDisclosureInit === '1') {
            return;
        }

        trigger.dataset.uiReferenceSidebarDisclosureInit = '1';
        trigger.addEventListener('click', () => {
            setOpen(trigger.getAttribute('aria-expanded') !== 'true');
        });
    });
};

export const initUiReferenceTablesRemote = () => {
    const root = document.querySelector('[data-ui-reference-tables-root]');

    if (!root || root.dataset.uiReferenceTablesRemoteInit === '1') {
        return;
    }

    root.dataset.uiReferenceTablesRemoteInit = '1';

    const setSectionLoading = (section, isLoading) => {
        const overlay = section?.querySelector('[data-table-loading-overlay]');

        if (!(overlay instanceof HTMLElement)) {
            return;
        }

        overlay.classList.toggle('hidden', !isLoading);
        overlay.classList.toggle('flex', isLoading);
        overlay.setAttribute('aria-hidden', isLoading ? 'false' : 'true');
    };

    const reinitTableRoot = () => {
        initFilterPanels();
        initTableSearchInputs();
        initAuditLogDrawer();
        initErrorLogDrawer();
        initUiReferenceTablesRemote();
    };

    const replaceRoot = async (url, section) => {
        const requestUrl = url instanceof URL ? url : new URL(url, window.location.origin);

        setSectionLoading(section, true);

        try {
            const response = await window.fetch(requestUrl.toString(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin',
            });

            if (!response.ok) {
                window.location.assign(requestUrl.toString());
                return;
            }

            const html = await response.text();
            const documentFragment = new DOMParser().parseFromString(html, 'text/html');
            const nextRoot = documentFragment.querySelector('[data-ui-reference-tables-root]');

            if (!(nextRoot instanceof HTMLElement)) {
                window.location.assign(requestUrl.toString());
                return;
            }

            root.replaceWith(nextRoot);
            window.history.replaceState({}, '', requestUrl.toString());
            reinitTableRoot();
        } catch (error) {
            window.location.assign(requestUrl.toString());
        } finally {
            setSectionLoading(section, false);
        }
    };

    root.querySelectorAll('form[method="GET"]').forEach((form) => {
        if (form.dataset.uiReferenceTableFormInit === '1') {
            return;
        }

        form.dataset.uiReferenceTableFormInit = '1';
        form.addEventListener('submit', (event) => {
            event.preventDefault();

            const action = form.getAttribute('action') || window.location.href;
            const url = new URL(action, window.location.origin);
            const formData = new FormData(form);

            url.search = new URLSearchParams(formData).toString();

            replaceRoot(url, form.closest('[data-table-section]'));
        });
    });

    root.querySelectorAll('a.ui-pagination-control, a.ui-table-sort').forEach((link) => {
        if (link.dataset.uiReferenceTableLinkInit === '1') {
            return;
        }

        link.dataset.uiReferenceTableLinkInit = '1';
        link.addEventListener('click', (event) => {
            event.preventDefault();
            replaceRoot(link.href, link.closest('[data-table-section]'));
        });
    });
};

export const initUiReferenceComponentTabs = () => {
    document.querySelectorAll('[data-ui-reference-tabs]').forEach((tabRoot) => {
        if (tabRoot.dataset.uiReferenceTabsInit === '1') {
            return;
        }

        tabRoot.dataset.uiReferenceTabsInit = '1';

        const tabs = Array.from(tabRoot.querySelectorAll('[role="tab"]'));
        const panels = Array.from(tabRoot.querySelectorAll('[role="tabpanel"]'));

        const activateTab = (activeTab) => {
            tabs.forEach((tab) => {
                const isActive = tab === activeTab;
                const panelId = tab.getAttribute('aria-controls');
                const panel = panelId ? tabRoot.querySelector(`#${CSS.escape(panelId)}`) : null;

                tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
                tab.tabIndex = isActive ? 0 : -1;

                if (panel instanceof HTMLElement) {
                    panel.hidden = !isActive;
                }
            });
        };

        tabs.forEach((tab, index) => {
            tab.addEventListener('click', () => activateTab(tab));

            tab.addEventListener('keydown', (event) => {
                if (!['ArrowLeft', 'ArrowRight', 'Home', 'End'].includes(event.key)) {
                    return;
                }

                event.preventDefault();

                const nextIndex = event.key === 'Home'
                    ? 0
                    : event.key === 'End'
                        ? tabs.length - 1
                        : event.key === 'ArrowRight'
                            ? (index + 1) % tabs.length
                            : (index - 1 + tabs.length) % tabs.length;
                const nextTab = tabs[nextIndex];

                nextTab?.focus();
                nextTab && activateTab(nextTab);
            });
        });

        panels.forEach((panel, index) => {
            panel.hidden = index !== 0;
        });

        if (tabs[0] instanceof HTMLElement) {
            activateTab(tabs[0]);
        }
    });
};

export const initUiReferenceOverlayDemos = () => {
    const prefersReducedMotion = window.matchMedia?.('(prefers-reduced-motion: reduce)').matches ?? false;
    const generatedToastTimers = new WeakMap();

    const clearGeneratedToastTimer = (toast) => {
        const timeoutId = generatedToastTimers.get(toast);

        if (timeoutId) {
            window.clearTimeout(timeoutId);
            generatedToastTimers.delete(toast);
        }
    };

    const scheduleGeneratedToastDismiss = (toast) => {
        if (!(toast instanceof HTMLElement) || !toast.hasAttribute('data-ui-demo-generated-toast')) {
            return;
        }

        clearGeneratedToastTimer(toast);

        const timeoutId = window.setTimeout(() => {
            animateToastVisibility(toast, false);
        }, 16000);

        generatedToastTimers.set(toast, timeoutId);
    };

    const animateToastVisibility = (toast, makeVisible) => {
        if (!(toast instanceof HTMLElement)) {
            return;
        }

        if (prefersReducedMotion) {
            if (makeVisible) {
                toast.classList.remove('hidden');
                scheduleGeneratedToastDismiss(toast);
                return;
            }

            clearGeneratedToastTimer(toast);

            if (toast.hasAttribute('data-ui-demo-generated-toast')) {
                toast.remove();
                return;
            }

            toast.classList.add('hidden');
            toast.classList.remove('is-entering', 'is-exiting');
            return;
        }

        const finalizeVisible = () => {
            toast.classList.remove('is-entering');
            scheduleGeneratedToastDismiss(toast);
        };

        const finalizeHidden = () => {
            if (toast.hasAttribute('data-ui-demo-generated-toast')) {
                toast.remove();
            } else {
                toast.classList.add('hidden');
            }
            toast.classList.remove('is-exiting');
        };

        if (makeVisible) {
            clearGeneratedToastTimer(toast);
            toast.classList.remove('hidden', 'is-exiting');
            toast.classList.add('is-entering');
            requestAnimationFrame(() => {
                requestAnimationFrame(finalizeVisible);
            });
            return;
        }

        clearGeneratedToastTimer(toast);
        toast.classList.add('is-exiting');
        window.setTimeout(finalizeHidden, 170);
    };

    const bindToastDismissButtons = (root) => {
        root.querySelectorAll('[data-ui-demo-toast-dismiss]').forEach((button) => {
            if (button.dataset.uiDemoToastDismissInit === '1') {
                return;
            }

            button.dataset.uiDemoToastDismissInit = '1';
            button.addEventListener('click', () => {
                const toast = button.closest('[data-ui-demo-toast]');

                clearGeneratedToastTimer(toast);
                animateToastVisibility(toast, false);
            });
        });
    };

    document.querySelectorAll('[data-ui-demo-overlay]').forEach((overlay) => {
        if (overlay.dataset.uiDemoOverlayInit === '1') {
            return;
        }

        overlay.dataset.uiDemoOverlayInit = '1';

        const overlayKey = overlay.dataset.uiDemoOverlay;
        const panel = overlay.querySelector('[data-ui-demo-panel]');
        const closeButtons = overlay.querySelectorAll('[data-ui-demo-close]');
        let lastFocusedElement = null;

        const setOpen = (open) => {
            overlay.classList.toggle('hidden', !open);
            overlay.setAttribute('aria-hidden', open ? 'false' : 'true');
            document.body.classList.toggle('overflow-hidden', open);

            if (open) {
                panel?.focus();
                return;
            }

            if (lastFocusedElement instanceof HTMLElement) {
                lastFocusedElement.focus();
            }
        };

        document.querySelectorAll(`[data-ui-demo-overlay-open="${overlayKey}"]`).forEach((trigger) => {
            if (trigger.dataset.uiDemoOverlayTriggerInit === '1') {
                return;
            }

            trigger.dataset.uiDemoOverlayTriggerInit = '1';
            trigger.addEventListener('click', (event) => {
                event.preventDefault();
                lastFocusedElement = trigger;
                setOpen(true);
            });
        });

        closeButtons.forEach((button) => {
            button.addEventListener('click', () => setOpen(false));
        });

        overlay.addEventListener('click', (event) => {
            if (event.target === overlay) {
                setOpen(false);
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !overlay.classList.contains('hidden')) {
                setOpen(false);
            }
        });
    });

    bindToastDismissButtons(document);

    document.querySelectorAll('[data-ui-demo-toast-reset]').forEach((button) => {
        if (button.dataset.uiDemoToastResetInit === '1') {
            return;
        }

        button.dataset.uiDemoToastResetInit = '1';
        button.addEventListener('click', () => {
            const root = button.closest('[data-ui-demo-toast-root]');

            root?.querySelectorAll('[data-ui-demo-toast-stack] [data-ui-demo-toast]').forEach((toast) => {
                animateToastVisibility(toast, true);
            });

            root?.querySelectorAll('[data-ui-demo-generated-toast]').forEach((toast) => {
                clearGeneratedToastTimer(toast);
                toast.remove();
            });
        });
    });

    document.querySelectorAll('[data-ui-demo-toast-generate]').forEach((button) => {
        if (button.dataset.uiDemoToastGenerateInit === '1') {
            return;
        }

        button.dataset.uiDemoToastGenerateInit = '1';
        button.addEventListener('click', () => {
            const root = button.closest('[data-ui-demo-toast-root]');
            const stack = document.querySelector('[data-ui-demo-toast-generated-stack]');
            const template = root?.querySelector('[data-ui-demo-toast-template]');

            if (!(stack instanceof HTMLElement) || !(template instanceof HTMLTemplateElement)) {
                return;
            }

            const nextToast = template.content.firstElementChild?.cloneNode(true);

            if (!(nextToast instanceof HTMLElement)) {
                return;
            }

            stack.prepend(nextToast);
            bindToastDismissButtons(nextToast);
            animateToastVisibility(nextToast, true);
        });
    });
};
