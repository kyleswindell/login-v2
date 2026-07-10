{{-- ==========================================================================
    File: Modules/Preferences/resources/views/partials/personal-defaults.blade.php
    Purpose: Account personal defaults panel.

    Notes:
    - Rendered inside the Preferences account page local section-tabs pattern.
    - Uses simple account card structure to match the Profile tab setup.
    - Uses x-patterns.key-value-display for compact preference facts.
    ========================================================================== --}}

@php
    $personalDefaults = [
        ['label' => 'Timezone', 'value' => $timezoneLabel],
        ['label' => 'Default language', 'value' => $languageLabel],
        ['label' => 'Theme mode', 'value' => $themeLabel],
    ];
@endphp

<section
    class="border border-[color:var(--ui-border-subtle-01)] bg-[color:var(--ui-layer)] p-6"
    aria-labelledby="account-preferences-personal-defaults-heading"
    data-account-preferences-personal-defaults-pane
>
    <header class="mb-6">
        <h2
            id="account-preferences-personal-defaults-heading"
            class="ui-card-title"
        >
            Personal defaults
        </h2>

        <p class="ui-card-copy mt-2">These defaults personalize app display and regional behavior.</p>
    </header>

    <x-patterns.key-value-display :items="$personalDefaults" :columns="2" />

    <footer class="mt-6 flex justify-end">
        <x-ui.button
            type="button"
            kind="primary"
            size="sm"
            icon="edit"
            aria-controls="account-preferences-modal"
            data-ui-dialog-trigger="account-preferences-modal"
        >
            Edit preferences
        </x-ui.button>
    </footer>
</section>
