@props([
    'status' => null,
    'label' => null,
    'semantic' => null,
    'variant' => null,
    'icon' => null,
    'showIcon' => true,
])

@php
    $normalized = $status !== null
        ? str_replace(['_', '-'], ' ', mb_strtolower(trim((string) $status)))
        : null;

    $normalized = match ($normalized) {
        'in review' => 'under review',
        'pending review' => 'pending review',
        'pending' => 'pending',
        'needs attention' => 'needs action',
        'non compliant' => 'non-compliant',
        'out of sync' => 'out of sync',
        default => $normalized,
    };

    $taxonomy = [
        'active' => ['semantic' => 'success', 'icon' => 'check-circle', 'variant' => 'soft'],
        'inactive' => ['semantic' => 'neutral', 'icon' => 'minus-circle', 'variant' => 'soft'],
        'archived' => ['semantic' => 'neutral', 'icon' => 'archive-box', 'variant' => 'outline'],
        'draft' => ['semantic' => 'neutral', 'icon' => 'minus-circle', 'variant' => 'soft'],
        'ready' => ['semantic' => 'info', 'icon' => 'information-circle', 'variant' => 'soft'],
        'enabled' => ['semantic' => 'success', 'icon' => 'check-circle', 'variant' => 'soft'],
        'disabled' => ['semantic' => 'neutral', 'icon' => 'minus-circle', 'variant' => 'outline'],
        'submitted' => ['semantic' => 'notice', 'icon' => 'clock', 'variant' => 'soft'],
        'pending review' => ['semantic' => 'notice', 'icon' => 'clock', 'variant' => 'soft'],
        'under review' => ['semantic' => 'notice', 'icon' => 'clock', 'variant' => 'soft'],
        'in progress' => ['semantic' => 'notice', 'icon' => 'clock', 'variant' => 'soft'],
        'approved' => ['semantic' => 'success', 'icon' => 'check-circle', 'variant' => 'soft'],
        'rejected' => ['semantic' => 'danger', 'icon' => 'x-circle', 'variant' => 'soft'],
        'blocked' => ['semantic' => 'danger', 'icon' => 'no-symbol', 'variant' => 'soft'],
        'needs action' => ['semantic' => 'warning', 'icon' => 'exclamation-triangle', 'variant' => 'soft'],
        'healthy' => ['semantic' => 'success', 'icon' => 'check-circle', 'variant' => 'soft'],
        'running' => ['semantic' => 'success', 'icon' => 'check-circle', 'variant' => 'soft'],
        'synced' => ['semantic' => 'success', 'icon' => 'check-circle', 'variant' => 'soft'],
        'pending' => ['semantic' => 'notice', 'icon' => 'clock', 'variant' => 'soft'],
        'queued' => ['semantic' => 'notice', 'icon' => 'clock', 'variant' => 'soft'],
        'degraded' => ['semantic' => 'warning', 'icon' => 'exclamation-triangle', 'variant' => 'soft'],
        'delayed' => ['semantic' => 'warning', 'icon' => 'exclamation-triangle', 'variant' => 'soft'],
        'failed' => ['semantic' => 'danger', 'icon' => 'x-circle', 'variant' => 'soft'],
        'error' => ['semantic' => 'danger', 'icon' => 'x-circle', 'variant' => 'soft'],
        'offline' => ['semantic' => 'danger', 'icon' => 'x-circle', 'variant' => 'soft'],
        'syncing' => ['semantic' => 'notice', 'icon' => 'arrow-path', 'variant' => 'soft'],
        'stale' => ['semantic' => 'warning', 'icon' => 'exclamation-triangle', 'variant' => 'soft'],
        'out of sync' => ['semantic' => 'danger', 'icon' => 'x-circle', 'variant' => 'soft'],
        'audited' => ['semantic' => 'success', 'icon' => 'check-circle', 'variant' => 'outline'],
        'compliant' => ['semantic' => 'success', 'icon' => 'check-circle', 'variant' => 'soft'],
        'review' => ['semantic' => 'notice', 'icon' => 'clock', 'variant' => 'outline'],
        'non-compliant' => ['semantic' => 'danger', 'icon' => 'x-circle', 'variant' => 'soft'],
        'low' => ['semantic' => 'success', 'icon' => 'check-circle', 'variant' => 'soft'],
        'moderate' => ['semantic' => 'notice', 'icon' => 'clock', 'variant' => 'soft'],
        'elevated' => ['semantic' => 'warning', 'icon' => 'exclamation-triangle', 'variant' => 'soft'],
        'high' => ['semantic' => 'danger', 'icon' => 'x-circle', 'variant' => 'soft'],
        'critical' => ['semantic' => 'danger', 'icon' => 'x-circle', 'variant' => 'solid'],
        'neutral' => ['semantic' => 'neutral', 'icon' => 'minus-circle', 'variant' => 'soft'],
        'info' => ['semantic' => 'info', 'icon' => 'information-circle', 'variant' => 'soft'],
        'success' => ['semantic' => 'success', 'icon' => 'check-circle', 'variant' => 'soft'],
        'notice' => ['semantic' => 'notice', 'icon' => 'clock', 'variant' => 'soft'],
        'warning' => ['semantic' => 'warning', 'icon' => 'exclamation-triangle', 'variant' => 'soft'],
        'danger' => ['semantic' => 'danger', 'icon' => 'x-circle', 'variant' => 'soft'],
    ];

    $resolved = $normalized !== null && array_key_exists($normalized, $taxonomy)
        ? $taxonomy[$normalized]
        : ['semantic' => 'neutral', 'icon' => 'minus-circle', 'variant' => 'soft'];

    $resolvedLabel = $label ?? ($normalized !== null ? $normalized : 'status');
    $resolvedSemantic = in_array($semantic, ['neutral', 'info', 'success', 'notice', 'warning', 'danger'], true)
        ? $semantic
        : $resolved['semantic'];
    $resolvedVariant = in_array($variant, ['soft', 'outline', 'solid'], true)
        ? $variant
        : $resolved['variant'];
    $resolvedIcon = $icon ?? $resolved['icon'];

    $classes = 'ui-status-pill ui-status-'.$resolvedSemantic;

    if ($resolvedVariant === 'outline') {
        $classes .= ' ui-status-outline';
    }

    if ($resolvedVariant === 'solid') {
        $classes .= ' ui-status-solid';
    }
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if ($showIcon && $resolvedIcon)
        <x-ui.status-icon :icon="$resolvedIcon" class="h-3.5 w-3.5" />
    @endif
    <span>{{ $resolvedLabel }}</span>
</span>
