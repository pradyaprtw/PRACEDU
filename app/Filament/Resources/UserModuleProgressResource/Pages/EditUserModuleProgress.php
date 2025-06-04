<?php

namespace App\Filament\Resources\UserModuleProgressResource\Pages;

use App\Filament\Resources\UserModuleProgressResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserModuleProgress extends EditRecord
{
    protected static string $resource = UserModuleProgressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
