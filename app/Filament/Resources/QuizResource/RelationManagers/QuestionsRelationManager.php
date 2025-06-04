<?php

namespace App\Filament\Resources\QuizResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Repeater; // Untuk mengelola jawaban
use Filament\Forms\Components\Checkbox; // Untuk is_correct
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

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
                    ->reactive(), // Agar field jawaban muncul/sembunyi

                // Field untuk jawaban pilihan ganda, menggunakan Repeater
                Repeater::make('answers') // Ini akan berinteraksi dengan relasi 'answers' di model Question
                    ->label('Answer Options')
                    ->relationship() // Menunjukkan bahwa ini adalah relasi
                    ->schema([
                        TextInput::make('answer_text')
                            ->required()
                            ->label('Answer Text')
                            ->columnSpan(2), // Ambil lebih banyak ruang
                        Checkbox::make('is_correct')
                            ->label('Correct Answer'),
                    ])
                    ->columns(3) // Jumlah kolom dalam satu item repeater
                    ->defaultItems(1) // Jumlah item default saat membuat
                    ->addActionLabel('Add Answer Option')
                    ->collapsible()
                    ->reorderable(false) // Nonaktifkan reorder jika tidak perlu
                    ->visible(fn (callable $get) => $get('question_type') === 'multiple_choice')
                    ->columnSpan('full'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question_text') // Atau atribut lain yang lebih singkat
            ->columns([
                TextColumn::make('question_text')->limit(50)->searchable(),
                TextColumn::make('question_type')->badge(),
                // TextColumn::make('answers_count')->counts('answers')->label('Options'), // Jika menggunakan model Answer
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