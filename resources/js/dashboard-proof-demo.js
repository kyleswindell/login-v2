import Sortable from 'sortablejs';

const proofStorageKey = 'ui-reference.dashboard-proof-layout';

const defaultProofWidgets = [
    {
        id: 'ops-summary',
        title: 'Operations Summary',
        kicker: '1x1 summary',
        description: 'Compact operational summary with one primary signal.',
        metric: '84%',
        supporting: 'SLA health',
        span: '1x1',
        visible: true,
        tone: 'neutral',
        notes: ['Queue age stable', 'No blocked deploys'],
    },
    {
        id: 'review-queue',
        title: 'Review Queue',
        kicker: '2x1 workflow',
        description: 'Wider surface for the current review mix and queue pressure.',
        metric: '12',
        supporting: 'Open reviews',
        span: '2x1',
        visible: true,
        tone: 'notice',
        notes: ['4 awaiting design sign-off', '2 need escalation'],
    },
    {
        id: 'activity-feed',
        title: 'Activity Feed',
        kicker: '1x2 tall list',
        description: 'Taller card for stacked activity and sequencing cues.',
        metric: '3',
        supporting: 'Recent actions',
        span: '1x2',
        visible: true,
        tone: 'success',
        notes: ['Lock widget shell contract', 'Recheck overlay publication', 'Publish menu-item re-review'],
    },
    {
        id: 'notification-mix',
        title: 'Notification Mix',
        kicker: '2x2 detail',
        description: 'Mixed summary/detail proof with room for a secondary block.',
        metric: '7',
        supporting: 'Unread notifications',
        span: '2x2',
        visible: true,
        tone: 'neutral',
        notes: ['Oldest alert: 18m', '3 routed to operations', '1 pinned for manual review'],
    },
    {
        id: 'deploy-readiness',
        title: 'Deploy Readiness',
        kicker: '3x1 full row',
        description: 'Full-row proof for shared deployment and publication signals.',
        metric: '2',
        supporting: 'Pending approvals',
        span: '3x1',
        visible: true,
        tone: 'danger',
        notes: ['Staging owner assigned', 'Rollback notes current', 'Production hold active'],
    },
];

const spanClasses = {
    '1x1': 'xl:col-span-4',
    '2x1': 'xl:col-span-8',
    '1x2': 'xl:col-span-4 xl:row-span-2',
    '2x2': 'xl:col-span-8 xl:row-span-2',
    '3x1': 'xl:col-span-12',
};

const spanDescriptors = {
    '1x1': 'Compact summary widget',
    '2x1': 'Wide summary widget',
    '1x2': 'Tall two-row widget',
    '2x2': 'Wide two-row detail widget',
    '3x1': 'Full-row summary widget',
};

const toneClasses = {
    neutral: 'border-slate-800 bg-slate-950/70',
    success: 'border-emerald-500/30 bg-emerald-500/10',
    notice: 'border-sky-500/30 bg-sky-500/10',
    danger: 'border-rose-500/30 bg-rose-500/10',
};

const clearReorderPreview = (scope) => {
    scope.querySelectorAll('.dashboard-reorder-preview').forEach((node) => {
        node.classList.remove('dashboard-reorder-preview');
        node.removeAttribute('data-reorder-preview');
    });
};

const markReorderPreview = (event, scope) => {
    clearReorderPreview(scope);

    if (!(event.related instanceof HTMLElement)) {
        return;
    }

    event.related.classList.add('dashboard-reorder-preview');
    event.related.dataset.reorderPreview = event.willInsertAfter ? 'after' : 'before';
};

const cloneDefaultWidgets = () => defaultProofWidgets.map((widget, index) => ({
    ...widget,
    position: index,
}));

const normalizeWidgets = (widgets) => {
    const fallback = new Map(cloneDefaultWidgets().map((widget) => [widget.id, widget]));
    const ordered = [];

    widgets.forEach((widget) => {
        if (!fallback.has(widget.id) || ordered.some((item) => item.id === widget.id)) {
            return;
        }

        const base = fallback.get(widget.id);

        ordered.push({
            ...base,
            ...widget,
            visible: widget.visible !== false,
        });
    });

    fallback.forEach((widget) => {
        if (!ordered.some((item) => item.id === widget.id)) {
            ordered.push(widget);
        }
    });

    return ordered.map((widget, index) => ({
        ...widget,
        position: index,
    }));
};

