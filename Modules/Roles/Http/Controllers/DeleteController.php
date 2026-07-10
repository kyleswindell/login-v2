<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Http/Controllers/DeleteController.php
| Purpose: Renders a dedicated role deletion confirmation page.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Roles\Services\RoleCatalog;
use App\Modules\Roles\Services\RoleMutationPreview;
use App\Modules\Roles\Services\ViewData;
use Illuminate\Contracts\View\View;
use Spatie\Permission\Models\Role;

final class DeleteController extends Controller
{
    public function __invoke(Role $role, ViewData $viewData, RoleMutationPreview $preview): View
    {
        $this->authorize(RoleCatalog::DELETE);

        return view('roles::delete', [
            'role' => $role,
            'roleSummary' => $viewData->roleSummary($role, request()->user()),
            'assignedUsers' => $viewData->assignedUsers($role),
            'mutationReview' => $preview->forDelete(request()->user(), $role),
        ]);
    }
}
