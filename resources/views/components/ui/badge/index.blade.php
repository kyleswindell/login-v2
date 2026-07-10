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
        'active' => ['semantic' => 'success', 'icon' => 'checkmark--filled', 'variant' => 'base'],
        'inactive' => ['semantic' => 'neutral', 'icon' => 'subtract--filled', 'variant' => 'base'],
        'archived' => ['semantic' => 'neutral', 'icon' => 'archive', 'variant' => 'outline'],
        'draft' => ['semantic' => 'neutral', 'icon' => 'subtract--filled', 'variant' => 'base'],
        'ready' => ['semantic' => 'info', 'icon' => 'information--filled', 'variant' => 'base'],
        'enabled' => ['semantic' => 'success', 'icon' => 'checkmark--filled', 'variant' => 'base'],
        'disabled' => ['semantic' => 'neutral', 'icon' => 'subtract--filled', 'variant' => 'outline'],
        'submitted' => ['semantic' => 'notice', 'icon' => 'time--filled', 'variant' => 'base'],
        'pending review' => ['semantic' => 'notice', 'icon' => 'time--filled', 'variant' => 'base'],
        'under review' => ['semantic' => 'notice', 'icon' => 'time--filled', 'variant' => 'base'],
        'in progress' => ['semantic' => 'notice', 'icon' => 'time--filled', 'variant' => 'base'],
        'approved' => ['semantic' => 'success', 'icon' => 'checkmark--filled', 'variant' => 'base'],
        'rejected' => ['semantic' => 'danger', 'icon' => 'error--filled', 'variant' => 'base'],
        'blocked' => ['semantic' => 'danger', 'icon' => 'error--filled', 'variant' => 'base'],
        'needs action' => ['semantic' => 'warning', 'icon' => 'warning--filled', 'variant' => 'base'],
        'healthy' => ['semantic' => 'success', 'icon' => 'checkmark--filled', 'variant' => 'base'],
        'running' => ['semantic' => 'success', 'icon' => 'checkmark--filled', 'variant' => 'base'],
        'synced' => ['semantic' => 'success', 'icon' => 'checkmark--filled', 'variant' => 'base'],
        'pending' => ['semantic' => 'notice', 'icon' => 'time--filled', 'variant' => 'base'],
        'queued' => ['semantic' => 'notice', 'icon' => 'time--filled', 'variant' => 'base'],
        'degraded' => ['semantic' => 'warning', 'icon' => 'warning--filled', 'variant' => 'base'],
        'delayed' => ['semantic' => 'warning', 'icon' => 'warning--filled', 'variant' => 'base'],
        'failed' => ['semantic' => 'danger', 'icon' => 'error--filled', 'variant' => 'base'],
        'error' => ['semantic' => 'danger', 'icon' => 'error--filled', 'variant' => 'base'],
        'offline' => ['semantic' => 'danger', 'icon' => 'error--filled', 'variant' => 'base'],
        'syncing' => ['semantic' => 'notice', 'icon' => 'renew', 'variant' => 'base'],
        'stale' => ['semantic' => 'warning', 'icon' => 'warning--filled', 'variant' => 'base'],
        'out of sync' => ['semantic' => 'danger', 'icon' => 'error--filled', 'variant' => 'base'],
        'audited' => ['semantic' => 'success', 'icon' => 'checkmark--filled', 'variant' => 'outline'],
        'compliant' => ['semantic' => 'success', 'icon' => 'checkmark--filled', 'variant' => 'base'],
        'review' => ['semantic' => 'notice', 'icon' => 'time--filled', 'variant' => 'outline'],
        'non-compliant' => ['semantic' => 'danger', 'icon' => 'error--filled', 'variant' => 'base'],
        'low' => ['semantic' => 'success', 'icon' => 'checkmark--filled', 'variant' => 'base'],
        'moderate' => ['semantic' => 'notice', 'icon' => 'time--filled', 'variant' => 'base'],
        'elevated' => ['semantic' => 'warning', 'icon' => 'warning--filled', 'variant' => 'base'],
        'high' => ['semantic' => 'danger', 'icon' => 'error--filled', 'variant' => 'base'],
        'critical' => ['semantic' => 'danger', 'icon' => 'error--filled', 'variant' => 'base'],
        'neutral' => ['semantic' => 'neutral', 'icon' => 'subtract--filled', 'variant' => 'base'],
        'info' => ['semantic' => 'info', 'icon' => 'information--filled', 'variant' => 'base'],
        'success' => ['semantic' => 'success', 'icon' => 'checkmark--filled', 'variant' => 'base'],
        'notice' => ['semantic' => 'notice', 'icon' => 'time--filled', 'variant' => 'base'],
        'warning' => ['semantic' => 'warning', 'icon' => 'warning--filled', 'variant' => 'base'],
        'danger' => ['semantic' => 'danger', 'icon' => 'error--filled', 'variant' => 'base'],
    ];

    $resolved = $normalized !== null && array_key_exists($normalized, $taxonomy)
        ? $taxonomy[$normalized]
        : ['semantic' => 'neutral', 'icon' => 'subtract--filled', 'variant' => 'soft'];

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
        <x-ui.icon :name="$resolvedIcon" class="h-3.5 w-3.5" />
    @endif
    <span>{{ $resolvedLabel }}</span>
</span>
