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
            <x-ui.notification.inline kind="success">
                {{ session('status') }}
            </x-ui.notification.inline>
        @endif

        <div class="flex flex-wrap items-center gap-3">
            <a wire:navigate href="{{ route('platform.users.create') }}" class="ui-action ui-action-success">
                Create User
            </a>
        </div>

        <div class="rounded-lg border border-slate-800 bg-slate-900/70" data-table-lite-container>
            <div class="grid gap-3 border-b border-slate-800 px-6 py-4 md:grid-cols-4">
                <label class="block">
                    <span class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Search</span>
                    <input type="text" data-table-lite-search placeholder="Search staff..." class="ui-input mt-2 py-2.5">
                </label>

                <label class="block">
                    <span class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Status</span>
                    <select data-table-lite-filter-status class="ui-select mt-2 py-2.5">
                        <option value="">Any status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </label>

                <label class="block">
                    <span class="text-xs font-semibold uppercase tracking-[0.15em] text-slate-500">Role</span>
                    <select data-table-lite-filter-role class="ui-select mt-2 py-2.5">
                        <option value="">Any role</option>
                        @php($roleOptions = $users->flatMap(fn ($user) => $user->roles->pluck('name'))->unique()->sort()->values())
                        @foreach ($roleOptions as $roleName)
                            <option value="{{ strtolower($roleName) }}">{{ $roleName }}</option>
                        @endforeach
                    </select>
                </label>

                <div class="flex items-end">
                    <button type="button" data-table-lite-filter-reset class="ui-action ui-action-ghost">
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
                                <x-ui.tag
                                    :label="$user->is_active ? 'active' : 'inactive'"
                                    :tone="$user->is_active ? 'success' : 'neutral'"
                                    size="sm"
                                />
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    @forelse ($user->roles as $role)
                                        <x-ui.tag :label="$role->name" type="outline" size="sm" />
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
                                    <a wire:navigate href="{{ route('platform.users.edit', $user) }}" class="ui-action ui-action-warning ui-action-xs">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('platform.users.toggle-active', $user) }}">
                                        @csrf
                                        <button type="submit" @class([
                                            'ui-action ui-action-xs',
                                            'ui-action-danger' => $user->is_active,
                                            'ui-action-success' => ! $user->is_active,
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
                    <select data-table-lite-rows-per-page class="ui-select !w-auto px-3 py-2 text-sm">
                        <option value="10">10</option>
                        <option value="25" selected>25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <p class="text-sm text-slate-400" data-table-lite-info></p>
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" data-table-lite-prev class="ui-action ui-action-ghost ui-action-xs">Prev</button>
                    <select data-table-lite-page-select class="ui-select !w-auto px-3 py-2 text-xs font-semibold uppercase tracking-[0.1em]"></select>
                    <button type="button" data-table-lite-next class="ui-action ui-action-ghost ui-action-xs">Next</button>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
