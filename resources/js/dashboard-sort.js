import Sortable from 'sortablejs';

/**
 * Alpine.js data function for dashboard drag-and-drop reordering.
 *
 * The component is initialized on the widget grid and dispatches
 * a Livewire `reorderWidgets` call whenever the user drops a widget.
 *
 * Usage (see livewire/platform/dashboard.blade.php):
 *   x-data="dashboardSort(initialOrder)"
 *   x-init="init()"
 */
window.dashboardSort = function (initialOrder) {
    return {
        order: initialOrder,
        sortableInstance: null,

        init() {
            const el = this.$el;

            this.sortableInstance = Sortable.create(el, {
                handle: '.dashboard-drag-handle',
                animation: 150,
                ghostClass: 'opacity-40',
                dragClass: 'ring-2 ring-emerald-500/50',

                onEnd: () => {
                    const orderedVisibleKeys = Array.from(el.querySelectorAll('[data-widget-key]'))
                        .map((node) => node.dataset.widgetKey)
                        .filter(Boolean);

                    // Persist only the visible widget identity order.
                    // Livewire rebuilds the saved layout deterministically so
                    // hidden widgets and placement metadata remain valid.
                    this.$wire.call('reorderWidgets', orderedVisibleKeys);
                },
            });
        },

        destroy() {
            if (this.sortableInstance) {
                this.sortableInstance.destroy();
                this.sortableInstance = null;
            }
        },
    };
};
