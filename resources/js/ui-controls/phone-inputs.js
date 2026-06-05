const formatPartialInternalPhoneNumber = (digits) => {
    if (digits.length <= 3) {
        return `(${digits}`;
    }

    if (digits.length <= 6) {
        return `(${digits.slice(0, 3)}) ${digits.slice(3)}`;
    }

    return `(${digits.slice(0, 3)}) ${digits.slice(3, 6)}-${digits.slice(6, 10)}`;
};

const normalizePhoneInputValue = (value) => {
    const normalizedWhitespace = value.trim().replace(/\s+/g, ' ');

    if (normalizedWhitespace === '') {
        return '';
    }

    const extensionMatch = normalizedWhitespace.match(/(?:ext\.?|extension|x)\s*(\d+)$/i);
    const extension = extensionMatch ? extensionMatch[1] : '';
    const baseValue = extensionMatch
        ? normalizedWhitespace.slice(0, normalizedWhitespace.length - extensionMatch[0].length).trim()
        : normalizedWhitespace;

    if (/[A-Za-z]/.test(baseValue)) {
        return normalizedWhitespace;
    }

    let digits = baseValue.replace(/\D+/g, '');

    if (digits.length > 10 && digits.startsWith('1')) {
        digits = digits.slice(1);
    }

    if (digits === '') {
        return normalizedWhitespace;
    }

    if (digits.length > 10) {
        return normalizedWhitespace;
    }

    const formatted = formatPartialInternalPhoneNumber(digits);

    return extension ? `${formatted} x${extension}` : formatted;
};

export const initInternalPhoneInputs = () => {
    document.querySelectorAll('[data-ui-phone-input]').forEach((input) => {
        if (!(input instanceof HTMLInputElement) || input.dataset.uiPhoneInputInit === '1') {
            return;
        }

        input.dataset.uiPhoneInputInit = '1';

        const syncFormattedValue = () => {
            const normalized = normalizePhoneInputValue(input.value);

            if (normalized !== input.value) {
                input.value = normalized;
            }
        };

        input.addEventListener('input', syncFormattedValue);
        input.addEventListener('blur', syncFormattedValue);
        syncFormattedValue();
    });
};
