        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="ui-page-header-title">UI Reference Workspace</h1>
                <p class="ui-page-header-copy">Canonical app-owned reference space for shell layout, forms, tables, menus, action tokens, and log drawer interactions.</p>
            </div>

            <a wire:navigate href="{{ route('platform.docs.index') }}" class="ui-action ui-action-ghost">Documentation Vault</a>
        </div>

        <div class="grid gap-4 xl:grid-cols-3">
            <article class="ui-card">
                <p class="ui-kicker">Shell Behavior</p>
                <h2 class="ui-card-title mt-3">Desktop + Mobile Baseline</h2>
                <p class="ui-card-copy">Header stays persistent, sidebar collapses under `lg`, and table sections use overflow wrappers for narrow screens.</p>
                <ul class="mt-4 space-y-2 text-sm ui-reference-text">
                    <li>1. Resize below 1024px and use the header toggle.</li>
                    <li>2. Use `wire:navigate` links to confirm shell persistence.</li>
                    <li>3. Confirm forms and tables stack without clipping.</li>
                </ul>
            </article>

            <article class="ui-card">
                <p class="ui-kicker">Theme Baseline</p>
                <h2 class="ui-card-title mt-3">Light/Dark Verification</h2>
                <p class="ui-card-copy">Use the account-menu theme controls in the header to verify this page under `light`, `dark`, and `system` modes.</p>
                <div class="mt-4 grid grid-cols-2 gap-2 text-sm">
                    <span class="ui-reference-code-surface px-3 py-2 text-sm">Surface</span>
                    <span class="ui-reference-example-surface px-3 py-2 text-sm">Card</span>
                    <span class="ui-reference-subtle-surface px-3 py-2 text-sm">Muted Fill</span>
                    <span class="ui-reference-subtle-surface px-3 py-2 text-sm">Elevated Fill</span>
                </div>
            </article>

            <article class="ui-card">
                <p class="ui-kicker">Menu Baseline</p>
                <h2 class="ui-card-title mt-3">List + Submenu Example</h2>
                <p class="ui-card-copy">Use icon + text entries with optional nested sections for dense operator groups.</p>
                <div class="mt-4 ui-reference-subtle-surface p-3">
                    <a href="#" class="ui-reference-nav-link flex items-center gap-3 rounded-md px-3 py-2 text-sm transition">
                        <x-layouts.nav-icon icon="home" /> Overview
                    </a>
                    <a href="#" class="ui-reference-nav-link mt-1 flex items-center gap-3 rounded-md px-3 py-2 text-sm transition">
                        <x-layouts.nav-icon icon="users" /> Users
                    </a>
                    <details class="mt-2 group" open>
                        <summary class="ui-reference-nav-link flex cursor-pointer list-none items-center gap-3 rounded-md px-3 py-2 text-sm transition">
                            <x-layouts.nav-icon icon="audit-log" /> Logs
                            <span class="ml-auto ui-reference-text-muted transition group-open:rotate-180">⌄</span>
                        </summary>
                        <div class="mt-1 space-y-1 pl-3">
                            <a href="#" class="ui-reference-nav-link block rounded-md px-3 py-2 text-sm transition">Audit Logs</a>
                            <a href="#" class="ui-reference-nav-link block rounded-md px-3 py-2 text-sm transition">Error Logs</a>
                        </div>
                    </details>
                </div>
            </article>
        </div>
