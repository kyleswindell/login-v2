<x-layouts.app title="Documentation Vault">
    <x-slot:sidebar>
        <div class="space-y-6 xl:flex xl:h-full xl:flex-col">
            <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30">
                <p class="text-sm font-medium uppercase tracking-[0.3em] text-slate-300">Platform Management</p>
                <h1 class="mt-3 text-2xl font-semibold text-white">Documentation Vault</h1>
                <p class="mt-2 text-sm text-slate-400">Browse the current `docs/` repository directly inside the staging app.</p>

                <div class="mt-6">
                    <a wire:navigate href="{{ route('dashboard') }}" class="inline-flex rounded-md border border-slate-700 px-4 py-3 text-sm font-semibold text-slate-100 transition hover:border-slate-500 hover:text-white">
                        Back to app
                    </a>
                </div>
            </div>

            <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-6 shadow-2xl shadow-black/30 xl:flex xl:min-h-0 xl:flex-1 xl:flex-col">
                <h2 class="text-lg font-semibold text-white">Repository Tree</h2>
                <div
                    class="mt-4 text-sm xl:min-h-0 xl:flex-1 xl:overflow-y-auto [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden"
                    data-docs-tree
                    data-selected-path="{{ $selectedPath }}"
                >
                    @foreach ($tree as $node)
                        @include('platform.docs.partials.tree-node', ['node' => $node, 'selectedPath' => $selectedPath, 'depth' => 0])
                    @endforeach
                </div>
            </div>
        </div>
    </x-slot:sidebar>

    <section class="flex flex-1 flex-col gap-6">
        <div>
            <h1 class="ui-page-header-title">{{ $selectedFile['display_name'] ?? 'Documentation Vault' }}</h1>
            <p class="ui-page-header-copy">
                {{ $selectedFile['display_path'] ?? 'Select a note from the repository tree to review the current documentation vault.' }}
            </p>
        </div>

        <div id="selected-doc" class="rounded-lg border border-slate-800 bg-slate-900/70 p-8">
            @if ($selectedFile)
                <article class="max-w-none text-slate-300
                    [&_h1]:mt-8 [&_h1]:text-3xl [&_h1]:font-semibold [&_h1]:text-white
                    [&_h2]:mt-8 [&_h2]:text-2xl [&_h2]:font-semibold [&_h2]:text-white
                    [&_h3]:mt-6 [&_h3]:text-xl [&_h3]:font-semibold [&_h3]:text-white
                    [&_p]:mt-4 [&_p]:leading-7
                    [&_ul]:mt-4 [&_ul]:list-disc [&_ul]:space-y-2 [&_ul]:pl-6
                    [&_ol]:mt-4 [&_ol]:list-decimal [&_ol]:space-y-2 [&_ol]:pl-6
                    [&_li]:leading-7
                    [&_a]:font-medium [&_a]:text-slate-200 hover:[&_a]:text-white
                    [&_table]:mt-6 [&_table]:w-full [&_table]:border-collapse [&_table]:overflow-hidden [&_table]:rounded-md
                    [&_thead]:bg-slate-950/80
                    [&_th]:border [&_th]:border-slate-800 [&_th]:px-4 [&_th]:py-3 [&_th]:text-left [&_th]:text-sm [&_th]:font-semibold [&_th]:text-white
                    [&_td]:border [&_td]:border-slate-800 [&_td]:px-4 [&_td]:py-3 [&_td]:align-top
                    [&_code]:rounded [&_code]:bg-slate-950 [&_code]:px-1.5 [&_code]:py-0.5 [&_code]:text-slate-200
                    [&_pre]:mt-4 [&_pre]:overflow-x-auto [&_pre]:rounded-md [&_pre]:bg-slate-950 [&_pre]:p-4
                    [&_blockquote]:mt-4 [&_blockquote]:border-l-4 [&_blockquote]:border-slate-700 [&_blockquote]:pl-4 [&_blockquote]:text-slate-400
                    [&_hr]:my-6 [&_hr]:border-slate-800
                    [&_strong]:font-semibold [&_strong]:text-white">
                    {!! $selectedFile['rendered'] !!}
                </article>
            @else
                <div class="flex h-full min-h-[24rem] items-center justify-center rounded-md border border-dashed border-slate-800 bg-slate-950/40 px-6 text-center text-slate-500">
                    Select a file from the repository tree to view the current docs and notes content.
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
