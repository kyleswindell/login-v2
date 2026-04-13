@php($viewerTimezone = auth()->user()?->timezone ?: config('app.timezone'))

<x-layouts.app title="Platform Users">
    <section class="flex flex-1 flex-col gap-6">
        <div>
            <div>
                <h1 class="ui-page-header-title">Platform Users</h1>
                <p class="ui-page-header-copy">Create, review, and update internal platform user access.</p>
            </div>
        </div>

        @if (session('status'))
            <div class="rounded-md border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
                {{ session('status') }}
            </div>
        @endif

        <div class="flex flex-wrap items-center gap-3">
            <a wire:navigate href="{{ route('platform.users.create') }}" class="inline-flex items-center rounded-md border border-emerald-500/50 bg-emerald-500/15 px-4 py-2.5 text-sm font-semibold text-emerald-100 transition hover:border-emerald-400/70 hover:bg-emerald-500/25 hover:text-emerald-50">
                Create User
            </a>
        </div>

        <div class="rounded-lg border border-slate-800 bg-slate-900/70" data-table-lite-container>
            <div class="grid gap-3 border-b border-slate-800 px-6 py-4 md:grid-cols-4">
                <label class="block">
                    <span class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Search</span>
                    <input type="text" data-table-lite-search placeholder="Search staff..." class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-2.5 text-sm text-slate-100 placeholder:text-slate-500">
                </label>

                <label class="block">
                    <span class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Status</span>
                    <select data-table-lite-filter-status class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-2.5 text-sm text-slate-100">
                        <option value="">Any status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </label>

                <label class="block">
                    <span class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Role</span>
                    <select data-table-lite-filter-role class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-2.5 text-sm text-slate-100">
                        <option value="">Any role</option>
                        @php($roleOptions = $users->flatMap(fn ($user) => $user->roles->pluck('name'))->unique()->sort()->values())
                        @foreach ($roleOptions as $roleName)
                            <option value="{{ strtolower($roleName) }}">{{ $roleName }}</option>
                        @endforeach
                    </select>
                </label>

                <div class="flex items-end">
                    <button type="button" data-table-lite-filter-reset class="inline-flex rounded-md border border-slate-700 px-4 py-2.5 text-sm font-semibold text-slate-200 transition hover:border-slate-500 hover:text-white">
                        Reset Filters
                    </button>
                </div>
            </div>

            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-slate-800" data-table-lite>
                <thead class="bg-slate-900">
                    <tr class="text-left text-xs uppercase tracking-[0.2em] text-slate-500">
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Roles</th>
                        <th class="px-6 py-4">Last Login</th>
                        <th class="px-6 py-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse ($users as $user)
                        <tr class="text-sm text-slate-200" data-table-status="{{ $user->is_active ? 'active' : 'inactive' }}" data-table-roles="{{ strtolower($user->roles->pluck('name')->join(',')) }}">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-white">{{ $user->name }}</p>
                                <p class="mt-1 text-slate-400">{{ $user->email }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span @class([
                                    'inline-flex rounded-full px-3 py-1 text-xs font-semibold',
                                    'bg-emerald-500/15 text-emerald-300' => $user->is_active,
                                    'bg-amber-500/15 text-amber-300' => ! $user->is_active,
                                ])>
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    @forelse ($user->roles as $role)
                                        <span class="inline-flex rounded-full bg-slate-800 px-3 py-1 text-xs font-medium text-slate-200">{{ $role->name }}</span>
                                    @empty
                                        <span class="text-slate-500">No roles assigned</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-400">
                                {{ $user->last_login_at?->timezone($viewerTimezone)->format('M j, Y g:i A T') ?? 'Never' }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a wire:navigate href="{{ route('platform.users.edit', $user) }}" class="inline-flex rounded-md border border-amber-500/50 bg-amber-500/15 px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.1em] text-amber-100 transition hover:border-amber-400/70 hover:bg-amber-500/25 hover:text-amber-50">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('platform.users.toggle-active', $user) }}">
                                        @csrf
                                        <button type="submit" @class([
                                            'inline-flex rounded-md px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.1em] transition',
                                            'border border-rose-500/50 bg-rose-500/15 text-rose-100 hover:border-rose-400/70 hover:bg-rose-500/25 hover:text-rose-50' => $user->is_active,
                                            'border border-emerald-500/50 bg-emerald-500/15 text-emerald-100 hover:border-emerald-400/70 hover:bg-emerald-500/25 hover:text-emerald-50' => ! $user->is_active,
                                        ])>
                                            {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-slate-500">No platform users have been created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
                </table>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-4 border-t border-slate-800 px-6 py-4">
                <div class="flex items-center gap-3">
                    <label class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Rows</label>
                    <select data-table-lite-rows-per-page class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm text-slate-100">
                        <option value="10">10</option>
                        <option value="25" selected>25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <p class="text-sm text-slate-400" data-table-lite-info></p>
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" data-table-lite-prev class="rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-[0.15em] text-slate-300 transition hover:border-slate-600 hover:text-white">Prev</button>
                    <select data-table-lite-page-select class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-xs font-semibold uppercase tracking-[0.1em] text-slate-200"></select>
                    <button type="button" data-table-lite-next class="rounded-lg border border-slate-700 px-3 py-2 text-xs font-semibold uppercase tracking-[0.15em] text-slate-300 transition hover:border-slate-600 hover:text-white">Next</button>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
