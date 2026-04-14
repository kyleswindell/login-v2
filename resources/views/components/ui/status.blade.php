@props([
    'status' => null,
    'label' => null,
    'semantic' => null,
    'icon' => null,
    'dot' => false,
])

@php
    $normalized = $status !== null
        ? str_replace(['_', '-'], ' ', mb_strtolower(trim((string) $status)))
        : null;

    $normalized = match ($normalized) {
        'in review' => 'under review',
        'needs attention' => 'needs action',
        'non compliant' => 'non-compliant',
        default => $normalized,
    };

    $taxonomy = [
        'active' => ['semantic' => 'success', 'icon' => 'check-circle'],
        'inactive' => ['semantic' => 'neutral', 'icon' => 'minus-circle'],
        'archived' => ['semantic' => 'neutral', 'icon' => 'archive-box'],
        'ready' => ['semantic' => 'info', 'icon' => 'information-circle'],
        'pending review' => ['semantic' => 'notice', 'icon' => 'clock'],
        'under review' => ['semantic' => 'notice', 'icon' => 'clock'],
        'in progress' => ['semantic' => 'notice', 'icon' => 'clock'],
        'approved' => ['semantic' => 'success', 'icon' => 'check-circle'],
        'blocked' => ['semantic' => 'danger', 'icon' => 'no-symbol'],
        'needs action' => ['semantic' => 'warning', 'icon' => 'exclamation-triangle'],
        'degraded' => ['semantic' => 'warning', 'icon' => 'exclamation-triangle'],
        'failed' => ['semantic' => 'danger', 'icon' => 'x-circle'],
        'error' => ['semantic' => 'danger', 'icon' => 'x-circle'],
        'low' => ['semantic' => 'success', 'icon' => 'check-circle'],
        'moderate' => ['semantic' => 'notice', 'icon' => 'clock'],
        'high' => ['semantic' => 'danger', 'icon' => 'x-circle'],
        'neutral' => ['semantic' => 'neutral', 'icon' => 'minus-circle'],
        'info' => ['semantic' => 'info', 'icon' => 'information-circle'],
        'success' => ['semantic' => 'success', 'icon' => 'check-circle'],
        'notice' => ['semantic' => 'notice', 'icon' => 'clock'],
        'warning' => ['semantic' => 'warning', 'icon' => 'exclamation-triangle'],
        'danger' => ['semantic' => 'danger', 'icon' => 'x-circle'],
    ];

    $resolved = $normalized !== null && array_key_exists($normalized, $taxonomy)
        ? $taxonomy[$normalized]
        : ['semantic' => 'neutral', 'icon' => 'minus-circle'];

    $resolvedLabel = $label ?? ($normalized !== null ? $normalized : 'status');
    $resolvedSemantic = in_array($semantic, ['neutral', 'info', 'success', 'notice', 'warning', 'danger'], true)
        ? $semantic
        : $resolved['semantic'];
    $resolvedIcon = $icon ?? $resolved['icon'];
@endphp

<span {{ $attributes->merge(['class' => 'ui-status-inline ui-status-inline-'.$resolvedSemantic]) }}>
    @if ($dot)
        <span class="h-2 w-2 rounded-full bg-current" aria-hidden="true"></span>
    @elseif ($resolvedIcon)
        <x-ui.status-icon :icon="$resolvedIcon" class="h-3.5 w-3.5" />
    @endif

    <span>{{ $resolvedLabel }}</span>
</span>
