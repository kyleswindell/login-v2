<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Http/Controllers/EditController.php
| Purpose: Renders the role permission assignment form.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Roles\Services\MutationGuard;
use App\Modules\Roles\Services\RoleMutationPreview;
use App\Modules\Roles\Services\ViewData;
use Illuminate\Contracts\View\View;
use Spatie\Permission\Models\Role;

final class EditController extends Controller
{
    public function __invoke(Role $role, ViewData $viewData, MutationGuard $guard, RoleMutationPreview $preview): View
    {
        abort_unless($guard->canEditRole(request()->user(), $role), 403);

        $selectedPermissions = $role->permissions()
            ->pluck('name')
            ->sort()
            ->values()
            ->all();

        $roleSummary = $viewData->roleSummary($role, request()->user());
        $submittedPermissions = request()->old('permissions', $selectedPermissions);
        $label = request()->old('label');
        $description = request()->old('description', $roleSummary['description']);

        return view('roles::edit', [
            'role' => $role,
            'roleSummary' => $roleSummary,
            'permissionFormItems' => $viewData->permissionFormItems($selectedPermissions, request()->user()),
            'mutationReview' => $preview->forUpdate(
                request()->user(),
                $role,
                is_string($label) && $label !== '' ? $label : $roleSummary['label'],
                is_string($description) ? $description : null,
                is_array($submittedPermissions) ? $submittedPermissions : [],
            ),
        ]);
    }
}
