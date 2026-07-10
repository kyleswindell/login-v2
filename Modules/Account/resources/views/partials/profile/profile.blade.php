{{-- ==========================================================================
    File: Modules/Account/resources/views/partials/profile/profile.blade.php
    Purpose: Profile details tab panel.

    Notes:
    - Rendered inside the Profile page local x-ui.tabs panel.
    - Uses two simple sections: profile summary and personal details.
    - Restores the known working avatar treatment.
    - Keeps action buttons at the bottom-right of each section.
    - Uses x-patterns.key-value-display for compact read-only facts.
    - Edit flows open focused modal dialogs.
    ========================================================================== --}}

@php
    $profileSummaryDetails = [
        ['label' => 'Display name', 'value' => $user->name],
        ['label' => 'Sign-in email', 'value' => $user->email],
        ['label' => 'Profile photo', 'value' => $user->profile_image_path ? 'Uploaded' : 'Using initials'],
    ];

    $personalDetails = [
        ['label' => 'First name', 'value' => $user->first_name ?: 'Not provided'],
        ['label' => 'Last name', 'value' => $user->last_name ?: 'Not provided'],
        ['label' => 'Display name', 'value' => $user->name],
        ['label' => 'Phone', 'value' => $user->phone ?: 'Not provided'],
    ];
@endphp

<x-ui.v-stack :gap="5" data-account-profile-pane>
    {{-- ----------------------------------------------------------------------
        Profile summary
        ---------------------------------------------------------------------- --}}

    <section
        class="border border-[color:var(--ui-border-subtle-01)] bg-[color:var(--ui-layer)] p-6"
        aria-labelledby="account-profile-summary-heading"
        data-account-profile-summary-card
    >
        <header class="mb-6">
            <h2 id="account-profile-summary-heading" class="ui-card-title">
                Profile
            </h2>

            <p class="ui-card-copy mt-2">Your profile photo and signed-in identity.</p>
        </header>

        <div
            class="grid gap-5 md:grid-cols-[auto_minmax(0,1fr)] md:items-start"
        >
            <div
                class="ui-pattern-identity-summary-avatar h-20 w-20 shrink-0"
                aria-hidden="true"
            >
                @if ($profileImageUrl)
                    <img
                        src="{{ $profileImageUrl }}"
                        alt=""
                        class="h-full w-full object-cover"
                    />
                @else
                    <span>{{
                        $initials ?:
                            "NA"
                    }}</span>
                @endif
            </div>

            <div class="min-w-0">
                <div class="flex flex-wrap items-center gap-2">
                    <h3 class="ui-platform-text-strong text-sm font-semibold">
                        {{ $user->name }}
                    </h3>

                    <x-ui.tag type="green" size="sm" variant="read-only">
                        Active
                    </x-ui.tag>
                </div>

                <p class="ui-card-copy mt-1">Current signed-in user</p>

                <div class="ui-pattern-compact-meta mt-3">
                    <span class="ui-pattern-compact-meta-item">
                        {{ $user->email }}
                    </span>

                    <span class="ui-pattern-compact-meta-item">
                        <span
                            class="ui-pattern-compact-meta-separator"
                            aria-hidden="true"
                        >
                            •
                        </span>

                        {{
                            $user->phone ?:
                                "No phone on file"
                        }}
                    </span>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <x-patterns.key-value-display
                :items="$profileSummaryDetails"
                :columns="3"
                compact
            />
        </div>

        <footer class="mt-6 flex justify-end">
            <x-ui.button
                type="button"
                kind="primary"
                size="sm"
                icon="upload"
                aria-controls="account-profile-photo-modal"
                data-ui-dialog-trigger="account-profile-photo-modal"
            >
                Update photo
            </x-ui.button>
        </footer>
    </section>

    {{-- ----------------------------------------------------------------------
        Personal details
        ---------------------------------------------------------------------- --}}

    <section
        class="border border-[color:var(--ui-border-subtle-01)] bg-[color:var(--ui-layer)] p-6"
        aria-labelledby="account-personal-details-heading"
        data-account-personal-details-card
    >
        <header class="mb-6">
            <h2 id="account-personal-details-heading" class="ui-card-title">
                Personal details
            </h2>

            <p class="ui-card-copy mt-2">Your name and primary phone number.</p>
        </header>

        <x-patterns.key-value-display :items="$personalDetails" :columns="2" />

        <footer class="mt-6 flex justify-end">
            <x-ui.button
                type="button"
                kind="primary"
                size="sm"
                icon="edit"
                aria-controls="account-profile-modal"
                data-ui-dialog-trigger="account-profile-modal"
            >
                Edit details
            </x-ui.button>
        </footer>
    </section>
</x-ui.v-stack>
