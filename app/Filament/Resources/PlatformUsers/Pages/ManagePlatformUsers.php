<?php

namespace App\Filament\Resources\PlatformUsers\Pages;

use App\Filament\Resources\PlatformUsers\PlatformUserResource;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Arr;

class ManagePlatformUsers extends ManageRecords
{
    protected static string $resource = PlatformUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->using(function (array $data): User {
                    $roles = Arr::pull($data, 'roles', []);
                    $user = User::query()->create(PlatformUserResource::normalizeUserData($data, true));
                    $user->syncRoles($roles);

                    return $user;
                }),
        ];
    }
}
