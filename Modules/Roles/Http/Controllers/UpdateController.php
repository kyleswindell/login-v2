<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Http/Controllers/UpdateController.php
| Purpose: Handles role metadata and permission updates.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Roles\Http\Requests\UpdateRoleRequest;
use App\Modules\Roles\Services\Writer;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;

final class UpdateController extends Controller
{
    public function __invoke(UpdateRoleRequest $request, Role $role, Writer $writer): RedirectResponse
    {
        $updated = $writer->update(
            $request->user(),
            $role,
            $request->roleLabel(),
            $request->roleDescription(),
            $request->permissionKeys(),
        );

        return redirect()
            ->route('roles.show', $updated)
            ->with('status', __('roles::module.flash.updated'));
    }
}
