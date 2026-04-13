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
                    const newOrder = Array.from(el.querySelectorAll('[data-widget-key]'))
                        .map((node, index) => ({
                            widget_key: node.dataset.widgetKey,
                            position: index,
                        }));

                    // Merge new position values into the existing layout array
                    // so column_span and is_visible values are preserved.
                    const positionMap = Object.fromEntries(
                        newOrder.map(({ widget_key, position }) => [widget_key, position])
                    );

                    // Dispatch to Livewire — the component re-merges with the full layout
                    // and persists the result.
                    this.$wire.call('reorderWidgets',
                        this.$wire.get('widgetLayout').map(slot => ({
                            ...slot,
                            position: positionMap[slot.widget_key] ?? slot.position,
                        }))
                    );
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
