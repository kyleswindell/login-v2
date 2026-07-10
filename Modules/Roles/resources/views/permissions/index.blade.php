{{-- ==========================================================================
    File: Modules/Roles/resources/views/permissions/index.blade.php
    Purpose: Read-only imported permission catalog view.
========================================================================== --}}

<x-layouts.app
    grid
    :title="__('roles::module.permission_catalog')"
    :page-title="__('roles::module.permission_catalog')"
    :page-subtitle="__('roles::module.permission_catalog_description')"
    :reserve-page-tabs="true"
>
    <x-slot:pageActions>
        <x-ui.button
            :href="route('roles.index')"
            kind="secondary"
        >
            {{ __('roles::module.back_to_roles') }}
        </x-ui.button>
    </x-slot:pageActions>

    <x-ui.grid-column
        tag="section"
        span="100"
        lg="12"
        xlg="12"
        max="12"
        data-roles-permission-catalog-section
    >
        <x-ui.contained-list :title="__('roles::module.permission_catalog_summary')">
            <x-ui.contained-list-item
                :title="__('roles::module.permission_catalog')"
                :description="trans_choice('roles::module.permissions_count', $permissionCatalogSummary['permissions'], ['count' => $permissionCatalogSummary['permissions']])"
                :meta="__('roles::module.permission_groups_count', ['count' => $permissionCatalogSummary['groups']])"
            >
                <x-slot:actions>
                    @if ($permissionCatalogSummary['elevated'] > 0)
                        <x-ui.tag
                            :text="__('roles::module.elevated_permissions_count', ['count' => $permissionCatalogSummary['elevated']])"
                            tone="red"
                            size="sm"
                        />
                    @endif

                    @if ($permissionCatalogSummary['stale'] > 0)
                        <x-ui.tag
                            :text="__('roles::module.stale_permissions_count', ['count' => $permissionCatalogSummary['stale']])"
                            tone="yellow"
                            size="sm"
                        />
                    @endif
                </x-slot:actions>
            </x-ui.contained-list-item>
        </x-ui.contained-list>

        <div class="mt-6">
            <x-ui.accordion
                :items="$permissionCatalogItems"
                variant="contained"
                alignment="flush"
                icon-alignment="start"
                size="compact"
                mode="multiple"
            />
        </div>
    </x-ui.grid-column>
</x-layouts.app>
