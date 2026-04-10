/**
 * Setup sidebar slide-in/out behavior.
 *
 * The sidebar host contains a flex track with two panels side by side.
 * Translating the track by -288px (w-72) slides to the Setup panel.
 * Translating back to 0 restores the main nav.
 */

const PANEL_WIDTH_PX = 288; // Tailwind w-72 = 18rem = 288px at default 16px base

function initSetupSidebar() {
    const host = document.querySelector('[data-sidebar-host]');
    if (!host) {
        return;
    }

    const track = host.querySelector('[data-sidebar-track]');
    const openBtn = host.querySelector('[data-setup-open]');
    const closeBtn = host.querySelector('[data-setup-close]');

    if (!track || !openBtn || !closeBtn) {
        return;
    }

    const openSetup = () => {
        track.style.transform = `translateX(-${PANEL_WIDTH_PX}px)`;
        openBtn.setAttribute('aria-expanded', 'true');
    };

    const closeSetup = () => {
        track.style.transform = 'translateX(0)';
        openBtn.setAttribute('aria-expanded', 'false');
    };

    openBtn.addEventListener('click', openSetup);
    closeBtn.addEventListener('click', closeSetup);

    // Close on Escape key
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && track.style.transform !== 'translateX(0)') {
            closeSetup();
        }
    });
}

document.addEventListener('DOMContentLoaded', initSetupSidebar);
