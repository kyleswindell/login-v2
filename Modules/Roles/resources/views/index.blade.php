{{-- ==========================================================================
    File: Modules/Roles/resources/views/index.blade.php
    Purpose: Roles module inventory dashboard.
========================================================================== --}}

<x-layouts.app
    grid
    :title="__('roles::module.title')"
    :page-title="__('roles::module.title')"
    :page-subtitle="__('roles::module.description')"
    :reserve-page-tabs="true"
>
    <x-slot:pageActions>
        @if ($canViewPermissions)
            <x-ui.button
                :href="route('roles.permissions.index')"
                kind="secondary"
            >
                {{ __('roles::module.view_permission_catalog') }}
            </x-ui.button>
        @endif

        @if ($canCreateRoles)
            <x-ui.button
                :href="route('roles.create')"
                kind="primary"
            >
                {{ __('roles::module.create_role') }}
            </x-ui.button>
        @endif
    </x-slot:pageActions>

    <x-ui.grid-column
        tag="section"
        span="100"
        lg="12"
        xlg="12"
        max="12"
        data-roles-inventory-section
    >
        <x-ui.data-table.container
            title="Role inventory"
            description="Review role assignment counts and permission totals before changing access."
        >
            <x-ui.data-table.table
                size="md"
                striped
                aria-label="Role inventory"
            >
                <x-ui.data-table.head>
                    <x-ui.data-table.row>
                        <x-ui.data-table.expand-header />

                        <x-ui.data-table.header>
                            {{ __('roles::module.role_title_column') }}
                        </x-ui.data-table.header>

                        <x-ui.data-table.header>
                            {{ __('roles::module.tags_column') }}
                        </x-ui.data-table.header>

                        <x-ui.data-table.header align="center">
                            {{ __('roles::module.permissions_column') }}
                        </x-ui.data-table.header>

                        <x-ui.data-table.header align="center">
                            {{ __('roles::module.assigned_users_column') }}
                        </x-ui.data-table.header>

                        <x-ui.data-table.header align="center">
                            {{ __('roles::module.view_column') }}
                        </x-ui.data-table.header>

                        <x-ui.data-table.header align="center">
                            {{ __('roles::module.edit_column') }}
                        </x-ui.data-table.header>
                    </x-ui.data-table.row>
                </x-ui.data-table.head>

                <x-ui.data-table.body>
                    @forelse ($roles as $role)
                        @php
                            $roleId = data_get($role, 'id');
                            $roleLabel = data_get($role, 'label');
                            $roleKey = data_get($role, 'key');
                            $roleDescription = data_get($role, 'description');
                            $permissionCount = (int) data_get($role, 'permission_count', 0);
                            $assignedUsers = (int) data_get($role, 'assigned_users', 0);
                            $isSystem = (bool) data_get($role, 'is_system', false);
                            $isElevated = (bool) data_get($role, 'is_elevated', false);
                            $isDefault = (bool) data_get($role, 'is_default', false);
                            $isProtected = (bool) data_get($role, 'is_protected', false);
                            $isAssignable = (bool) data_get($role, 'is_assignable', true);
                            $canEdit = (bool) data_get($role, 'can_edit', false);
                            $detailsId = 'roles-inventory-details-'.$roleId;
                        @endphp

                        <x-ui.data-table.expand-row
                            :aria-controls="$detailsId"
                            :aria-label="__('roles::module.expand_role_details', ['role' => $roleLabel])"
                        >
                            <x-ui.data-table.cell>
                                <div class="font-semibold">
                                    {{ $roleLabel }}
                                </div>
                            </x-ui.data-table.cell>

                            <x-ui.data-table.cell>
                                <span class="flex flex-wrap gap-2">
                                    <x-ui.tag
                                        :text="$isSystem ? __('roles::module.system_role') : __('roles::module.custom_role')"
                                        :tone="$isSystem ? 'blue' : 'gray'"
                                        size="sm"
                                    />

                                    @if ($isElevated)
                                        <x-ui.tag
                                            :text="__('roles::module.elevated_role')"
                                            tone="red"
                                            size="sm"
                                        />
                                    @endif

                                    @if ($isDefault)
                                        <x-ui.tag
                                            :text="__('roles::module.default_role')"
                                            tone="purple"
                                            size="sm"
                                        />
                                    @endif
                                </span>
                            </x-ui.data-table.cell>

                            <x-ui.data-table.cell align="center">
                                {{ $permissionCount }}
                            </x-ui.data-table.cell>

                            <x-ui.data-table.cell align="center">
                                {{ $assignedUsers }}
                            </x-ui.data-table.cell>

                            <x-ui.data-table.cell align="center">
                                <x-ui.link
                                    :href="route('roles.show', $roleId)"
                                    size="sm"
                                    :aria-label="__('roles::module.view_role_aria', ['role' => $roleLabel])"
                                >
                                    {{ __('roles::module.view_role') }}
                                </x-ui.link>
                            </x-ui.data-table.cell>

                            <x-ui.data-table.cell align="center">
                                @if ($canEdit)
                                    <x-ui.link
                                        :href="route('roles.edit', $roleId)"
                                        size="sm"
                                        :aria-label="__('roles::module.edit_role_aria', ['role' => $roleLabel])"
                                    >
                                        {{ __('roles::module.edit_role') }}
                                    </x-ui.link>
                                @else
                                    <x-ui.tag
                                        :text="__('roles::module.view_only')"
                                        tone="gray"
                                        size="sm"
                                    />
                                @endif
                            </x-ui.data-table.cell>
                        </x-ui.data-table.expand-row>

                        <x-ui.data-table.expanded-row
                            :id="$detailsId"
                            colspan="7"
                        >
                            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                                <div class="space-y-1">
                                    <div class="text-xs font-semibold uppercase">
                                        {{ __('roles::module.role_description') }}
                                    </div>

                                    <div class="text-sm">
                                        {{ filled($roleDescription) ? $roleDescription : __('roles::module.no_role_description') }}
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <div class="text-xs font-semibold uppercase">
                                        {{ __('roles::module.role_key') }}
                                    </div>

                                    <div class="text-sm">
                                        {{ $roleKey }}
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <div class="text-xs font-semibold uppercase">
                                        {{ __('roles::module.role_constraints') }}
                                    </div>

                                    <div class="flex flex-wrap gap-2">
                                        @if ($isProtected)
                                            <x-ui.tag
                                                :text="__('roles::module.protected_role')"
                                                tone="blue"
                                                size="sm"
                                            />
                                        @endif

                                        <x-ui.tag
                                            :text="$isAssignable ? __('roles::module.assignable_role') : __('roles::module.not_assignable_role')"
                                            :tone="$isAssignable ? 'green' : 'gray'"
                                            size="sm"
                                        />
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <div class="text-xs font-semibold uppercase">
                                        {{ __('roles::module.permission_assignment') }}
                                    </div>

                                    <div class="text-sm">
                                        {{
                                            trans_choice(
                                                'roles::module.permissions_count',
                                                $permissionCount,
                                                ['count' => $permissionCount],
                                            )
                                        }}
                                    </div>
                                </div>
                            </div>
                        </x-ui.data-table.expanded-row>
                    @empty
                        <x-ui.data-table.row>
                            <x-ui.data-table.cell colspan="7">
                                {{ __('roles::module.no_roles') }}
                            </x-ui.data-table.cell>
                        </x-ui.data-table.row>
                    @endforelse
                </x-ui.data-table.body>
            </x-ui.data-table.table>
        </x-ui.data-table.container>
    </x-ui.grid-column>
</x-layouts.app>
