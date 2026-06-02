<aside class="w-full lg:w-72">
    <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-4 shadow-2xl shadow-black/20 lg:sticky lg:top-24">
        <p class="px-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">UI Reference</p>

        <nav class="mt-3 space-y-1">
            <a wire:navigate href="{{ route('platform.ui-reference.index') }}" @class([
                'flex items-center gap-2 rounded-md px-3 py-3 text-sm font-medium transition',
                'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => ($currentSection ?? 'overview') === 'overview',
                'text-slate-300 hover:bg-slate-800 hover:text-white' => ($currentSection ?? 'overview') !== 'overview',
            ])>
                <x-layouts.nav-icon icon="home" />
                <span>Overview</span>
            </a>
        </nav>

        <div class="mt-4 border-t border-slate-800 pt-4">
            <p class="px-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Component Library</p>
            <nav class="mt-2 space-y-1">
                <a wire:navigate href="{{ route('platform.ui-reference.components.actions') }}" @class([
                    'flex items-center gap-2 rounded-md px-3 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => ($currentSection ?? '') === 'components.actions',
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ($currentSection ?? '') !== 'components.actions',
                ])>
                    <x-layouts.nav-icon icon="settings" />
                    <span>Buttons + Icons</span>
                </a>
                <a wire:navigate href="{{ route('platform.ui-reference.components.status') }}" @class([
                    'flex items-center gap-2 rounded-md px-3 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => ($currentSection ?? '') === 'components.status',
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ($currentSection ?? '') !== 'components.status',
                ])>
                    <x-layouts.nav-icon icon="audit-log" />
                    <span>Badges + Status</span>
                </a>
                <a wire:navigate href="{{ route('platform.ui-reference.components.forms') }}" @class([
                    'flex items-center gap-2 rounded-md px-3 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => ($currentSection ?? '') === 'components.forms',
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ($currentSection ?? '') !== 'components.forms',
                ])>
                    <x-layouts.nav-icon icon="docs" />
                    <span>Inputs + Forms</span>
                </a>
            </nav>
        </div>

        <div class="mt-4 border-t border-slate-800 pt-4">
            <p class="px-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Pattern Standards</p>
            <nav class="mt-2 space-y-1">
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.forms') }}" @class([
                    'flex items-center gap-2 rounded-md px-3 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => ($currentSection ?? '') === 'patterns.forms',
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ($currentSection ?? '') !== 'patterns.forms',
                ])>
                    <x-layouts.nav-icon icon="docs" />
                    <span>Form Patterns</span>
                </a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.data-content') }}" @class([
                    'flex items-center gap-2 rounded-md px-3 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => ($currentSection ?? '') === 'patterns.data-content',
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ($currentSection ?? '') !== 'patterns.data-content',
                ])>
                    <x-layouts.nav-icon icon="users" />
                    <span>Data + Content</span>
                </a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.tables') }}" @class([
                    'flex items-center gap-2 rounded-md px-3 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => ($currentSection ?? '') === 'patterns.tables',
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ($currentSection ?? '') !== 'patterns.tables',
                ])>
                    <x-layouts.nav-icon icon="users" />
                    <span>Table Baselines</span>
                </a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.overlays') }}" @class([
                    'flex items-center gap-2 rounded-md px-3 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => ($currentSection ?? '') === 'patterns.overlays',
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ($currentSection ?? '') !== 'patterns.overlays',
                ])>
                    <x-layouts.nav-icon icon="error-log" />
                    <span>Overlays + Feedback</span>
                </a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.navigation') }}" @class([
                    'flex items-center gap-2 rounded-md px-3 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => ($currentSection ?? '') === 'patterns.navigation',
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ($currentSection ?? '') !== 'patterns.navigation',
                ])>
                    <x-layouts.nav-icon icon="home" />
                    <span>Navigation + Actions</span>
                </a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.layout') }}" @class([
                    'flex items-center gap-2 rounded-md px-3 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => ($currentSection ?? '') === 'patterns.layout',
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ($currentSection ?? '') !== 'patterns.layout',
                ])>
                    <x-layouts.nav-icon icon="settings" />
                    <span>Layout + Dashboard</span>
                </a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content') }}" @class([
                    'flex items-center gap-2 rounded-md px-3 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => ($currentSection ?? '') === 'patterns.widget-content',
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ($currentSection ?? '') !== 'patterns.widget-content',
                ])>
                    <x-layouts.nav-icon icon="settings" />
                    <span>Widget Content</span>
                </a>
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.archetypes') }}" @class([
                    'flex items-center gap-2 rounded-md px-3 py-3 text-sm font-medium transition',
                    'bg-slate-700/60 text-white ring-1 ring-slate-500/40' => ($currentSection ?? '') === 'patterns.archetypes',
                    'text-slate-300 hover:bg-slate-800 hover:text-white' => ($currentSection ?? '') !== 'patterns.archetypes',
                ])>
                    <x-layouts.nav-icon icon="audit-log" />
                    <span>Archetype Proofs</span>
                </a>
            </nav>
        </div>
    </div>
</aside>
