<?php

namespace App\Filament\Resources\CentralErrorLogs\Pages;

use App\Filament\Resources\CentralErrorLogs\CentralErrorLogResource;
use Filament\Resources\Pages\ManageRecords;

class ManageCentralErrorLogs extends ManageRecords
{
    protected static string $resource = CentralErrorLogResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
