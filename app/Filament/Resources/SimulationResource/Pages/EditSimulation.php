<?php

namespace App\Filament\Resources\SimulationResource\Pages;

use App\Filament\Resources\SimulationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSimulation extends EditRecord
{
    protected static string $resource = SimulationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
