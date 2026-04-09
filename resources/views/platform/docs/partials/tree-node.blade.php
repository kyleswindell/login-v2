<div class="{{ $depth > 0 ? 'mt-1' : '' }}">
    @if ($node['type'] === 'directory')
        <div class="rounded-lg px-3 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500" style="margin-left: {{ $depth * 0.75 }}rem;">
            {{ $node['name'] }}
        </div>

        @foreach ($node['children'] as $child)
            @include('platform.docs.partials.tree-node', ['node' => $child, 'selectedPath' => $selectedPath, 'depth' => $depth + 1])
        @endforeach
    @else
        <a
            href="{{ route('platform.docs.index', ['path' => $node['path']]).'#selected-doc' }}"
            @class([
                'mt-1 block rounded-lg px-3 py-2 text-sm transition',
                'bg-sky-500/15 text-sky-200 ring-1 ring-sky-500/30' => $selectedPath === $node['path'],
                'text-slate-300 hover:bg-slate-800 hover:text-white' => $selectedPath !== $node['path'],
            ])
            style="margin-left: {{ $depth * 0.75 }}rem;"
        >
            {{ $node['name'] }}
        </a>
    @endif
</div>
