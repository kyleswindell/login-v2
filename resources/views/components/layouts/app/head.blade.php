    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? config('app.name') }}</title>
        <script>
            (() => {
                const root = document.documentElement;
                const allowedModes = new Set(['system', 'dark', 'light']);
                const persistedMode = window.localStorage.getItem('platform.theme.mode');
                const bootPayload = document.getElementById('theme-boot-payload');
                const serverMode = bootPayload ? JSON.parse(bootPayload.textContent).mode : 'system';
                const themeMode = allowedModes.has(persistedMode) ? persistedMode : serverMode;
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const resolved = themeMode === 'system' ? (prefersDark ? 'dark' : 'light') : themeMode;

                root.dataset.themeMode = themeMode;
                root.dataset.themeResolved = resolved;
                root.classList.toggle('dark', resolved === 'dark');
                root.style.backgroundColor = resolved === 'light' ? 'rgb(248 250 252)' : 'rgb(9 9 11)';
                root.style.color = resolved === 'light' ? 'rgb(15 23 42)' : 'rgb(241 245 249)';
            })();
        </script>
        <script id="theme-boot-payload" type="application/json">{{ $themeBootPayload }}</script>
        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
