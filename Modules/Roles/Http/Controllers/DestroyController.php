<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Http/Controllers/DestroyController.php
| Purpose: Handles custom role deletion.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Roles\Services\Writer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

final class DestroyController extends Controller
{
    public function __invoke(Request $request, Role $role, Writer $writer): RedirectResponse
    {
        $writer->delete($request->user(), $role);

        return redirect()
            ->route('roles.index')
            ->with('status', __('roles::module.flash.deleted'));
    }
}
