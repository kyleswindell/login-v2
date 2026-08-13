<?php

/*
|--------------------------------------------------------------------------
| File: Modules/ProfileMfgPoc/config/profile-mfg-poc.php
| Purpose: Configures the temporary Profile Mfg static POC runtime seam.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

return [
    'enabled' => (bool) env('PROFILE_MFG_POC_ENABLED', false),
    'data_path' => env('PROFILE_MFG_POC_DATA_PATH', 'storage/app/private/profile-mfg-poc.json'),
    'media_path' => env('PROFILE_MFG_POC_MEDIA_PATH', 'storage/app/private/profile-mfg-poc-media'),
];
