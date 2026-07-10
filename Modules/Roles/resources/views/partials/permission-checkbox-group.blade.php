{{-- ==========================================================================
    File: Modules/Roles/resources/views/partials/permission-checkbox-group.blade.php
    Purpose: Permission assignment controls for one permission group.

    Notes:
    - Used by role create/edit forms.
    - Renders grouped permission assignment controls with contained-list rows.
    - Elevated permissions can be disabled when the current user is not allowed
      to manage elevated capabilities.
    - Permission assignment order must remain source-order readable and should
      not rely on visual grid placement.
    ========================================================================== --}}

@php
    /*
    |--------------------------------------------------------------------------
    | Selected Permissions
    |--------------------------------------------------------------------------
    */

    $selectedPermissions = old('permissions', $selected ?? []);

    $selectedPermissions = is_array($selectedPermissions)
        ? $selectedPermissions
        : [];
@endphp

<x-ui.contained-list>
    @foreach ($permissions as $permission)
        @php
            /*
            |--------------------------------------------------------------------------
            | Permission Control State
            |--------------------------------------------------------------------------
            */

            $permissionLabel = data_get($permission, 'label');
            $permissionDescription = data_get($permission, 'description');
            $permissionKey = data_get($permission, 'key');
            $permissionAction = data_get($permission, 'action');
            $isElevated = (bool) data_get($permission, 'elevated', false);
            $isDestructive = (bool) data_get($permission, 'destructive', false);

            $isChecked = in_array($permissionKey, $selectedPermissions, true);
            $isElevatedDisabled = $isElevated && ! $canManageElevated;
            $permissionMeta = collect([$permissionKey, $permissionAction])->filter()->join(' · ');
        @endphp

        <x-ui.contained-list-item
            :title="$permissionLabel"
            :description="$permissionDescription"
            :meta="$permissionMeta"
            :disabled="$isElevatedDisabled"
        >
            <x-slot:actions>
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

                <x-ui.checkbox
                    name="permissions[]"
                    :value="$permissionKey"
                    :label-text="$permissionLabel"
                    :checked="$isChecked"
                    :disabled="$isElevatedDisabled"
                    hide-label
                />
            </x-slot:actions>
        </x-ui.contained-list-item>
    @endforeach
</x-ui.contained-list>
