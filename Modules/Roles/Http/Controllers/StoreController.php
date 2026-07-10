<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Http/Controllers/StoreController.php
| Purpose: Handles custom role creation.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Roles\Http\Requests\StoreRoleRequest;
use App\Modules\Roles\Services\Writer;
use Illuminate\Http\RedirectResponse;

final class StoreController extends Controller
{
    public function __invoke(StoreRoleRequest $request, Writer $writer): RedirectResponse
    {
        $role = $writer->create(
            $request->user(),
            $request->roleKey(),
            $request->roleLabel(),
            $request->roleDescription(),
            $request->permissionKeys(),
        );

        return redirect()
            ->route('roles.show', $role)
            ->with('status', __('roles::module.flash.created'));
    }
}
