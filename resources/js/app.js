import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-notification-menu]').forEach((menu) => {
        const trigger = menu.querySelector('[data-notification-trigger]');
        const panel = menu.querySelector('[data-notification-panel]');

        if (!trigger || !panel) {
            return;
        }

        let pinnedOpen = false;
        let hoverCloseTimeout;

        const setOpen = (open) => {
            panel.classList.toggle('hidden', !open);
            trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
        };

        const clearHoverClose = () => {
            if (hoverCloseTimeout) {
                window.clearTimeout(hoverCloseTimeout);
                hoverCloseTimeout = undefined;
            }
        };

        const closeIfTransient = () => {
            if (!pinnedOpen) {
                setOpen(false);
            }
        };

        const scheduleTransientClose = () => {
            clearHoverClose();

            hoverCloseTimeout = window.setTimeout(() => {
                closeIfTransient();
            }, 120);
        };

        [trigger, panel].forEach((element) => {
            element.addEventListener('mouseenter', () => {
                clearHoverClose();

                if (!pinnedOpen) {
                    setOpen(true);
                }
            });
        });

        trigger.addEventListener('mouseenter', () => {
            if (!pinnedOpen) {
                setOpen(true);
            }
        });

        trigger.addEventListener('mouseleave', scheduleTransientClose);
        panel.addEventListener('mouseleave', scheduleTransientClose);

        trigger.addEventListener('click', (event) => {
            event.preventDefault();
            clearHoverClose();
            pinnedOpen = !pinnedOpen;
            setOpen(pinnedOpen);
        });

        document.addEventListener('click', (event) => {
            if (!menu.contains(event.target)) {
                clearHoverClose();
                pinnedOpen = false;
                setOpen(false);
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                clearHoverClose();
                pinnedOpen = false;
                setOpen(false);
            }
        });
    });
});
