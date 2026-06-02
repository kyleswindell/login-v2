import './bootstrap';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import './setup-sidebar';
import './table-enhance';
import './dashboard-sort';
import './dashboard-proof-demo';

const allowedThemeModes = new Set(['system', 'dark', 'light']);

const resolveThemeMode = (mode) => {
    if (mode === 'dark' || mode === 'light') {
        return mode;
    }

    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
};

const getPreferredThemeMode = () => {
    const storedMode = window.localStorage.getItem('platform.theme.mode');

    if (allowedThemeModes.has(storedMode)) {
        return storedMode;
    }

    const datasetMode = document.documentElement.dataset.themeMode;

    return allowedThemeModes.has(datasetMode) ? datasetMode : 'system';
};

const applyThemeMode = (mode, persistLocal = true) => {
    const normalized = allowedThemeModes.has(mode) ? mode : 'system';
    const resolved = resolveThemeMode(normalized);
    const root = document.documentElement;

    root.dataset.themeMode = normalized;
    root.dataset.themeResolved = resolved;
    root.classList.toggle('dark', resolved === 'dark');
    root.style.backgroundColor = resolved === 'light' ? 'rgb(248 250 252)' : 'rgb(9 9 11)';
    root.style.color = resolved === 'light' ? 'rgb(15 23 42)' : 'rgb(241 245 249)';

    if (document.body) {
        document.body.style.backgroundColor = resolved === 'light' ? 'rgb(248 250 252)' : 'rgb(9 9 11)';
        document.body.style.color = resolved === 'light' ? 'rgb(15 23 42)' : 'rgb(241 245 249)';
    }

    if (persistLocal) {
        window.localStorage.setItem('platform.theme.mode', normalized);
    }

    document.querySelectorAll('[data-theme-mode-toggle]').forEach((button) => {
        const isActive = button.dataset.themeMode === normalized;
        button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
        button.dataset.uiCurrent = isActive ? 'true' : 'false';
    });
};

const persistThemePreference = (mode) => {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const url = document.body?.dataset.themeUpdateUrl;

    if (!url || !token) {
        return;
    }

    window.fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
            'X-CSRF-TOKEN': token,
            Accept: 'application/json',
        },
        body: new URLSearchParams({
            theme_preference: mode,
        }),
        credentials: 'same-origin',
    }).catch(() => {});
};

const initThemeModeControls = () => {
    if (document.body?.dataset.themeControlsInit === '1') {
        applyThemeMode(getPreferredThemeMode(), false);
        return;
    }

    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');

    mediaQuery.addEventListener('change', () => {
        if ((document.documentElement.dataset.themeMode || 'system') === 'system') {
            applyThemeMode('system', false);
        }
    });

    document.body.dataset.themeControlsInit = '1';

    document.addEventListener('click', (event) => {
        const button = event.target.closest('[data-theme-mode-toggle]');

        if (!button) {
            return;
        }

        event.preventDefault();
        const mode = allowedThemeModes.has(button.dataset.themeMode) ? button.dataset.themeMode : 'system';
        applyThemeMode(mode);
        persistThemePreference(mode);
    });

    applyThemeMode(getPreferredThemeMode(), false);
};

const initFilterPanels = () => {
    document.querySelectorAll('[data-filter-toggle]').forEach((toggle) => {
        if (toggle.dataset.filterToggleInit === '1') {
            return;
        }
        toggle.dataset.filterToggleInit = '1';

        const panel = toggle.closest('section')?.querySelector('[data-filter-panel]')
            ?? document.querySelector('[data-filter-panel]');

        if (!panel) {
            return;
        }

        const syncExpandedState = () => {
            toggle.setAttribute('aria-expanded', panel.classList.contains('hidden') ? 'false' : 'true');
        };

        const setOpen = (open) => {
            panel.classList.toggle('hidden', !open);
            syncExpandedState();
        };

        syncExpandedState();

        toggle.addEventListener('click', () => {
            setOpen(panel.classList.contains('hidden'));
        });

        document.addEventListener('click', (event) => {
            if (panel.classList.contains('hidden')) {
                return;
            }

            if (toggle.contains(event.target) || panel.contains(event.target)) {
                return;
            }

            setOpen(false);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !panel.classList.contains('hidden')) {
                setOpen(false);
            }
        });
    });
};

const syncSelectableOptionStates = (scope = document) => {
    scope.querySelectorAll('.ui-selectable-option').forEach((option) => {
        const input = option.querySelector('input[type="checkbox"], input[type="radio"]');

        if (!(input instanceof HTMLInputElement)) {
            return;
        }

        option.classList.toggle('is-selected', input.checked);
    });
};

const initSelectableOptionStates = () => {
    if (document.body?.dataset.selectableOptionStateInit !== '1') {
        document.body.dataset.selectableOptionStateInit = '1';

        document.addEventListener('change', (event) => {
            const input = event.target.closest('.ui-selectable-option input[type="checkbox"], .ui-selectable-option input[type="radio"]');

            if (!(input instanceof HTMLInputElement)) {
                return;
            }

            const fieldset = input.closest('fieldset');

            if (input.type === 'radio' && input.name) {
                const scope = fieldset ?? document;

                scope.querySelectorAll(`input[type="radio"][name="${CSS.escape(input.name)}"]`).forEach((radio) => {
                    const option = radio.closest('.ui-selectable-option');

                    if (option) {
                        option.classList.toggle('is-selected', radio.checked);
                    }
                });

                return;
            }

            const option = input.closest('.ui-selectable-option');

            if (option) {
                option.classList.toggle('is-selected', input.checked);
            }
        });
    }

    syncSelectableOptionStates(document);
};

