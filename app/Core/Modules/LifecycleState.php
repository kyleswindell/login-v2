<?php

/*
|--------------------------------------------------------------------------
| File: app/Core/Modules/LifecycleState.php
| Purpose: Declares module lifecycle states for module metadata.
|--------------------------------------------------------------------------
*/

namespace App\Core\Modules;


enum LifecycleState: string
{
    case Available = 'available';
    case Installing = 'installing';
    case NeedsSetup = 'needs_setup';
    case Enabled = 'enabled';
    case Disabled = 'disabled';
    case Failed = 'failed';
}
