const enabledOptions = (list) => Array.from(list.querySelectorAll('[data-ui-content-switcher-option]'))
    .filter((option) => !option.disabled);

const selectOption = (root, option) => {
    const options = Array.from(root.querySelectorAll('[data-ui-content-switcher-option]'));
    const panels = Array.from(root.querySelectorAll('[data-ui-content-switcher-panel]'));

    options.forEach((candidate) => {
        const selected = candidate === option;
        candidate.setAttribute('aria-selected', selected ? 'true' : 'false');
        candidate.tabIndex = selected ? 0 : -1;
    });

    panels.forEach((panel) => {
        panel.hidden = panel.id !== option.getAttribute('aria-controls');
    });
};

const initializeSelectedOption = (root, list) => {
    const options = enabledOptions(list);
    const selected = options.find((option) => option.getAttribute('aria-selected') === 'true') ?? options[0];

    if (selected) {
        selectOption(root, selected);
    }
};

const nextEnabledOption = (options, current, direction) => {
    const currentIndex = options.indexOf(current);
    const nextIndex = (currentIndex + direction + options.length) % options.length;

    return options[nextIndex] ?? current;
};

export function initContentSwitchers(root = document) {
    root.querySelectorAll('[data-ui-content-switcher]').forEach((switcherRoot) => {
        if (switcherRoot.dataset.uiContentSwitcherInitialized === 'true') {
            return;
        }

        switcherRoot.dataset.uiContentSwitcherInitialized = 'true';
        const list = switcherRoot.querySelector('[data-ui-content-switcher-list]');

        if (!list) {
            return;
        }

        initializeSelectedOption(switcherRoot, list);

        list.addEventListener('click', (event) => {
            const option = event.target.closest('[data-ui-content-switcher-option]');

            if (!option || option.disabled) {
                return;
            }

            selectOption(switcherRoot, option);
            option.focus();
        });

        list.addEventListener('keydown', (event) => {
            const current = event.target.closest('[data-ui-content-switcher-option]');

            if (!current) {
                return;
            }

            const options = enabledOptions(list);
            let next = null;

            if (['ArrowRight', 'ArrowDown'].includes(event.key)) {
                next = nextEnabledOption(options, current, 1);
            } else if (['ArrowLeft', 'ArrowUp'].includes(event.key)) {
                next = nextEnabledOption(options, current, -1);
            } else if (event.key === 'Home') {
                next = options[0];
            } else if (event.key === 'End') {
                next = options[options.length - 1];
            } else if (['Enter', ' '].includes(event.key)) {
                event.preventDefault();
                selectOption(switcherRoot, current);
                return;
            }

            if (!next) {
                return;
            }

            event.preventDefault();
            next.focus();
            selectOption(switcherRoot, next);
        });
    });
}
