{{-- ==========================================================================
    File: Modules/Roles/resources/views/edit.blade.php
    Purpose: Roles module edit form view.
========================================================================== --}}

@php
    $rolesUpdateFormId = "roles-update-form-".$role->getKey();
    $rolesUpdateReviewModalId = "roles-update-review-modal-".$role->getKey();
@endphp

<x-layouts.app
    :title="__('roles::module.edit_title', ['role' => $roleSummary['label']])"
    :page-title="__('roles::module.edit_title', ['role' => $roleSummary['label']])"
    :page-subtitle="__('roles::module.edit_description')"
    :reserve-page-tabs="true"
>
    <x-ui.grid-column tag="section" span="100" lg="12" xlg="12">
        <x-patterns.forms.page
            :title="__('roles::module.edit_title', ['role' => $roleSummary['label']])"
            :description="__('roles::module.edit_description')"
            :action="route('roles.update', $role)"
            method="PATCH"
            width="xl"
            :show-header="false"
            :id="$rolesUpdateFormId"
            submit-state
            :loading-text="__('roles::module.saving_role')"
        >
            <x-ui.contained-list :title="__('roles::module.role_summary')">
                <x-ui.contained-list-item
                    :title="$roleSummary['label']"
                    :description="$roleSummary['key']"
                    :meta="__('roles::module.locked_key')"
                >
                    <x-slot:actions>
                        <x-ui.tag
                            :text="$roleSummary['is_system'] ? __('roles::module.system_role') : __('roles::module.custom_role')"
                            :tone="$roleSummary['is_system'] ? 'blue' : 'gray'"
                            size="sm"
                        />
                    </x-slot:actions>
                </x-ui.contained-list-item>
            </x-ui.contained-list>

            <x-ui.text-input
                name="label"
                :label-text="__('roles::module.role_label')"
                :helper-text="__('roles::module.role_label_help')"
                :value="old('label', $roleSummary['label'])"
                :invalid="$errors->has('label')"
                :invalid-text="$errors->first('label')"
                required
            />

            <x-ui.text-area
                name="description"
                :label-text="__('roles::module.role_description')"
                :helper-text="__('roles::module.role_description_help')"
                :value="old('description', $roleSummary['description'])"
                :invalid="$errors->has('description')"
                :invalid-text="$errors->first('description')"
                rows="3"
            />

            <section class="flex flex-col gap-4">
                <div>
                    <h2 class="text-lg font-semibold">{{ __('roles::module.permission_assignment') }}</h2>
                    <p class="text-sm">{{ __('roles::module.permission_assignment_description') }}</p>
                </div>

                <x-ui.accordion
                    :items="$permissionFormItems"
                    variant="contained"
                    mode="multiple"
                />
            </section>

            <x-slot:actions>
                <x-patterns.forms.actions label="Update role actions">
                    <x-ui.button
                        :href="route('roles.show', $role)"
                        kind="secondary"
                    >
                        {{ __('roles::module.back_to_role') }}
                    </x-ui.button>

                    @if ($roleSummary['can_delete'])
                        <x-ui.button
                            :href="route('roles.delete', $role)"
                            kind="danger"
                        >
                            {{ __('roles::module.delete_role') }}
                        </x-ui.button>
                    @endif

                    <x-ui.button
                        type="button"
                        kind="primary"
                        href="#{{ $rolesUpdateReviewModalId }}"
                        aria-controls="{{ $rolesUpdateReviewModalId }}"
                        data-ui-dialog-trigger="{{ $rolesUpdateReviewModalId }}"
                        data-roles-action-review-trigger
                    >
                        {{ __('roles::module.review_save_role') }}
                    </x-ui.button>
                </x-patterns.forms.actions>
            </x-slot:actions>
        </x-patterns.forms.page>

        @include ("roles::partials.review.mutation-modal",
            [
                "id" => $rolesUpdateReviewModalId,
                "review" => $mutationReview,
                "status" => "warning",
                "formId" => $rolesUpdateFormId,
                "title" => __("roles::module.review_update_title", ["role" => $roleSummary["label"]]),
                "label" => __("roles::module.review_update_label"),
                "description" => __("roles::module.review_update_description"),
                "confirmLabel" => __("roles::module.save_role"),
                "cancelLabel" => __("roles::module.cancel_review"),
                "busyLabel" => __("roles::module.saving_role"),
            ])
    </x-ui.grid-column>
</x-layouts.app>
