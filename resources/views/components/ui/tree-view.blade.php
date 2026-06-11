@props([
    'nodes' => [],
    'label' => 'Tree view',
    'selected' => null,
    'active' => null,
    'expanded' => [],
])

@php
    $expandedIds = collect($expanded)->map(fn ($item) => (string) $item);

    $renderNodes = function ($nodes, $level = 1) use (&$renderNodes, $selected, $active, $expandedIds) {
        $html = '<ul class="ui-tree-view-list" role="'.($level === 1 ? 'tree' : 'group').'" data-ui-tree-level="'.$level.'">';

        foreach ($nodes as $node) {
            $nodeId = (string) data_get($node, 'id', str()->slug(data_get($node, 'label', 'node')));
            $label = e(data_get($node, 'label', $nodeId));
            $children = data_get($node, 'children', []);
            $hasChildren = ! empty($children);
            $isExpanded = (bool) data_get($node, 'expanded', $expandedIds->contains($nodeId));
            $isSelected = (string) data_get($node, 'selected', $selected === $nodeId) === '1' || (string) $selected === $nodeId;
            $isActive = (string) data_get($node, 'active', $active === $nodeId) === '1' || (string) $active === $nodeId;
            $isDisabled = (bool) data_get($node, 'disabled', false);
            $href = data_get($node, 'href');

            $html .= '<li class="ui-tree-view-node" role="treeitem" aria-level="'.$level.'"';
            $html .= $hasChildren ? ' aria-expanded="'.($isExpanded ? 'true' : 'false').'"' : '';
            $html .= $isSelected ? ' aria-selected="true"' : ' aria-selected="false"';
            $html .= $isDisabled ? ' aria-disabled="true"' : '';
            $html .= ' data-ui-tree-node data-ui-tree-node-id="'.e($nodeId).'" data-ui-tree-expanded="'.($isExpanded ? 'true' : 'false').'" data-ui-tree-selected="'.($isSelected ? 'true' : 'false').'" data-ui-tree-active="'.($isActive ? 'true' : 'false').'">';

            if ($hasChildren) {
                $html .= '<button type="button" class="ui-tree-view-node-control" '.($isDisabled ? 'disabled' : '').' data-ui-tree-trigger>';
                $html .= '<span class="ui-tree-view-caret" aria-hidden="true">'.($isExpanded ? '-' : '+').'</span>';
                $html .= '<span class="ui-tree-view-label">'.$label.'</span>';
                $html .= '</button>';
                $html .= '<div data-ui-tree-children '.($isExpanded ? '' : 'hidden').'>'.$renderNodes($children, $level + 1).'</div>';
            } elseif ($href && ! $isDisabled) {
                $html .= '<a class="ui-tree-view-node-control" href="'.e($href).'" data-ui-tree-leaf>';
                $html .= '<span class="ui-tree-view-spacer" aria-hidden="true"></span><span class="ui-tree-view-label">'.$label.'</span>';
                $html .= '</a>';
            } else {
                $html .= '<span class="ui-tree-view-node-control" data-ui-tree-leaf>';
                $html .= '<span class="ui-tree-view-spacer" aria-hidden="true"></span><span class="ui-tree-view-label">'.$label.'</span>';
                $html .= '</span>';
            }

            $html .= '</li>';
        }

        return $html.'</ul>';
    };
@endphp

<nav
    {{ $attributes->class(['ui-tree-view']) }}
    data-ui-component="tree-view"
    data-ui-tree-view
    aria-label="{{ $label }}"
>
    {!! $renderNodes($nodes) !!}
</nav>
