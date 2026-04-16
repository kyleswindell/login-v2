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
        'active' => ['semantic' => 'success', 'icon' => 'check-circle', 'variant' => 'base'],
        'inactive' => ['semantic' => 'neutral', 'icon' => 'minus-circle', 'variant' => 'base'],
        'archived' => ['semantic' => 'neutral', 'icon' => 'archive-box', 'variant' => 'outline'],
        'draft' => ['semantic' => 'neutral', 'icon' => 'minus-circle', 'variant' => 'base'],
        'ready' => ['semantic' => 'info', 'icon' => 'information-circle', 'variant' => 'base'],
        'enabled' => ['semantic' => 'success', 'icon' => 'check-circle', 'variant' => 'base'],
        'disabled' => ['semantic' => 'neutral', 'icon' => 'minus-circle', 'variant' => 'outline'],
        'submitted' => ['semantic' => 'notice', 'icon' => 'clock', 'variant' => 'base'],
        'pending review' => ['semantic' => 'notice', 'icon' => 'clock', 'variant' => 'base'],
        'under review' => ['semantic' => 'notice', 'icon' => 'clock', 'variant' => 'base'],
        'in progress' => ['semantic' => 'notice', 'icon' => 'clock', 'variant' => 'base'],
        'approved' => ['semantic' => 'success', 'icon' => 'check-circle', 'variant' => 'base'],
        'rejected' => ['semantic' => 'danger', 'icon' => 'x-circle', 'variant' => 'base'],
        'blocked' => ['semantic' => 'danger', 'icon' => 'no-symbol', 'variant' => 'base'],
        'needs action' => ['semantic' => 'warning', 'icon' => 'exclamation-triangle', 'variant' => 'base'],
        'healthy' => ['semantic' => 'success', 'icon' => 'check-circle', 'variant' => 'base'],
        'running' => ['semantic' => 'success', 'icon' => 'check-circle', 'variant' => 'base'],
        'synced' => ['semantic' => 'success', 'icon' => 'check-circle', 'variant' => 'base'],
        'pending' => ['semantic' => 'notice', 'icon' => 'clock', 'variant' => 'base'],
        'queued' => ['semantic' => 'notice', 'icon' => 'clock', 'variant' => 'base'],
        'degraded' => ['semantic' => 'warning', 'icon' => 'exclamation-triangle', 'variant' => 'base'],
        'delayed' => ['semantic' => 'warning', 'icon' => 'exclamation-triangle', 'variant' => 'base'],
        'failed' => ['semantic' => 'danger', 'icon' => 'x-circle', 'variant' => 'base'],
        'error' => ['semantic' => 'danger', 'icon' => 'x-circle', 'variant' => 'base'],
        'offline' => ['semantic' => 'danger', 'icon' => 'x-circle', 'variant' => 'base'],
        'syncing' => ['semantic' => 'notice', 'icon' => 'arrow-path', 'variant' => 'base'],
        'stale' => ['semantic' => 'warning', 'icon' => 'exclamation-triangle', 'variant' => 'base'],
        'out of sync' => ['semantic' => 'danger', 'icon' => 'x-circle', 'variant' => 'base'],
        'audited' => ['semantic' => 'success', 'icon' => 'check-circle', 'variant' => 'outline'],
        'compliant' => ['semantic' => 'success', 'icon' => 'check-circle', 'variant' => 'base'],
        'review' => ['semantic' => 'notice', 'icon' => 'clock', 'variant' => 'outline'],
        'non-compliant' => ['semantic' => 'danger', 'icon' => 'x-circle', 'variant' => 'base'],
        'low' => ['semantic' => 'success', 'icon' => 'check-circle', 'variant' => 'base'],
        'moderate' => ['semantic' => 'notice', 'icon' => 'clock', 'variant' => 'base'],
        'elevated' => ['semantic' => 'warning', 'icon' => 'exclamation-triangle', 'variant' => 'base'],
        'high' => ['semantic' => 'danger', 'icon' => 'x-circle', 'variant' => 'base'],
        'critical' => ['semantic' => 'danger', 'icon' => 'x-circle', 'variant' => 'base'],
        'neutral' => ['semantic' => 'neutral', 'icon' => 'minus-circle', 'variant' => 'base'],
        'info' => ['semantic' => 'info', 'icon' => 'information-circle', 'variant' => 'base'],
        'success' => ['semantic' => 'success', 'icon' => 'check-circle', 'variant' => 'base'],
        'notice' => ['semantic' => 'notice', 'icon' => 'clock', 'variant' => 'base'],
        'warning' => ['semantic' => 'warning', 'icon' => 'exclamation-triangle', 'variant' => 'base'],
        'danger' => ['semantic' => 'danger', 'icon' => 'x-circle', 'variant' => 'base'],
    ];

    $resolved = $normalized !== null && array_key_exists($normalized, $taxonomy)
        ? $taxonomy[$normalized]
        : ['semantic' => 'neutral', 'icon' => 'minus-circle', 'variant' => 'soft'];

    $resolvedLabel = $label ?? ($normalized !== null ? $normalized : 'status');
    $resolvedSemantic = in_array($semantic, ['neutral', 'info', 'success', 'notice', 'warning', 'danger'], true)
        ? $semantic
        : $resolved['semantic'];
    $resolvedVariant = match ($variant) {
        'soft' => 'base',
        'outline' => 'outline',
        'base', null => $variant ?? $resolved['variant'],
        default => $resolved['variant'],
    };

    $resolvedVariant = in_array($resolvedVariant, ['base', 'outline'], true)
        ? $resolvedVariant
        : $resolved['variant'];
    $resolvedIcon = $icon ?? $resolved['icon'];

    $classes = 'ui-status-pill ui-status-'.$resolvedSemantic;

    if ($resolvedVariant === 'outline') {
        $classes .= ' ui-status-outline';
    }

@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if ($showIcon && $resolvedIcon)
        <x-ui.status-icon :icon="$resolvedIcon" class="h-3.5 w-3.5" />
    @endif
    <span>{{ $resolvedLabel }}</span>
</span>
