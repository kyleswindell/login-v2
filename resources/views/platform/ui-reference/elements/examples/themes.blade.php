<div class="space-y-6">
    <section class="ui-card" data-theme-example="theme-matrix">
        <h2 class="ui-card-title">Theme Switcher Matrix</h2>
        <p class="ui-card-copy mt-2">These static previews show supported app theme contexts. The role names stay stable while visual values resolve through the current theme.</p>
        <div class="mt-5 grid gap-4 xl:grid-cols-5">
            @foreach ([
                ['App default', 'bg-[var(--ui-surface)] text-[var(--ui-text-strong)] border-[var(--ui-border-default)]', 'Live app variables'],
                ['White equivalent', 'bg-white text-slate-950 border-slate-300', 'Light base'],
                ['Gray 10 equivalent', 'bg-slate-50 text-slate-950 border-slate-300', 'Light layer'],
                ['Gray 90 equivalent', 'bg-slate-900 text-slate-100 border-slate-700', 'Dark layer'],
                ['Gray 100 equivalent', 'bg-slate-950 text-slate-100 border-slate-800', 'Dark base'],
            ] as [$name, $classes, $note])
                <article class="rounded-lg border p-4 {{ $classes }}">
                    <p class="text-sm font-semibold">{{ $name }}</p>
                    <p class="mt-2 text-xs opacity-75">{{ $note }}</p>
                    <button type="button" class="mt-4 rounded-md border px-3 py-2 text-xs font-semibold">Action sample</button>
                </article>
            @endforeach
        </div>
    </section>

    <section class="ui-card" data-theme-example="component-preview-matrix">
        <h2 class="ui-card-title">Component Preview Matrix</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-4">
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                <p class="text-sm font-semibold text-white">Button + icon button</p>
                <div class="mt-3 flex items-center gap-2">
                    <button class="ui-button ui-button-primary" type="button">Save</button>
                    <button class="grid h-11 w-11 place-items-center rounded-md border border-slate-700 text-slate-200" type="button" aria-label="Open settings"><x-heroicon-o-cog-6-tooth class="h-5 w-5" /></button>
                </div>
            </article>
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                <label class="text-sm font-semibold text-slate-100" for="theme-field">Form field</label>
                <input id="theme-field" class="ui-input mt-2" value="Tenant domain">
            </article>
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                <p class="text-sm font-semibold text-white">Table row</p>
                <div class="mt-3 rounded-md border border-slate-700">
                    <div class="grid grid-cols-2 border-b border-slate-800 px-3 py-2 text-xs uppercase tracking-[0.16em] text-slate-500"><span>Name</span><span>Status</span></div>
                    <div class="grid grid-cols-2 bg-sky-500/10 px-3 py-2 text-sm text-slate-200"><span>Para Solutions</span><span>Selected</span></div>
                </div>
            </article>
            <article class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                <p class="text-sm font-semibold text-white">Notification</p>
                <div class="mt-3 rounded-md border border-emerald-500/40 bg-emerald-500/10 p-3 text-sm text-emerald-100">Workspace saved.</div>
            </article>
        </div>
    </section>

    <section class="ui-card" data-theme-example="layer-inheritance">
        <h2 class="ui-card-title">Layer Inheritance</h2>
        <div class="mt-5 grid gap-4 xl:grid-cols-2">
            <article class="rounded-lg border border-slate-300 bg-white p-4 text-slate-950">
                <p class="text-sm font-semibold">Light page with nested layers</p>
                <div class="mt-3 rounded-lg border border-slate-200 bg-slate-50 p-4">
                    Card on page
                    <div class="mt-3 rounded-md border border-slate-200 bg-white p-3 shadow-sm">Dropdown on card</div>
                </div>
            </article>
            <article class="rounded-lg border border-slate-700 bg-slate-950 p-4 text-slate-100">
                <p class="text-sm font-semibold">Dark page with overlay layer</p>
                <div class="mt-3 rounded-lg border border-slate-700 bg-slate-900 p-4">
                    Modal overlay region
                    <div class="mt-3 rounded-md border border-slate-700 bg-slate-950 p-3 shadow-xl">Nested panel</div>
                </div>
            </article>
        </div>
    </section>

    <section class="ui-card" data-theme-example="inline-theme-examples">
        <h2 class="ui-card-title">Inline Theme Examples</h2>
        <p class="ui-card-copy mt-2">Inline high-contrast treatment is allowed only when an owner standard documents it. Examples include a dark shell/header on a light page or a dark detail panel inside a light workflow.</p>
        <div class="mt-5 grid gap-4 xl:grid-cols-3">
            <article class="rounded-lg border border-slate-300 bg-white p-4 text-slate-950">
                <div class="rounded-md bg-slate-950 px-4 py-3 text-slate-100">Dark UI Shell Header on light page</div>
            </article>
            <article class="rounded-lg border border-slate-300 bg-white p-4 text-slate-950">
                <div class="rounded-md border border-slate-700 bg-slate-900 p-4 text-slate-100">Dark panel inside light page</div>
            </article>
            <article class="rounded-lg border border-slate-700 bg-slate-950 p-4 text-slate-100">
                <div class="rounded-md bg-white p-4 text-slate-950">High-contrast moment</div>
            </article>
        </div>
    </section>

    <section class="ui-card" data-theme-example="approved-overrides">
        <h2 class="ui-card-title">Approved Custom Token Overrides</h2>
        <div class="mt-5 overflow-x-auto rounded-lg border border-slate-800 bg-slate-950/60">
            <table class="w-full min-w-[760px] divide-y divide-slate-800 text-sm">
                <thead class="bg-slate-900 text-left text-xs uppercase tracking-[0.18em] text-slate-500">
                    <tr><th class="px-4 py-3">Override</th><th class="px-4 py-3">Reason</th><th class="px-4 py-3">Owner</th><th class="px-4 py-3">Source</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-800 text-slate-300">
                    <tr><td class="px-4 py-3 font-mono text-xs">--ui-action-*</td><td class="px-4 py-3">App action semantics</td><td class="px-4 py-3">UI standards</td><td class="px-4 py-3">resources/css/app.css</td></tr>
                    <tr><td class="px-4 py-3 font-mono text-xs">--ui-status-*</td><td class="px-4 py-3">Semantic feedback</td><td class="px-4 py-3">UI standards</td><td class="px-4 py-3">resources/css/app.css</td></tr>
                </tbody>
            </table>
        </div>
    </section>
</div>
