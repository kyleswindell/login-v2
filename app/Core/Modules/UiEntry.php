<?php
/*
|--------------------------------------------------------------------------
| File: app/Core/Modules/UiEntry.php
| Purpose: Defines module UI contribution metadata.
|--------------------------------------------------------------------------
*/

namespace App\Core\Modules;


final class UiEntry
{
    public function __construct(
        public readonly string $key,
        public readonly UiEntryType $type,
        public readonly UiPlacement $placement,
        public readonly ?UiAccessMode $access = null,
        public readonly ?string $label = null,
        public readonly ?string $routeName = null,
        public readonly ?string $viewPath = null,
        public readonly ?string $widgetKey = null,
        public readonly ?string $panelTarget = null,
        public readonly ?string $componentView = null,
        public readonly ?string $panelView = null,
        public readonly ?string $dataProvider = null,
        public readonly ?string $extensionPoint = null,
        public readonly ?string $targetExtensionPoint = null,
        public readonly ?string $accessValue = null,
        public readonly ?string $icon = null,
        public readonly ?string $groupKey = null,
        public readonly ?string $groupLabel = null,
        public readonly int $groupSortOrder = 0,
        public readonly array $activeRoutePatterns = [],
        public readonly int $sortOrder = 0,
        public readonly bool $tenantEligible = false,
    ) {
    }
}
