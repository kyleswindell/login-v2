<x-layouts.app title="Sign In">
    <section class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center">
        <div class="rounded-lg border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
            <p class="text-sm font-medium uppercase tracking-[0.3em] text-slate-300">Login App 2.0</p>
            <h1 class="mt-3 text-3xl font-semibold text-white">Sign in</h1>
            <p class="mt-2 text-sm text-slate-400">Access the platform foundation dashboard.</p>

            <form method="POST" action="{{ route('login.store') }}" class="mt-8 space-y-5">
                @csrf
                <input type="hidden" name="timezone" id="timezone" value="{{ old('timezone') }}">

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-200">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-3 py-2 text-white outline-none ring-slate-500 transition focus:border-slate-500 focus:ring-2"
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-200">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-3 py-2 text-white outline-none ring-slate-500 transition focus:border-slate-500 focus:ring-2"
                    >
                    @error('password')
                        <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-center gap-2 text-sm text-slate-300">
                    <input name="remember" type="checkbox" value="1" class="rounded border-slate-700 bg-slate-950 text-slate-300">
                    Remember this browser
                </label>

                <button type="submit" class="w-full rounded-md border border-slate-700 bg-slate-700/70 px-4 py-2.5 font-semibold text-slate-100 transition hover:border-slate-500 hover:bg-slate-700 hover:text-white">
                    Sign in
                </button>
            </form>
        </div>
    </section>

    <script>
        document.getElementById('timezone').value = Intl.DateTimeFormat().resolvedOptions().timeZone;
    </script>
</x-layouts.app>
