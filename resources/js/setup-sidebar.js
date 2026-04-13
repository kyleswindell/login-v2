/**
 * Setup sidebar slide-in/out behavior.
 *
 * The sidebar host contains a flex track with two panels side by side.
 * We measure panel width at runtime to avoid coupling to a hard-coded value.
 */

function initSetupSidebar() {
    const host = document.querySelector('[data-sidebar-host]');
    if (!host) {
        return;
    }
    if (host.dataset.sidebarInit === '1') {
        return;
    }
    host.dataset.sidebarInit = '1';

    const track = host.querySelector('[data-sidebar-track]');
    const mainPanel = host.querySelector('[data-main-nav-panel]');
    const openBtn = host.querySelector('[data-setup-open]');
    const closeBtn = host.querySelector('[data-setup-close]');
    const setupNavLinks = host.querySelectorAll('[data-setup-nav-link]');
    const mainNavLinks = host.querySelectorAll('[data-main-nav-link]');
    const storageKey = 'platform.setupSidebarOpen';

    if (!track || !mainPanel || !openBtn || !closeBtn) {
        return;
    }

    let isOpen = false;

    const panelWidth = () => Math.round(mainPanel.getBoundingClientRect().width);

    const openSetup = ({ animate = true } = {}) => {
        if (!animate) {
            track.style.transition = 'none';
        }

        track.style.transform = `translateX(-${panelWidth()}px)`;
        openBtn.setAttribute('aria-expanded', 'true');
        window.localStorage.setItem(storageKey, '1');
        isOpen = true;

        if (!animate) {
            requestAnimationFrame(() => {
                track.style.transition = '';
            });
        }
    };

    const closeSetup = () => {
        track.style.transform = 'translateX(0)';
        openBtn.setAttribute('aria-expanded', 'false');
        window.localStorage.setItem(storageKey, '0');
        isOpen = false;
    };

    openBtn.addEventListener('click', openSetup);
    closeBtn.addEventListener('click', closeSetup);

    setupNavLinks.forEach((link) => {
        link.addEventListener('click', () => {
            window.localStorage.setItem(storageKey, '1');
        });
    });

    mainNavLinks.forEach((link) => {
        link.addEventListener('click', () => {
            window.localStorage.setItem(storageKey, '0');
        });
    });

    window.addEventListener('resize', () => {
        if (isOpen) {
            track.style.transform = `translateX(-${panelWidth()}px)`;
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && isOpen) {
            closeSetup();
        }
    });

    if (window.localStorage.getItem(storageKey) === '1') {
        openSetup({ animate: false });
    }
}

document.addEventListener('DOMContentLoaded', initSetupSidebar);
document.addEventListener('livewire:navigated', initSetupSidebar);
