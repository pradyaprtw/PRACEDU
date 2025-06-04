<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuizResource\Pages;
use App\Filament\Resources\QuizResource\RelationManagers\UserQuizAttemptsRelationManager as QuizUserQuizAttemptsRelationManager; // Tambahkan ini
use App\Models\Quiz;
use App\Filament\Resources\QuizResource\RelationManagers;
use App\Filament\Resources\QuizResource\RelationManagers\QuestionsRelationManager; // Import QuestionsRelationManager
use App\Models\Course;
use App\Models\Module;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\TextColumn;


class QuizResource extends Resource
{
    protected static ?string $model = \App\Models\Quiz::class; // Pastikan model path benar

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?string $navigationGroup = 'Assessments'; // Ubah grup navigasi
    // ... (sisa kode QuizResource tetap sama)

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan('full'),
                Select::make('course_id')
                    ->relationship('course', 'title')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->reactive() 
                    ->afterStateUpdated(fn (callable $set) => $set('module_id', null)), 
                Select::make('module_id')
                    ->label('Module (Optional)')
                    ->options(function (callable $get) {
                        $courseId = $get('course_id');
                        if ($courseId) {
                            return \App\Models\Module::where('course_id', $courseId)->pluck('title', 'id');
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('course.title')->searchable()->sortable(),
                TextColumn::make('module.title')->searchable()->sortable()->default('N/A'),
                TextColumn::make('questions_count')->counts('questions')->label('Questions')->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('course_id')
                    ->relationship('course', 'title')
                    ->searchable()
                    ->preload(),
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
            RelationManagers\QuestionsRelationManager::class, 
            // Tambahkan relation manager untuk pertanyaan
            RelationManagers\UserQuizAttemptsRelationManager::class, // Tambahkan relation manager untuk attempts
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuizzes::route('/'),
            'create' => Pages\CreateQuiz::route('/create'),
            'edit' => Pages\EditQuiz::route('/{record}/edit'),
            'view' => Pages\ViewQuiz::route('/{record}'),
        ];
    }
}
