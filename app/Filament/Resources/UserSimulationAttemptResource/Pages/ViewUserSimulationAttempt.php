<?php

namespace App\Filament\Resources\UserSimulationAttemptResource\Pages;

use App\Filament\Resources\UserSimulationAttemptResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUserSimulationAttempt extends ViewRecord
{
    protected static string $resource = UserSimulationAttemptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(), // Dihilangkan karena form di resource di-disable
        ];
    }
}