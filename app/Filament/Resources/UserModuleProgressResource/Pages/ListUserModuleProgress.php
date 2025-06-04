<?php

namespace App\Filament\Resources\UserModuleProgressResource\Pages;

use App\Filament\Resources\UserModuleProgressResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserModuleProgress extends ListRecords
{
    protected static string $resource = UserModuleProgressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
