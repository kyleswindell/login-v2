                <div class="fixed inset-0 z-50 hidden bg-black/70 lg:hidden" data-sidebar-backdrop></div>

                <div @class([
                    'mx-auto flex min-h-[calc(100vh-5.5rem)] w-full max-w-[1700px] gap-6 px-4 py-6 xl:px-6',
                    'flex-col lg:flex-row' => $hasCustomSidebar,
                    'flex-col lg:flex-row' => ! $hasCustomSidebar,
                ])>
                    @include('components.layouts.app.sidebar')

                    <main class="flex min-h-full min-w-0 flex-1 flex-col">
                        {{ $slot }}
                    </main>
                </div>
