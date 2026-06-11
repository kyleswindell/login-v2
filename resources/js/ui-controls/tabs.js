const enabledTabs = (tablist) => Array.from(tablist.querySelectorAll('[data-ui-tabs-tab]'))
    .filter((tab) => !tab.disabled);

const selectTab = (root, tab) => {
    const tabs = Array.from(root.querySelectorAll('[data-ui-tabs-tab]'));
    const panels = Array.from(root.querySelectorAll('[data-ui-tabs-panel]'));

    tabs.forEach((candidate) => {
        const selected = candidate === tab;
        candidate.setAttribute('aria-selected', selected ? 'true' : 'false');
        candidate.tabIndex = selected ? 0 : -1;
    });

    panels.forEach((panel) => {
        panel.hidden = panel.id !== tab.getAttribute('aria-controls');
    });
};

const nextEnabledTab = (tabs, current, direction) => {
    const currentIndex = tabs.indexOf(current);
    const nextIndex = (currentIndex + direction + tabs.length) % tabs.length;

    return tabs[nextIndex] ?? current;
};

export function initTabs(root = document) {
    root.querySelectorAll('[data-ui-tabs]').forEach((tabsRoot) => {
        if (tabsRoot.dataset.uiTabsInitialized === 'true') {
            return;
        }

        tabsRoot.dataset.uiTabsInitialized = 'true';
        const tablist = tabsRoot.querySelector('[role="tablist"]');

        if (!tablist) {
            return;
        }

        const activation = tabsRoot.dataset.uiTabsActivation ?? 'automatic';

        tablist.addEventListener('click', (event) => {
            const dismiss = event.target.closest('.ui-tabs-tab-dismiss');
            const tab = event.target.closest('[data-ui-tabs-tab]');

            if (!tab || tab.disabled) {
                return;
            }

            if (dismiss) {
                const tabs = enabledTabs(tablist);
                const selected = tab.getAttribute('aria-selected') === 'true';
                const panel = tabsRoot.querySelector(`#${CSS.escape(tab.getAttribute('aria-controls'))}`);
                const fallback = nextEnabledTab(tabs, tab, tabs.indexOf(tab) === tabs.length - 1 ? -1 : 1);

                panel?.remove();
                tab.remove();

                if (selected && fallback && fallback !== tab) {
                    selectTab(tabsRoot, fallback);
                    fallback.focus();
                }

                return;
            }

            selectTab(tabsRoot, tab);
            tab.focus();
        });

        tablist.addEventListener('keydown', (event) => {
            const current = event.target.closest('[data-ui-tabs-tab]');

            if (!current) {
                return;
            }

            const tabs = enabledTabs(tablist);
            let next = null;

            if (['ArrowRight', 'ArrowDown'].includes(event.key)) {
                next = nextEnabledTab(tabs, current, 1);
            } else if (['ArrowLeft', 'ArrowUp'].includes(event.key)) {
                next = nextEnabledTab(tabs, current, -1);
            } else if (event.key === 'Home') {
                next = tabs[0];
            } else if (event.key === 'End') {
                next = tabs[tabs.length - 1];
            } else if (activation === 'manual' && ['Enter', ' '].includes(event.key)) {
                event.preventDefault();
                selectTab(tabsRoot, current);
                return;
            }

            if (!next) {
                return;
            }

            event.preventDefault();
            next.focus();

            if (activation === 'automatic') {
                selectTab(tabsRoot, next);
            }
        });
    });
}
