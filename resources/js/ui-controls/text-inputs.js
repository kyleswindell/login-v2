const syncPasswordToggle = (button, input) => {
    const isVisible = input.type === 'text';

    button.setAttribute('aria-pressed', isVisible ? 'true' : 'false');
    button.setAttribute('aria-label', isVisible ? 'Hide password' : 'Show password');
};

export function initTextInputs(root = document) {
    root.querySelectorAll('[data-ui-text-input]').forEach((field) => {
        if (!(field instanceof HTMLElement) || field.dataset.uiTextInputInit === '1') {
            return;
        }

        const input = field.querySelector('[data-ui-text-input-control]');
        const toggle = field.querySelector('[data-ui-password-toggle]');

        if (!(input instanceof HTMLInputElement) || !(toggle instanceof HTMLButtonElement)) {
            field.dataset.uiTextInputInit = '1';
            return;
        }

        field.dataset.uiTextInputInit = '1';
        syncPasswordToggle(toggle, input);

        toggle.addEventListener('click', () => {
            if (input.disabled || input.readOnly || toggle.disabled) {
                return;
            }

            input.type = input.type === 'password' ? 'text' : 'password';
            syncPasswordToggle(toggle, input);
            input.focus();
        });
    });
}
