const allowedThemeModes = new Set(['system', 'dark', 'light']);

const resolveThemeMode = (mode) => {
    if (mode === 'dark' || mode === 'light') {
        return mode;
    }

    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
};

const getPreferredThemeMode = () => {
    const storedMode = window.localStorage.getItem('platform.theme.mode');

    if (allowedThemeModes.has(storedMode)) {
        return storedMode;
    }

    const datasetMode = document.documentElement.dataset.themeMode;

    return allowedThemeModes.has(datasetMode) ? datasetMode : 'system';
};

const applyThemeMode = (mode, persistLocal = true) => {
    const normalized = allowedThemeModes.has(mode) ? mode : 'system';
    const resolved = resolveThemeMode(normalized);
    const root = document.documentElement;

    root.dataset.themeMode = normalized;
    root.dataset.themeResolved = resolved;
    root.classList.toggle('dark', resolved === 'dark');
    root.style.backgroundColor = resolved === 'light' ? 'rgb(248 250 252)' : 'rgb(9 9 11)';
    root.style.color = resolved === 'light' ? 'rgb(15 23 42)' : 'rgb(241 245 249)';

    if (document.body) {
        document.body.style.backgroundColor = resolved === 'light' ? 'rgb(248 250 252)' : 'rgb(9 9 11)';
        document.body.style.color = resolved === 'light' ? 'rgb(15 23 42)' : 'rgb(241 245 249)';
    }

    if (persistLocal) {
        window.localStorage.setItem('platform.theme.mode', normalized);
    }

    document.querySelectorAll('[data-theme-mode-toggle]').forEach((button) => {
        const isActive = button.dataset.themeMode === normalized;
        button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
        button.dataset.uiCurrent = isActive ? 'true' : 'false';
    });
};

const persistThemePreference = (mode) => {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const url = document.body?.dataset.themeUpdateUrl;

    if (!url || !token) {
        return;
    }

    window.fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
            'X-CSRF-TOKEN': token,
            Accept: 'application/json',
        },
        body: new URLSearchParams({
            theme_preference: mode,
        }),
        credentials: 'same-origin',
    }).catch(() => {});
};

export const refreshThemeMode = () => {
    applyThemeMode(getPreferredThemeMode(), false);
};

export const initThemeModeControls = () => {
    if (document.body?.dataset.themeControlsInit === '1') {
        refreshThemeMode();
        return;
    }

    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');

    mediaQuery.addEventListener('change', () => {
        if ((document.documentElement.dataset.themeMode || 'system') === 'system') {
            applyThemeMode('system', false);
        }
    });

    document.body.dataset.themeControlsInit = '1';

    document.addEventListener('click', (event) => {
        const button = event.target.closest('[data-theme-mode-toggle]');

        if (!button) {
            return;
        }

        event.preventDefault();
        const mode = allowedThemeModes.has(button.dataset.themeMode) ? button.dataset.themeMode : 'system';
        applyThemeMode(mode);
        persistThemePreference(mode);
    });

    refreshThemeMode();
};
