<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Http/Controllers/PermissionsIndexController.php
| Purpose: Renders the read-only Roles permission catalog.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Roles\Services\RoleCatalog;
use App\Modules\Roles\Services\ViewData;
use Illuminate\Contracts\View\View;

final class PermissionsIndexController extends Controller
{
    public function __invoke(ViewData $viewData): View
    {
        $this->authorize(RoleCatalog::PERMISSIONS_VIEW);

        return view('roles::permissions.index', [
            'permissionCatalogItems' => $viewData->permissionCatalogItems(),
            'permissionCatalogSummary' => $viewData->permissionCatalogSummary(),
        ]);
    }
}
