        <section class="ui-card">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="ui-kicker">Action Tokens</p>
                    <h2 class="ui-card-title mt-2">Buttons And Badges</h2>
                </div>
                <p class="text-sm text-slate-400">Mapped from DaisyUI button references into the project token system.</p>
            </div>

            <div class="mt-4 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                <button type="button" class="ui-action">Neutral</button>
                <button type="button" class="ui-action ui-action-primary">Primary</button>
                <button type="button" class="ui-action ui-action-success">Success</button>
                <button type="button" class="ui-action ui-action-warning">Warning</button>
                <button type="button" class="ui-action ui-action-danger">Danger</button>
                <button type="button" class="ui-action ui-action-notice">Notice</button>
                <button type="button" class="ui-action ui-action-info">Info</button>
                <button type="button" class="ui-action ui-action-ghost">Ghost</button>
            </div>

            <p class="mt-4 text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Soft Buttons</p>
            <div class="mt-2 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                <button type="button" class="ui-action ui-action-soft">Soft Neutral</button>
                <button type="button" class="ui-action ui-action-primary ui-action-soft">Soft Primary</button>
                <button type="button" class="ui-action ui-action-success ui-action-soft">Soft Success</button>
                <button type="button" class="ui-action ui-action-warning ui-action-soft">Soft Warning</button>
                <button type="button" class="ui-action ui-action-danger ui-action-soft">Soft Danger</button>
                <button type="button" class="ui-action ui-action-notice ui-action-soft">Soft Notice</button>
                <button type="button" class="ui-action ui-action-info ui-action-soft">Soft Info</button>
                <button type="button" class="ui-action ui-action-outline">Outline Neutral</button>
            </div>

            <p class="mt-4 text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Outline Buttons</p>
            <div class="mt-2 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                <button type="button" class="ui-action ui-action-primary ui-action-outline">Outline Primary</button>
                <button type="button" class="ui-action ui-action-success ui-action-outline">Outline Success</button>
                <button type="button" class="ui-action ui-action-warning ui-action-outline">Outline Warning</button>
                <button type="button" class="ui-action ui-action-danger ui-action-outline">Outline Danger</button>
                <button type="button" class="ui-action ui-action-notice ui-action-outline">Outline Notice</button>
                <button type="button" class="ui-action ui-action-info ui-action-outline">Outline Info</button>
                <button type="button" class="ui-icon-button" aria-label="Example icon action">
                    <x-heroicon-o-funnel class="h-4 w-4" aria-hidden="true" />
                </button>
            </div>

            <p class="mt-4 text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Login Buttons</p>
            <div class="mt-2 grid gap-3 md:grid-cols-3">
                <button type="button" class="ui-action-login ui-action-login-google">
                    <span aria-hidden="true">G</span>
                    Continue with Google
                </button>
                <button type="button" class="ui-action-login ui-action-login-github">
                    <span aria-hidden="true">GH</span>
                    Continue with GitHub
                </button>
                <button type="button" class="ui-action-login ui-action-login-microsoft">
                    <span aria-hidden="true">MS</span>
                    Continue with Microsoft
                </button>
            </div>

            <p class="mt-4 text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">Button Sizes</p>
            <div class="mt-2 flex flex-wrap items-center gap-3">
                <button type="button" class="ui-action ui-action-primary ui-action-xs">XS</button>
                <button type="button" class="ui-action ui-action-primary ui-action-sm">SM</button>
                <button type="button" class="ui-action ui-action-primary ui-action-md">MD</button>
                <button type="button" class="ui-action ui-action-primary ui-action-lg">LG</button>
                <button type="button" class="ui-action ui-action-primary ui-action-xl">XL</button>
            </div>

            <div class="mt-4 flex flex-wrap gap-2 text-xs font-semibold uppercase tracking-[0.15em]">
                <span class="rounded-full bg-slate-700/60 px-3 py-1 text-slate-200">info</span>
                <span class="rounded-full bg-emerald-500/15 px-3 py-1 text-emerald-300">success</span>
                <span class="rounded-full bg-violet-500/15 px-3 py-1 text-violet-300">notice</span>
                <span class="rounded-full bg-amber-500/15 px-3 py-1 text-amber-300">warning</span>
                <span class="rounded-full bg-rose-500/15 px-3 py-1 text-rose-300">error</span>
            </div>
        </section>
