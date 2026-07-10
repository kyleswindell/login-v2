/**
 * File: resources/js/ui-controls/docs-tree.js
 * Purpose: Documentation tree expansion behavior.
 */

export function initDocsTree() {
    const tree = document.querySelector('[data-docs-tree]');
    if (!tree) {
        return;
    }

    const selectedPath = tree.dataset.selectedPath || '';
    if (!selectedPath) {
        return;
    }

    tree.querySelectorAll('[data-docs-dir][data-docs-path]').forEach((node) => {
        const path = node.dataset.docsPath || '';
        if (path && (selectedPath === path || selectedPath.startsWith(`${path}/`))) {
            node.setAttribute('open', 'open');
        }
    });

    const selectedFile = tree.querySelector(`[data-docs-file][data-docs-path="${CSS.escape(selectedPath)}"]`);
    if (selectedFile) {
        selectedFile.scrollIntoView({ block: 'center' });
    }
}
