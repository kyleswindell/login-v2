<?php

/*
|--------------------------------------------------------------------------
| File: Modules/_Template/module.php
| Purpose: Defines the copy-source module package metadata template.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

use App\Core\Modules\Category;
use App\Core\Modules\LifecycleState;
use App\Core\Modules\PackageDefinition;


return PackageDefinition::defaults(__DIR__, [
    'manifest' => [
        'type' => Category::Shared,
        'defaultState' => LifecycleState::Available,
        'installedByDefault' => false,
        'defaultEnabled' => false,
        'disableable' => true,
        'tenantEligible' => false,
    ],
]);
