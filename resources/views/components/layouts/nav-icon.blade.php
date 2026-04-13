@props(['icon' => 'circle'])

@switch($icon)
    @case('home')
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.75L12 3l9 7.75" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 9.75V21h13.5V9.75" />
        </svg>
        @break
    @case('users')
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 19a4 4 0 0 0-8 0" />
            <circle cx="12" cy="10" r="3" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M20 19a4 4 0 0 0-3-3.87M4 19a4 4 0 0 1 3-3.87" />
        </svg>
        @break
    @case('docs')
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l5 5v13H7z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v5h5" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 13h6M10 17h4" />
        </svg>
        @break
    @case('bell')
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 1 5.454 1.31A8.967 8.967 0 0 1 18 9.75V9a6 6 0 1 0-12 0v.75a8.967 8.967 0 0 1-2.312 8.642 23.848 23.848 0 0 1 5.454-1.31m5.715 0a24.255 24.255 0 0 0-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
        </svg>
        @break
    @case('audit-log')
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 4h14v16H5z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 8h8M8 12h8M8 16h5" />
        </svg>
        @break
    @case('error-log')
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l9 16H3z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v5" />
            <circle cx="12" cy="17" r="1" />
        </svg>
        @break
    @case('settings')
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 3h1.5l.74 2.13a6.96 6.96 0 0 1 1.71.71l2.05-.93 1.06 1.06-.93 2.05c.27.54.5 1.1.67 1.7L21 10.5v1.5l-2.12.74a6.93 6.93 0 0 1-.7 1.71l.92 2.05-1.06 1.06-2.04-.92a6.9 6.9 0 0 1-1.72.7L12.75 21h-1.5l-.74-2.12a6.9 6.9 0 0 1-1.71-.7l-2.05.92-1.06-1.06.92-2.05a6.95 6.95 0 0 1-.7-1.71L3 12v-1.5l2.12-.74a6.98 6.98 0 0 1 .71-1.71l-.93-2.05 1.06-1.06 2.05.93a6.96 6.96 0 0 1 1.71-.71z" />
            <circle cx="12" cy="12" r="3" />
        </svg>
        @break
    @default
        <span class="h-4 w-4 rounded-full bg-current/30"></span>
@endswitch
