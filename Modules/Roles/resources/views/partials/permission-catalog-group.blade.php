{{-- ==========================================================================
    File: Modules/Roles/resources/views/partials/permission-catalog-group.blade.php
    Purpose: Permission catalog rows for one permission group.

    Notes:
    - Used by the Roles module permission catalog accordion.
    - Renders read-only permission metadata through the Contained List API.
    - Uses array-driven x-ui.contained-list items so the component owns list
      count, empty state, row anatomy, status treatment, and accessibility.
    - Elevated permissions are represented as warning-status rows with visible
      metadata text, not as row actions.
    ========================================================================== --}}

@php
    /*
    |--------------------------------------------------------------------------
    | Permission Group State
    |--------------------------------------------------------------------------
    */

    $permissionRows = is_iterable($permissions ?? [])
        ? collect($permissions)->values()
        : collect();

    $resolvedGroupLabel = $groupLabel
        ?? data_get($group ?? null, 'label')
        ?? data_get($permissionGroup ?? null, 'label')
        ?? __('roles::module.permission_catalog');

    $elevatedLabel = __('roles::module.elevated_permission');

    /*
    |--------------------------------------------------------------------------
    | Contained List Items
    |--------------------------------------------------------------------------
    |
    | Keep row actions out of the read-only catalog. Elevated permissions use
    | the item status surface and visible metadata text so the row remains a
    | catalog row instead of becoming an action row.
    |
    */

    $permissionItems = $permissionRows->map(function ($permission) use ($elevatedLabel) {
        $permissionLabel = data_get($permission, 'label');
        $permissionDescription = data_get($permission, 'description');
        $permissionKey = data_get($permission, 'key');
        $permissionAction = data_get($permission, 'action');
        $isElevated = (bool) data_get($permission, 'elevated', false);
        $isDestructive = (bool) data_get($permission, 'destructive', false);

        $meta = collect([
            $permissionKey,
            $permissionAction,
            $isElevated ? $elevatedLabel : null,
            $isDestructive ? __('roles::module.destructive_permission') : null,
        ])->filter(fn ($value) => filled($value))->join(' · ');

        return [
            'title' => filled($permissionLabel)
                ? $permissionLabel
                : $permissionKey,
            'description' => $permissionDescription,
            'meta' => $meta,
            'status' => $isElevated ? 'warning' : null,
            'disabled' => false,
        ];
    })->all();

    $listLabel = "{$resolvedGroupLabel} permissions";
@endphp

<x-ui.contained-list
    :aria-label="$listLabel"
    :items="$permissionItems"
    variant="disclosed"
    size="sm"
    empty-title="No permissions"
    empty-description="This group does not declare any permissions."
    data-roles-permission-catalog-group
>
    {{-- Array-driven rendering owned by x-ui.contained-list. --}}
</x-ui.contained-list>
