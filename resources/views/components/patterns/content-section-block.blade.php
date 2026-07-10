@props([
    'title' => null,
    'description' => null,
    'kicker' => null,
])

<section {{ $attributes->class(['ui-card', 'ui-pattern-content-section']) }} data-ui-pattern="content-section-block">
    @if ($title || $description || $kicker || isset($headerActions))
        <div class="ui-pattern-content-section-header">
            <div class="min-w-0 flex-1">
                @if ($kicker)
                    <p class="ui-kicker">{{ $kicker }}</p>
                @endif
                @if ($title)
                    <h2 class="ui-card-title @if($kicker) mt-2 @endif">{{ $title }}</h2>
                @endif
                @if ($description)
                    <p class="ui-card-copy">{{ $description }}</p>
                @endif
            </div>

            @isset($headerActions)
                <div class="ui-pattern-content-section-actions">
                    {{ $headerActions }}
                </div>
            @endisset
        </div>
    @endif

    <div class="@if($title || $description || $kicker || isset($headerActions)) mt-5 @endif">
        {{ $slot }}
    </div>
</section>
