<?php

namespace App\Filament\Resources\QuizResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\UserQuizAttemptResource; // Untuk action view

class UserQuizAttemptsRelationManager extends RelationManager
{
    protected static string $relationship = 'userQuizAttempts';
    protected static ?string $recordTitleAttribute = 'user.name';

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
            // ->recordTitleAttribute('user.name')
            ->columns([
                TextColumn::make('user.name')->label('Student')->searchable()->sortable(),
                TextColumn::make('score')->sortable()->default('N/A'),
                TextColumn::make('attempted_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->url(fn ($record): string => UserQuizAttemptResource::getUrl('view', ['record' => $record])),
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}