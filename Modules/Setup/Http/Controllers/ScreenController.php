<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Setup/Http/Controllers/ScreenController.php
| Purpose: Handles Setup module screen rendering.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Setup\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Setup\Navigation\ItemsBuilder;
use App\Modules\Setup\Services\SetupPermissions;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class ScreenController extends Controller
{
    public function index(Request $request, ItemsBuilder $items): View
    {
        $this->authorize(SetupPermissions::VIEW);

        return view('setup::index', [
            'setupItems' => $items->landingItems($request->user(), $request->route()?->getName()),
        ]);
    }
}
