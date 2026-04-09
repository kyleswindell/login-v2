<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Platform\Docs\DocsRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DocsController extends Controller
{
    public function __invoke(Request $request, DocsRepository $docsRepository): View
    {
        $this->authorize('view-platform-docs');

        $selectedPath = $request->string('path')->toString();

        if ($selectedPath === '') {
            $selectedPath = $docsRepository->defaultFilePath();
        }

        return view('platform.docs.index', [
            'tree' => $docsRepository->tree(),
            'selectedPath' => $selectedPath,
            'selectedFile' => $docsRepository->file($selectedPath),
        ]);
    }
}
