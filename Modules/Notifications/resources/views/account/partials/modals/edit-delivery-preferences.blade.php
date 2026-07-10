<x-ui.modal
    id="account-notifications-modal"
    title="Edit notification preferences"
    label="Notifications"
    size="md"
    :open="$notificationPreferenceErrors->any()"
    secondary-button-text="Cancel"
    primary-button-text="Save notifications"
    primary-button-type="submit"
    primary-button-form="account-notifications-form"
    :close-on-backdrop="false"
>
    <x-ui.form
        id="account-notifications-form"
        method="POST"
        :action="route('platform.account.notifications.update')"
        data-account-notification-preferences-form
        data-ui-form-submit-state
        data-ui-form-submit-state-loading-text="Saving notifications..."
    >
        <x-ui.grid subgrid row-gap>
            <x-ui.grid-column span="100">
                <input type="hidden" name="email_enabled" value="0">
                <x-ui.toggle
                    id="email_enabled"
                    name="email_enabled"
                    value="1"
                    label="Email notifications"
                    helper="Store your preference for future notification email delivery."
                    :checked="old('email_enabled', $preference->email_enabled) ? true : false"
                    data-ui-dialog-primary-focus
                />
            </x-ui.grid-column>

            <x-ui.grid-column span="100">
                <x-ui.select
                    id="digest_frequency"
                    name="digest_frequency"
                    label="Digest frequency"
                    :value="old('digest_frequency', $preference->digest_frequency ?? 'never')"
                    :items="$digestItems"
                    :invalid="$notificationPreferenceErrors->has('digest_frequency')"
                    :invalid-text="$notificationPreferenceErrors->first('digest_frequency')"
                />
            </x-ui.grid-column>
        </x-ui.grid>
    </x-ui.form>
</x-ui.modal>
