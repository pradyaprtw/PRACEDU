<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SimulationResource\RelationManagers\UserSimulationAttemptsRelationManager as SimulationUserSimulationAttemptsRelationManager; // Tambahkan ini
use App\Filament\Resources\SimulationResource\Pages;
use App\Filament\Resources\SimulationResource\RelationManagers;
use App\Filament\Resources\SimulationResource\RelationManagers\SimulationQuestionsRelationManager;
use App\Models\Simulation;
// use App\Models\Course; // Jika dikaitkan dengan Course
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

class SimulationResource extends Resource
{
    protected static ?string $model = Simulation::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationGroup = 'Assessments'; // Grup baru untuk Kuis & Simulasi
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan('full'),
                RichEditor::make('description')
                    ->nullable()
                    ->columnSpan('full'),
                Select::make('simulation_type')
                    ->options([
                        'SNBT' => 'SNBT',
                        'Mandiri' => 'Ujian Mandiri',
                        'Lainnya' => 'Lainnya',
                    ])
                    ->required(),
                TextInput::make('duration_minutes')
                    ->numeric()
                    ->label('Duration (Minutes)')
                    ->minValue(1)
                    ->nullable(),
                // Select::make('course_id')
                //     ->relationship('course', 'title')
                //     ->searchable()
                //     ->preload()
                //     ->label('Related Course (Optional)')
                //     ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('simulation_type')->badge()->sortable(),
                TextColumn::make('duration_minutes')->suffix(' min')->sortable(),
                // TextColumn::make('course.title')->label('Course')->default('N/A')->sortable(),
                TextColumn::make('simulation_questions_count')->counts('simulationQuestions')->label('Questions')->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('simulation_type')
                    ->options([
                        'SNBT' => 'SNBT',
                        'Mandiri' => 'Ujian Mandiri',
                        'Lainnya' => 'Lainnya',
                    ]),
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
            SimulationQuestionsRelationManager::class,
            SimulationUserSimulationAttemptsRelationManager::class, // Tambahkan ini untuk relasi dengan UserSimulationAttempts
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSimulations::route('/'),
            'create' => Pages\CreateSimulation::route('/create'),
            'edit' => Pages\EditSimulation::route('/{record}/edit'),
            'view' => Pages\ViewSimulation::route('/{record}'),
        ];
    }
}
