<?php

namespace App\Livewire\Platform\Dashboard;

use App\Models\UserDashboardLayout;
use App\Platform\Dashboard\RendersOnDashboard;
use App\Platform\Dashboard\WidgetRegistry;
use App\Platform\Notifications\NotificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
        $defaults = app(WidgetRegistry::class)->defaults();

        $saved = UserDashboardLayout::query()
            ->where('user_id', Auth::id())
            ->first();

        if ($saved) {
            $this->widgetLayout = $this->synchronizeLayoutWithDefaults($saved->layout, $defaults);
            $this->isLocked = $saved->is_locked;

            if ($this->widgetLayout !== $saved->layout) {
                $this->persistLayout();
            }
        } else {
            $this->widgetLayout = $defaults;
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

    public function generateTestNotification(): void
    {
        $user = Auth::user();

        if (! $user || ! Gate::allows('view-platform-notifications')) {
            return;
        }

        $notificationService = app(NotificationService::class);
        $notification = $notificationService->sendTo(
            notifiable: $user,
            moduleKey: 'development',
            title: 'Test notification',
            body: 'This notification was generated from the dashboard development tools widget.',
            severity: 'notice',
            actionUrl: route('platform.administration.notifications.index'),
            metadata: ['source' => 'dashboard-development-tools'],
        );

        $this->dispatch('platform-notification-created', notification: $notificationService->payloadFor($notification));
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
     * @param  list<array{widget_key?: string, position?: int, column_span?: int|string, is_visible?: bool}>  $savedLayout
     * @param  list<array{widget_key: string, position: int, column_span: int|string, is_visible: bool}>  $defaults
     * @return list<array{widget_key: string, position: int, column_span: int|string, is_visible: bool}>
     */
    private function synchronizeLayoutWithDefaults(array $savedLayout, array $defaults): array
    {
        $registry = app(WidgetRegistry::class);
        $knownKeys = array_keys($registry->getAll());

        $defaultByKey = collect($defaults)
            ->keyBy('widget_key');

        $savedByKey = collect($savedLayout)
            ->filter(fn (array $slot): bool => in_array($slot['widget_key'] ?? '', $knownKeys, true))
            ->sortBy('position')
            ->keyBy(fn (array $slot): string => (string) $slot['widget_key']);

        $normalized = collect();

        foreach ($savedByKey as $key => $slot) {
            $fallback = $defaultByKey->get($key, [
                'widget_key' => $key,
                'position' => 0,
                'column_span' => 'full',
                'is_visible' => true,
            ]);

            $normalized->push([
                'widget_key' => $key,
                'position' => 0,
                'column_span' => $slot['column_span'] ?? $fallback['column_span'],
                'is_visible' => (bool) ($slot['is_visible'] ?? $fallback['is_visible']),
            ]);
        }

        foreach ($defaults as $slot) {
            if (! $savedByKey->has($slot['widget_key'])) {
                $normalized->push($slot);
            }
        }

        return $normalized
            ->values()
            ->map(fn (array $slot, int $index): array => [
                'widget_key' => $slot['widget_key'],
                'position' => $index,
                'column_span' => $slot['column_span'],
                'is_visible' => (bool) $slot['is_visible'],
            ])
            ->all();
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
