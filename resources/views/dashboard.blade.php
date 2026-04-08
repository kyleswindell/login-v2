<x-layouts.app title="Dashboard">
    <section class="flex flex-1 flex-col justify-center">
        <div class="rounded-2xl border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
            <p class="text-sm font-medium uppercase tracking-[0.3em] text-sky-300">Platform Foundation</p>
            <h1 class="mt-3 text-3xl font-semibold text-white">Dashboard</h1>
            <p class="mt-2 text-slate-400">You are signed in as {{ auth()->user()->email }}.</p>

            <form method="POST" action="{{ route('logout') }}" class="mt-8">
                @csrf
                <button type="submit" class="rounded-lg border border-slate-700 px-4 py-2 font-semibold text-slate-100 transition hover:border-sky-400 hover:text-sky-300">
                    Sign out
                </button>
            </form>
        </div>
    </section>
</x-layouts.app>
