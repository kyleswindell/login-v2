const setExpanded = (node, expanded) => {
    const children = node.querySelector(':scope > [data-ui-tree-children]');
    const trigger = node.querySelector(':scope > [data-ui-tree-trigger]');
    const caret = trigger?.querySelector('.ui-tree-view-caret');

    node.setAttribute('aria-expanded', expanded ? 'true' : 'false');
    node.dataset.uiTreeExpanded = expanded ? 'true' : 'false';

    if (children) {
        children.hidden = !expanded;
    }

    if (caret) {
        caret.textContent = expanded ? '-' : '+';
    }
};

export function initTreeViews(root = document) {
    root.querySelectorAll('[data-ui-tree-view]').forEach((tree) => {
        if (tree.dataset.uiTreeInitialized === 'true') {
            return;
        }

        tree.dataset.uiTreeInitialized = 'true';

        tree.querySelectorAll('[data-ui-tree-trigger]').forEach((trigger) => {
            trigger.addEventListener('click', () => {
                const node = trigger.closest('[data-ui-tree-node]');

                if (node) {
                    setExpanded(node, node.getAttribute('aria-expanded') !== 'true');
                }
            });

            trigger.addEventListener('keydown', (event) => {
                const node = trigger.closest('[data-ui-tree-node]');

                if (!node) {
                    return;
                }

                if (['Enter', ' '].includes(event.key)) {
                    event.preventDefault();
                    setExpanded(node, node.getAttribute('aria-expanded') !== 'true');
                }
            });
        });
    });
}
