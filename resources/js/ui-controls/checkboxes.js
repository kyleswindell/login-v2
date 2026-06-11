const checkboxInput = (root) => root.querySelector('[data-ui-checkbox-input]');

const childInputsForParent = (group, parentId) => Array.from(group.querySelectorAll(`[data-ui-checkbox-child="${CSS.escape(parentId)}"] [data-ui-checkbox-input]`))
    .filter((input) => input instanceof HTMLInputElement);

const setIndeterminate = (input, mixed) => {
    input.indeterminate = mixed;
    input.setAttribute('aria-checked', mixed ? 'mixed' : (input.checked ? 'true' : 'false'));
    const root = input.closest('[data-ui-checkbox-root]');

    if (!root) {
        return;
    }

    if (mixed) {
        root.setAttribute('data-ui-checkbox-indeterminate', 'true');
    } else {
        root.removeAttribute('data-ui-checkbox-indeterminate');
    }
};

const syncParentFromChildren = (group, parentRoot) => {
    const parentId = parentRoot.dataset.uiCheckboxParent;
    const parentInput = checkboxInput(parentRoot);

    if (!parentId || !(parentInput instanceof HTMLInputElement)) {
        return;
    }

    const children = childInputsForParent(group, parentId).filter((input) => !input.disabled);
    const checkedChildren = children.filter((input) => input.checked);

    parentInput.checked = children.length > 0 && checkedChildren.length === children.length;
    setIndeterminate(parentInput, checkedChildren.length > 0 && checkedChildren.length < children.length);
};

const syncChildrenFromParent = (group, parentRoot) => {
    const parentId = parentRoot.dataset.uiCheckboxParent;
    const parentInput = checkboxInput(parentRoot);

    if (!parentId || !(parentInput instanceof HTMLInputElement)) {
        return;
    }

    childInputsForParent(group, parentId).forEach((child) => {
        if (child.disabled || child.closest('[data-ui-checkbox-readonly]')) {
            return;
        }

        child.checked = parentInput.checked;
        setIndeterminate(child, false);
    });

    setIndeterminate(parentInput, false);
};

const preventReadonlyMutation = (root) => {
    root.querySelectorAll('[data-ui-checkbox-readonly] [data-ui-checkbox-input]').forEach((input) => {
        if (!(input instanceof HTMLInputElement) || input.dataset.uiCheckboxReadonlyInitialized === 'true') {
            return;
        }

        input.dataset.uiCheckboxReadonlyInitialized = 'true';
        input.addEventListener('click', (event) => {
            event.preventDefault();
        });
        input.addEventListener('keydown', (event) => {
            if (event.key === ' ') {
                event.preventDefault();
            }
        });
    });
};

export function initCheckboxes(root = document) {
    preventReadonlyMutation(root);

    root.querySelectorAll('[data-ui-checkbox-nested-group]').forEach((group) => {
        if (group.dataset.uiCheckboxNestedInitialized === 'true') {
            return;
        }

        group.dataset.uiCheckboxNestedInitialized = 'true';

        const parentRoots = Array.from(group.querySelectorAll('[data-ui-checkbox-parent]'));
        parentRoots.forEach((parentRoot) => syncParentFromChildren(group, parentRoot));

        parentRoots.forEach((parentRoot) => {
            const parentInput = checkboxInput(parentRoot);

            if (!(parentInput instanceof HTMLInputElement)) {
                return;
            }

            parentInput.addEventListener('change', () => {
                if (parentRoot.hasAttribute('data-ui-checkbox-readonly')) {
                    syncParentFromChildren(group, parentRoot);
                    return;
                }

                syncChildrenFromParent(group, parentRoot);
            });
        });

        group.querySelectorAll('[data-ui-checkbox-child] [data-ui-checkbox-input]').forEach((childInput) => {
            if (!(childInput instanceof HTMLInputElement)) {
                return;
            }

            childInput.addEventListener('change', () => {
                const parentId = childInput.closest('[data-ui-checkbox-child]')?.dataset.uiCheckboxChild;
                const parentRoot = parentId ? group.querySelector(`[data-ui-checkbox-parent="${CSS.escape(parentId)}"]`) : null;

                if (parentRoot instanceof HTMLElement) {
                    syncParentFromChildren(group, parentRoot);
                }
            });
        });
    });
}
