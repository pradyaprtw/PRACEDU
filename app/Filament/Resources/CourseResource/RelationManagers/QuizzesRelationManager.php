<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select; // Untuk memilih modul
use App\Models\Module; // Untuk opsi modul
use Filament\Tables\Columns\TextColumn;

class QuizzesRelationManager extends RelationManager // Nama kelas ini harus unik jika ada ModuleQuizzesRelationManager
{
    protected static string $relationship = 'quizzes';
    // protected static ?string $recordTitleAttribute = 'title'; // Tidak perlu jika sudah ada di Resource utama

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan('full'),
                // Ambil course_id dari owner record (Course)
                // $form->getRecord()->getKey() akan memberikan ID Course saat ini
                Select::make('module_id')
                    ->label('Module (Optional)')
                    ->options(function (RelationManager $livewire) {
                        // Ambil course_id dari owner record (Course)
                        $courseId = $livewire->ownerRecord->id;
                        if ($courseId) {
                            return Module::where('course_id', $courseId)->pluck('title', 'id');
                        }
                        return [];
                    })
                    ->searchable()
                    ->preload()
                    ->nullable(),
                RichEditor::make('description')
                    ->nullable()
                    ->columnSpan('full'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('module.title')->label('Module')->default('N/A')->sortable(),
                TextColumn::make('questions_count')->counts('questions')->label('Questions')->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    // ->mutateFormDataUsing(function (array $data, RelationManager $livewire): array {
                    //     $data['course_id'] = $livewire->ownerRecord->id; // Otomatis set course_id
                    //     return $data;
                    // }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                // Tambahkan action untuk mengelola pertanyaan dari sini jika mau
                Tables\Actions\Action::make('manage_questions')
                    ->label('Manage Questions')
                    ->icon('heroicon-o-document-text')
                    ->url(fn ($record): string => \App\Filament\Resources\QuizResource::getUrl('edit', ['record' => $record])),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}