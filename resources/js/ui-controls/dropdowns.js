const closeDropdown = (root, { restoreFocus = false } = {}) => {
    const trigger = root.querySelector('[data-ui-dropdown-trigger]');
    const menu = root.querySelector('[data-ui-dropdown-menu]');

    if (!(trigger instanceof HTMLButtonElement) || !(menu instanceof HTMLElement)) {
        return;
    }

    menu.hidden = true;
    trigger.setAttribute('aria-expanded', 'false');
    root.dataset.uiDropdownOpen = 'false';
    root.classList.remove('ui-dropdown-open');

    if (restoreFocus) {
        trigger.focus();
    }
};

const openDropdown = (root) => {
    const trigger = root.querySelector('[data-ui-dropdown-trigger]');
    const menu = root.querySelector('[data-ui-dropdown-menu]');
    const selectedOption = root.querySelector('[data-ui-dropdown-option][aria-selected="true"]:not(:disabled)');
    const firstOption = root.querySelector('[data-ui-dropdown-option]:not(:disabled)');

    if (!(trigger instanceof HTMLButtonElement) || !(menu instanceof HTMLElement)) {
        return;
    }

    document.querySelectorAll('[data-ui-dropdown]').forEach((otherRoot) => {
        if (otherRoot !== root && otherRoot instanceof HTMLElement) {
            closeDropdown(otherRoot);
        }
    });

    menu.hidden = false;
    trigger.setAttribute('aria-expanded', 'true');
    root.dataset.uiDropdownOpen = 'true';
    root.classList.add('ui-dropdown-open');

    window.requestAnimationFrame(() => {
        const focusTarget = selectedOption instanceof HTMLButtonElement
            ? selectedOption
            : firstOption;

        if (focusTarget instanceof HTMLButtonElement) {
            focusTarget.focus();
        }
    });
};

const selectDropdownOption = (root, option) => {
    const hiddenInput = root.querySelector('[data-ui-dropdown-hidden-input]');
    const triggerValue = root.querySelector('[data-ui-dropdown-value]');
    const optionValue = option.dataset.uiDropdownOptionValue || option.dataset.uiDropdownValue || '';
    const optionLabel = option.dataset.uiDropdownOptionLabel || option.textContent?.trim() || optionValue;

    if (!(hiddenInput instanceof HTMLInputElement) || !(triggerValue instanceof HTMLElement)) {
        return;
    }

    hiddenInput.value = optionValue;
    triggerValue.textContent = optionLabel;
    triggerValue.classList.remove('ui-dropdown-placeholder');

    root.querySelectorAll('[data-ui-dropdown-option]').forEach((item) => {
        const isSelected = item === option;
        item.setAttribute('aria-selected', isSelected ? 'true' : 'false');
        item.classList.toggle('ui-dropdown-option-selected', isSelected);
    });

    closeDropdown(root, { restoreFocus: true });
};

const focusRelativeOption = (root, direction) => {
    const options = Array.from(root.querySelectorAll('[data-ui-dropdown-option]:not(:disabled)'))
        .filter((option) => option instanceof HTMLButtonElement);

    if (options.length === 0) {
        return;
    }

    const currentIndex = options.findIndex((option) => option === document.activeElement);
    const nextIndex = currentIndex === -1
        ? 0
        : (currentIndex + direction + options.length) % options.length;

    options[nextIndex].focus();
};

export function initDropdowns(root = document) {
    root.querySelectorAll('[data-ui-dropdown]').forEach((dropdown) => {
        if (!(dropdown instanceof HTMLElement) || dropdown.dataset.uiDropdownInit === '1') {
            return;
        }

        const trigger = dropdown.querySelector('[data-ui-dropdown-trigger]');
        const menu = dropdown.querySelector('[data-ui-dropdown-menu]');
        const options = Array.from(dropdown.querySelectorAll('[data-ui-dropdown-option]'));

        if (!(trigger instanceof HTMLButtonElement) || !(menu instanceof HTMLElement)) {
            return;
        }

        dropdown.dataset.uiDropdownInit = '1';

        if (dropdown.dataset.uiDropdownOpen === 'true') {
            dropdown.classList.add('ui-dropdown-open');
            menu.hidden = false;
            trigger.setAttribute('aria-expanded', 'true');
        }

        trigger.addEventListener('click', () => {
            if (dropdown.dataset.uiDropdownReadonly === 'true') {
                return;
            }

            if (trigger.getAttribute('aria-expanded') === 'true') {
                closeDropdown(dropdown);
                return;
            }

            openDropdown(dropdown);
        });

        trigger.addEventListener('keydown', (event) => {
            if (dropdown.dataset.uiDropdownReadonly === 'true') {
                return;
            }

            if (['ArrowDown', 'ArrowUp', 'Enter', ' '].includes(event.key)) {
                event.preventDefault();
                openDropdown(dropdown);
            }
        });

        options.forEach((option) => {
            if (!(option instanceof HTMLButtonElement)) {
                return;
            }

            option.addEventListener('click', () => selectDropdownOption(dropdown, option));
            option.addEventListener('keydown', (event) => {
                if (event.key === 'ArrowDown') {
                    event.preventDefault();
                    focusRelativeOption(dropdown, 1);
                } else if (event.key === 'ArrowUp') {
                    event.preventDefault();
                    focusRelativeOption(dropdown, -1);
                } else if (event.key === 'Escape') {
                    event.preventDefault();
                    closeDropdown(dropdown, { restoreFocus: true });
                } else if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    selectDropdownOption(dropdown, option);
                } else if (event.key === 'Tab') {
                    closeDropdown(dropdown);
                }
            });
        });
    });

    if (document.body?.dataset.uiDropdownDocumentInit === '1') {
        return;
    }

    document.body.dataset.uiDropdownDocumentInit = '1';

    document.addEventListener('click', (event) => {
        if (event.target instanceof HTMLElement && event.target.closest('[data-ui-dropdown]')) {
            return;
        }

        document.querySelectorAll('[data-ui-dropdown]').forEach((dropdown) => {
            if (dropdown instanceof HTMLElement) {
                closeDropdown(dropdown);
            }
        });
    });

    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') {
            return;
        }

        document.querySelectorAll('[data-ui-dropdown]').forEach((dropdown) => {
            if (dropdown instanceof HTMLElement) {
                closeDropdown(dropdown, { restoreFocus: dropdown.contains(document.activeElement) });
            }
        });
    });
}
