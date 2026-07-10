{{-- ==========================================================================
    File: resources/views/components/ui/tree-view/index.blade.php
    Purpose: Tree View component.

    Source: Converted from the Carbon TreeView / TreeNode React components.

    Notes:
    - Emits the installed .ui-tree-view selector contract.
    - Renders an array-driven tree from the nodes prop.
    - Tree node rendering is internal because no x-ui.tree-node Blade
      component exists at this time.
    - Supports selected, active, expanded, disabled, href, multiselect, hidden
      label, and xs/sm size metadata.
    - Expand/collapse, roving focus, and selection behavior are handled by
      installed Tree View JavaScript when available.
    ========================================================================== --}}

@props([
    'id' => null,
    'nodes' => [],
    'label' => 'Tree view',
    'hideLabel' => false,
    'selected' => [],
    'active' => null,
    'expanded' => [],
    'multiselect' => false,
    'size' => 'sm',
])

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\HtmlString;

    /*
    |--------------------------------------------------------------------------
    | Supported Public Values
    |--------------------------------------------------------------------------
    */

    $allowedSizes = [
        'xs',
        'sm',
    ];

    /*
    |--------------------------------------------------------------------------
    | Resolve Values
    |--------------------------------------------------------------------------
    */

    $treeId = $id ?? 'ui-tree-view-'.Str::uuid();
    $labelId = $treeId.'-label';
    $treeRootId = $treeId.'-root';

    $resolvedSize = in_array($size, $allowedSizes, true)
        ? $size
        : 'sm';

    /*
    |--------------------------------------------------------------------------
    | Render State
    |--------------------------------------------------------------------------
    */

    $isLabelHidden = filter_var($hideLabel, FILTER_VALIDATE_BOOLEAN);
    $isMultiselect = filter_var($multiselect, FILTER_VALIDATE_BOOLEAN);

    $selectedIds = collect(is_array($selected) ? $selected : (is_null($selected) ? [] : [$selected]))
        ->map(fn ($item) => (string) $item);

    $expandedIds = collect(is_array($expanded) ? $expanded : (is_null($expanded) ? [] : [$expanded]))
        ->map(fn ($item) => (string) $item);

    $activeId = is_null($active) ? null : (string) $active;
    $hasActive = filled($activeId);

    $firstTabbableAssigned = false;

    /*
    |--------------------------------------------------------------------------
    | Recursive Node Renderer
    |--------------------------------------------------------------------------
    |
    | Node shape:
    | [
    |     'id' => 'unique-id',
    |     'label' => 'Node label',
    |     'href' => '/optional-link',
    |     'children' => [...],
    |     'expanded' => true,
    |     'selected' => true,
    |     'active' => true,
    |     'disabled' => true,
    | ]
    |
    */

    $renderNodes = function (
        $nodeList,
        int $level = 1,
        ?string $listDomId = null,
        ?string $labelledBy = null,
        bool $hidden = false
    ) use (
        &$renderNodes,
        &$firstTabbableAssigned,
        $treeId,
        $treeRootId,
        $label,
        $labelId,
        $isLabelHidden,
        $isMultiselect,
        $selectedIds,
        $activeId,
        $hasActive,
        $expandedIds,
        $resolvedSize
    ): string {
        $nodesCollection = collect($nodeList)->values();
        $role = $level === 1 ? 'tree' : 'group';

        $listClasses = [
            'ui-tree-view-list',
            'ui-tree-view-list--root' => $level === 1,
            'ui-tree-view-list--nested' => $level > 1,
            'ui-tree-node__children' => $level > 1,
            'ui-tree-node--hidden' => $hidden,
        ];

        $html = '<ul class="'.e(collect($listClasses)->filter(fn ($enabled) => $enabled !== false)->keys()->implode(' ')).'"';
        $html .= ' role="'.e($role).'"';
        $html .= ' data-ui-tree-level="'.e((string) $level).'"';

        if ($level === 1) {
            $html .= ' id="'.e($treeRootId).'"';
            $html .= ' data-ui-tree-root';
            $html .= ' data-ui-tree-size="'.e($resolvedSize).'"';

            if ($isLabelHidden) {
                $html .= ' aria-label="'.e(strip_tags((string) $label)).'"';
            } else {
                $html .= ' aria-labelledby="'.e($labelId).'"';
            }

            if ($isMultiselect) {
                $html .= ' aria-multiselectable="true"';
            }
        } else {
            if (filled($listDomId)) {
                $html .= ' id="'.e($listDomId).'"';
            }

            if (filled($labelledBy)) {
                $html .= ' aria-labelledby="'.e($labelledBy).'"';
            }

            if ($hidden) {
                $html .= ' hidden';
            }
        }

        $html .= '>';

        foreach ($nodesCollection as $index => $node) {
            $rawNodeId = (string) data_get($node, 'id', data_get($node, 'value', data_get($node, 'label', 'node-'.$level.'-'.$index)));
            $safeNodeId = Str::slug($rawNodeId) ?: 'node-'.$level.'-'.$index;
            $nodeDomId = $treeId.'-'.$safeNodeId;
            $nodeLabelId = $nodeDomId.'-label';
            $subtreeId = $nodeDomId.'-subtree';

            $nodeLabel = (string) data_get($node, 'label', $rawNodeId);
            $children = data_get($node, 'children', []);
            $hasChildren = ! empty($children);

            $nodeExpandedValue = data_get($node, 'expanded');
            $isExpanded = ! is_null($nodeExpandedValue)
                ? filter_var($nodeExpandedValue, FILTER_VALIDATE_BOOLEAN)
                : $expandedIds->contains($rawNodeId);

            $nodeSelectedValue = data_get($node, 'selected');
            $isSelected = ! is_null($nodeSelectedValue)
                ? filter_var($nodeSelectedValue, FILTER_VALIDATE_BOOLEAN)
                : $selectedIds->contains($rawNodeId);

            $nodeActiveValue = data_get($node, 'active');
            $isActive = ! is_null($nodeActiveValue)
                ? filter_var($nodeActiveValue, FILTER_VALIDATE_BOOLEAN)
                : $activeId === $rawNodeId;

            $isDisabled = filter_var(data_get($node, 'disabled', false), FILTER_VALIDATE_BOOLEAN);
            $href = data_get($node, 'href');

            $tabIndex = '-1';

            if (! $isDisabled && (($hasActive && $isActive) || (! $hasActive && ! $firstTabbableAssigned))) {
                $tabIndex = '0';
                $firstTabbableAssigned = true;
            }

            $nodeClasses = [
                'ui-tree-view-node',
                'ui-tree-node',
                'ui-tree-parent-node' => $hasChildren,
                'ui-tree-leaf-node' => ! $hasChildren,
                'ui-tree-node--active' => $isActive,
                'ui-tree-node--selected' => $isSelected,
                'ui-tree-node--disabled' => $isDisabled,
                'ui-tree-node--expanded' => $hasChildren && $isExpanded,
                'ui-tree-node--collapsed' => $hasChildren && ! $isExpanded,
            ];

            $nodeClassString = collect($nodeClasses)
                ->filter(fn ($enabled) => $enabled !== false)
                ->keys()
                ->implode(' ');

            $nodeAttrs = ' id="'.e($nodeDomId).'"';
            $nodeAttrs .= ' class="'.e($nodeClassString).'"';
            $nodeAttrs .= ' role="treeitem"';
            $nodeAttrs .= ' tabindex="'.e($tabIndex).'"';
            $nodeAttrs .= ' aria-level="'.e((string) $level).'"';

            if ($hasChildren) {
                $nodeAttrs .= ' aria-expanded="'.($isExpanded ? 'true' : 'false').'"';
                $nodeAttrs .= ' aria-owns="'.e($subtreeId).'"';
            }

            if (! $isDisabled) {
                $nodeAttrs .= ' aria-selected="'.($isSelected ? 'true' : 'false').'"';
            }

            if ($isActive) {
                $nodeAttrs .= filled($href) ? ' aria-current="page"' : ' aria-current="true"';
            }

            if ($isDisabled) {
                $nodeAttrs .= ' aria-disabled="true"';
            }

            $nodeAttrs .= ' data-ui-tree-node';
            $nodeAttrs .= ' data-ui-tree-node-id="'.e($rawNodeId).'"';
            $nodeAttrs .= ' data-ui-tree-node-level="'.e((string) $level).'"';
            $nodeAttrs .= ' data-ui-tree-expanded="'.($isExpanded ? 'true' : 'false').'"';
            $nodeAttrs .= ' data-ui-tree-selected="'.($isSelected ? 'true' : 'false').'"';
            $nodeAttrs .= ' data-ui-tree-active="'.($isActive ? 'true' : 'false').'"';
            $nodeAttrs .= ' data-ui-tree-disabled="'.($isDisabled ? 'true' : 'false').'"';

            if ($hasChildren) {
                $nodeAttrs .= ' data-ui-tree-parent-node';
            } else {
                $nodeAttrs .= ' data-ui-tree-leaf';
            }

            $controlHtml = '<span class="ui-tree-view-node-control"'.($hasChildren ? ' data-ui-tree-trigger' : ' data-ui-tree-leaf-control').'>';

            if ($hasChildren) {
                $controlHtml .= '<span class="ui-tree-view-caret" aria-hidden="true">'.($isExpanded ? '▾' : '▸').'</span>';
            } else {
                $controlHtml .= '<span class="ui-tree-view-spacer" aria-hidden="true"></span>';
            }

            $controlHtml .= '<span id="'.e($nodeLabelId).'" class="ui-tree-view-label ui-tree-node__label__text">'.e($nodeLabel).'</span>';
            $controlHtml .= '</span>';

            if (filled($href) && ! $isDisabled) {
                $html .= '<li role="none" class="'.($hasChildren ? 'ui-tree-node-link-parent' : 'ui-tree-node-link-leaf').'">';
                $html .= '<a href="'.e($href).'"'.$nodeAttrs.'>';
                $html .= $controlHtml;
                $html .= '</a>';

                if ($hasChildren) {
                    $html .= $renderNodes($children, $level + 1, $subtreeId, $nodeLabelId, ! $isExpanded);
                }

                $html .= '</li>';
            } else {
                $html .= '<li'.$nodeAttrs.'>';
                $html .= $controlHtml;

                if ($hasChildren) {
                    $html .= $renderNodes($children, $level + 1, $subtreeId, $nodeLabelId, ! $isExpanded);
                }

                $html .= '</li>';
            }
        }

        return $html.'</ul>';
    };

    /*
    |--------------------------------------------------------------------------
    | CSS Class Contract
    |--------------------------------------------------------------------------
    */

    $rootClasses = [
        'ui-tree-view',
        'ui-tree-view--'.$resolvedSize,
        'ui-tree-view--multiselect' => $isMultiselect,
        'ui-tree-view--label-hidden' => $isLabelHidden,
    ];
@endphp

<div
    {{ $attributes->class($rootClasses)->merge([
        'id' => $treeId,
        'data-ui-component' => 'tree-view',
        'data-ui-tree-view' => true,
        'data-ui-tree-view-size' => $resolvedSize,
        'data-ui-tree-view-multiselect' => $isMultiselect ? 'true' : 'false',
        'data-ui-tree-view-label-hidden' => $isLabelHidden ? 'true' : 'false',
    ]) }}
>
    @unless ($isLabelHidden)
        <span id="{{ $labelId }}" class="ui-label">
            @if ($label instanceof HtmlString)
                {!! $label !!}
            @else
                {{ $label }}
            @endif
        </span>
    @endunless

    {!! $renderNodes($nodes) !!}
</div>