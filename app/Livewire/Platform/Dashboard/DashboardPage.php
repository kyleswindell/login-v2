<?php

namespace App\Livewire\Platform\Dashboard;

use App\Models\UserDashboardLayout;
use App\Platform\Dashboard\RendersOnDashboard;
use App\Platform\Dashboard\WidgetRegistry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View as ViewContract;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Dashboard')]
class DashboardPage extends Component
{
    /** @var list<array{widget_key: string, position: int, column_span: int|string, is_visible: bool}> */
    public array $widgetLayout = [];

    public bool $isLocked = true;

    #[Locked]
    public bool $isEditing = false;

    public function mount(): void
    {
        $saved = UserDashboardLayout::query()
            ->where('user_id', Auth::id())
            ->first();

        if ($saved) {
            $this->widgetLayout = $saved->layout;
            $this->isLocked = $saved->is_locked;
        } else {
            $this->widgetLayout = app(WidgetRegistry::class)->defaults();
            $this->isLocked = true;
        }

        $this->isEditing = false;
    }

    public function toggleLock(): void
    {
        $this->isLocked = ! $this->isLocked;
        $this->isEditing = ! $this->isLocked;
        $this->persistLayout();
    }

    /**
     * @param  list<array{widget_key: string, position: int, column_span: int|string, is_visible: bool}>  $layout
     */
    public function reorderWidgets(array $layout): void
    {
        $registry = app(WidgetRegistry::class);
        $knownKeys = array_keys($registry->getAll());

        // Reject any widget_key that is not registered to prevent arbitrary data injection.
        $this->widgetLayout = array_values(
            array_filter($layout, fn (array $slot) => in_array($slot['widget_key'] ?? '', $knownKeys, true))
        );

        $this->persistLayout();
    }

    public function toggleWidgetVisibility(string $widgetKey): void
    {
        $registry = app(WidgetRegistry::class);
        $knownKeys = array_keys($registry->getAll());

        if (! in_array($widgetKey, $knownKeys, true)) {
            return;
        }

        foreach ($this->widgetLayout as &$slot) {
            if ($slot['widget_key'] === $widgetKey) {
                $slot['is_visible'] = ! $slot['is_visible'];
                break;
            }
        }
        unset($slot);

        $this->persistLayout();
    }

    public function resetLayout(): void
    {
        $this->widgetLayout = app(WidgetRegistry::class)->defaults();
        $this->isLocked = true;
        $this->isEditing = false;
        $this->persistLayout();
    }

    private function persistLayout(): void
    {
        UserDashboardLayout::query()->updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'layout'    => $this->widgetLayout,
                'is_locked' => $this->isLocked,
            ],
        );
    }

    /**
     * Build the ordered list of rendered widget slots visible to the current user.
     *
    * @return list<array{widget_key: string, column_span: int|string, widgetClass: class-string, renderedHtml: string}>
     */
    public function getVisibleWidgets(): array
    {
        $registry = app(WidgetRegistry::class);
        $all = $registry->getAll();

        $slots = collect($this->widgetLayout)
            ->sortBy('position')
            ->filter(fn (array $slot) => $slot['is_visible'] ?? true)
            ->filter(function (array $slot) use ($all): bool {
                $key = $slot['widget_key'] ?? '';
                if (! isset($all[$key])) {
                    return false;
                }

                /** @var class-string $class */
                $class = $all[$key];

                return method_exists($class, 'canView') ? $class::canView() : true;
            })
            ->map(function (array $slot) use ($all): array {
                /** @var class-string $class */
                $class = $all[$slot['widget_key']];
                $renderedHtml = '';

                try {
                    $widget = app($class);
                    if ($widget instanceof RendersOnDashboard) {
                        $result = view($widget->getDashboardView(), $widget->getDashboardViewData());
                        $renderedHtml = $result instanceof ViewContract ? $result->render() : (string) $result;
                    }
                } catch (\Throwable) {
                    // If a widget fails to render, skip its content rather than breaking the dashboard.
                }

                return [
                    'widget_key'   => $slot['widget_key'],
                    'column_span'  => $slot['column_span'] ?? 'full',
                    'widgetClass'  => $class,
                    'renderedHtml' => $renderedHtml,
                ];
            })
            ->values()
            ->all();

        return $slots;
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.platform.dashboard', [
            'visibleWidgets' => $this->getVisibleWidgets(),
            'allSlots'       => $this->widgetLayout,
            'widgetClasses'  => app(WidgetRegistry::class)->getAll(),
        ]);
    }
}
