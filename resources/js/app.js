import './bootstrap';
import './setup-sidebar';
import './table-enhance';
import './dashboard-sort';
import './dashboard-proof-demo';

import {
    initDropdownActionMenus,
    initFilterPanels,
    initInternalPhoneInputs,
    initSearchableSelects,
    initSelectableOptionStates,
    initTableSearchInputs,
    initThemeModeControls,
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
import { initUiReferenceOverlayDemos, initUiReferenceTablesRemote } from './ui-reference';

const lifecycleInitializers = [
    initNotificationMenus,
    initAccountMenu,
    initDocsTree,
    initMobileSidebarDock,
    initFilterPanels,
    initTableSearchInputs,
    initSelectableOptionStates,
    initSearchableSelects,
    initInternalPhoneInputs,
    initDropdownActionMenus,
    initErrorLogDrawer,
    initAuditLogDrawer,
    initSidebarToggle,
    initThemeModeControls,
    initUiReferenceOverlayDemos,
    initUiReferenceTablesRemote,
    initRealtimeNotifications,
];

lifecycleInitializers.forEach((initializer) => {
    document.addEventListener('DOMContentLoaded', initializer);
    document.addEventListener('livewire:navigated', initializer);
});

document.addEventListener('livewire:navigating', refreshThemeMode);
window.addEventListener('pageshow', refreshThemeMode);
