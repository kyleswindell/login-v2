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
            panel.classList.remove('ui-list-box-menu-open');
            trigger.setAttribute('aria-expanded', 'false');
            trigger.classList.remove('ui-list-box-expanded');

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
            panel.classList.add('ui-list-box-menu-open');
            trigger.setAttribute('aria-expanded', 'true');
            trigger.classList.add('ui-list-box-expanded');
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
                option.classList.toggle('ui-list-box-menu-item-selected', isSelected);

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
