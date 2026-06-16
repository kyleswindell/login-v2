const getTileInput = (tile) => tile.querySelector('.ui-tile__input');

const setTileSelected = (tile, selected) => {
    tile.classList.toggle('ui-tile--selected', selected);
    tile.dataset.uiSelected = selected ? 'true' : 'false';
    tile.setAttribute('aria-checked', selected ? 'true' : 'false');
};

const syncSelectableGroup = (input) => {
    const root = input.closest('[data-ui-tile-selectable]');

    if (!root) {
        return;
    }

    if (input.type !== 'radio' || !input.name) {
        setTileSelected(root, input.checked);
        return;
    }

    const form = input.form;
    const scope = form ?? document;
    const groupInputs = Array.from(scope.querySelectorAll('.ui-tile__input[type="radio"]'))
        .filter((groupInput) => groupInput.name === input.name);

    groupInputs.forEach((groupInput) => {
        const tile = groupInput.closest('[data-ui-tile-selectable]');

        if (tile) {
            setTileSelected(tile, groupInput.checked);
        }
    });
};

const initSelectableTile = (tile) => {
    if (!(tile instanceof HTMLElement) || tile.dataset.uiTileSelectableInit === '1') {
        return;
    }

    const input = getTileInput(tile);

    if (!(input instanceof HTMLInputElement)) {
        return;
    }

    tile.dataset.uiTileSelectableInit = '1';
    setTileSelected(tile, input.checked);

    input.addEventListener('change', () => syncSelectableGroup(input));

    tile.addEventListener('keydown', (event) => {
        if (input.disabled || ![' ', 'Enter'].includes(event.key)) {
            return;
        }

        event.preventDefault();
        input.click();
        syncSelectableGroup(input);
    });
};

const setTileExpanded = (tile, expanded) => {
    const trigger = tile.querySelector('[data-ui-tile-expand-trigger]');
    const panel = tile.querySelector('[data-ui-tile-expanded-panel]');

    tile.classList.toggle('ui-tile--expanded', expanded);
    tile.classList.toggle('ui-tile--collapsed', !expanded);
    tile.dataset.uiExpanded = expanded ? 'true' : 'false';
    tile.dataset.uiTileExpanded = expanded ? 'true' : 'false';

    if (trigger) {
        trigger.setAttribute('aria-expanded', expanded ? 'true' : 'false');
    }

    if (panel) {
        panel.hidden = !expanded;
    }
};

const initExpandableTile = (tile) => {
    if (!(tile instanceof HTMLElement) || tile.dataset.uiTileExpandableInit === '1') {
        return;
    }

    const trigger = tile.querySelector('[data-ui-tile-expand-trigger]');

    if (!(trigger instanceof HTMLButtonElement)) {
        return;
    }

    tile.dataset.uiTileExpandableInit = '1';
    setTileExpanded(tile, tile.dataset.uiTileExpanded === 'true' || tile.dataset.uiExpanded === 'true');

    trigger.addEventListener('click', () => {
        if (trigger.disabled) {
            return;
        }

        setTileExpanded(tile, tile.dataset.uiTileExpanded !== 'true');
    });

    tile.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && tile.dataset.uiTileExpanded === 'true') {
            setTileExpanded(tile, false);
            trigger.focus();
        }
    });
};

export function initTiles(root = document) {
    root.querySelectorAll('[data-ui-tile-selectable]').forEach(initSelectableTile);
    root.querySelectorAll('[data-ui-tile-expandable]').forEach(initExpandableTile);
}
