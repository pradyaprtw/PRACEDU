<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserQuizAttemptResource\Pages;
use App\Filament\Resources\UserQuizAttemptResource\RelationManagers;
use App\Models\UserQuizAttempt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea; // Untuk menampilkan JSON jawaban
use Filament\Tables\Columns\TextColumn;

class UserQuizAttemptResource extends Resource
{
    protected static ?string $model = UserQuizAttempt::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';
    protected static ?string $navigationGroup = 'Assessments';
    protected static ?string $label = 'Quiz Attempt';
    protected static ?string $pluralLabel = 'Quiz Attempts';
    protected static ?int $navigationSort = 3; // Urutan setelah Simulations

    public static function form(Form $form): Form
    {
        // Biasanya admin tidak membuat/mengedit attempt secara manual,
        // tapi form ini bisa berguna untuk melihat detail.
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->disabled()
                    ->preload(),
                Select::make('quiz_id')
                    ->relationship('quiz', 'title')
                    ->disabled()
                    ->preload(),
                TextInput::make('score')
                    ->numeric()
                    ->disabled(),
                DateTimePicker::make('attempted_at')
                    ->disabled(),
                Textarea::make('answers_submitted') // Menampilkan JSON apa adanya
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
                TextColumn::make('quiz.title')->label('Quiz')->searchable()->sortable()->limit(40),
                TextColumn::make('score')->sortable()->default('N/A'),
                TextColumn::make('attempted_at')->dateTime()->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Student'),
                Tables\Filters\SelectFilter::make('quiz_id')
                    ->relationship('quiz', 'title')
                    ->searchable()
                    ->preload()
                    ->label('Quiz'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(), // Mungkin tidak perlu edit manual
                Tables\Actions\DeleteAction::make(), // Hati-hati menghapus riwayat
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
            'index' => Pages\ListUserQuizAttempts::route('/'),
            // 'create' => Pages\CreateUserQuizAttempt::route('/create'), // Admin tidak membuat attempt
            // 'edit' => Pages\EditUserQuizAttempt::route('/{record}/edit'),
            'view' => Pages\ViewUserQuizAttempt::route('/{record}'),
        ];
    }

    public static function canCreate(): bool // Admin tidak seharusnya membuat attempt manual
    {
        return false;
    }
}
