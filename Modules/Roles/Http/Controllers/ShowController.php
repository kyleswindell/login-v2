<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Http/Controllers/ShowController.php
| Purpose: Renders a role review page.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Roles\Services\RoleCatalog;
use App\Modules\Roles\Services\ViewData;
use Illuminate\Contracts\View\View;
use Spatie\Permission\Models\Role;

final class ShowController extends Controller
{
    public function __invoke(Role $role, ViewData $viewData): View
    {
        $this->authorize(RoleCatalog::VIEW);

        return view('roles::show', [
            'role' => $role,
            'roleSummary' => $viewData->roleSummary($role, request()->user()),
            'permissionItems' => $viewData->assignedPermissionItems($role),
            'assignedUsers' => $viewData->assignedUsers($role),
        ]);
    }
}
