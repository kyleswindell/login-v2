@props(['icon' => 'circle'])

@php
    $component = match ($icon) {
        'home' => 'heroicon-o-home',
        'users' => 'heroicon-o-users',
        'docs' => 'heroicon-o-document-text',
        'bell' => 'heroicon-o-bell',
        'audit-log' => 'heroicon-o-clipboard-document-list',
        'error-log' => 'heroicon-o-exclamation-triangle',
        'settings' => 'heroicon-o-cog-6-tooth',
        default => null,
    };
@endphp

@if ($component)
    <x-dynamic-component :component="$component" class="h-4 w-4" aria-hidden="true" />
@else
    <span class="h-4 w-4 rounded-full bg-current/30" aria-hidden="true"></span>
@endif
