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

export const refreshThemeMode = () => {
    applyThemeMode(getPreferredThemeMode(), false);
};

export const initThemeModeControls = () => {
    if (document.body?.dataset.themeControlsInit === '1') {
        refreshThemeMode();
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

    refreshThemeMode();
};

export const initFilterPanels = () => {
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

export const initSelectableOptionStates = () => {
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

export const initSearchableSelects = () => {
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

export const initInternalPhoneInputs = () => {
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

export const initDropdownActionMenus = () => {
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

export const initTableSearchInputs = () => {
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
