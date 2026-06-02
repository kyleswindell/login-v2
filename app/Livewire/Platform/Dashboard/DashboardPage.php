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
    /** @var list<array{widget_key: string, position: int, column_span: int|string, row_span: int, is_visible: bool}> */
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
            $this->widgetLayout = $this->synchronizeLayoutWithDefaults($saved->layout);
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
     * @param  list<string>|list<array{widget_key: string, position: int, column_span: int|string, row_span: int, is_visible: bool}>  $layout
     */
    public function reorderWidgets(array $layout): void
    {
        if ($this->isLocked) {
            return;
        }

        $orderedVisibleKeys = $this->extractOrderedVisibleKeys($layout);
        $this->widgetLayout = $this->rebuildLayoutForVisibleOrder($orderedVisibleKeys);

        $this->persistLayout();
    }

    public function toggleWidgetVisibility(string $widgetKey): void
    {
        $registry = app(WidgetRegistry::class);
        $knownKeys = $registry->knownKeys();

        if ($this->isLocked || ! in_array($widgetKey, $knownKeys, true)) {
            return;
        }

        $normalized = $this->normalizeLayoutSlots($this->widgetLayout);
        $visibleKeys = collect($normalized)
            ->filter(fn (array $slot): bool => $slot['is_visible'])
            ->pluck('widget_key')
            ->values()
            ->all();
        $hiddenKeys = collect($normalized)
            ->reject(fn (array $slot): bool => $slot['is_visible'])
            ->pluck('widget_key')
            ->values()
            ->all();

        if (in_array($widgetKey, $visibleKeys, true)) {
            $visibleKeys = array_values(array_filter($visibleKeys, fn (string $key): bool => $key !== $widgetKey));
            $hiddenKeys[] = $widgetKey;
        } else {
            $hiddenKeys = array_values(array_filter($hiddenKeys, fn (string $key): bool => $key !== $widgetKey));
            $visibleKeys[] = $widgetKey;
        }

        $this->widgetLayout = $this->buildLayoutFromOrderedKeys($visibleKeys, $hiddenKeys, $normalized);

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
        $this->widgetLayout = $this->normalizeLayoutSlots($this->widgetLayout);

        UserDashboardLayout::query()->updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'layout'    => $this->widgetLayout,
                'is_locked' => $this->isLocked,
            ],
        );
    }

    /**
     * @param  list<array{widget_key?: string, position?: int, column_span?: int|string, row_span?: int, is_visible?: bool}>  $savedLayout
     * @return list<array{widget_key: string, position: int, column_span: int|string, row_span: int, is_visible: bool}>
     */
    private function synchronizeLayoutWithDefaults(array $savedLayout): array
    {
        return $this->normalizeLayoutSlots($savedLayout);
    }

    /**
     * Build the ordered list of rendered widget slots visible to the current user.
     *
    * @return list<array{widget_key: string, column_span: int|string, row_span: int, widgetClass: class-string, renderedHtml: string}>
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
                    'row_span'     => (int) ($slot['row_span'] ?? 1),
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

    /**
     * @param  list<string>|list<array{widget_key?: string}>  $layout
     * @return list<string>
     */
    private function extractOrderedVisibleKeys(array $layout): array
    {
        return collect($layout)
            ->map(function (mixed $item): ?string {
                if (is_string($item)) {
                    return $item;
                }

                if (is_array($item) && is_string($item['widget_key'] ?? null)) {
                    return $item['widget_key'];
                }

                return null;
            })
            ->filter(fn (?string $key): bool => filled($key))
            ->values()
            ->all();
    }

    /**
     * @param  list<string>  $orderedVisibleKeys
     * @return list<array{widget_key: string, position: int, column_span: int|string, row_span: int, is_visible: bool}>
     */
    private function rebuildLayoutForVisibleOrder(array $orderedVisibleKeys): array
    {
        $normalized = $this->normalizeLayoutSlots($this->widgetLayout);
        $visibleSlots = collect($normalized)->filter(fn (array $slot): bool => $slot['is_visible']);
        $visibleKeySet = $visibleSlots->pluck('widget_key')->all();

        $orderedVisibleKeys = collect($orderedVisibleKeys)
            ->filter(fn (string $key): bool => in_array($key, $visibleKeySet, true))
            ->unique()
            ->values()
            ->all();

        $remainingVisibleKeys = $visibleSlots
            ->pluck('widget_key')
            ->reject(fn (string $key): bool => in_array($key, $orderedVisibleKeys, true))
            ->values()
            ->all();

        $hiddenKeys = collect($normalized)
            ->reject(fn (array $slot): bool => $slot['is_visible'])
            ->pluck('widget_key')
            ->values()
            ->all();

        return $this->buildLayoutFromOrderedKeys(
            [...$orderedVisibleKeys, ...$remainingVisibleKeys],
            $hiddenKeys,
            $normalized,
        );
    }

    /**
     * @param  list<string>  $visibleKeys
     * @param  list<string>  $hiddenKeys
     * @param  list<array{widget_key: string, position: int, column_span: int|string, row_span: int, is_visible: bool}>|null  $sourceLayout
     * @return list<array{widget_key: string, position: int, column_span: int|string, row_span: int, is_visible: bool}>
     */
    private function buildLayoutFromOrderedKeys(array $visibleKeys, array $hiddenKeys, ?array $sourceLayout = null): array
    {
        $registry = app(WidgetRegistry::class);
        $knownKeys = $registry->knownKeys();
        $source = collect($sourceLayout ?? $this->normalizeLayoutSlots($this->widgetLayout))
            ->keyBy('widget_key');

        $orderedKeys = collect([...$visibleKeys, ...$hiddenKeys])
            ->filter(fn (string $key): bool => in_array($key, $knownKeys, true))
            ->unique()
            ->values();

        return $orderedKeys
            ->map(function (string $key, int $position) use ($registry, $source, $visibleKeys): array {
                $slot = $source->get($key, ['widget_key' => $key]);
                $slot['is_visible'] = in_array($key, $visibleKeys, true);

                return $registry->normalizeSlot($key, $slot, $position);
            })
            ->all();
    }

    /**
     * @param  list<array{widget_key?: string, position?: int, column_span?: int|string, row_span?: int, is_visible?: bool}>  $layout
     * @return list<array{widget_key: string, position: int, column_span: int|string, row_span: int, is_visible: bool}>
     */
    private function normalizeLayoutSlots(array $layout): array
    {
        $registry = app(WidgetRegistry::class);
        $knownKeys = $registry->knownKeys();
        $defaults = collect($registry->defaults())->keyBy('widget_key');
        $savedByKey = collect($layout)
            ->filter(fn (array $slot): bool => in_array($slot['widget_key'] ?? '', $knownKeys, true))
            ->sortBy('position')
            ->keyBy(fn (array $slot): string => (string) $slot['widget_key']);

        $orderedKeys = $savedByKey->keys()
            ->merge($defaults->keys()->reject(fn (string $key): bool => $savedByKey->has($key)))
            ->values();

        return $orderedKeys
            ->map(function (string $key, int $position) use ($registry, $savedByKey, $defaults): array {
                $slot = $savedByKey->get($key, $defaults->get($key, ['widget_key' => $key]));

                return $registry->normalizeSlot($key, $slot, $position);
            })
            ->all();
    }
}
