<x-layouts.app title="Documentation Vault">
    <section class="flex flex-1 flex-col gap-6">
        <div class="rounded-3xl border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
            <p class="text-sm font-medium uppercase tracking-[0.3em] text-sky-300">Platform Management</p>
            <h1 class="mt-3 text-3xl font-semibold text-white">Documentation Vault</h1>
            <p class="mt-2 text-slate-400">Browse the current `docs/` repository directly inside the staging app.</p>

            @if ($selectedFile)
                <div class="mt-4 rounded-2xl border border-sky-500/20 bg-sky-500/10 px-4 py-3 text-sm text-sky-100">
                    Selected file: <span class="font-semibold">{{ $selectedFile['path'] }}</span>
                </div>
            @endif
        </div>

        <div class="grid min-h-[70vh] gap-6 lg:grid-cols-[22rem_minmax(0,1fr)]">
            <aside class="rounded-3xl border border-slate-800 bg-slate-900/70 p-6">
                <h2 class="text-lg font-semibold text-white">Repository Tree</h2>
                <div class="mt-4 overflow-y-auto text-sm">
                    @foreach ($tree as $node)
                        @include('platform.docs.partials.tree-node', ['node' => $node, 'selectedPath' => $selectedPath, 'depth' => 0])
                    @endforeach
                </div>
            </aside>

            <div id="selected-doc" class="rounded-3xl border border-slate-800 bg-slate-900/70 p-8">
                @if ($selectedFile)
                    <div class="border-b border-slate-800 pb-4">
                        <p class="text-sm uppercase tracking-[0.25em] text-slate-500">{{ strtoupper($selectedFile['extension']) }}</p>
                        <h2 class="mt-2 text-2xl font-semibold text-white">{{ $selectedFile['name'] }}</h2>
                        <p class="mt-2 break-all text-sm text-slate-400">{{ $selectedFile['path'] }}</p>
                    </div>

                    <article class="prose prose-invert mt-6 max-w-none prose-headings:text-white prose-p:text-slate-300 prose-a:text-sky-300 prose-code:text-sky-200 prose-strong:text-white">
                        {!! $selectedFile['rendered'] !!}
                    </article>
                @else
                    <div class="flex h-full min-h-[24rem] items-center justify-center rounded-2xl border border-dashed border-slate-800 bg-slate-950/40 px-6 text-center text-slate-500">
                        Select a file from the repository tree to view the current docs and notes content.
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-layouts.app>
