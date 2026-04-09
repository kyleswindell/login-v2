<x-layouts.app title="Platform Users">
    <section class="flex flex-1 flex-col gap-6">
        <div class="flex flex-col gap-4 rounded-3xl border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-[0.3em] text-sky-300">Platform Management</p>
                <h1 class="mt-3 text-3xl font-semibold text-white">Platform Users</h1>
                <p class="mt-2 text-slate-400">Create, review, and update internal platform user access.</p>
            </div>

            <a href="{{ route('platform.users.create') }}" class="inline-flex rounded-xl border border-slate-700 px-4 py-3 text-sm font-semibold text-slate-100 transition hover:border-sky-400 hover:text-sky-300">
                Create User
            </a>
        </div>

        @if (session('status'))
            <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
                {{ session('status') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-3xl border border-slate-800 bg-slate-900/70">
            <table class="min-w-full divide-y divide-slate-800">
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
                        <tr class="text-sm text-slate-200">
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
                                {{ $user->last_login_at?->format('M j, Y g:i A') ?? 'Never' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('platform.users.edit', $user) }}" class="text-sm font-semibold text-sky-300 transition hover:text-sky-200">
                                    Edit
                                </a>
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
    </section>
</x-layouts.app>