const initSearchableSelects = () => {
    document.querySelectorAll('[data-ui-searchable-select]').forEach((root) => {
        if (root.dataset.uiSearchableSelectInit === '1') {
            return;
        }

        const trigger = root.querySelector('[data-ui-searchable-select-trigger]');
        const triggerText = root.querySelector('[data-ui-searchable-select-trigger-text]');
        const panel = root.querySelector('[data-ui-searchable-select-panel]');
        const filterInput = root.querySelector('[data-ui-searchable-select-filter]');
        const hiddenInput = root.querySelector('[data-ui-searchable-select-value]');
        const emptyState = root.querySelector('[data-ui-searchable-select-empty]');
        const optionButtons = Array.from(root.querySelectorAll('[data-ui-searchable-select-option]'));

        if (
            !(trigger instanceof HTMLButtonElement)
            || !(panel instanceof HTMLElement)
            || !(filterInput instanceof HTMLInputElement)
            || !(hiddenInput instanceof HTMLInputElement)
            || optionButtons.length === 0
        ) {
            return;
        }

        root.dataset.uiSearchableSelectInit = '1';

        const emptyLabel = root.dataset.uiSearchableSelectEmptyLabel || 'No matching options';
        const placeholder = trigger.dataset.uiSearchableSelectLabel || 'Select an option';

        const closePanel = ({ restoreFocus = false, clearSearch = true } = {}) => {
            panel.classList.add('hidden');
            trigger.setAttribute('aria-expanded', 'false');

            if (clearSearch && filterInput.value !== '') {
                filterInput.value = '';
                renderOptions();
            }

            if (restoreFocus) {
                trigger.focus();
            }
        };

        const openPanel = () => {
            panel.classList.remove('hidden');
            trigger.setAttribute('aria-expanded', 'true');
            window.requestAnimationFrame(() => {
                filterInput.focus();
                filterInput.select();
            });
        };

        const syncSelectedState = () => {
            const selectedValue = hiddenInput.value;
            const selectedButton = optionButtons.find((option) => option.dataset.value === selectedValue);

            optionButtons.forEach((option) => {
                const isSelected = option.dataset.value === selectedValue;
                option.setAttribute('aria-selected', isSelected ? 'true' : 'false');

                const existingIcons = Array.from(option.querySelectorAll('[data-ui-searchable-select-check]'));
                const [existingIcon, ...duplicateIcons] = existingIcons;

                if (isSelected && !existingIcon) {
                    option.insertAdjacentHTML('beforeend', `
                        <svg data-ui-searchable-select-check xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 shrink-0" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.704 5.29a1 1 0 0 1 .006 1.414l-7.25 7.313a1 1 0 0 1-1.42 0L3.29 9.268a1 1 0 1 1 1.414-1.414l4.046 4.045 6.543-6.609a1 1 0 0 1 1.41 0Z" clip-rule="evenodd" />
                        </svg>
                    `);
                }

                if (!isSelected) {
                    existingIcons.forEach((icon) => icon.remove());
                }

                duplicateIcons.forEach((icon) => icon.remove());

                if (isSelected && existingIcon instanceof HTMLElement) {
                    option.appendChild(existingIcon);
                }
            });

            if (triggerText instanceof HTMLElement) {
                triggerText.textContent = selectedButton?.dataset.label || placeholder;
            }
        };

        const renderOptions = () => {
            const query = filterInput.value.trim().toLowerCase();
            let visibleCount = 0;

            optionButtons.forEach((option) => {
                const haystack = `${option.dataset.label || ''} ${option.dataset.value || ''}`.toLowerCase();
                const visible = query === '' || haystack.includes(query);
                option.classList.toggle('hidden', !visible);

                if (visible) {
                    visibleCount += 1;
                }
            });

            if (!(emptyState instanceof HTMLElement)) {
                return;
            }

            emptyState.classList.toggle('hidden', visibleCount > 0);
            emptyState.textContent = emptyLabel;
        };

        trigger.addEventListener('click', () => {
            const isOpen = !panel.classList.contains('hidden');

            if (isOpen) {
                closePanel({ restoreFocus: false });
                return;
            }

            document.querySelectorAll('[data-ui-searchable-select-panel]').forEach((otherPanel) => {
                if (!(otherPanel instanceof HTMLElement) || otherPanel === panel) {
                    return;
                }

                otherPanel.classList.add('hidden');
                const otherTrigger = otherPanel.parentElement?.querySelector('[data-ui-searchable-select-trigger]');

                if (otherTrigger instanceof HTMLElement) {
                    otherTrigger.setAttribute('aria-expanded', 'false');
                }
            });

            openPanel();
        });

        optionButtons.forEach((option) => {
            option.addEventListener('click', () => {
                hiddenInput.value = option.dataset.value || '';
                syncSelectedState();
                closePanel({ restoreFocus: true });
            });
        });

        filterInput.addEventListener('input', renderOptions);
        filterInput.addEventListener('keydown', (event) => {
            if (event.key !== 'Escape') {
                return;
            }

            closePanel({ restoreFocus: true });
        });

        document.addEventListener('click', (event) => {
            if (!(event.target instanceof HTMLElement) || root.contains(event.target)) {
                return;
            }

            closePanel();
        });

        document.addEventListener('focusin', (event) => {
            if (!(event.target instanceof HTMLElement) || root.contains(event.target)) {
                return;
            }

            closePanel();
        });

        syncSelectedState();
        renderOptions();
    });
};

