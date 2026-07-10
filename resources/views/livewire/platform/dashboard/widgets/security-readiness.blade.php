<x-patterns.widget-shell
    title="Security Readiness"
    description="Current ASVS and security checklist alignment."
    :meta="[$total.' controls tracked', $openCritical.' high-risk open']"
>
    @php
        $readinessRows = collect($labels)
            ->map(fn ($label, $status): array => [
                'title' => $label,
                'meta' => (string) ($counts[$status] ?? 0),
            ])
            ->values()
            ->all();
    @endphp

    <x-ui.structured-list
        :columns="[
            ['key' => 'title', 'label' => 'Alignment'],
            ['key' => 'meta', 'label' => 'Count'],
        ]"
        :rows="$readinessRows"
        size="condensed"
    />

    <x-slot:footer>
        <x-ui.button :href="route('platform.security.index')" semantic="primary" size="sm" wire:navigate>
            Open checklist
        </x-ui.button>
    </x-slot:footer>
</x-patterns.widget-shell>
