<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserModuleProgressResource\Pages;
use App\Filament\Resources\UserModuleProgressResource\RelationManagers;
use App\Models\UserModuleProgress;
use App\Models\Enrollment;
use App\Models\Module;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\BooleanColumn; // Alternatif untuk is_completed

class UserModuleProgressResource extends Resource
{
    protected static ?string $model = UserModuleProgress::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static ?string $navigationGroup = 'User Activity';
    protected static ?string $label = 'Module Progress';
    protected static ?string $pluralLabel = 'Module Progresses';
    protected static ?int $navigationSort = 2; // Setelah User Schedules

    public static function form(Form $form): Form
    {
        // Admin mungkin perlu mengedit status penyelesaian secara manual
        return $form
            ->schema([
                Select::make('enrollment_id')
                    ->relationship('enrollment', 'id') // Menampilkan ID enrollment, bisa dicustom jika perlu
                    ->label('Enrollment (User & Course)')
                    // Untuk menampilkan info lebih, perlu custom getOptionLabel atau getSearchResultsUsing
                    ->getOptionLabelFromRecordUsing(fn (Enrollment $record) => "Enrollment #{$record->id} (User: {$record->user->name} - Course: {$record->course->title})")
                    ->searchable(['user.name', 'course.title']) // Ini tidak akan bekerja langsung, perlu penyesuaian
                    ->preload()
                    ->required()
                    ->disabledOn('edit'), // Mungkin tidak boleh diubah setelah dibuat
                Select::make('module_id')
                    ->relationship('module', 'title')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->disabledOn('edit'),
                Toggle::make('is_completed')
                    ->label('Completed Status')
                    ->default(false)
                    ->reactive(),
                DateTimePicker::make('last_accessed_at')
                    ->nullable(),
                DateTimePicker::make('completed_at')
                    ->label('Completed At')
                    ->nullable()
                    ->visible(fn (callable $get) => $get('is_completed') === true), // Hanya tampil jika completed
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('enrollment.user.name')->label('Student')->searchable()->sortable(),
                TextColumn::make('enrollment.course.title')->label('Course')->searchable()->sortable()->limit(30),
                TextColumn::make('module.title')->label('Module')->searchable()->sortable()->limit(30),
                IconColumn::make('is_completed')->label('Completed')->boolean(),
                TextColumn::make('last_accessed_at')->dateTime()->sortable()->default('N/A'),
                TextColumn::make('completed_at')->dateTime()->sortable()->default('N/A'),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('enrollment_id') // Filter by enrollment
                    ->label('Enrollment')
                    ->options(Enrollment::with(['user', 'course'])->get()->mapWithKeys(function ($enrollment) {
                        return [$enrollment->id => "Enroll #{$enrollment->id}: {$enrollment->user->name} - {$enrollment->course->title}"];
                    }))
                    ->searchable(),
                Tables\Filters\SelectFilter::make('module_id')
                    ->relationship('module', 'title')
                    ->searchable()
                    ->preload()
                    ->label('Module'),
                Tables\Filters\TernaryFilter::make('is_completed'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListUserModuleProgress::route('/'),
            'create' => Pages\CreateUserModuleProgress::route('/create'),
            'edit' => Pages\EditUserModuleProgress::route('/{record}/edit'),
            'view' => Pages\ViewUserModuleProgress::route('/{record}'),
        ];
    }
}