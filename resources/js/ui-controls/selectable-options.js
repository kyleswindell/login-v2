const syncSelectableOptionStates = (scope = document) => {
    scope.querySelectorAll('.ui-selectable-option').forEach((option) => {
        const input = option.querySelector('input[type="checkbox"], input[type="radio"]');

        if (!(input instanceof HTMLInputElement)) {
            return;
        }

        option.classList.toggle('is-selected', input.checked);
    });
};

export const initSelectableOptionStates = () => {
    if (document.body?.dataset.selectableOptionStateInit !== '1') {
        document.body.dataset.selectableOptionStateInit = '1';

        document.addEventListener('change', (event) => {
            const input = event.target.closest('.ui-selectable-option input[type="checkbox"], .ui-selectable-option input[type="radio"]');

            if (!(input instanceof HTMLInputElement)) {
                return;
            }

            const fieldset = input.closest('fieldset');

            if (input.type === 'radio' && input.name) {
                const scope = fieldset ?? document;

                scope.querySelectorAll(`input[type="radio"][name="${CSS.escape(input.name)}"]`).forEach((radio) => {
                    const option = radio.closest('.ui-selectable-option');

                    if (option) {
                        option.classList.toggle('is-selected', radio.checked);
                    }
                });

                return;
            }

            const option = input.closest('.ui-selectable-option');

            if (option) {
                option.classList.toggle('is-selected', input.checked);
            }
        });
    }

    syncSelectableOptionStates(document);
};
