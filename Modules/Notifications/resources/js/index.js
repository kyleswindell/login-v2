/**
 * File: Modules/Notifications/resources/js/index.js
 * Purpose: Notifications module public JavaScript exports.
 *
 * Notes:
 * - Module-specific notification behavior lives here, not in ui-controls.
 * - Generic x-ui.notification component behavior remains in resources/js/ui-controls/notification.js.
 */

export { initNotificationRuntime } from "./runtime";
export { initAppHeaderNotifications } from "./header-menu";
