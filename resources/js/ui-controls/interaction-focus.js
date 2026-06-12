const interactionFocusSelector = '.ui-action:not(:disabled), .ui-icon-button:not(:disabled)';
let interactionFocusClearRegistered = false;

const clearInteractionFocus = (root = document) => {
    root.querySelectorAll('[data-ui-interaction-focus="true"]').forEach((element) => {
        element.removeAttribute('data-ui-interaction-focus');
    });
};

const persistInteractionFocus = (element) => {
    clearInteractionFocus();
    element.setAttribute('data-ui-interaction-focus', 'true');
};

const registerInteractionFocusClear = () => {
    if (interactionFocusClearRegistered) {
        return;
    }

    interactionFocusClearRegistered = true;

    document.addEventListener('pointerdown', () => {
        clearInteractionFocus();
    }, true);

    document.addEventListener('keydown', () => {
        clearInteractionFocus();
    }, true);
};

export function initInteractionFocus(root = document) {
    registerInteractionFocusClear();

    root.querySelectorAll(interactionFocusSelector).forEach((element) => {
        if (!(element instanceof HTMLElement) || element.dataset.uiInteractionFocusInitialized === 'true') {
            return;
        }

        element.dataset.uiInteractionFocusInitialized = 'true';
        element.addEventListener('click', () => persistInteractionFocus(element));
    });
}
