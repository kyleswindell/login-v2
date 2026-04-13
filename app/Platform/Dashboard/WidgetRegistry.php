<?php

namespace App\Platform\Dashboard;

use InvalidArgumentException;

class WidgetRegistry
{
    /** @var array<string, class-string> */
    private array $widgets = [];

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
     *   is_visible  — whether the widget is rendered
     *
     * @return list<array{widget_key: string, position: int, column_span: int|string, is_visible: bool}>
     */
    public function defaults(): array
    {
        return [
            ['widget_key' => 'platform_stats',       'position' => 0, 'column_span' => 'full', 'is_visible' => true],
            ['widget_key' => 'error_health',          'position' => 1, 'column_span' => 6,      'is_visible' => true],
            ['widget_key' => 'audit_activity',        'position' => 2, 'column_span' => 6,      'is_visible' => true],
            ['widget_key' => 'notifications_summary', 'position' => 3, 'column_span' => 'full', 'is_visible' => true],
        ];
    }
}
