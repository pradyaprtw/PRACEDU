<?php

namespace App\Filament\Resources\UserModuleProgressResource\Pages;

use App\Filament\Resources\UserModuleProgressResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUserModuleProgress extends ViewRecord
{
    protected static string $resource = UserModuleProgressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
