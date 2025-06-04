<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\TextColumn;

class UserSchedulesRelationManager extends RelationManager
{
    protected static string $relationship = 'userSchedules';
    protected static ?string $recordTitleAttribute = 'event_title';

    public function form(Form $form): Form // Admin bisa membuat jadwal untuk user dari sini
    {
        return $form
            ->schema([
                TextInput::make('event_title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan('full'),
                RichEditor::make('event_description')
                    ->nullable()
                    ->columnSpan('full'),
                DateTimePicker::make('start_time')
                    ->required(),
                DateTimePicker::make('end_time')
                    ->nullable()
                    ->afterOrEqual('start_time'),
                DateTimePicker::make('reminder_time')
                    ->label('Reminder At')
                    ->nullable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            // ->recordTitleAttribute('event_title') // Sudah di set di atas
            ->columns([
                TextColumn::make('event_title')->searchable()->sortable()->limit(50),
                TextColumn::make('start_time')->dateTime()->sortable(),
                TextColumn::make('end_time')->dateTime()->sortable()->default('N/A'),
                TextColumn::make('reminder_time')->dateTime()->sortable()->default('N/A'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make()->url(fn ($record): string => \App\Filament\Resources\UserScheduleResource::getUrl('view', ['record' => $record])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
