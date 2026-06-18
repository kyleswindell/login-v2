const getOptions = (component) => Array.from(component.querySelectorAll('[data-ui-multiselect-option]'));

const syncHiddenInputs = (component) => {
    const name = component.dataset.uiMultiselectName;

    if (!name) {
        return;
    }

    component.querySelectorAll('[data-ui-multiselect-hidden-input]').forEach((input) => input.remove());

    getOptions(component)
        .filter((option) => option.getAttribute('aria-selected') === 'true')
        .forEach((option) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = option.dataset.uiMultiselectOptionValue || '';
            input.dataset.uiMultiselectHiddenInput = '';
            component.insertBefore(input, component.querySelector('[data-ui-multiselect-trigger]'));
        });
};

const syncValueLabel = (component) => {
    const valueContainer = component.querySelector('[data-ui-multiselect-value]');
    const placeholder = component.querySelector('.ui-multiselect-placeholder')?.textContent || 'Choose options';

    if (!valueContainer) {
        return;
    }

    const selected = getOptions(component).filter((option) => option.getAttribute('aria-selected') === 'true');

    if (selected.length === 0) {
        valueContainer.innerHTML = `<span class="ui-multiselect-placeholder">${placeholder}</span>`;
        return;
    }

    valueContainer.innerHTML = selected
        .map((option) => {
            const value = option.dataset.uiMultiselectOptionValue || '';
            const label = option.querySelector('[data-ui-multiselect-option-label]')?.textContent?.trim() || value;

            return `<span class="ui-multiselect-tag" data-ui-multiselect-selected-value="${value}">${label}</span>`;
        })
        .join('');
};

const syncOptionCheck = (option) => {
    const check = option.querySelector('[data-ui-multiselect-option-check]');
    const selected = option.getAttribute('aria-selected') === 'true';

    option.classList.toggle('ui-list-box-menu-item-selected', selected);

    if (check) {
        check.textContent = selected ? 'Selected' : '';
    }
};

const setOpen = (component, open) => {
    const trigger = component.querySelector('[data-ui-multiselect-trigger]');
    const menu = component.querySelector('[data-ui-multiselect-menu]');

    if (!trigger || !menu) {
        return;
    }

    trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
    menu.hidden = !open;
    component.dataset.uiMultiselectOpen = open ? 'true' : 'false';
    trigger.classList.toggle('ui-list-box-expanded', open);
    menu.classList.toggle('ui-list-box-menu-open', open);

    if (open) {
        const filter = component.querySelector('[data-ui-multiselect-filter]');
        const firstSelected = component.querySelector('[data-ui-multiselect-option][aria-selected="true"]:not(:disabled)');
        const firstOption = component.querySelector('[data-ui-multiselect-option]:not(:disabled)');

        if (filter instanceof HTMLInputElement) {
            filter.focus();
        } else if (firstSelected instanceof HTMLButtonElement) {
            firstSelected.focus();
        } else if (firstOption instanceof HTMLButtonElement) {
            firstOption.focus();
        }
    }
};

const focusRelativeOption = (component, direction) => {
    const options = getOptions(component).filter((option) => !option.disabled && !option.hidden);

    if (options.length === 0) {
        return;
    }

    const currentIndex = options.findIndex((option) => option === document.activeElement);
    const nextIndex = currentIndex === -1
        ? 0
        : (currentIndex + direction + options.length) % options.length;

    options[nextIndex].focus();
};

const focusMultiselectOption = (component, placement) => {
    const options = getOptions(component).filter((option) => !option.disabled && !option.hidden);

    if (options.length === 0) {
        return;
    }

    const target = placement === 'last' ? options[options.length - 1] : options[0];
    target.focus();
};

export function initMultiselects(root = document) {
    root.querySelectorAll('[data-ui-multiselect]').forEach((component) => {
        if (component.dataset.uiMultiselectInitialized === 'true') {
            return;
        }

        component.dataset.uiMultiselectInitialized = 'true';

        const trigger = component.querySelector('[data-ui-multiselect-trigger]');
        const filter = component.querySelector('[data-ui-multiselect-filter]');

        trigger?.addEventListener('click', () => {
            setOpen(component, trigger.getAttribute('aria-expanded') !== 'true');
        });

        trigger?.addEventListener('keydown', (event) => {
            if (['ArrowDown', 'ArrowUp', 'Enter', ' '].includes(event.key)) {
                event.preventDefault();
                setOpen(component, true);
            }
        });

        filter?.addEventListener('input', () => {
            const query = filter.value.trim().toLowerCase();

            getOptions(component).forEach((option) => {
                const label = option.querySelector('[data-ui-multiselect-option-label]')?.textContent?.toLowerCase() || '';
                option.hidden = query !== '' && !label.includes(query);
            });
        });

        getOptions(component).forEach((option) => {
            syncOptionCheck(option);

            option.addEventListener('click', () => {
                if (option.disabled) {
                    return;
                }

                const selected = option.getAttribute('aria-selected') === 'true';
                option.setAttribute('aria-selected', selected ? 'false' : 'true');
                syncOptionCheck(option);
                syncHiddenInputs(component);
                syncValueLabel(component);
            });

            option.addEventListener('keydown', (event) => {
                if (event.key === 'ArrowDown') {
                    event.preventDefault();
                    focusRelativeOption(component, 1);
                } else if (event.key === 'ArrowUp') {
                    event.preventDefault();
                    focusRelativeOption(component, -1);
                } else if (event.key === 'Home') {
                    event.preventDefault();
                    focusMultiselectOption(component, 'first');
                } else if (event.key === 'End') {
                    event.preventDefault();
                    focusMultiselectOption(component, 'last');
                } else if (event.key === 'Escape') {
                    event.preventDefault();
                    setOpen(component, false);
                    trigger?.focus();
                } else if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    option.click();
                } else if (event.key === 'Tab') {
                    setOpen(component, false);
                }
            });
        });

        component.querySelector('[data-ui-multiselect-clear]')?.addEventListener('click', () => {
            getOptions(component).forEach((option) => {
                option.setAttribute('aria-selected', 'false');
                syncOptionCheck(option);
            });
            syncHiddenInputs(component);
            syncValueLabel(component);
        });

        component.querySelector('[data-ui-multiselect-select-all]')?.addEventListener('click', () => {
            getOptions(component).forEach((option) => {
                if (!option.disabled) {
                    option.setAttribute('aria-selected', 'true');
                    syncOptionCheck(option);
                }
            });
            syncHiddenInputs(component);
            syncValueLabel(component);
        });
    });
}