const formatPartialInternalPhoneNumber = (digits) => {
    if (digits.length <= 3) {
        return `(${digits}`;
    }

    if (digits.length <= 6) {
        return `(${digits.slice(0, 3)}) ${digits.slice(3)}`;
    }

    return `(${digits.slice(0, 3)}) ${digits.slice(3, 6)}-${digits.slice(6, 10)}`;
};

const normalizePhoneInputValue = (value) => {
    const normalizedWhitespace = value.trim().replace(/\s+/g, ' ');

    if (normalizedWhitespace === '') {
        return '';
    }

    const extensionMatch = normalizedWhitespace.match(/(?:ext\.?|extension|x)\s*(\d+)$/i);
    const extension = extensionMatch ? extensionMatch[1] : '';
    const baseValue = extensionMatch
        ? normalizedWhitespace.slice(0, normalizedWhitespace.length - extensionMatch[0].length).trim()
        : normalizedWhitespace;

    if (/[A-Za-z]/.test(baseValue)) {
        return normalizedWhitespace;
    }

    let digits = baseValue.replace(/\D+/g, '');

    if (digits.length > 10 && digits.startsWith('1')) {
        digits = digits.slice(1);
    }

    if (digits === '') {
        return normalizedWhitespace;
    }

    if (digits.length > 10) {
        return normalizedWhitespace;
    }

    const formatted = formatPartialInternalPhoneNumber(digits);

    return extension ? `${formatted} x${extension}` : formatted;
};

const initInternalPhoneInputs = () => {
    document.querySelectorAll('[data-ui-phone-input]').forEach((input) => {
        if (!(input instanceof HTMLInputElement) || input.dataset.uiPhoneInputInit === '1') {
            return;
        }

        input.dataset.uiPhoneInputInit = '1';

        const syncFormattedValue = () => {
            const normalized = normalizePhoneInputValue(input.value);

            if (normalized !== input.value) {
                input.value = normalized;
            }
        };

        input.addEventListener('input', syncFormattedValue);
        input.addEventListener('blur', syncFormattedValue);
        syncFormattedValue();
    });
};

const closeOpenDropdownActionMenus = (exception = null) => {
    document.querySelectorAll('[data-ui-pattern="dropdown-action-menu"][open]').forEach((menu) => {
        if (exception instanceof HTMLElement && menu === exception) {
            return;
        }

        menu.removeAttribute('open');
    });
};

const initDropdownActionMenus = () => {
    if (document.body?.dataset.dropdownActionMenuInit !== '1') {
        document.body.dataset.dropdownActionMenuInit = '1';

        document.addEventListener('click', (event) => {
            const target = event.target;
            const menu = target instanceof HTMLElement
                ? target.closest('[data-ui-pattern="dropdown-action-menu"]')
                : null;
            const summary = target instanceof HTMLElement ? target.closest('summary') : null;

            if (summary && menu instanceof HTMLElement) {
                window.requestAnimationFrame(() => {
                    closeOpenDropdownActionMenus(menu.hasAttribute('open') ? menu : null);
                });

                return;
            }

            if (menu instanceof HTMLElement) {
                return;
            }

            closeOpenDropdownActionMenus();
        });

        document.addEventListener('focusin', (event) => {
            const target = event.target;

            if (target instanceof HTMLElement && target.closest('[data-ui-pattern="dropdown-action-menu"]')) {
                return;
            }

            closeOpenDropdownActionMenus();
        });

        document.addEventListener('keydown', (event) => {
            if (event.key !== 'Escape') {
                return;
            }

            const openMenus = Array.from(document.querySelectorAll('[data-ui-pattern="dropdown-action-menu"][open]'));

            if (openMenus.length === 0) {
                return;
            }

            const activeMenu = openMenus.at(-1);
            closeOpenDropdownActionMenus();
            activeMenu?.querySelector('summary')?.focus();
        });

        document.addEventListener('toggle', (event) => {
            const target = event.target;

            if (!(target instanceof HTMLDetailsElement) || target.dataset.uiPattern !== 'dropdown-action-menu') {
                return;
            }

            if (!target.open) {
                return;
            }

            closeOpenDropdownActionMenus(target);
        }, true);
    }

    document.querySelectorAll('[data-ui-pattern="dropdown-action-menu"]').forEach((menu) => {
        if (!(menu instanceof HTMLDetailsElement)) {
            return;
        }

        const summary = menu.querySelector('summary');

        if (summary instanceof HTMLElement && !summary.hasAttribute('aria-haspopup')) {
            summary.setAttribute('aria-haspopup', 'menu');
        }
    });
};

