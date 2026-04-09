<section class="flex flex-1 flex-col gap-6">
    <div class="rounded-3xl border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
        <p class="text-sm font-medium uppercase tracking-[0.3em] text-sky-300">Platform Management</p>
        <h1 class="mt-3 text-3xl font-semibold text-white">{{ $heading }}</h1>
        <p class="mt-2 text-slate-400">{{ $subheading }}</p>
    </div>

    @if (session('status'))
        <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-2xl border border-rose-500/30 bg-rose-500/10 px-4 py-3 text-sm text-rose-200">
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $action }}" class="rounded-3xl border border-slate-800 bg-slate-900/70 p-8">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif

        <div class="grid gap-6 lg:grid-cols-2">
            <label class="block">
                <span class="text-sm font-semibold text-slate-200">Name</span>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $user?->name) }}"
                    class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-sky-400 focus:outline-none focus:ring-0"
                    required
                >
            </label>

            <label class="block">
                <span class="text-sm font-semibold text-slate-200">Email</span>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $user?->email) }}"
                    class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-sky-400 focus:outline-none focus:ring-0"
                    required
                >
            </label>

            <label class="block lg:col-span-2">
                <span class="text-sm font-semibold text-slate-200">Password {{ $user ? '(leave blank to keep current password)' : '' }}</span>
                <input
                    type="password"
                    name="password"
                    class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-sky-400 focus:outline-none focus:ring-0"
                    @if (! $user) required @endif
                >
            </label>

            <fieldset class="lg:col-span-2">
                <legend class="text-sm font-semibold text-slate-200">Roles</legend>
                <div class="mt-3 grid gap-3 md:grid-cols-2">
                    @php($selectedRoles = collect(old('roles', $user?->roles->pluck('name')->all() ?? [])))
                    @foreach ($roles as $role)
                        <label class="flex items-center gap-3 rounded-xl border border-slate-800 bg-slate-950 px-4 py-3 text-sm text-slate-200">
                            <input
                                type="checkbox"
                                name="roles[]"
                                value="{{ $role->name }}"
                                @checked($selectedRoles->contains($role->name))
                                class="rounded border-slate-600 bg-slate-900 text-sky-400 focus:ring-sky-400"
                            >
                            <span>{{ $role->name }}</span>
                        </label>
                    @endforeach
                </div>
            </fieldset>

            <label class="flex items-center gap-3 rounded-xl border border-slate-800 bg-slate-950 px-4 py-3 text-sm text-slate-200 lg:col-span-2">
                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    @checked(old('is_active', $user?->is_active ?? true))
                    class="rounded border-slate-600 bg-slate-900 text-sky-400 focus:ring-sky-400"
                >
                <span>User account is active</span>
            </label>
        </div>

        <div class="mt-8 flex flex-wrap gap-3">
            <button type="submit" class="inline-flex rounded-xl border border-slate-700 px-4 py-3 text-sm font-semibold text-slate-100 transition hover:border-sky-400 hover:text-sky-300">
                Save User
            </button>

            <a href="{{ route('platform.users.index') }}" class="inline-flex rounded-xl border border-slate-800 px-4 py-3 text-sm font-semibold text-slate-300 transition hover:border-slate-600 hover:text-white">
                Back to Users
            </a>
        </div>
    </form>
</section>
