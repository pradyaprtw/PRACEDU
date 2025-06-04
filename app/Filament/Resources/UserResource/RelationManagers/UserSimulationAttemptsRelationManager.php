<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\UserSimulationAttemptResource; // Untuk action view

class UserSimulationAttemptsRelationManager extends RelationManager
{
    protected static string $relationship = 'userSimulationAttempts';
    protected static ?string $recordTitleAttribute = 'id'; // Atau bisa juga simulation.title

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('simulation.title')->label('Simulation')->searchable()->sortable(),
                TextColumn::make('score')->sortable()->default('N/A'),
                TextColumn::make('time_spent_seconds')->label('Time (sec)')->sortable()->default('N/A'),
                TextColumn::make('attempted_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->url(fn ($record): string => UserSimulationAttemptResource::getUrl('view', ['record' => $record])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}