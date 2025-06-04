<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserScheduleResource\Pages;
use App\Filament\Resources\UserScheduleResource\RelationManagers;
use App\Models\UserSchedule;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\TextColumn;

class UserScheduleResource extends Resource
{
    protected static ?string $model = UserSchedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'User Activity'; // Grup baru atau bisa dimasukkan ke User Management
    protected static ?string $label = 'User Schedule';
    protected static ?string $pluralLabel = 'User Schedules';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
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
                    ->nullable()
                    ->helperText('Set a time for the reminder notification.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('user.name')->label('User')->searchable()->sortable(),
                TextColumn::make('event_title')->searchable()->sortable()->limit(50),
                TextColumn::make('start_time')->dateTime()->sortable(),
                TextColumn::make('end_time')->dateTime()->sortable()->default('N/A'),
                TextColumn::make('reminder_time')->dateTime()->sortable()->default('N/A'),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->label('User'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListUserSchedules::route('/'),
            'create' => Pages\CreateUserSchedule::route('/create'), // Admin bisa membuat/mengedit jadwal user jika perlu
            'edit' => Pages\EditUserSchedule::route('/{record}/edit'),
            'view' => Pages\ViewUserSchedule::route('/{record}'),
        ];
    }
}