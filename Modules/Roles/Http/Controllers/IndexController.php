<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Http/Controllers/IndexController.php
| Purpose: Renders the read-only Roles module index page.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Roles\Services\MutationGuard;
use App\Modules\Roles\Services\RoleCatalog;
use App\Modules\Roles\Services\ViewData;
use Illuminate\Contracts\View\View;

final class IndexController extends Controller
{
    public function __invoke(ViewData $viewData, MutationGuard $guard): View
    {
        $this->authorize(RoleCatalog::VIEW);

        return view('roles::index', [
            'roles' => $viewData->roleSummaries(request()->user()),
            'permissionCatalogSummary' => $viewData->permissionCatalogSummary(),
            'canCreateRoles' => $guard->canCreateRole(request()->user()),
            'canViewPermissions' => request()->user()?->can(RoleCatalog::PERMISSIONS_VIEW) ?? false,
        ]);
    }
}
