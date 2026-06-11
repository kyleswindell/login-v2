@php
    $items = [
        [
            'id' => 'accordion-form-domain-help',
            'title' => 'How domain matching works',
            'body' => 'Use this only for optional background detail. The field label, helper text, and validation messages must remain visible outside the Accordion.',
            'open' => true,
        ],
    ];
@endphp

<div class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_minmax(20rem,0.8fr)]">
    <div>
        <label for="accordion-form-domain" class="block text-sm font-semibold" style="color: var(--ui-text-primary);">Allowed admin domain</label>
        <p class="mt-1 text-sm" style="color: var(--ui-text-helper);">Use the tenant-owned admin hostname. This visible helper text cannot be replaced by an Accordion.</p>
        <input id="accordion-form-domain" class="ui-input mt-2" value="admin.example.test">
    </div>
    <x-ui.accordion id="accordion-form-assistance-example" size="compact" :items="$items" />
</div>
