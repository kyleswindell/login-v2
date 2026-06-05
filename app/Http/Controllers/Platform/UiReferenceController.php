<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Platform\UiReference\UiReferenceSamples;
use App\Platform\UiReference\UiReferenceTables;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UiReferenceController extends Controller
{
    public function __construct(
        private readonly UiReferenceSamples $samples,
        private readonly UiReferenceTables $tables,
    ) {}

    public function index(Request $request): View
    {
        $this->authorize('view-platform-ui-reference');

        return $this->renderSection('overview');
    }

    public function actions(Request $request): View
    {
        $this->authorize('view-platform-ui-reference');

        return $this->renderSection('components.actions');
    }

    public function status(Request $request): View
    {
        $this->authorize('view-platform-ui-reference');

        return $this->renderSection('components.status');
    }

    public function forms(Request $request): View
    {
        $this->authorize('view-platform-ui-reference');

        return $this->renderSection('components.forms');
    }

    public function tables(Request $request): View
    {
        $this->authorize('view-platform-ui-reference');

        return $this->renderSection('patterns.tables', $this->tables->tablePagePayload($request));
    }

    public function formsPatterns(Request $request): View
    {
        $this->authorize('view-platform-ui-reference');

        return $this->renderSection('patterns.forms');
    }

    public function dataContent(Request $request): View
    {
        $this->authorize('view-platform-ui-reference');

        return $this->renderSection('patterns.data-content');
    }

    public function overlays(Request $request): View
    {
        $this->authorize('view-platform-ui-reference');

        return $this->renderSection('patterns.overlays');
    }

    public function navigation(Request $request): View
    {
        $this->authorize('view-platform-ui-reference');

        return $this->renderSection('patterns.navigation');
    }

    public function layout(Request $request): View
    {
        $this->authorize('view-platform-ui-reference');

        return $this->renderSection('patterns.layout');
    }

    private const WIDGET_CONTENT_SUBPAGES = [
        'shape-map', '1x1', '2x1', '1x2', '2x2', '3x1', '3x2', '3x3', '4x0-5',
    ];

    public function widgetContent(Request $request): View
    {
        $this->authorize('view-platform-ui-reference');

        return $this->renderSection('patterns.widget-content');
    }

    public function widgetContentSubpage(Request $request, string $size): View
    {
        $this->authorize('view-platform-ui-reference');

        abort_unless(in_array($size, self::WIDGET_CONTENT_SUBPAGES, true), 404);

        return $this->renderSection('patterns.widget-content.'.$size);
    }

    public function starters(Request $request): View
    {
        $this->authorize('view-platform-ui-reference');

        return $this->renderSection('patterns.starters');
    }

    public function archetypes(Request $request): View
    {
        $this->authorize('view-platform-ui-reference');

        return $this->renderSection('patterns.archetypes');
    }

    public function showAuditSample(Request $request, string $sample): JsonResponse
    {
        $this->authorize('view-platform-ui-reference');

        abort_unless($this->samples->hasAuditSample($sample), 404);

        return response()->json($this->samples->auditSamplePayload($sample));
    }

    public function showErrorSample(Request $request, string $sample): JsonResponse
    {
        $this->authorize('view-platform-ui-reference');

        abort_unless($this->samples->hasErrorSample($sample), 404);

        return response()->json($this->samples->errorSamplePayload($sample));
    }

    /**
     * @param array<string, mixed> $data
     */
    private function renderSection(string $section, array $data = []): View
    {
        return view('platform.ui-reference.'.$section, [
            'currentSection' => $section,
            ...$data,
        ]);
    }
}
