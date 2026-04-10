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

    const track = host.querySelector('[data-sidebar-track]');
    const mainPanel = host.querySelector('[data-main-nav-panel]');
    const openBtn = host.querySelector('[data-setup-open]');
    const closeBtn = host.querySelector('[data-setup-close]');

    if (!track || !mainPanel || !openBtn || !closeBtn) {
        return;
    }

    let isOpen = false;

    const panelWidth = () => Math.round(mainPanel.getBoundingClientRect().width);

    const openSetup = () => {
        track.style.transform = `translateX(-${panelWidth()}px)`;
        openBtn.setAttribute('aria-expanded', 'true');
        isOpen = true;
    };

    const closeSetup = () => {
        track.style.transform = 'translateX(0)';
        openBtn.setAttribute('aria-expanded', 'false');
        isOpen = false;
    };

    openBtn.addEventListener('click', openSetup);
    closeBtn.addEventListener('click', closeSetup);

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
}

document.addEventListener('DOMContentLoaded', initSetupSidebar);
