<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ForumThreadResource\Pages;
use App\Filament\Resources\ForumThreadResource\RelationManagers;
use App\Filament\Resources\ForumThreadResource\RelationManagers\ForumPostsRelationManager;
use App\Models\ForumThread;
use App\Models\User;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor; // Untuk konten post nanti
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str; // Untuk slug

class ForumThreadResource extends Resource
{
    protected static ?string $model = ForumThread::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Community';
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true) // Update slug saat focus keluar
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state)))
                    ->columnSpan('full'),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ForumThread::class, 'slug', ignoreRecord: true) // Pastikan slug unik
                    ->columnSpan('full'),
                Select::make('user_id')
                    ->label('Creator')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->default(auth()->id()) // Default ke user yang login
                    ->disabledOn('edit'), // Tidak bisa diubah saat edit
                Select::make('course_id')
                    ->label('Related Course (Optional)')
                    ->relationship('course', 'title')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                // Forms\Components\Toggle::make('is_pinned')->label('Pin Thread'),
                // Forms\Components\Toggle::make('is_locked')->label('Lock Thread (No new replies)'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('title')->searchable()->sortable()->limit(50),
                TextColumn::make('user.name')->label('Creator')->searchable()->sortable(),
                TextColumn::make('course.title')->label('Course')->searchable()->sortable()->default('N/A'),
                TextColumn::make('posts_count')->counts('posts')->label('Replies')->sortable(),
                TextColumn::make('last_reply_at')->since()->sortable()->label('Last Reply'),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Creator'),
                Tables\Filters\SelectFilter::make('course_id')
                    ->relationship('course', 'title')
                    ->searchable()
                    ->preload()
                    ->label('Course'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('last_reply_at', 'desc'); // Urutkan berdasarkan balasan terakhir
    }

    public static function getRelations(): array
    {
        return [
            ForumPostsRelationManager::class, // Commented out because the class does not exist
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListForumThreads::route('/'),
            'create' => Pages\CreateForumThread::route('/create'),
            'edit' => Pages\EditForumThread::route('/{record}/edit'),
            'view' => Pages\ViewForumThread::route('/{record}'),
        ];
    }
}