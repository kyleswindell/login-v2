<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Http/Controllers/CreateController.php
| Purpose: Renders the custom role creation form.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Roles\Services\RoleCatalog;
use App\Modules\Roles\Services\RoleMutationPreview;
use App\Modules\Roles\Services\ViewData;
use Illuminate\Contracts\View\View;

final class CreateController extends Controller
{
    public function __invoke(ViewData $viewData, RoleMutationPreview $preview): View
    {
        $this->authorize(RoleCatalog::CREATE);

        $permissions = request()->old('permissions', []);
        $key = request()->old('key');
        $label = request()->old('label');
        $description = request()->old('description');

        return view('roles::create', [
            'permissionFormItems' => $viewData->permissionFormItems([], request()->user()),
            'mutationReview' => $preview->forCreate(
                request()->user(),
                is_string($key) && $key !== '' ? $key : 'custom_role',
                is_string($label) && $label !== '' ? $label : __('roles::module.new_custom_role'),
                is_string($description) ? $description : null,
                is_array($permissions) ? $permissions : [],
            ),
        ]);
    }
}
