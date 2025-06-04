<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserSimulationAttemptResource\Pages;
use App\Filament\Resources\UserSimulationAttemptResource\RelationManagers;
use App\Models\UserSimulationAttempt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

class UserSimulationAttemptResource extends Resource
{
    protected static ?string $model = UserSimulationAttempt::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = 'Assessments';
    protected static ?string $label = 'Simulation Attempt';
    protected static ?string $pluralLabel = 'Simulation Attempts';
    protected static ?int $navigationSort = 4; // Urutan setelah Quiz Attempts

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->disabled()
                    ->preload(),
                Select::make('simulation_id')
                    ->relationship('simulation', 'title')
                    ->disabled()
                    ->preload(),
                TextInput::make('score')
                    ->numeric()
                    ->disabled(),
                DateTimePicker::make('attempted_at')
                    ->disabled(),
                TextInput::make('time_spent_seconds')
                    ->label('Time Spent (seconds)')
                    ->numeric()
                    ->disabled(),
                Textarea::make('answers_submitted')
                    ->label('Submitted Answers (JSON)')
                    ->disabled()
                    ->rows(10)
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('user.name')->label('Student')->searchable()->sortable(),
                TextColumn::make('simulation.title')->label('Simulation')->searchable()->sortable()->limit(40),
                TextColumn::make('score')->sortable()->default('N/A'),
                TextColumn::make('time_spent_seconds')->label('Time (sec)')->sortable()->default('N/A'),
                TextColumn::make('attempted_at')->dateTime()->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Student'),
                Tables\Filters\SelectFilter::make('simulation_id')
                    ->relationship('simulation', 'title')
                    ->searchable()
                    ->preload()
                    ->label('Simulation'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserSimulationAttempts::route('/'),
            'view' => Pages\ViewUserSimulationAttempt::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}