export const initFilterPanels = () => {
    document.querySelectorAll('[data-filter-toggle]').forEach((toggle) => {
        if (toggle.dataset.filterToggleInit === '1') {
            return;
        }
        toggle.dataset.filterToggleInit = '1';

        const panel = toggle.closest('section')?.querySelector('[data-filter-panel]')
            ?? document.querySelector('[data-filter-panel]');

        if (!panel) {
            return;
        }

        const syncExpandedState = () => {
            toggle.setAttribute('aria-expanded', panel.classList.contains('hidden') ? 'false' : 'true');
        };

        const setOpen = (open) => {
            panel.classList.toggle('hidden', !open);
            syncExpandedState();
        };

        syncExpandedState();

        toggle.addEventListener('click', () => {
            setOpen(panel.classList.contains('hidden'));
        });

        document.addEventListener('click', (event) => {
            if (panel.classList.contains('hidden')) {
                return;
            }

            if (toggle.contains(event.target) || panel.contains(event.target)) {
                return;
            }

            setOpen(false);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !panel.classList.contains('hidden')) {
                setOpen(false);
            }
        });
    });
};
