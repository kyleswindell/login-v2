import './bootstrap';
import './setup-sidebar';
import './table-enhance';
import './dashboard-sort';
import './dashboard-proof-demo';

import {
    initAccordions,
    initCheckboxes,
    initCodeSnippets,
    initContentSwitchers,
    initDropdowns,
    initDropdownActionMenus,
    initFilterPanels,
    initInternalPhoneInputs,
    initInteractionFocus,
    initMenus,
    initMultiselects,
    initPopovers,
    initSearchControls,
    initSearchableSelects,
    initSelectableOptionStates,
    initSliders,
    initTableSearchInputs,
    initTabs,
    initThemeModeControls,
    initTooltips,
    initTreeViews,
    refreshThemeMode,
} from './ui-controls';
import { initAuditLogDrawer, initErrorLogDrawer } from './log-drawers';
import { initRealtimeNotifications } from './realtime-notifications';
import {
    initAccountMenu,
    initDocsTree,
    initMobileSidebarDock,
    initNotificationMenus,
    initSidebarToggle,
} from './shell-ui';
import {
    initUiReferenceComponentTabs,
    initUiReferenceOverlayDemos,
    initUiReferenceSidebarDisclosures,
    initUiReferenceTablesRemote,
} from './ui-reference';

const lifecycleInitializers = [
    initNotificationMenus,
    initAccountMenu,
    initDocsTree,
    initMobileSidebarDock,
    initAccordions,
    initFilterPanels,
    initTableSearchInputs,
    initSelectableOptionStates,
    initSearchableSelects,
    initSearchControls,
    initDropdowns,
    initInternalPhoneInputs,
    initInteractionFocus,
    initDropdownActionMenus,
    initMenus,
    initCheckboxes,
    initCodeSnippets,
    initMultiselects,
    initPopovers,
    initTooltips,
    initSliders,
    initTreeViews,
    initTabs,
    initContentSwitchers,
    initErrorLogDrawer,
    initAuditLogDrawer,
    initSidebarToggle,
    initThemeModeControls,
    initUiReferenceSidebarDisclosures,
    initUiReferenceComponentTabs,
    initUiReferenceOverlayDemos,
    initUiReferenceTablesRemote,
    initRealtimeNotifications,
];

const runLifecycleInitializer = (initializer) => {
    initializer(document);
};

lifecycleInitializers.forEach((initializer) => {
    const run = () => runLifecycleInitializer(initializer);

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', run, { once: true });
    } else {
        run();
    }

    document.addEventListener('livewire:navigated', run);
});

document.addEventListener('livewire:navigating', refreshThemeMode);
window.addEventListener('pageshow', refreshThemeMode);
