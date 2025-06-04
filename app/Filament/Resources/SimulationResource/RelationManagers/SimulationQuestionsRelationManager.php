<?php

namespace App\Filament\Resources\SimulationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;

class SimulationQuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'simulationQuestions';
    protected static ?string $recordTitleAttribute = 'question_text'; // Atau ID jika teks terlalu panjang

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                RichEditor::make('question_text')
                    ->required()
                    ->columnSpan('full'),
                Select::make('question_type')
                    ->options([
                        'multiple_choice' => 'Multiple Choice',
                        'essay' => 'Essay',
                    ])
                    ->required()
                    ->default('multiple_choice')
                    ->reactive(),
                Repeater::make('simulationAnswers') // Nama relasi di model SimulationQuestion
                    ->label('Answer Options')
                    ->relationship() // Menunjukkan ini adalah relasi
                    ->schema([
                        TextInput::make('answer_text')
                            ->required()
                            ->label('Answer Text')
                            ->columnSpan(2),
                        Checkbox::make('is_correct')
                            ->label('Correct Answer'),
                    ])
                    ->columns(3)
                    ->defaultItems(1)
                    ->addActionLabel('Add Answer Option')
                    ->collapsible()
                    ->reorderable(false)
                    ->visible(fn (callable $get) => $get('question_type') === 'multiple_choice')
                    ->columnSpan('full'),
                // TextInput::make('points')->numeric()->default(1)->label('Points'),
                // RichEditor::make('explanation')->label('Answer Explanation')->columnSpan('full')->nullable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            // ->recordTitleAttribute('question_text')
            ->columns([
                TextColumn::make('question_text')->limit(70)->searchable()->html(),
                TextColumn::make('question_type')->badge(),
                // TextColumn::make('points'),
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
