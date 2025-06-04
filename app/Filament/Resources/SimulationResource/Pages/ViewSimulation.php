<?php

namespace App\Filament\Resources\SimulationResource\Pages;

use App\Filament\Resources\SimulationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSimulation extends ViewRecord
{
    protected static string $resource = SimulationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