const initTableSearchInputs = () => {
    document.querySelectorAll('[data-table-search-form]').forEach((form) => {
        if (form.dataset.tableSearchInit === '1') {
            return;
        }
        form.dataset.tableSearchInit = '1';

        const input = form.querySelector('[data-table-search-input]');
        const clearButton = form.querySelector('[data-table-search-clear]');
        const resetButton = form.querySelector('[data-table-search-reset]');

        if (!input || !clearButton || !resetButton) {
            return;
        }

        const initialValue = (input.dataset.initialSearch || '').trim();

        const setButtonVisible = (button, visible) => {
            button.classList.toggle('hidden', !visible);
            button.classList.toggle('inline-flex', visible);
            button.setAttribute('aria-hidden', visible ? 'false' : 'true');
        };

        const syncButtons = () => {
            const currentValue = input.value.trim();
            const hasAppliedValue = initialValue.length > 0;
            const hasCurrentValue = currentValue.length > 0;
            const isDirty = currentValue !== initialValue;

            setButtonVisible(clearButton, hasCurrentValue && (!hasAppliedValue || isDirty));
            setButtonVisible(resetButton, hasAppliedValue && !isDirty);
        };

        clearButton.addEventListener('click', () => {
            input.value = '';
            syncButtons();
            input.focus();
        });

        resetButton.addEventListener('click', () => {
            input.value = '';
            form.submit();
        });

        input.addEventListener('input', syncButtons);
        input.addEventListener('keydown', (event) => {
            if (event.key !== 'Escape') {
                return;
            }

            input.value = '';
            syncButtons();
            input.blur();
        });

        syncButtons();
    });
};

