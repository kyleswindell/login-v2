{{-- ==========================================================================
    File: resources/views/platform/users/index.blade.php
    Purpose: Permission-aware platform employee and access directory.

    Notes:
    - Uses the installed page, filter, Data Table, and pagination contracts.
    - Client-side filtering and pagination remain progressive enhancements.
    - User mutations remain governed by existing platform permissions.
    ========================================================================== --}}

@php
    $viewerTimezone = auth()->user()?->timezone ?: config('app.timezone');
    $canManageUsers = auth()->user()?->can('manage-platform-users') ?? false;
    $roleOptions = collect([['value' => '', 'label' => 'Any role']])
        ->merge(
            $users
                ->flatMap(fn ($user) => $user->roles->pluck('name'))
                ->unique()
                ->sort()
                ->values()
                ->map(fn ($roleName): array => ['value' => strtolower($roleName), 'label' => $roleName]),
        )
        ->all();
@endphp

<x-layouts.app
    grid
    title="Platform Users"
    page-title="Platform Users"
    page-subtitle="Review employee accounts, access roles, status, and recent sign-in activity."
>
    @if ($canManageUsers)
        <x-slot:pageActions>
            <x-ui.button
                :href="route('platform.users.create')"
                semantic="primary"
                wire:navigate
            >
                Create user
            </x-ui.button>
        </x-slot:pageActions>
    @endif

    <x-ui.grid-column class="min-w-0" tag="section" span="100" lg="16" max="16" data-platform-users-page>
        <x-ui.v-stack class="min-w-0" :gap="6" data-table-lite-container>

        @if (session('status'))
            <x-ui.notification.inline kind="success" title="Employee access updated">
                {{ session('status') }}
            </x-ui.notification.inline>
        @endif

            <x-patterns.content-section-block
                title="Directory filters"
                description="Find an employee by name or email, then narrow the directory by account status or role."
            >
            <x-patterns.search-filter-bar>
                <x-ui.text-input
                    id="platform-user-search"
                    label="Search"
                    placeholder="Search employees"
                    data-table-lite-search
                />

                <x-ui.select
                    id="platform-user-status"
                    label="Status"
                    :items="[
                        ['value' => '', 'label' => 'Any status'],
                        ['value' => 'active', 'label' => 'Active'],
                        ['value' => 'inactive', 'label' => 'Inactive'],
                    ]"
                    data-table-lite-filter-status
                />

                <x-ui.select
                    id="platform-user-role"
                    label="Role"
                    :items="$roleOptions"
                    data-table-lite-filter-role
                />

                <x-slot:actions>
                    <x-ui.button
                        type="button"
                        semantic="ghost"
                        data-table-lite-filter-reset
                    >
                        Reset filters
                    </x-ui.button>
                </x-slot:actions>
            </x-patterns.search-filter-bar>
            </x-patterns.content-section-block>

            <x-ui.data-table.container
                class="min-w-0"
                title="Employee access"
                description="Application users and their current access assignment."
                title-id="platform-users-title"
                description-id="platform-users-description"
            >
            <x-ui.data-table.table
                size="md"
                :use-static-width="true"
                aria-labelledby="platform-users-title"
                aria-describedby="platform-users-description"
                data-table-lite
            >
                <x-ui.data-table.head>
                    <x-ui.data-table.row>
                        <x-ui.data-table.header>Employee</x-ui.data-table.header>
                        <x-ui.data-table.header>Status</x-ui.data-table.header>
                        <x-ui.data-table.header>Access roles</x-ui.data-table.header>
                        <x-ui.data-table.header>Last sign-in</x-ui.data-table.header>
                        @if ($canManageUsers)
                            <x-ui.data-table.header align="end">Actions</x-ui.data-table.header>
                        @endif
                    </x-ui.data-table.row>
                </x-ui.data-table.head>

                <x-ui.data-table.body>
                    @forelse ($users as $user)
                        <x-ui.data-table.row
                            data-table-status="{{ $user->is_active ? 'active' : 'inactive' }}"
                            data-table-roles="{{ strtolower($user->roles->pluck('name')->join(',')) }}"
                        >
                            <x-ui.data-table.cell class="whitespace-nowrap">
                                <strong>{{ $user->name }}</strong><br>
                                <span class="ui-data-table-cell-secondary-text">{{ $user->email }}</span>
                            </x-ui.data-table.cell>

                            <x-ui.data-table.cell class="whitespace-nowrap">
                                <x-ui.tag
                                    :label="$user->is_active ? 'Active' : 'Inactive'"
                                    :tone="$user->is_active ? 'success' : 'neutral'"
                                    size="sm"
                                />
                            </x-ui.data-table.cell>

                            <x-ui.data-table.cell class="whitespace-nowrap">
                                @forelse ($user->roles as $role)
                                    <x-ui.tag :label="$role->name" type="outline" size="sm" />
                                @empty
                                    <span class="ui-data-table-cell-secondary-text">No roles assigned</span>
                                @endforelse
                            </x-ui.data-table.cell>

                            <x-ui.data-table.cell class="whitespace-nowrap">
                                {{ $user->last_login_at?->timezone($viewerTimezone)->format('M j, Y g:i A T') ?? 'Never' }}
                            </x-ui.data-table.cell>

                            @if ($canManageUsers)
                                <x-ui.data-table.cell align="end" class="whitespace-nowrap">
                                    <x-ui.button
                                        :href="route('platform.users.edit', $user)"
                                        semantic="ghost"
                                        size="sm"
                                        wire:navigate
                                    >
                                        Manage
                                    </x-ui.button>
                                </x-ui.data-table.cell>
                            @endif
                        </x-ui.data-table.row>
                    @empty
                        <x-ui.data-table.row>
                            <x-ui.data-table.cell :colspan="$canManageUsers ? 5 : 4">
                                No application users have been created yet.
                            </x-ui.data-table.cell>
                        </x-ui.data-table.row>
                    @endforelse
                </x-ui.data-table.body>
            </x-ui.data-table.table>

            <div class="ui-data-table-pagination">
                <x-ui.pagination
                    id="platform-users-pagination"
                    label="Employee access pagination"
                    variant="pagination"
                    :current-page="1"
                    :total-items="$users->count()"
                    :page-size="25"
                    :page-size-options="[10, 25, 50, 100]"
                    interactive
                />
            </div>
            </x-ui.data-table.container>
        </x-ui.v-stack>
    </x-ui.grid-column>
</x-layouts.app>
