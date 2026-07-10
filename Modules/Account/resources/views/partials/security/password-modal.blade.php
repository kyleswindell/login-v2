<x-ui.modal
    id="account-password-modal"
    title="Update password"
    label="Security"
    size="sm"
    :open="$passwordErrors->any()"
    has-scrolling-content
    secondary-button-text="Cancel"
    primary-button-text="Update password"
    primary-button-type="submit"
    primary-button-form="account-password-form"
    should-submit-on-enter
    :close-on-backdrop="false"
>
    <x-ui.form
        id="account-password-form"
        method="POST"
        :action="route('platform.account.password.update')"
        data-account-password-form
        data-ui-form-submit-state
        data-ui-form-submit-state-loading-text="Updating password..."
    >
        <x-ui.grid subgrid row-gap>
            <x-ui.grid-column span="100">
                <x-ui.password-input
                    id="current_password"
                    name="current_password"
                    label="Current password"
                    autocomplete="current-password"
                    required
                    data-ui-dialog-primary-focus
                    :invalid="$passwordErrors->has('current_password')"
                    :invalid-text="$passwordErrors->first('current_password')"
                />
            </x-ui.grid-column>

            <x-ui.grid-column span="100">
                <x-ui.password-input
                    id="new_password"
                    name="new_password"
                    label="New password"
                    autocomplete="new-password"
                    required
                    :invalid="$passwordErrors->has('new_password')"
                    :invalid-text="$passwordErrors->first('new_password')"
                />
            </x-ui.grid-column>

            <x-ui.grid-column span="100">
                <x-ui.password-input
                    id="new_password_confirmation"
                    name="new_password_confirmation"
                    label="Confirm new password"
                    autocomplete="new-password"
                    required
                    :invalid="$passwordErrors->has('new_password_confirmation')"
                    :invalid-text="$passwordErrors->first('new_password_confirmation')"
                />
            </x-ui.grid-column>
        </x-ui.grid>
    </x-ui.form>
</x-ui.modal>
