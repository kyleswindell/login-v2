{{-- ==========================================================================
    File: Modules/Roles/resources/views/show.blade.php
    Purpose: Role detail and review view.
========================================================================== --}}

<x-layouts.app
    grid
    :title="__('roles::module.show_title', ['role' => $roleSummary['label']])"
    :page-title="__('roles::module.show_title', ['role' => $roleSummary['label']])"
    :page-subtitle="$roleSummary['description']"
    :reserve-page-tabs="true"
>
    <x-slot:pageActions>
        <x-ui.button
            :href="route('roles.index')"
            kind="secondary"
        >
            {{ __('roles::module.back_to_roles') }}
        </x-ui.button>

        @if ($roleSummary['can_edit'])
            <x-ui.button
                :href="route('roles.edit', $role)"
                kind="primary"
            >
                {{ __('roles::module.edit_role') }}
            </x-ui.button>
        @endif
    </x-slot:pageActions>

    <x-ui.grid-column
        tag="section"
        span="100"
        lg="6"
        xlg="6"
        max="6"
    >
        <x-ui.contained-list :title="__('roles::module.role_summary')">
            <x-ui.contained-list-item
                :title="$roleSummary['label']"
                :description="$roleSummary['key']"
                :meta="trans_choice('roles::module.permissions_count', $roleSummary['permission_count'], ['count' => $roleSummary['permission_count']])"
            >
                <x-slot:actions>
                    <x-ui.tag
                        :text="$roleSummary['is_system'] ? __('roles::module.system_role') : __('roles::module.custom_role')"
                        :tone="$roleSummary['is_system'] ? 'blue' : 'gray'"
                        size="sm"
                    />

                    @if ($roleSummary['is_elevated'])
                        <x-ui.tag
                            :text="__('roles::module.elevated_role')"
                            tone="red"
                            size="sm"
                        />
                    @endif
                </x-slot:actions>
            </x-ui.contained-list-item>

            <x-ui.contained-list-item
                :title="__('roles::module.assigned_users_column')"
                :description="trans_choice('roles::module.assigned_users_count', $roleSummary['assigned_users'], ['count' => $roleSummary['assigned_users']])"
                :meta="$roleSummary['is_assignable'] ? __('roles::module.assignable_role') : __('roles::module.not_assignable_role')"
            />
        </x-ui.contained-list>
    </x-ui.grid-column>

    <x-ui.grid-column
        tag="section"
        span="100"
        lg="6"
        xlg="6"
        max="6"
    >
        <x-ui.contained-list :title="__('roles::module.role_constraints')">
            <x-ui.contained-list-item
                :title="__('roles::module.locked_key')"
                :description="__('roles::module.locked_key_description')"
                :meta="$roleSummary['key']"
            />

            <x-ui.contained-list-item
                :title="__('roles::module.delete_role')"
                :description="$roleSummary['can_delete'] ? __('roles::module.delete_available') : __('roles::module.delete_unavailable')"
                :meta="$roleSummary['can_delete'] ? __('roles::module.available') : __('roles::module.blocked')"
            >
                @if ($roleSummary['can_delete'])
                    <x-slot:actions>
                        <x-ui.button
                            :href="route('roles.delete', $role)"
                            kind="danger"
                            size="sm"
                        >
                            {{ __('roles::module.delete_role') }}
                        </x-ui.button>
                    </x-slot:actions>
                @endif
            </x-ui.contained-list-item>
        </x-ui.contained-list>
    </x-ui.grid-column>

    <x-ui.grid-column
        tag="section"
        span="100"
        lg="12"
        xlg="12"
        max="12"
    >
        <x-ui.contained-list :title="__('roles::module.permission_assignment')">
            @forelse ($permissionItems as $permission)
                @php
                    $isElevated = (bool) data_get($permission, 'elevated', false);
                    $isDestructive = (bool) data_get($permission, 'destructive', false);
                    $isStale = (bool) data_get($permission, 'is_stale', false);
                    $permissionMeta = collect([
                        data_get($permission, 'key'),
                        data_get($permission, 'action'),
                    ])->filter()->join(' · ');
                @endphp

                <x-ui.contained-list-item
                    :title="data_get($permission, 'label')"
                    :description="data_get($permission, 'description')"
                    :meta="$permissionMeta"
                >
                    <x-slot:actions>
                        @if ($isStale)
                            <x-ui.tag
                                :text="__('roles::module.stale_permission')"
                                tone="yellow"
                                size="sm"
                            />
                        @endif

                        @if ($isElevated)
                            <x-ui.tag
                                :text="__('roles::module.elevated_permission')"
                                tone="red"
                                size="sm"
                            />
                        @endif

                        @if ($isDestructive)
                            <x-ui.tag
                                :text="__('roles::module.destructive_permission')"
                                tone="red"
                                size="sm"
                            />
                        @endif
                    </x-slot:actions>
                </x-ui.contained-list-item>
            @empty
                <x-ui.contained-list-item
                    :title="__('roles::module.no_permissions')"
                    :description="__('roles::module.no_permissions_description')"
                />
            @endforelse
        </x-ui.contained-list>
    </x-ui.grid-column>

    <x-ui.grid-column
        tag="section"
        span="100"
        lg="12"
        xlg="12"
        max="12"
    >
        <x-ui.contained-list :title="__('roles::module.assigned_users_column')">
            @forelse ($assignedUsers as $assignedUser)
                <x-ui.contained-list-item
                    :title="data_get($assignedUser, 'name')"
                    :description="data_get($assignedUser, 'email')"
                />
            @empty
                <x-ui.contained-list-item
                    :title="__('roles::module.no_assigned_users')"
                    :description="__('roles::module.no_assigned_users_description')"
                />
            @endforelse
        </x-ui.contained-list>
    </x-ui.grid-column>
</x-layouts.app>
