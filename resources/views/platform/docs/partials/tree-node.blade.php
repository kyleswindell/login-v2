<div class="{{ $depth > 0 ? 'mt-1' : '' }}">
    @if ($node['type'] === 'directory')
        @php($isOpen = $selectedPath !== '' && str_starts_with($selectedPath, $node['path'].'/'))

        <details class="group" @open($isOpen)>
            <summary
                @class([
                    'flex cursor-pointer list-none items-center justify-between rounded-lg px-3 py-2 text-xs font-semibold uppercase tracking-[0.2em] transition',
                    'bg-sky-500/15 text-sky-200 ring-1 ring-sky-500/30' => $isOpen,
                    'text-slate-500 hover:bg-slate-800 hover:text-slate-200' => ! $isOpen,
                ])
                style="margin-left: {{ $depth * 0.75 }}rem;"
            >
                <span>{{ $node['name'] }}</span>
                <span class="text-[10px] text-slate-500 transition group-open:rotate-90 group-open:text-sky-200">›</span>
            </summary>

            <div class="mt-1">
                @foreach ($node['children'] as $child)
                    @include('platform.docs.partials.tree-node', ['node' => $child, 'selectedPath' => $selectedPath, 'depth' => $depth + 1])
                @endforeach
            </div>
        </details>
    @else
        <a
            href="{{ route('platform.docs.index', ['path' => $node['path']]) }}"
            @class([
                'mt-1 block rounded-lg px-3 py-2 text-sm transition',
                'bg-sky-500/15 text-sky-200 ring-1 ring-sky-500/30' => $selectedPath === $node['path'],
                'text-slate-300 hover:bg-slate-800 hover:text-white' => $selectedPath !== $node['path'],
            ])
            style="margin-left: {{ $depth * 0.75 }}rem;"
        >
            {{ \Illuminate\Support\Str::beforeLast($node['name'], '.'.pathinfo($node['name'], PATHINFO_EXTENSION)) }}
        </a>
    @endif
</div>
