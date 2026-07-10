<?php

declare(strict_types=1);

namespace App\Surfaces\Contracts;

use RuntimeException;
use UnexpectedValueException;

/*
|--------------------------------------------------------------------------
| File: app/Surfaces/Contracts/Repository.php
| Purpose: Loads and normalizes registered UI entry contract.php files.
|--------------------------------------------------------------------------
|
| The repository is read-only. It does not decide maturity, patch contracts,
| render UI, own evidence pages, create examples, or enforce runtime strictness.
| It loads owner contract.php files and returns normalized arrays.
|
*/

final class Repository
{
    /*
    |--------------------------------------------------------------------------
    | Registered Surface Paths
    |--------------------------------------------------------------------------
    */

    public const ELEMENTS = [
        "grid" => "resources/views/elements/grid/contract.php",
        "color" => "resources/views/elements/color/contract.php",
        "icons" => "resources/views/elements/icons/contract.php",
        "motion" => "resources/views/elements/motion/contract.php",
        "pictograms" => "resources/views/elements/pictograms/contract.php",
        "spacing" => "resources/views/elements/spacing/contract.php",
        "themes" => "resources/views/elements/themes/contract.php",
        "typography" => "resources/views/elements/typography/contract.php",
    ];

    public const COMPONENTS = [
        "grid" => "resources/views/components/ui/grid/contract.php",
        "grid-column" =>
            "resources/views/components/ui/grid-column/contract.php",
        "breadcrumb" => "resources/views/components/ui/breadcrumb/contract.php",
        "icon" => "resources/views/components/ui/icon/contract.php",
        "button" => "resources/views/components/ui/button/contract.php",
        "button-set" => "resources/views/components/ui/button-set/contract.php",
        "icon-button" =>
            "resources/views/components/ui/icon-button/contract.php",
        "combo-button" =>
            "resources/views/components/ui/combo-button/contract.php",
        "menu-item" => "resources/views/components/ui/menu-item/contract.php",
        "menu" => "resources/views/components/ui/menu/contract.php",
        "checkbox" => "resources/views/components/ui/checkbox/contract.php",
        "checkbox-group" =>
            "resources/views/components/ui/checkbox-group/contract.php",
        "data-table" => "resources/views/components/ui/data-table/contract.php",
        "data-table-toolbar" =>
            "resources/views/components/ui/data-table/toolbar/contract.php",
        "form" => "resources/views/components/ui/form/contract.php",
        "form-item" => "resources/views/components/ui/form-item/contract.php",
        "form-label" => "resources/views/components/ui/form-label/contract.php",
        "form-group" => "resources/views/components/ui/form-group/contract.php",
        "inline-loading" =>
            "resources/views/components/ui/inline-loading/contract.php",
        "link" => "resources/views/components/ui/link/contract.php",
        "loading" => "resources/views/components/ui/loading/contract.php",
        "modal" => "resources/views/components/ui/modal/contract.php",
        "notification" =>
            "resources/views/components/ui/notification/contract.php",
        "pagination" => "resources/views/components/ui/pagination/contract.php",
        "pagination-nav" =>
            "resources/views/components/ui/pagination-nav/contract.php",
        "radio-button" =>
            "resources/views/components/ui/radio-button/contract.php",
        "radio-button-group" =>
            "resources/views/components/ui/radio-button-group/contract.php",
        "search" => "resources/views/components/ui/search/contract.php",
        "select" => "resources/views/components/ui/select/contract.php",
        "tag" => "resources/views/components/ui/tag/contract.php",
        "text-input" => "resources/views/components/ui/text-input/contract.php",
        "toggle" => "resources/views/components/ui/toggle/contract.php",
        "tooltip" => "resources/views/components/ui/tooltip/contract.php",
        "ui-shell-content" =>
            "resources/views/components/shell/content/contract.php",
        "ui-shell-header" =>
            "resources/views/components/shell/header/contract.php",
        "ui-shell-page-header" =>
            "resources/views/components/shell/page-header/contract.php",
        "ui-shell-page-title" =>
            "resources/views/components/shell/page-title/contract.php",
        "ui-shell-page-tabs" =>
            "resources/views/components/shell/page-tabs/contract.php",
        "ui-shell-side-nav" =>
            "resources/views/components/shell/side-nav/contract.php",
        "ui-shell-skip-to-content" =>
            "resources/views/components/shell/skip-to-content/contract.php",
        "ui-shell-switcher" =>
            "resources/views/components/shell/switcher/contract.php",
        "menu-button" =>
            "resources/views/components/ui/menu-button/contract.php",
        "overflow-menu" =>
            "resources/views/components/ui/overflow-menu/contract.php",
        "popover" => "resources/views/components/ui/popover/contract.php",
        "toggletip" => "resources/views/components/ui/toggletip/contract.php",
        "tabs" => "resources/views/components/ui/tabs/contract.php",
        "content-switcher" =>
            "resources/views/components/ui/content-switcher/contract.php",
        "switch" => "resources/views/components/ui/switch/contract.php",
        "text-area" => "resources/views/components/ui/text-area/contract.php",
        "password-input" =>
            "resources/views/components/ui/password-input/contract.php",
        "number-input" =>
            "resources/views/components/ui/number-input/contract.php",
        "combo-box" => "resources/views/components/ui/combo-box/contract.php",
        "dropdown" => "resources/views/components/ui/dropdown/contract.php",
        "multi-select" =>
            "resources/views/components/ui/multi-select/contract.php",
        "filterable-multi-select" =>
            "resources/views/components/ui/filterable-multi-select/contract.php",
        "searchable-select" =>
            "resources/views/components/ui/searchable-select/contract.php",
        "date-picker" =>
            "resources/views/components/ui/date-picker/contract.php",
        "date-picker-input" =>
            "resources/views/components/ui/date-picker-input/contract.php",
        "time-picker" =>
            "resources/views/components/ui/time-picker/contract.php",
        "filename" => "resources/views/components/ui/filename/contract.php",
        "file-uploader-button" =>
            "resources/views/components/ui/file-uploader-button/contract.php",
        "file-uploader-item" =>
            "resources/views/components/ui/file-uploader-item/contract.php",
        "file-uploader-drop-container" =>
            "resources/views/components/ui/file-uploader-drop-container/contract.php",
        "file-uploader" =>
            "resources/views/components/ui/file-uploader/contract.php",
        "tile" => "resources/views/components/ui/tile/contract.php",
        "structured-list" =>
            "resources/views/components/ui/structured-list/contract.php",
        "structured-list-row" =>
            "resources/views/components/ui/structured-list-row/contract.php",
        "contained-list-item" =>
            "resources/views/components/ui/contained-list-item/contract.php",
        "contained-list" =>
            "resources/views/components/ui/contained-list/contract.php",
        "progress-bar" =>
            "resources/views/components/ui/progress-bar/contract.php",
        "progress-step" =>
            "resources/views/components/ui/progress-step/contract.php",
        "progress-indicator" =>
            "resources/views/components/ui/progress-indicator/contract.php",
        "copy-button" =>
            "resources/views/components/ui/copy-button/contract.php",
        "code-snippet" =>
            "resources/views/components/ui/code-snippet/contract.php",
        "ordered-list" =>
            "resources/views/components/ui/ordered-list/contract.php",
        "unordered-list" =>
            "resources/views/components/ui/unordered-list/contract.php",
        "list-item" => "resources/views/components/ui/list-item/contract.php",
        "stack" => "resources/views/components/ui/stack/contract.php",
        "v-stack" => "resources/views/components/ui/v-stack/contract.php",
        "h-stack" => "resources/views/components/ui/h-stack/contract.php",
        "tree-view" => "resources/views/components/ui/tree-view/contract.php",
        "slider" => "resources/views/components/ui/slider/contract.php",
        "select-item" =>
            "resources/views/components/ui/select-item/contract.php",
        "select-item-group" =>
            "resources/views/components/ui/select-item-group/contract.php",
        "dialog" => "resources/views/components/ui/dialog/contract.php",
        "accordion" => "resources/views/components/ui/accordion/contract.php",
    ];

