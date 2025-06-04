<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

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
    protected static ?string $recordTitleAttribute = 'id'; // Atau bisa juga quiz.title

    public function form(Form $form): Form // Admin tidak membuat attempt dari sini
    {
        return $form
            ->schema([
                //
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            // ->recordTitleAttribute('quiz.title')
            ->columns([
                TextColumn::make('quiz.title')->label('Quiz')->searchable()->sortable(),
                TextColumn::make('score')->sortable()->default('N/A'),
                TextColumn::make('attempted_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(), // Tidak ada create dari sini
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->url(fn ($record): string => UserQuizAttemptResource::getUrl('view', ['record' => $record])),
                // Tables\Actions\EditAction::make(), // Tidak ada edit dari sini
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}