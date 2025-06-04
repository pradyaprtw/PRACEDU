<?php

namespace App\Filament\Resources\ForumThreadResource\Pages;

use App\Filament\Resources\ForumThreadResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewForumThread extends ViewRecord
{
    protected static string $resource = ForumThreadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
