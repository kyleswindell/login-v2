<?php

namespace App\Platform\Dashboard;

use InvalidArgumentException;

class WidgetRegistry
{
    /** @var array<string, class-string> */
    private array $widgets = [];

    /**
     * Return the registered dashboard widget keys.
     *
     * @return list<string>
     */
    public function knownKeys(): array
    {
        return array_keys($this->widgets);
    }

    /**
     * Register a widget key and its widget class.
     *
     * Modules call this in their ServiceProvider::boot() to add widgets
     * to the dashboard without patching core dashboard code.
     *
     * @param class-string $widgetClass
     */
    public function register(string $key, string $widgetClass): void
    {
        if (isset($this->widgets[$key])) {
            throw new InvalidArgumentException("Dashboard widget key '{$key}' is already registered.");
        }

        $this->widgets[$key] = $widgetClass;
    }

    /**
     * Return all registered widget classes indexed by key.
     *
     * @return array<string, class-string>
     */
    public function getAll(): array
    {
        return $this->widgets;
    }

    /**
     * Return the default layout array used for new users or after a layout reset.
     *
     * Each entry describes one widget slot:
     *   widget_key  — matches a registered key
     *   position    — 0-based render order
     *   column_span — Tailwind grid column span (1–12, or 'full')
     *   row_span    — dashboard row span used for saved placement validation
     *   is_visible  — whether the widget is rendered
     *
     * @return list<array{widget_key: string, position: int, column_span: int|string, row_span: int, is_visible: bool}>
     */
    public function defaults(): array
    {
        return collect([
            ['widget_key' => 'platform_stats', 'position' => 0],
            ['widget_key' => 'error_health', 'position' => 1],
            ['widget_key' => 'audit_activity', 'position' => 2],
            ['widget_key' => 'notifications_summary', 'position' => 3],
            ['widget_key' => 'development_tools', 'position' => 4],
        ])->map(fn (array $slot): array => $this->normalizeSlot(
            $slot['widget_key'],
            $slot,
            $slot['position'],
        ))->all();
    }

    /**
     * Normalize one persisted layout slot against the registry contract.
     *
     * @param  array{widget_key?: string, position?: int, column_span?: int|string, row_span?: int, is_visible?: bool}  $slot
     * @return array{widget_key: string, position: int, column_span: int|string, row_span: int, is_visible: bool}
     */
    public function normalizeSlot(string $key, array $slot, int $position): array
    {
        $definition = $this->layoutDefinitions()[$key] ?? [
            'column_span' => 'full',
            'row_span' => 1,
            'allowed_column_spans' => ['full'],
            'allowed_row_spans' => [1],
            'default_visible' => true,
        ];

        $columnSpan = $slot['column_span'] ?? $definition['column_span'];
        if (! in_array($columnSpan, $definition['allowed_column_spans'], true)) {
            $columnSpan = $definition['column_span'];
        }

        $rowSpan = (int) ($slot['row_span'] ?? $definition['row_span']);
        if (! in_array($rowSpan, $definition['allowed_row_spans'], true)) {
            $rowSpan = $definition['row_span'];
        }

        return [
            'widget_key' => $key,
            'position' => $position,
            'column_span' => $columnSpan,
            'row_span' => $rowSpan,
            'is_visible' => (bool) ($slot['is_visible'] ?? $definition['default_visible']),
        ];
    }

    /**
     * @return array<string, array{column_span: int|string, row_span: int, allowed_column_spans: list<int|string>, allowed_row_spans: list<int>, default_visible: bool}>
     */
    private function layoutDefinitions(): array
    {
        return [
            'platform_stats' => [
                'column_span' => 'full',
                'row_span' => 1,
                'allowed_column_spans' => ['full'],
                'allowed_row_spans' => [1],
                'default_visible' => true,
            ],
            'error_health' => [
                'column_span' => 6,
                'row_span' => 1,
                'allowed_column_spans' => [6, 'full'],
                'allowed_row_spans' => [1],
                'default_visible' => true,
            ],
            'audit_activity' => [
                'column_span' => 6,
                'row_span' => 1,
                'allowed_column_spans' => [6, 'full'],
                'allowed_row_spans' => [1, 2],
                'default_visible' => true,
            ],
            'notifications_summary' => [
                'column_span' => 'full',
                'row_span' => 1,
                'allowed_column_spans' => ['full', 6],
                'allowed_row_spans' => [1, 2],
                'default_visible' => true,
            ],
            'development_tools' => [
                'column_span' => 'full',
                'row_span' => 1,
                'allowed_column_spans' => ['full', 6],
                'allowed_row_spans' => [1],
                'default_visible' => true,
            ],
        ];
    }
}
