const tagSelector = '[data-ui-tag]';
const selectableSelector = '[data-ui-tag-variant="selectable"]';
const operationalSelector = '[data-ui-tag-operational]';
const dismissSelector = '[data-ui-tag-dismiss]';

const setSelected = (tag, selected) => {
    tag.classList.toggle('ui-tag-selected', selected);
    tag.dataset.uiTagSelected = selected ? 'true' : 'false';
    tag.setAttribute('aria-pressed', selected ? 'true' : 'false');
};

const setExpanded = (trigger, expanded) => {
    const targetId = trigger.dataset.uiTagDisclosureTarget;
    const panel = targetId ? document.getElementById(targetId) : null;

    trigger.dataset.uiTagExpanded = expanded ? 'true' : 'false';
    trigger.setAttribute('aria-expanded', expanded ? 'true' : 'false');

    if (panel) {
        panel.hidden = !expanded;
    }
};

const closeDisclosure = (trigger) => {
    setExpanded(trigger, false);
};

const toggleDisclosure = (trigger) => {
    const isOpen = trigger.getAttribute('aria-expanded') === 'true';

    document.querySelectorAll(operationalSelector).forEach((otherTrigger) => {
        if (otherTrigger !== trigger) {
            closeDisclosure(otherTrigger);
        }
    });

    setExpanded(trigger, !isOpen);
};

const initDismissibleTags = (root) => {
    root.querySelectorAll(dismissSelector).forEach((button) => {
        if (!(button instanceof HTMLButtonElement) || button.dataset.uiTagDismissInit === '1') {
            return;
        }

        button.dataset.uiTagDismissInit = '1';
        button.addEventListener('click', () => {
            if (button.disabled) {
                return;
            }

            const tag = button.closest(tagSelector);

            if (tag instanceof HTMLElement) {
                tag.remove();
            }
        });
    });
};

const initSelectableTags = (root) => {
    root.querySelectorAll(selectableSelector).forEach((tag) => {
        if (!(tag instanceof HTMLButtonElement) || tag.dataset.uiTagSelectableInit === '1') {
            return;
        }

        tag.dataset.uiTagSelectableInit = '1';
        setSelected(tag, tag.dataset.uiTagSelected === 'true' || tag.classList.contains('ui-tag-selected'));

        tag.addEventListener('click', () => {
            if (tag.disabled) {
                return;
            }

            const group = tag.closest('[data-ui-tag-group]');
            const mode = group?.dataset.uiTagGroupSelectionMode;
            const nextSelected = tag.getAttribute('aria-pressed') !== 'true';

            if (mode === 'single' && nextSelected && group) {
                group.querySelectorAll(selectableSelector).forEach((otherTag) => {
                    if (otherTag instanceof HTMLButtonElement && otherTag !== tag) {
                        setSelected(otherTag, false);
                    }
                });
            }

            setSelected(tag, nextSelected);
        });
    });
};

const initOperationalTags = (root) => {
    root.querySelectorAll(operationalSelector).forEach((trigger) => {
        if (!(trigger instanceof HTMLButtonElement) || trigger.dataset.uiTagOperationalInit === '1') {
            return;
        }

        trigger.dataset.uiTagOperationalInit = '1';
        setExpanded(
            trigger,
            trigger.dataset.uiTagExpanded === 'true' || trigger.getAttribute('aria-expanded') === 'true',
        );

        trigger.addEventListener('click', () => {
            if (!trigger.disabled) {
                toggleDisclosure(trigger);
            }
        });

        trigger.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeDisclosure(trigger);
                trigger.focus();
            }
        });
    });
};

let documentListenersRegistered = false;

const registerDocumentListeners = () => {
    if (documentListenersRegistered) {
        return;
    }

    documentListenersRegistered = true;

    document.addEventListener('click', (event) => {
        const target = event.target;

        if (!(target instanceof Node)) {
            return;
        }

        document.querySelectorAll(operationalSelector).forEach((trigger) => {
            const targetId = trigger.dataset.uiTagDisclosureTarget;
            const panel = targetId ? document.getElementById(targetId) : null;

            if (trigger.contains(target) || panel?.contains(target)) {
                return;
            }

            closeDisclosure(trigger);
        });
    });

    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') {
            return;
        }

        document.querySelectorAll(operationalSelector).forEach((trigger) => {
            closeDisclosure(trigger);
        });
    });
};

export function initTags(root = document) {
    registerDocumentListeners();
    initDismissibleTags(root);
    initSelectableTags(root);
    initOperationalTags(root);
}