    public const PATTERNS = [
        "common-actions-action-set" =>
            "resources/views/components/patterns/common-actions/action-set/contract.php",
        "common-actions-form-actions" =>
            "resources/views/components/patterns/forms/actions/contract.php",
        "common-actions-row-actions" =>
            "resources/views/components/patterns/common-actions/row-actions/contract.php",
        "common-actions-page-actions" =>
            "resources/views/components/patterns/common-actions/page-actions/contract.php",
        "common-actions-destructive-actions" =>
            "resources/views/components/patterns/common-actions/destructive-actions/contract.php",
        "common-actions-bulk-actions" =>
            "resources/views/components/patterns/common-actions/bulk-actions/contract.php",
        "common-actions-empty-state-actions" =>
            "resources/views/components/patterns/common-actions/empty-state-actions/contract.php",
        "tag-group" =>
            "resources/views/components/patterns/tag-group/contract.php",
        "auth-challenge-form" =>
            "resources/views/components/patterns/auth/challenge-form/contract.php",
        "forms-page" =>
            "resources/views/components/patterns/forms/page/contract.php",
        "status-indicator" =>
            "resources/views/components/patterns/status-indicator/contract.php",
        "notifications-modal-action" =>
            "resources/views/components/patterns/notifications/modal-action/contract.php",
    ];

