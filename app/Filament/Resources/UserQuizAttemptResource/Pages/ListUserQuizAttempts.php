<?php 

namespace App\Filament\Resources\UserQuizAttemptResource\Pages; 

use App\Filament\Resources\UserQuizAttemptResource; 
use Filament\Resources\Pages\ListRecords; 

class ListUserQuizAttempts extends ListRecords 
{ 
    protected static string $resource = UserQuizAttemptResource::class; 
}