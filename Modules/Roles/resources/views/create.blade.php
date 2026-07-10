{{-- ==========================================================================
    File: Modules/Roles/resources/views/create.blade.php
    Purpose: Roles module create form view.
========================================================================== --}}

@php
    $rolesCreateFormId = "roles-create-form";
    $rolesCreateReviewModalId = "roles-create-review-modal";
@endphp

<x-layouts.app
    :title="__('roles::module.create_title')"
    :page-title="__('roles::module.create_title')"
    :page-subtitle="__('roles::module.create_description')"
    :reserve-page-tabs="true"
>
    <x-ui.grid-column tag="section" span="100" lg="12" xlg="12">
        <x-patterns.forms.page
            :title="__('roles::module.create_title')"
            :description="__('roles::module.create_description')"
            :action="route('roles.store')"
            method="POST"
            width="xl"
            :show-header="false"
            :id="$rolesCreateFormId"
            submit-state
            :loading-text="__('roles::module.creating_role')"
        >
            <x-ui.text-input
                name="key"
                :label-text="__('roles::module.role_key')"
                :helper-text="__('roles::module.role_key_help')"
                :value="old('key')"
                :invalid="$errors->has('key')"
                :invalid-text="$errors->first('key')"
                required
            />

            <x-ui.text-input
                name="label"
                :label-text="__('roles::module.role_label')"
                :helper-text="__('roles::module.role_label_help')"
                :value="old('label')"
                :invalid="$errors->has('label')"
                :invalid-text="$errors->first('label')"
                required
            />

            <x-ui.text-area
                name="description"
                :label-text="__('roles::module.role_description')"
                :helper-text="__('roles::module.role_description_help')"
                :value="old('description')"
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
                <x-patterns.forms.actions label="Create role actions">
                    <x-ui.button
                        :href="route('roles.index')"
                        kind="secondary"
                    >
                        {{ __('roles::module.back_to_roles') }}
                    </x-ui.button>

                    <x-ui.button
                        type="button"
                        kind="primary"
                        href="#{{ $rolesCreateReviewModalId }}"
                        aria-controls="{{ $rolesCreateReviewModalId }}"
                        data-ui-dialog-trigger="{{ $rolesCreateReviewModalId }}"
                        data-roles-action-review-trigger
                    >
                        {{ __('roles::module.review_create_role') }}
                    </x-ui.button>
                </x-patterns.forms.actions>
            </x-slot:actions>
        </x-patterns.forms.page>

        @include ("roles::partials.review.mutation-modal",
            [
                "id" => $rolesCreateReviewModalId,
                "review" => $mutationReview,
                "status" => "warning",
                "formId" => $rolesCreateFormId,
                "title" => __("roles::module.review_create_title"),
                "label" => __("roles::module.review_create_label"),
                "description" => __("roles::module.review_create_description"),
                "confirmLabel" => __("roles::module.create_role"),
                "cancelLabel" => __("roles::module.cancel_review"),
                "busyLabel" => __("roles::module.creating_role"),
            ])
    </x-ui.grid-column>
</x-layouts.app>