const initUiReferenceTablesRemote = () => {
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

const initErrorLogDrawer = () => {
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

const initAuditLogDrawer = () => {
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

const initSidebarToggle = () => {
    const root = document.documentElement;
    const body = document.body;

    const isMobile = () => window.innerWidth < 1024;
    const getSidebar = () => document.querySelector('[data-sidebar-panel]');
    const getBackdrop = () => document.querySelector('[data-sidebar-backdrop]');
    const isOpen = () => root.dataset.sidebarMobileOpen === '1';

    const updateToggleAffordances = () => {
        const open = isMobile() && isOpen();
        const icon = open ? '✕' : '☰';

        document.querySelectorAll('[data-sidebar-toggle]').forEach((toggle) => {
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });

        document.querySelectorAll('[data-sidebar-toggle-icon]').forEach((target) => {
            target.textContent = icon;
        });
    };

    const renderSidebar = () => {
        const sidebar = getSidebar();
        const backdrop = getBackdrop();

        if (!sidebar) {
            return;
        }

        const mobile = isMobile();
        const open = mobile && isOpen();
        const shouldShow = mobile ? open : true;

        root.classList.toggle('sidebar-open', open);
        sidebar.classList.toggle('hidden', !shouldShow);
        sidebar.style.display = '';

        if (backdrop) {
            backdrop.classList.toggle('hidden', !open);
        }

        if (body) {
            body.classList.toggle('overflow-hidden', open);
        }
        updateToggleAffordances();
    };

    const setOpen = (isOpen) => {
        root.dataset.sidebarMobileOpen = isMobile() && isOpen ? '1' : '0';
        renderSidebar();
    };

    if (body && body.dataset.sidebarEventsInit !== '1') {
        body.dataset.sidebarEventsInit = '1';

        document.addEventListener('click', (event) => {
            const toggle = event.target.closest('[data-sidebar-toggle]');
            if (toggle) {
                if (!isMobile()) {
                    return;
                }
                event.preventDefault();
                setOpen(!isOpen());
                return;
            }

            const backdrop = event.target.closest('[data-sidebar-backdrop]');
            if (backdrop && isMobile()) {
                setOpen(false);
                return;
            }

            if (!isMobile()) {
                return;
            }

            const navigationTarget = event.target.closest('[data-main-nav-link], [data-setup-nav-link], a[href], button[type="submit"], input[type="submit"]');
            if (navigationTarget) {
                setOpen(false);
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && isMobile() && isOpen()) {
                setOpen(false);
            }
        });

        window.addEventListener('resize', () => {
            if (!isMobile()) {
                setOpen(false);
                return;
            }
            renderSidebar();
        });

        document.addEventListener('livewire:navigating', () => {
            setOpen(false);
        });
    }

    if (!isMobile()) {
        root.dataset.sidebarMobileOpen = '0';
    }
    renderSidebar();
};

const initNotificationMenus = () => {
    document.querySelectorAll('[data-notification-menu]').forEach((menu) => {
        if (menu.dataset.notificationMenuInit === '1') {
            return;
        }
        menu.dataset.notificationMenuInit = '1';

        const trigger = menu.querySelector('[data-notification-trigger]');
        const panel = menu.querySelector('[data-notification-panel]');

        if (!trigger || !panel) {
            return;
        }

        let pinnedOpen = false;
        let hoverCloseTimeout;

        const setOpen = (open) => {
            panel.classList.toggle('hidden', !open);
            trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
        };

        const clearHoverClose = () => {
            if (hoverCloseTimeout) {
                window.clearTimeout(hoverCloseTimeout);
                hoverCloseTimeout = undefined;
            }
        };

        const closeIfTransient = () => {
            if (!pinnedOpen) {
                setOpen(false);
            }
        };

        const scheduleTransientClose = () => {
            clearHoverClose();

            hoverCloseTimeout = window.setTimeout(() => {
                closeIfTransient();
            }, 120);
        };

        [trigger, panel].forEach((element) => {
            element.addEventListener('mouseenter', () => {
                clearHoverClose();

                if (!pinnedOpen) {
                    setOpen(true);
                }
            });
        });

        trigger.addEventListener('mouseenter', () => {
            if (!pinnedOpen) {
                setOpen(true);
            }
        });

        trigger.addEventListener('mouseleave', scheduleTransientClose);
        panel.addEventListener('mouseleave', scheduleTransientClose);

        trigger.addEventListener('click', (event) => {
            event.preventDefault();
            clearHoverClose();
            pinnedOpen = !pinnedOpen;
            setOpen(pinnedOpen);
        });

        document.addEventListener('click', (event) => {
            if (!menu.contains(event.target)) {
                clearHoverClose();
                pinnedOpen = false;
                setOpen(false);
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                clearHoverClose();
                pinnedOpen = false;
                setOpen(false);
            }
        });
    });
};

const initAccountMenu = () => {
    const menu = document.querySelector('[data-account-menu]');
    if (!menu) {
        return;
    }
    if (menu.dataset.accountMenuInit === '1') {
        return;
    }
    menu.dataset.accountMenuInit = '1';

    const closeMenu = () => {
        menu.removeAttribute('open');
    };

    document.addEventListener('click', (event) => {
        if (!menu.contains(event.target)) {
            closeMenu();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeMenu();
        }
    });
};

const initDocsTree = () => {
    const tree = document.querySelector('[data-docs-tree]');
    if (!tree) {
        return;
    }

    const selectedPath = tree.dataset.selectedPath || '';
    if (!selectedPath) {
        return;
    }

    tree.querySelectorAll('[data-docs-dir][data-docs-path]').forEach((node) => {
        const path = node.dataset.docsPath || '';
        if (path && (selectedPath === path || selectedPath.startsWith(`${path}/`))) {
            node.setAttribute('open', 'open');
        }
    });

    const selectedFile = tree.querySelector(`[data-docs-file][data-docs-path="${CSS.escape(selectedPath)}"]`);
    if (selectedFile) {
        selectedFile.scrollIntoView({ block: 'center' });
    }
};

const initMobileSidebarDock = () => {
    document.querySelectorAll('[data-mobile-sidebar-dock]').forEach((container) => {
        if (container.dataset.mobileSidebarDockInit === '1') {
            return;
        }
        container.dataset.mobileSidebarDockInit = '1';

        const buttons = Array.from(container.querySelectorAll('[data-mobile-dock-target]'));
        const panels = Array.from(container.querySelectorAll('[data-mobile-dock-panel]'));
        const isMobile = () => window.innerWidth < 1024;

        if (buttons.length === 0 || panels.length === 0) {
            return;
        }

        const setActivePanel = (target) => {
            const selected = target || container.dataset.defaultPanel || 'main';

            buttons.forEach((button) => {
                const isActive = button.dataset.mobileDockTarget === selected;
                button.classList.toggle('bg-slate-700/60', isActive);
                button.classList.toggle('text-white', isActive);
                button.classList.toggle('ring-1', isActive);
                button.classList.toggle('ring-slate-500/40', isActive);
                button.classList.toggle('text-slate-300', !isActive);
                button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
            });

            panels.forEach((panel) => {
                panel.classList.toggle('hidden', isMobile() && panel.dataset.mobileDockPanel !== selected);
            });
        };

        buttons.forEach((button) => {
            button.addEventListener('click', () => {
                setActivePanel(button.dataset.mobileDockTarget);
            });
        });

        window.addEventListener('resize', () => {
            setActivePanel(container.dataset.defaultPanel || 'main');
        });

        setActivePanel(container.dataset.defaultPanel || 'main');
    });
};

const initUiReferenceOverlayDemos = () => {
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

document.addEventListener('DOMContentLoaded', initNotificationMenus);
document.addEventListener('livewire:navigated', initNotificationMenus);
document.addEventListener('DOMContentLoaded', initAccountMenu);
document.addEventListener('livewire:navigated', initAccountMenu);
document.addEventListener('DOMContentLoaded', initDocsTree);
document.addEventListener('livewire:navigated', initDocsTree);
document.addEventListener('DOMContentLoaded', initMobileSidebarDock);
document.addEventListener('livewire:navigated', initMobileSidebarDock);
document.addEventListener('DOMContentLoaded', initFilterPanels);
document.addEventListener('livewire:navigated', initFilterPanels);
document.addEventListener('DOMContentLoaded', initTableSearchInputs);
document.addEventListener('livewire:navigated', initTableSearchInputs);
document.addEventListener('DOMContentLoaded', initSelectableOptionStates);
document.addEventListener('livewire:navigated', initSelectableOptionStates);
document.addEventListener('DOMContentLoaded', initSearchableSelects);
document.addEventListener('livewire:navigated', initSearchableSelects);
document.addEventListener('DOMContentLoaded', initInternalPhoneInputs);
document.addEventListener('livewire:navigated', initInternalPhoneInputs);
document.addEventListener('DOMContentLoaded', initDropdownActionMenus);
document.addEventListener('livewire:navigated', initDropdownActionMenus);
document.addEventListener('DOMContentLoaded', initErrorLogDrawer);
document.addEventListener('livewire:navigated', initErrorLogDrawer);
document.addEventListener('DOMContentLoaded', initAuditLogDrawer);
document.addEventListener('livewire:navigated', initAuditLogDrawer);
document.addEventListener('DOMContentLoaded', initSidebarToggle);
document.addEventListener('livewire:navigated', initSidebarToggle);
document.addEventListener('DOMContentLoaded', initThemeModeControls);
document.addEventListener('livewire:navigated', initThemeModeControls);
document.addEventListener('DOMContentLoaded', initUiReferenceOverlayDemos);
document.addEventListener('livewire:navigated', initUiReferenceOverlayDemos);
document.addEventListener('DOMContentLoaded', initUiReferenceTablesRemote);
document.addEventListener('livewire:navigated', initUiReferenceTablesRemote);
document.addEventListener('livewire:navigating', () => {
    applyThemeMode(getPreferredThemeMode(), false);
});
window.addEventListener('pageshow', () => {
    applyThemeMode(getPreferredThemeMode(), false);
});

const realtimeRoot = document.querySelector('[data-realtime-notifications="1"]');

if (realtimeRoot) {
    window.Pusher = Pusher;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const userId = realtimeRoot.dataset.userId;
    const notificationTrigger = document.querySelector('[data-notification-trigger]');
    const notificationTriggerLabel = document.querySelector('[data-notification-trigger-label]');
    const triggerSummary = document.querySelector('[data-notification-trigger-summary]');
    const markAllButton = document.querySelector('[data-notification-mark-all]');
    const markAllForm = document.querySelector('[data-notification-mark-all-form]');
    const panelSummary = document.querySelector('[data-notification-panel-summary]');
    const previewList = document.querySelector('[data-notification-preview-list]');
    const previewEmptyState = document.querySelector('[data-notification-preview-empty-state]');
    const inboxList = document.querySelector('[data-notification-inbox-list]');
    const inboxEmptyState = document.querySelector('[data-notification-inbox-empty-state]');
    const inboxUnreadCount = document.querySelector('[data-notification-inbox-unread-count]');
    const toastContainer = document.querySelector('[data-notification-toast-container]');
    const indexUrl = realtimeRoot.dataset.notificationsIndexUrl;

    const echo = new Echo({
        broadcaster: 'reverb',
        key: import.meta.env.VITE_REVERB_APP_KEY,
        wsHost: import.meta.env.VITE_REVERB_HOST,
        wsPort: Number(import.meta.env.VITE_REVERB_PORT ?? 80),
        wssPort: Number(import.meta.env.VITE_REVERB_PORT ?? 443),
        forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
        enabledTransports: ['ws', 'wss'],
        authEndpoint: '/platform/realtime/auth',
        authorizer: (channel) => ({
            authorize: (socketId, callback) => {
                window.axios.post('/platform/realtime/auth', {
                    socket_id: socketId,
                    channel_name: channel.name,
                    _token: csrfToken,
                }).then((response) => {
                    callback(false, response.data);
                }).catch((error) => {
                    callback(true, error);
                });
            },
        }),
    });

    const escapeHtml = (value) => String(value ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');

    const syncNotificationTriggerState = (unreadCount) => {
        if (!notificationTrigger) {
            return;
        }

        const hasUnread = unreadCount > 0;
        notificationTrigger.dataset.notificationTriggerUnread = hasUnread ? 'true' : 'false';
        notificationTrigger.title = hasUnread ? `${unreadCount} unread notifications` : 'Notifications';

        if (notificationTriggerLabel) {
            notificationTriggerLabel.textContent = hasUnread ? `${unreadCount} unread notifications` : 'No unread notifications';
        }

        if (triggerSummary) {
            triggerSummary.textContent = `${unreadCount}`;
            triggerSummary.classList.toggle('hidden', !hasUnread);
            triggerSummary.dataset.notificationTriggerBadgeHidden = hasUnread ? 'false' : 'true';
        }

        if (markAllButton) {
            markAllButton.disabled = !hasUnread;
            markAllButton.dataset.notificationMarkAllEnabled = hasUnread ? 'true' : 'false';
        }
    };

    const updateUnreadSummaries = (unreadCount) => {
        syncNotificationTriggerState(unreadCount);

        if (panelSummary) {
            panelSummary.textContent = `${unreadCount} unread across your latest updates`;
        }

        if (inboxUnreadCount) {
            inboxUnreadCount.textContent = `${unreadCount}`;
        }
    };

    const severityClasses = (severity) => {
        switch (severity) {
            case 'success':
                return 'bg-emerald-500/15 text-emerald-300';
            case 'notice':
                return 'bg-violet-500/15 text-violet-300';
            case 'warning':
                return 'bg-amber-500/15 text-amber-300';
            case 'error':
            case 'urgent':
                return 'bg-rose-500/15 text-rose-300';
            default:
                return 'bg-slate-700/60 text-slate-200';
        }
    };

    const severitySemantic = (severity) => {
        switch (severity) {
            case 'info':
                return 'info';
            case 'success':
                return 'success';
            case 'notice':
                return 'notice';
            case 'warning':
                return 'warning';
            case 'error':
            case 'urgent':
                return 'danger';
            default:
                return 'neutral';
        }
    };

    const unreadPreviewBadge = (notification) => notification.read_at
        ? ''
        : '<span class="ui-notification-preview-pill ui-notification-preview-pill-unread" data-notification-preview-unread>Unread</span>';

    const severityPreviewBadge = (notification) => {
        const semantic = severitySemantic(notification.severity);

        return `
            <span
                class="ui-notification-preview-pill ui-notification-preview-pill-${semantic}"
                data-notification-preview-severity="${semantic}"
            >
                ${escapeHtml(notification.severity)}
            </span>
        `;
    };

    const dismissedBadge = (notification) => notification.dismissed_at
        ? '<span class="inline-flex rounded-full bg-slate-800 px-3 py-1 text-xs font-medium text-slate-400">Dismissed</span>'
        : '';

    const readBadge = (notification) => notification.read_at
        ? '<span class="inline-flex rounded-full bg-slate-800 px-3 py-1 text-xs font-medium text-slate-300" data-notification-read-badge="true">Read</span>'
        : '<span class="inline-flex rounded-full bg-slate-700/70 px-3 py-1 text-xs font-medium text-slate-200" data-notification-read-badge="false">Unread</span>';

    const createPreviewMarkup = (notification) => `
        <a
            href="${escapeHtml(notification.action_url || indexUrl)}"
            class="ui-notification-preview-item${notification.read_at ? '' : ' ui-notification-preview-item-unread'}"
            data-notification-preview-item
            data-notification-preview-item-unread="${notification.read_at ? 'false' : 'true'}"
            data-notification-id="${notification.id}"
        >
            <div class="flex items-center gap-2">
                ${unreadPreviewBadge(notification)}
                ${severityPreviewBadge(notification)}
                <span class="ml-auto text-xs text-slate-500">${escapeHtml(notification.created_at_label || '')}</span>
            </div>
            <p class="mt-3 text-sm font-semibold text-white">${escapeHtml(notification.title)}</p>
            <p class="mt-1 line-clamp-2 text-sm text-slate-400">${escapeHtml(notification.body)}</p>
        </a>
    `;

    const createInboxMarkup = (notification) => `
        <article class="rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/20" data-notification-card data-notification-id="${notification.id}">
            <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-2" data-notification-badges>
                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-[0.15em] ${severityClasses(notification.severity)}" data-notification-severity-badge>
                            ${escapeHtml(notification.severity)}
                        </span>
                        ${readBadge(notification)}
                        ${dismissedBadge(notification)}
                    </div>
                    <h2 class="mt-4 text-xl font-semibold text-white">${escapeHtml(notification.title)}</h2>
                    <p class="mt-2 leading-7 text-slate-300">${escapeHtml(notification.body)}</p>
                    <div class="mt-4 flex flex-wrap gap-4 text-sm text-slate-500">
                        <span>Module: ${escapeHtml(notification.module_key)}</span>
                        <span data-notification-created-label>${escapeHtml(notification.created_at_label || '')}</span>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="${escapeHtml(notification.action_url || indexUrl)}" class="ui-action ui-action-notice text-sm">
                            Open notification link
                        </a>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3" data-notification-actions>
                    ${notification.read_at ? '' : `
                        <form method="POST" action="${escapeHtml(notification.mark_read_url)}" data-notification-mark-read-form>
                            <input type="hidden" name="_token" value="${escapeHtml(csrfToken || '')}">
                            <button type="submit" class="ui-action ui-action-success">
                                Mark read
                            </button>
                        </form>
                    `}
                    ${notification.dismissed_at ? '' : `
                        <form method="POST" action="${escapeHtml(notification.dismiss_url)}">
                            <input type="hidden" name="_token" value="${escapeHtml(csrfToken || '')}">
                            <button type="submit" class="ui-action ui-action-ghost">
                                Dismiss
                            </button>
                        </form>
                    `}
                </div>
            </div>
        </article>
    `;

    const renderPreviewItem = (notification) => {
        const existing = previewList?.querySelector(`[data-notification-id="${notification.id}"]`);

        if (!previewList) {
            return;
        }

        if (previewEmptyState) {
            previewEmptyState.remove();
        }

        if (existing) {
            existing.outerHTML = createPreviewMarkup(notification);
            return;
        }

        previewList.insertAdjacentHTML('afterbegin', createPreviewMarkup(notification));

        while (previewList.querySelectorAll('[data-notification-preview-item]').length > 5) {
            previewList.querySelector('[data-notification-preview-item]:last-of-type')?.remove();
        }
    };

    const renderInboxItem = (notification) => {
        if (!inboxList) {
            return;
        }

        if (inboxEmptyState) {
            inboxEmptyState.remove();
        }

        const existing = inboxList.querySelector(`[data-notification-id="${notification.id}"]`);

        if (existing) {
            existing.outerHTML = createInboxMarkup(notification);
            return;
        }

        inboxList.insertAdjacentHTML('afterbegin', createInboxMarkup(notification));
    };

    const markPreviewItemReadLocally = (item) => {
        if (!(item instanceof HTMLElement)) {
            return;
        }

        item.dataset.notificationPreviewItemUnread = 'false';
        item.classList.remove('ui-notification-preview-item-unread');
        item.querySelector('[data-notification-preview-unread]')?.remove();
    };

    const markInboxCardReadLocally = (card) => {
        if (!(card instanceof HTMLElement)) {
            return;
        }

        card.querySelectorAll('[data-notification-mark-read-form]').forEach((form) => form.remove());

        const badges = card.querySelector('[data-notification-badges]');

        if (!(badges instanceof HTMLElement)) {
            return;
        }

        const readBadgeElement = badges.querySelector('[data-notification-read-badge]');

        if (readBadgeElement instanceof HTMLElement) {
            readBadgeElement.className = 'inline-flex rounded-full bg-slate-800 px-3 py-1 text-xs font-medium text-slate-300';
            readBadgeElement.dataset.notificationReadBadge = 'true';
            readBadgeElement.textContent = 'Read';
            return;
        }

        const severityBadge = badges.querySelector('[data-notification-severity-badge]');
        const badge = document.createElement('span');
        badge.className = 'inline-flex rounded-full bg-slate-800 px-3 py-1 text-xs font-medium text-slate-300';
        badge.dataset.notificationReadBadge = 'true';
        badge.textContent = 'Read';

        if (severityBadge?.nextSibling) {
            badges.insertBefore(badge, severityBadge.nextSibling);
            return;
        }

        badges.append(badge);
    };

    const markNotificationsReadLocally = (notificationIds = []) => {
        const ids = new Set(notificationIds.map((id) => String(id)));

        previewList?.querySelectorAll('[data-notification-id]').forEach((item) => {
            if (ids.size > 0 && !ids.has(item.dataset.notificationId || '')) {
                return;
            }

            markPreviewItemReadLocally(item);
        });

        inboxList?.querySelectorAll('[data-notification-id]').forEach((card) => {
            if (ids.size > 0 && !ids.has(card.dataset.notificationId || '')) {
                return;
            }

            markInboxCardReadLocally(card);
        });
    };

    const createToast = (notification) => {
        if (!toastContainer) {
            return;
        }

        const existing = toastContainer.querySelector(`[data-notification-toast-id="${notification.id}"]`);
        existing?.remove();

        const toast = document.createElement('a');
        toast.href = notification.action_url || indexUrl;
        toast.dataset.notificationToastId = `${notification.id}`;
        toast.className = 'pointer-events-auto block rounded-md border border-slate-800 bg-slate-900/95 px-4 py-4 shadow-2xl shadow-black/40 transition hover:border-slate-600';
        toast.innerHTML = `
            <div class="flex items-start gap-3">
                <div class="mt-0.5">
                    ${severityPreviewBadge(notification)}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-white">${escapeHtml(notification.title)}</p>
                    <p class="mt-1 text-sm text-slate-400">${escapeHtml(notification.body)}</p>
                </div>
                <button type="button" class="ml-2 text-slate-500 transition hover:text-slate-200" data-notification-toast-close>×</button>
            </div>
        `;

        toastContainer.prepend(toast);

        const removeToast = () => toast.remove();
        const closeButton = toast.querySelector('[data-notification-toast-close]');

        closeButton?.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();
            removeToast();
        });

        window.setTimeout(removeToast, 5000);
    };

    const applyNotification = (notification, options = { toast: false }) => {
        updateUnreadSummaries(notification.unread_count ?? 0);
        renderPreviewItem(notification);
        renderInboxItem(notification);

        if (options.toast && !notification.read_at) {
            createToast(notification);
        }
    };

    if (markAllForm && markAllButton && csrfToken) {
        markAllForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            if (markAllButton.disabled) {
                return;
            }

            const originalLabel = markAllButton.textContent;
            markAllButton.disabled = true;
            markAllButton.textContent = 'Updating...';

            try {
                const response = await window.fetch(markAllForm.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                        'X-CSRF-TOKEN': csrfToken,
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: new URLSearchParams(new FormData(markAllForm)).toString(),
                    credentials: 'same-origin',
                });

                if (!response.ok) {
                    markAllForm.submit();
                    return;
                }

                const payload = await response.json();
                updateUnreadSummaries(payload.unread_count ?? 0);
                markNotificationsReadLocally(payload.marked_notification_ids ?? []);
            } catch (error) {
                markAllForm.submit();
                return;
            } finally {
                markAllButton.textContent = originalLabel;
                markAllButton.disabled = markAllButton.dataset.notificationMarkAllEnabled !== 'true';
            }
        });
    }

    echo.private(`App.Models.User.${userId}`)
        .listen('.notification.created', (event) => {
            applyNotification(event.notification, { toast: true });
        })
        .listen('.notification.updated', (event) => {
            applyNotification(event.notification, { toast: false });
        });

    window.addEventListener('platform-notification-created', (event) => {
        const notification = event.detail?.notification;

        if (!notification) {
            return;
        }

        applyNotification(notification, { toast: true });
    });
}
