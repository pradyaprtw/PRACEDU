<?php

namespace App\Filament\Resources\UserScheduleResource\Pages;

use App\Filament\Resources\UserScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserSchedule extends EditRecord
{
    protected static string $resource = UserScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
