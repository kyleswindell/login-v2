import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-notification-menu]').forEach((menu) => {
        const trigger = menu.querySelector('[data-notification-trigger]');
        const panel = menu.querySelector('[data-notification-panel]');

        if (!trigger || !panel) {
            return;
        }

        let pinnedOpen = false;

        const setOpen = (open) => {
            panel.classList.toggle('hidden', !open);
            trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
        };

        const closeIfTransient = () => {
            if (!pinnedOpen) {
                setOpen(false);
            }
        };

        trigger.addEventListener('mouseenter', () => {
            if (!pinnedOpen) {
                setOpen(true);
            }
        });

        menu.addEventListener('mouseleave', closeIfTransient);

        trigger.addEventListener('click', (event) => {
            event.preventDefault();
            pinnedOpen = !pinnedOpen;
            setOpen(pinnedOpen);
        });

        document.addEventListener('click', (event) => {
            if (!menu.contains(event.target)) {
                pinnedOpen = false;
                setOpen(false);
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                pinnedOpen = false;
                setOpen(false);
            }
        });
    });
});