window.dashboardProofDemo = function () {
    return {
        editing: false,
        sortableInstance: null,
        widgets: cloneDefaultWidgets(),

        init() {
            this.load();

            this.$nextTick(() => {
                this.syncSortable();
            });

            this.$watch('editing', () => {
                this.$nextTick(() => {
                    this.syncSortable();
                });
            });

            this.$watch('widgets', () => {
                this.save();

                this.$nextTick(() => {
                    this.syncSortable();
                });
            });
        },

        load() {
            try {
                const stored = window.localStorage.getItem(proofStorageKey);

                if (!stored) {
                    return;
                }

                const parsed = JSON.parse(stored);

                if (Array.isArray(parsed)) {
                    this.widgets = normalizeWidgets(parsed);
                }
            } catch (_) {
                this.widgets = cloneDefaultWidgets();
            }
        },

        save() {
            window.localStorage.setItem(proofStorageKey, JSON.stringify(this.widgets));
        },

        reset() {
            this.widgets = cloneDefaultWidgets();
            this.editing = false;
        },

        toggleEditing() {
            this.editing = !this.editing;
        },

        hideWidget(id) {
            if (!this.editing) {
                return;
            }

            this.widgets = this.widgets.map((widget) => (
                widget.id === id ? { ...widget, visible: false } : widget
            ));
        },

        showWidget(id) {
            if (!this.editing) {
                return;
            }

            this.widgets = this.widgets.map((widget) => (
                widget.id === id ? { ...widget, visible: true } : widget
            ));
        },

        syncSortable() {
            const grid = this.$refs.visibleGrid;

            if (!(grid instanceof HTMLElement)) {
                return;
            }

            if (!this.editing) {
                if (this.sortableInstance) {
                    this.sortableInstance.destroy();
                    this.sortableInstance = null;
                }

                return;
            }

            if (this.sortableInstance) {
                return;
            }

            this.sortableInstance = Sortable.create(grid, {
                handle: '.dashboard-proof-drag-handle',
                animation: 150,
                swapThreshold: 0.65,
                invertSwap: true,
                invertedSwapThreshold: 0.45,
                ghostClass: 'dashboard-sort-ghost',
                chosenClass: 'dashboard-sort-chosen',
                dragClass: 'dashboard-sort-drag',
                onMove: (event) => {
                    markReorderPreview(event, grid);
                },
                onEnd: () => {
                    clearReorderPreview(grid);

                    const orderedIds = Array.from(grid.querySelectorAll('[data-proof-widget-id]'))
                        .map((node) => node.dataset.proofWidgetId)
                        .filter(Boolean);

                    const hidden = this.widgets.filter((widget) => !widget.visible);
                    const visibleById = new Map(this.widgets
                        .filter((widget) => widget.visible)
                        .map((widget) => [widget.id, widget]));

                    const reorderedVisible = orderedIds
                        .map((id) => visibleById.get(id))
                        .filter(Boolean);

                    this.widgets = normalizeWidgets([...reorderedVisible, ...hidden]);
                },
                onUnchoose: () => {
                    clearReorderPreview(grid);
                },
            });
        },

        get visibleWidgets() {
            return this.widgets.filter((widget) => widget.visible);
        },

        get hiddenWidgets() {
            return this.widgets.filter((widget) => !widget.visible);
        },

        cardClass(widget) {
            return toneClasses[widget.tone] ?? toneClasses.neutral;
        },

        spanClass(widget) {
            return spanClasses[widget.span] ?? spanClasses['1x1'];
        },

        spanDescriptor(widget) {
            return spanDescriptors[widget.span] ?? 'Widget proof surface';
        },

        savedLayoutPreview() {
            return JSON.stringify(this.widgets.map((widget, index) => ({
                widget_key: widget.id,
                position: index,
                column_span: widget.span,
                is_visible: widget.visible,
            })), null, 2);
        },
    };
};
