@props([
    'title',
    'description' => null,
    'kicker' => null,
])

<header {{ $attributes->class(['ui-pattern-page-header']) }} data-ui-pattern="page-title-actions-row">
    <div class="min-w-0 flex-1">
        @if ($kicker)
            <p class="ui-kicker">{{ $kicker }}</p>
        @endif
        <h1 class="ui-page-header-title @if($kicker) mt-2 @endif">{{ $title }}</h1>
        @if ($description)
            <p class="ui-page-header-copy">{{ $description }}</p>
        @endif
        @isset($context)
            <div class="mt-3">
                {{ $context }}
            </div>
        @endisset
    </div>

    @isset($actions)
        <div class="ui-pattern-page-header-actions">
            {{ $actions }}
        </div>
    @endisset
</header>
