<?php

namespace App\Filament\Resources\UserSimulationAttemptResource\Pages;

use App\Filament\Resources\UserSimulationAttemptResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageUserSimulationAttempts extends ManageRecords
{
    protected static string $resource = UserSimulationAttemptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
