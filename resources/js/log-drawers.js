const formatDrawerPayload = (value) => {
    if (value === null || value === undefined || value === '') {
        return '';
    }

    if (typeof value === 'string') {
        return value;
    }

    try {
        return JSON.stringify(value, null, 2);
    } catch (error) {
        return String(value);
    }
};

const loadDrawerPayload = async (url) => {
    if (!url) {
        return {};
    }

    try {
        const response = await window.fetch(url, {
            headers: {
                Accept: 'application/json',
            },
            credentials: 'same-origin',
        });

        if (!response.ok) {
            return {};
        }

        return await response.json();
    } catch (error) {
        return {};
    }
};

const initLogDrawer = ({
    modalSelector,
    triggerSelector,
    rowSelector,
    closeSelector,
    initKey,
    urlAttribute,
    populate,
}) => {
    const modal = document.querySelector(modalSelector);

    if (!modal || modal.dataset[initKey] === '1') {
        return;
    }

    modal.dataset[initKey] = '1';

    const panel = modal.querySelector('[data-log-drawer-panel]');
    const closeButtons = modal.querySelectorAll(closeSelector);
    let lastFocusedElement = null;

    const openDrawer = (sourceElement) => {
        lastFocusedElement = sourceElement instanceof HTMLElement ? sourceElement : document.activeElement;
        modal.classList.remove('hidden');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');
        panel?.focus();
    };

    const closeDrawer = () => {
        modal.classList.add('hidden');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('overflow-hidden');

        if (lastFocusedElement instanceof HTMLElement) {
            lastFocusedElement.focus();
        }
    };

    const bindTrigger = (element) => {
        if (element.dataset.logDrawerInit === '1') {
            return;
        }

        element.dataset.logDrawerInit = '1';
        element.addEventListener('click', async (event) => {
            event.preventDefault();

            const url = element.dataset[urlAttribute];
            const data = await loadDrawerPayload(url);
            populate(modal, data);
            openDrawer(element);
        });
    };

    document.querySelectorAll(triggerSelector).forEach((element) => {
        bindTrigger(element);
    });

    document.querySelectorAll(rowSelector).forEach((row) => {
        if (row.dataset.logDrawerRowInit === '1') {
            return;
        }

        row.dataset.logDrawerRowInit = '1';
        row.addEventListener('click', async (event) => {
            if (event.target.closest('a, button, input, select, textarea, label, form')) {
                return;
            }

            const url = row.dataset[urlAttribute];
            const data = await loadDrawerPayload(url);
            populate(modal, data);
            openDrawer(row);
        });
    });

    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeDrawer();
        }
    });

    closeButtons.forEach((button) => {
        button.addEventListener('click', closeDrawer);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeDrawer();
        }
    });
};

export const initErrorLogDrawer = () => {
    initLogDrawer({
        modalSelector: '[data-error-log-modal]',
        triggerSelector: '[data-error-log-view]',
        rowSelector: '[data-error-log-row]',
        closeSelector: '[data-error-log-close]',
        initKey: 'errorLogInit',
        urlAttribute: 'errorLogUrl',
        populate: (modal, data) => {
            const setText = (selector, value) => {
                const target = modal.querySelector(selector);

                if (target) {
                    target.textContent = value || '—';
                }
            };

            setText('[data-error-log-title]', data.message);
            setText('[data-error-log-subtitle]', data.exception_class);
            setText('[data-error-log-occurred]', data.occurred_at);
            setText('[data-error-log-severity]', data.severity);
            setText('[data-error-log-handled]', data.handled ? 'Handled' : 'Uncaught');
            setText('[data-error-log-environment]', data.environment);
            setText('[data-error-log-exception]', data.exception_class);
            setText('[data-error-log-code]', data.error_code);
            setText('[data-error-log-file]', data.file_path ? `${data.file_path}:${data.line_number || ''}` : '');
            setText('[data-error-log-route]', data.route);
            setText('[data-error-log-method]', data.method);
            setText('[data-error-log-status]', data.status_code);
            setText('[data-error-log-user]', data.user_id ? `User #${data.user_id}` : 'Guest');
            setText('[data-error-log-request]', data.request_id);
            setText('[data-error-log-trace]', data.trace_id);
            setText('[data-error-log-ip]', data.ip_address);
            setText('[data-error-log-host]', data.hostname);
            setText('[data-error-log-message]', data.message);
            setText('[data-error-log-trace-stack]', formatDrawerPayload(data.stack_trace));
            setText('[data-error-log-context]', formatDrawerPayload(data.context));
        },
    });
};

export const initAuditLogDrawer = () => {
    initLogDrawer({
        modalSelector: '[data-audit-log-modal]',
        triggerSelector: '[data-audit-log-view]',
        rowSelector: '[data-audit-log-row]',
        closeSelector: '[data-audit-log-close]',
        initKey: 'auditLogInit',
        urlAttribute: 'auditLogUrl',
        populate: (modal, data) => {
            const setText = (selector, value) => {
                const target = modal.querySelector(selector);

                if (target) {
                    target.textContent = value || '—';
                }
            };

            const subject = [data.subject_type, data.subject_id].filter(Boolean).join(' #');

            setText('[data-audit-log-title]', data.event_type);
            setText('[data-audit-log-subtitle]', data.actor_label ? `${data.actor_label} • ${data.result}` : data.result);
            setText('[data-audit-log-occurred]', data.occurred_at);
            setText('[data-audit-log-result]', data.result);
            setText('[data-audit-log-severity]', data.severity);
            setText('[data-audit-log-action]', data.action);
            setText('[data-audit-log-actor-name]', data.actor_name || data.actor_label);
            setText('[data-audit-log-actor-email]', data.actor_email);
            setText('[data-audit-log-route]', data.route);
            setText('[data-audit-log-method]', data.method);
            setText('[data-audit-log-request]', data.request_id);
            setText('[data-audit-log-trace]', data.trace_id);
            setText('[data-audit-log-ip]', data.ip_address);
            setText('[data-audit-log-subject]', subject);
            setText('[data-audit-log-metadata]', formatDrawerPayload(data.metadata));
        },
    });
};
