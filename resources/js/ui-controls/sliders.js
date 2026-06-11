const updateSliderValue = (component) => {
    const value = component.querySelector('[data-ui-slider-value]');
    const inputs = Array.from(component.querySelectorAll('[data-ui-slider-input]'));

    if (!value || inputs.length === 0) {
        return;
    }

    if (component.matches('[data-ui-range-slider]') && inputs.length > 1) {
        value.textContent = `${inputs[0].value} - ${inputs[1].value}`;
    } else {
        value.textContent = inputs[0].value;
    }
};

export function initSliders(root = document) {
    root.querySelectorAll('[data-ui-slider]').forEach((component) => {
        if (component.dataset.uiSliderInitialized === 'true') {
            return;
        }

        component.dataset.uiSliderInitialized = 'true';

        component.querySelectorAll('[data-ui-slider-input], [data-ui-slider-number]').forEach((input) => {
            input.addEventListener('input', () => {
                const paired = component.querySelector('[data-ui-slider-input]');

                if (input.matches('[data-ui-slider-number]') && paired && !component.matches('[data-ui-range-slider]')) {
                    paired.value = input.value;
                }

                updateSliderValue(component);
            });
        });

        updateSliderValue(component);
    });
}
