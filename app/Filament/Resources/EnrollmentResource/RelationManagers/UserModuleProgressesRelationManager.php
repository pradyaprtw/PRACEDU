<?php

namespace App\Filament\Resources\EnrollmentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use App\Models\Module; // Untuk memilih modul

class UserModuleProgressesRelationManager extends RelationManager
{
    protected static string $relationship = 'userModuleProgresses';
    protected static ?string $recordTitleAttribute = 'module.title';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('module_id')
                    ->label('Module')
                    // Opsi modul hanya dari kursus yang terkait dengan enrollment ini
                    ->options(function (RelationManager $livewire): array {
                        $courseId = $livewire->ownerRecord->course_id; // Ambil course_id dari enrollment
                        if ($courseId) {
                            return Module::where('course_id', $courseId)->pluck('title', 'id')->all();
                        }
                        return [];
                    })
                    ->searchable()
                    ->preload()
                    ->required()
                    ->disabledOn('edit'), // Tidak bisa diubah setelah dibuat
                Toggle::make('is_completed')
                    ->label('Completed Status')
                    ->default(false)
                    ->reactive(),
                DateTimePicker::make('last_accessed_at')
                    ->nullable(),
                DateTimePicker::make('completed_at')
                    ->label('Completed At')
                    ->nullable()
                    ->visible(fn (callable $get) => $get('is_completed') === true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            // ->recordTitleAttribute('module.title') // sudah di set di atas
            ->columns([
                TextColumn::make('module.title')->label('Module')->searchable()->sortable(),
                IconColumn::make('is_completed')->label('Completed')->boolean(),
                TextColumn::make('last_accessed_at')->dateTime()->sortable()->default('N/A'),
                TextColumn::make('completed_at')->dateTime()->sortable()->default('N/A'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_completed'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}