    public function __construct(
        private readonly ?string $basePath = null,
        private readonly array $elements = self::ELEMENTS,
        private readonly array $components = self::COMPONENTS,
        private readonly array $patterns = self::PATTERNS,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | All Registered Surfaces
    |--------------------------------------------------------------------------
    */

    public function all(): array
    {
        return array_merge(
            $this->prefix("element", $this->elements()),
            $this->prefix("component", $this->components()),
            $this->prefix("pattern", $this->patterns()),
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Surface Groups
    |--------------------------------------------------------------------------
    */

    public function elements(): array
    {
        return $this->loadGroup($this->elements);
    }

    public function components(): array
    {
        return $this->loadGroup($this->components);
    }

    public function patterns(): array
    {
        return $this->loadGroup($this->patterns);
    }

    /*
    |--------------------------------------------------------------------------
    | Surface Lookup
    |--------------------------------------------------------------------------
    */

    public function find(string $type, string $slug): ?array
    {
        $path = $this->pathFor($type, $slug);

        return $path === null ? null : $this->load($path);
    }

    public function get(string $type, string $slug): array
    {
        $surface = $this->find($type, $slug);

        if ($surface === null) {
            throw new RuntimeException(
                "UI entry contract [{$type}.{$slug}] is not registered.",
            );
        }

        return $surface;
    }

    public function pathFor(string $type, string $slug): ?string
    {
        $group = $this->groupMap($type);

        return $group[$slug] ?? null;
    }

    public function registeredPaths(): array
    {
        return array_merge(
            array_values($this->elements),
            array_values($this->components),
            array_values($this->patterns),
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Loading
    |--------------------------------------------------------------------------
    */

    public function load(string $relativePath): array
    {
        $path = $this->absolutePath($relativePath);

        if (!is_file($path)) {
            throw new RuntimeException(
                "UI entry contract file does not exist: {$relativePath}",
            );
        }

        $surface = require $path;

        if (!is_array($surface)) {
            throw new UnexpectedValueException(
                "UI entry contract must return an array: {$relativePath}",
            );
        }

        return $this->normalizeLoaded($surface);
    }

    private function loadGroup(array $paths): array
    {
        $surfaces = [];

        foreach ($paths as $slug => $path) {
            $surfaces[$slug] = $this->load($path);
        }

        return $surfaces;
    }

    private function normalizeLoaded(array $surface): array
    {
        $type = $surface["identity"]["type"] ?? null;

        $defaults = match ($type) {
            "element" => Defaults::element(),
            "component" => Defaults::component(),
            "pattern" => Defaults::pattern(),
            default => Defaults::base(),
        };

        /*
        |--------------------------------------------------------------------------
        | Migration Compatibility
        |--------------------------------------------------------------------------
        |
        | Preserve unknown top-level keys while loading older expanded contracts
        | so existing files can be inspected during migration. Validator reports
        | unsupported keys separately.
        |
        */

        return Normalizer::normalize($surface, $defaults, false);
    }

    /*
    |--------------------------------------------------------------------------
    | Path Helpers
    |--------------------------------------------------------------------------
    */

    private function groupMap(string $type): array
    {
        return match (strtolower($type)) {
            "element", "elements" => $this->elements,
            "component", "components" => $this->components,
            "pattern", "patterns" => $this->patterns,
            default => [],
        };
    }

    private function prefix(string $type, array $surfaces): array
    {
        $prefixed = [];

        foreach ($surfaces as $slug => $surface) {
            $prefixed["{$type}.{$slug}"] = $surface;
        }

        return $prefixed;
    }

    private function absolutePath(string $relativePath): string
    {
        $normalized = str_replace(
            ["/", "\\"],
            DIRECTORY_SEPARATOR,
            $relativePath,
        );

        if ($this->basePath !== null) {
            return rtrim($this->basePath, DIRECTORY_SEPARATOR) .
                DIRECTORY_SEPARATOR .
                $normalized;
        }

        if (function_exists("base_path")) {
            return base_path($relativePath);
        }

        return getcwd() . DIRECTORY_SEPARATOR . $normalized;
    }
}
