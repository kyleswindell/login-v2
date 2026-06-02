import Sortable from 'sortablejs';

/**
 * Alpine.js data function for dashboard drag-and-drop reordering.
 *
 * The controller stays mounted in both locked and editing modes so Livewire
 * can toggle the sortable instance on demand instead of trying to inject
 * Alpine behavior only after the grid has already rendered.
 *
 * Usage (see livewire/platform/dashboard.blade.php):
 *   x-data="dashboardSort(@entangle('isEditing').live)"
 *   x-init="init()"
 */
window.dashboardSort = function (editingState = false) {
    return {
        editing: editingState,
        sortableInstance: null,

        init() {
            this.$watch('editing', (value) => {
                this.syncSortable(Boolean(value));
            });

            this.syncSortable(Boolean(this.editing));
        },

        syncSortable(enabled) {
            const el = this.$el;

            if (!(el instanceof HTMLElement)) {
                return;
            }

            if (!enabled) {
                this.destroy();
                return;
            }

            if (this.sortableInstance) {
                return;
            }

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
