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

    if (check) {
        check.textContent = option.getAttribute('aria-selected') === 'true' ? 'Selected' : '';
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

    if (open) {
        component.querySelector('[data-ui-multiselect-filter]')?.focus();
    }
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

        filter?.addEventListener('input', () => {
            const query = filter.value.trim().toLowerCase();

            getOptions(component).forEach((option) => {
                const label = option.querySelector('[data-ui-multiselect-option-label]')?.textContent?.toLowerCase() || '';
                option.hidden = query !== '' && !label.includes(query);
            });
        });

        getOptions(component).forEach((option) => {
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
