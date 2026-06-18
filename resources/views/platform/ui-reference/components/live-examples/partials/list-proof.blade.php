@php
    $listKind = $sample['items'][0]['kind'] ?? 'unordered';
@endphp

@if ($listKind === 'ordered')
    <ol class="ui-list ui-list-ordered">
        <li>Review tenant identity.</li>
        <li>Confirm routing policy.
            <ol class="ui-list ui-list-ordered ui-list-nested">
                <li>Verify the primary domain.</li>
                <li>Confirm the fallback route.</li>
            </ol>
        </li>
        <li>Save the configuration.</li>
    </ol>
@elseif ($listKind === 'content')
    <ul class="ui-list ui-list-content">
        <li>Content lists remove marker styling when the surrounding content already provides structure.</li>
        <li>Use this only for content blocks, not navigation or actions.</li>
    </ul>
@else
    <ul class="ui-list ui-list-unordered">
        <li>Ordered and unordered content uses browser semantics.</li>
        <li>Nested lists are limited to content documentation, not app navigation.
            <ul class="ui-list ui-list-unordered ui-list-nested">
                <li>Nested item text remains short and supporting.</li>
            </ul>
        </li>
        <li>Comparable rows should move to structured list or table.</li>
    </ul>
@endif
