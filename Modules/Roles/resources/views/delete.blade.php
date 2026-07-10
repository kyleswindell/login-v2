{{-- ==========================================================================
    File: Modules/Roles/resources/views/delete.blade.php
    Purpose: Role deletion confirmation view.
========================================================================== --}}

@php
    $rolesDeleteFormId = "roles-delete-form-".$role->getKey();
    $rolesDeleteReviewModalId = "roles-delete-review-modal-".$role->getKey();
@endphp

<x-layouts.app
    :title="__('roles::module.delete_title', ['role' => $roleSummary['label']])"
    :page-title="__('roles::module.delete_title', ['role' => $roleSummary['label']])"
    :page-subtitle="__('roles::module.delete_description')"
    :reserve-page-tabs="true"
>
    <x-ui.grid-column tag="section" span="100" lg="12" xlg="12">
        <x-patterns.forms.page
            :title="__('roles::module.delete_title', ['role' => $roleSummary['label']])"
            :description="__('roles::module.delete_description')"
            :action="route('roles.destroy', $role)"
            method="DELETE"
            width="lg"
            :show-header="false"
            :id="$rolesDeleteFormId"
            submit-state
            :loading-text="__('roles::module.deleting_role')"
        >
            <x-ui.contained-list :title="__('roles::module.delete_review')">
                <x-ui.contained-list-item
                    :title="$roleSummary['label']"
                    :description="$roleSummary['key']"
                    :meta="$roleSummary['can_delete'] ? __('roles::module.available') : __('roles::module.blocked')"
                >
                    <x-slot:actions>
                        <x-ui.tag
                            :text="$roleSummary['is_system'] ? __('roles::module.system_role') : __('roles::module.custom_role')"
                            :tone="$roleSummary['is_system'] ? 'blue' : 'gray'"
                            size="sm"
                        />
                    </x-slot:actions>
                </x-ui.contained-list-item>

                @if ($roleSummary['is_system'])
                    <x-ui.contained-list-item
                        :title="__('roles::module.system_role')"
                        :description="__('roles::module.delete_unavailable_system')"
                        :meta="__('roles::module.blocked')"
                    />
                @endif

                @if ($roleSummary['assigned_users'] > 0)
                    <x-ui.contained-list-item
                        :title="__('roles::module.assigned_users_column')"
                        :description="trans_choice('roles::module.assigned_users_count', $roleSummary['assigned_users'], ['count' => $roleSummary['assigned_users']])"
                        :meta="__('roles::module.blocked')"
                    />
                @endif

                @if ($roleSummary['is_elevated'])
                    <x-ui.contained-list-item
                        :title="__('roles::module.elevated_role')"
                        :description="__('roles::module.delete_elevated_review')"
                        :meta="$roleSummary['can_delete'] ? __('roles::module.available') : __('roles::module.blocked')"
                    />
                @endif
            </x-ui.contained-list>

            @if (! $roleSummary['can_delete'])
                <p class="text-sm">{{ __('roles::module.delete_unavailable') }}</p>
            @endif

            <x-slot:actions>
                <x-patterns.forms.actions label="Delete role actions">
                    <x-ui.button
                        :href="route('roles.show', $role)"
                        kind="secondary"
                    >
                        {{ __('roles::module.back_to_role') }}
                    </x-ui.button>

                    <x-ui.button
                        type="button"
                        kind="danger"
                        :disabled="! $roleSummary['can_delete']"
                        href="#{{ $rolesDeleteReviewModalId }}"
                        aria-controls="{{ $rolesDeleteReviewModalId }}"
                        data-ui-dialog-trigger="{{ $rolesDeleteReviewModalId }}"
                        data-roles-action-review-trigger
                    >
                        {{ __('roles::module.confirm_delete_role') }}
                    </x-ui.button>
                </x-patterns.forms.actions>
            </x-slot:actions>
        </x-patterns.forms.page>

        @include ("roles::partials.review.mutation-modal",
            [
                "id" => $rolesDeleteReviewModalId,
                "review" => $mutationReview,
                "formId" => $rolesDeleteFormId,
                "title" => __("roles::module.review_delete_title", ["role" => $roleSummary["label"]]),
                "label" => __("roles::module.review_delete_label"),
                "description" => __("roles::module.review_delete_description"),
                "confirmLabel" => __("roles::module.confirm_delete_role"),
                "cancelLabel" => __("roles::module.cancel_review"),
                "busyLabel" => __("roles::module.deleting_role"),
            ])
    </x-ui.grid-column>
</x-layouts.app>
