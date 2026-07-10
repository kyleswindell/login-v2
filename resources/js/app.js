/**
 * File: resources/js/app.js
 * Purpose: Main browser entry point for app scripts and UI initializers.
 *
 * Notes:
 * - Imports global app scripts.
 * - Runs UI control lifecycle initializers on page load and Livewire navigation.
 */

import "./bootstrap";
import "./table-enhance";
import "./dashboard-sort";

import {
    initMotion,
    initAccordions,
    initCheckboxes,
    initCodeSnippets,
    initComboBoxes,
    initContentSwitchers,
    initDatePickers,
    initDialogs,
    initDataTables,
    initDocsTree,
    initDropdowns,
    initDropdownActionMenus,
    initFileUploaders,
    initFilterPanels,
    initInternalPhoneInputs,
    initInteractionFocus,
    initInlineLoading,
    initLoading,
    initMenus,
    initMultiselects,
    initNumberInputs,
    initSideNavs,
    initPagination,
    initPaginationNav,
    initPopovers,
    initNotifications,
    initAppHeaderSearch,
    initSearchControls,
    initSearchableSelects,
    initSelectControls,
    initSelectableOptionStates,
    initSliders,
    initStructuredLists,
    initTableSearchInputs,
    initTabs,
    initTags,
    initTextAreas,
    initTextInputs,
    initFormSubmitState,
    initThemeModeControls,
    initTiles,
    initToggles,
    initTooltips,
    initToggletips,
    initTreeViews,
    initUiShell,
    initDestructiveActions,
    refreshThemeMode,
} from "./ui-controls";

import { initAuditLogDrawer, initErrorLogDrawer } from "./log-drawers";
import { initDashboardTestNotification } from "./dashboard-test-notification";
import {
    initAppHeaderNotifications,
    initNotificationRuntime,
} from "/Modules/Notifications/resources/js";

const lifecycleInitializers = [
    initMotion,
    initDocsTree,
    initAccordions,
    initFilterPanels,
    initTableSearchInputs,
    initSelectableOptionStates,
    initSearchableSelects,
    initSelectControls,
    initSearchControls,
    initDropdowns,
    initComboBoxes,
    initInternalPhoneInputs,
    initInteractionFocus,
    initLoading,
    initInlineLoading,
    initDropdownActionMenus,
    initMenus,
    initCheckboxes,
    initToggles,
    initToggletips,
    initCodeSnippets,
    initMultiselects,
    initPagination,
    initPaginationNav,
    initPopovers,
    initDialogs,
    initNotifications,
    initAppHeaderNotifications,
    initNotificationRuntime,
    initTooltips,
    initNumberInputs,
    initSliders,
    initFileUploaders,
    initTreeViews,
    initTabs,
    initTextInputs,
    initTextAreas,
    initFormSubmitState,
    initContentSwitchers,
    initDatePickers,
    initStructuredLists,
    initDataTables,
    initDestructiveActions,
    initTiles,
    initTags,
    initUiShell,
    initSideNavs,
    initAppHeaderSearch,
    initErrorLogDrawer,
    initAuditLogDrawer,
    initThemeModeControls,
    initDashboardTestNotification,
];

const runLifecycleInitializer = (initializer) => {
    initializer(document);
};

lifecycleInitializers.forEach((initializer) => {
    const run = () => runLifecycleInitializer(initializer);

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", run, { once: true });
    } else {
        run();
    }

    document.addEventListener("livewire:navigated", run);
});

document.addEventListener("DOMContentLoaded", () => {
    initDestructiveActions(document);
});

document.addEventListener("livewire:navigated", () => {
    initDestructiveActions(document);
});

document.addEventListener("livewire:navigating", refreshThemeMode);
window.addEventListener("pageshow", refreshThemeMode);
