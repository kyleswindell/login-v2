{{-- ==========================================================================
    File: Modules/Account/resources/views/partials/profile/modals.blade.php
    Purpose: Profile page modal edit flows.

    Notes:
    - Owns profile, profile photo, and contact email modal form composition.
    - Uses x-ui.modal generated footer actions.
    - Uses x-ui.form for native form, CSRF, and Laravel method spoofing.
    - Uses data-ui-form-submit-state for duplicate-submit protection and local
      inline-loading action feedback.
    ========================================================================== --}}

<x-ui.modal
    id="account-profile-modal"
    title="Edit profile"
    label="Profile"
    size="md"
    :open="$accountDetailsErrors->any()"
    has-scrolling-content
    secondary-button-text="Cancel"
    primary-button-text="Save profile"
    primary-button-type="submit"
    primary-button-form="account-profile-form"
    should-submit-on-enter
    :close-on-backdrop="false"
>
    <x-ui.form
        id="account-profile-form"
        method="PATCH"
        :action="route('platform.account.details.update')"
        data-account-details-form
        data-ui-form-submit-state
        data-ui-form-submit-state-loading-text="Saving profile..."
    >
        <x-ui.grid subgrid row-gap>
            <x-ui.grid-column span="100" md="4" lg="6">
                <x-ui.text-input
                    id="first_name"
                    name="first_name"
                    label="First name"
                    :value="old('first_name', $user->first_name)"
                    autocomplete="given-name"
                    :invalid="$accountDetailsErrors->has('first_name')"
                    :invalid-text="$accountDetailsErrors->first('first_name')"
                />
            </x-ui.grid-column>

            <x-ui.grid-column span="100" md="4" lg="6">
                <x-ui.text-input
                    id="last_name"
                    name="last_name"
                    label="Last name"
                    :value="old('last_name', $user->last_name)"
                    autocomplete="family-name"
                    :invalid="$accountDetailsErrors->has('last_name')"
                    :invalid-text="$accountDetailsErrors->first('last_name')"
                />
            </x-ui.grid-column>

            <x-ui.grid-column span="100">
                <x-ui.text-input
                    id="name"
                    name="name"
                    label="Display name"
                    :value="old('name', $user->name)"
                    autocomplete="name"
                    required
                    data-ui-dialog-primary-focus
                    :invalid="$accountDetailsErrors->has('name')"
                    :invalid-text="$accountDetailsErrors->first('name')"
                />
            </x-ui.grid-column>

            <x-ui.grid-column span="100">
                <x-ui.text-input
                    id="phone"
                    name="phone"
                    label="Phone"
                    :value="old('phone', $user->phone)"
                    type="tel"
                    inputmode="tel"
                    autocomplete="tel"
                    placeholder="(555) 555-5555"
                    data-ui-phone-input
                    :invalid="$accountDetailsErrors->has('phone')"
                    :invalid-text="$accountDetailsErrors->first('phone')"
                />
            </x-ui.grid-column>
        </x-ui.grid>
    </x-ui.form>
</x-ui.modal>

<x-ui.modal
    id="account-profile-photo-modal"
    title="Edit profile photo"
    label="Profile"
    size="sm"
    :open="$profilePhotoErrors->any()"
    secondary-button-text="Cancel"
    primary-button-text="Save photo"
    primary-button-type="submit"
    primary-button-form="account-profile-photo-form"
    :close-on-backdrop="false"
>
    <div class="grid gap-5 sm:grid-cols-[auto_minmax(0,1fr)] sm:items-start">
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
            <x-ui.form
                id="account-profile-photo-form"
                method="PATCH"
                :action="route('platform.account.profile-photo.update')"
                enctype="multipart/form-data"
                data-account-profile-photo-form
                data-ui-form-submit-state
                data-ui-form-submit-state-loading-text="Saving photo..."
            >
                <x-ui.file-uploader
                    name="profile_photo"
                    button-label="Choose photo"
                    :accept="
                        [
       '.jpg',
       '.jpeg',
       '.png',
       '.webp',
       'image/jpeg',
       'image/png',
       'image/webp',
    ]
                    "
                    label-title="Profile photo"
                    label-description="Upload a square JPG, PNG, or WebP image up to 2 MB."
                    max-file-size="2 MB"
                />

                @if ($profilePhotoErrors->has("profile_photo"))
                    <p class="mt-2 text-sm" data-ui-field-error>
                        {{
                            $profilePhotoErrors->first(
                                "profile_photo",
                            )
                        }}
                    </p>
                @endif
            </x-ui.form>

            @if ($user->profile_image_path)
                <x-ui.form
                    method="DELETE"
                    :action="route('platform.account.profile-photo.destroy')"
                    class="mt-4"
                    data-account-profile-photo-remove-form
                    data-ui-form-submit-state
                    data-ui-form-submit-state-loading-text="Removing photo..."
                    data-ui-form-actions
                    data-ui-form-actions-loading-text="Removing photo..."
                >
                    <x-ui.button
                        type="submit"
                        kind="danger--tertiary"
                        size="md"
                        data-ui-form-action
                        data-ui-form-action-role="delete"
                        data-ui-form-action-allow-during-busy="false"
                    >
                        Remove current photo
                    </x-ui.button>
                </x-ui.form>
            @endif
        </div>
    </div>
</x-ui.modal>

<x-ui.modal
    id="account-contact-email-modal"
    title="Add contact email"
    label="Contact methods"
    size="md"
    :open="$contactEmailErrors->any()"
    secondary-button-text="Cancel"
    primary-button-text="Add contact email"
    primary-button-type="submit"
    primary-button-form="account-contact-email-form"
    should-submit-on-enter
    :close-on-backdrop="false"
>
    <x-ui.form
        id="account-contact-email-form"
        method="POST"
        :action="route('platform.account.contact-emails.store')"
        data-account-contact-email-form
        data-ui-form-submit-state
        data-ui-form-submit-state-loading-text="Adding contact email..."
    >
        <x-ui.grid subgrid row-gap>
            <x-ui.grid-column span="100" md="4" lg="6">
                <x-ui.text-input
                    id="contact_email"
                    name="email"
                    type="email"
                    label="Email"
                    :value="old('email')"
                    autocomplete="email"
                    required
                    data-ui-dialog-primary-focus
                    :invalid="$contactEmailErrors->has('email')"
                    :invalid-text="$contactEmailErrors->first('email')"
                />
            </x-ui.grid-column>

            <x-ui.grid-column span="100" md="4" lg="6">
                <x-ui.text-input
                    id="contact_email_label"
                    name="label"
                    label="Label"
                    :value="old('label')"
                    placeholder="Billing, assistant, alternate"
                    :invalid="$contactEmailErrors->has('label')"
                    :invalid-text="$contactEmailErrors->first('label')"
                />
            </x-ui.grid-column>
        </x-ui.grid>
    </x-ui.form>
</x-ui.modal>
