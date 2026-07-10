/**
 * File: resources/js/ui-controls/dialog.js
 * Purpose: Public dialog behavior entrypoint.
 *
 * Notes:
 * - This is the only app-level initializer for native dialog and modal dialog
 *   behavior.
 * - x-ui.dialog.* and x-ui.modal both render native dialog markup and use
 *   data-ui-dialog-* hooks.
 * - Do not import or initialize resources/js/ui-controls/modal.js.
 */

export {
    closeDialog,
    initDialogs,
    openDialog,
    requestDialogSubmit,
} from "./dialog/controller";
