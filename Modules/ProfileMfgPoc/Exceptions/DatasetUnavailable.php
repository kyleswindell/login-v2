<?php

/*
|--------------------------------------------------------------------------
| File: Modules/ProfileMfgPoc/Exceptions/DatasetUnavailable.php
| Purpose: Marks private POC dataset failures without exposing record data.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\ProfileMfgPoc\Exceptions;

use RuntimeException;

final class DatasetUnavailable extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('The Profile Mfg POC dataset is unavailable.');
    }
}
