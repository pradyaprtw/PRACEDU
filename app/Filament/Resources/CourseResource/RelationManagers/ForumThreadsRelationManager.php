<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;

class ForumThreadsRelationManager extends RelationManager
{
    protected static string $relationship = 'forumThreads';
    // protected static ?string $recordTitleAttribute = 'title'; // Tidak perlu jika sudah ada di Resource utama

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))) // Otomatis generate slug
                    ->columnSpan('full'),
                TextInput::make('slug') // Slug akan diisi otomatis, bisa disembunyikan jika mau
                    ->required()
                    ->maxLength(255)
                    ->unique(table: \App\Models\ForumThread::class, column: 'slug', ignoreRecord: true)
                    ->columnSpan('full'),
                // user_id akan diambil dari user yang login (admin) saat membuat dari sini
                // course_id akan diambil dari ownerRecord (Course)
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            // ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')->searchable()->sortable()->limit(50),
                TextColumn::make('user.name')->label('Creator')->searchable()->sortable(),
                TextColumn::make('posts_count')->counts('posts')->label('Replies')->sortable(),
                TextColumn::make('last_reply_at')->since()->sortable()->label('Last Reply'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['user_id'] = auth()->id(); // Set creator ke admin yang login
                        // course_id sudah otomatis terisi oleh Filament karena ini RelationManager
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('view_thread')
                    ->label('View Posts')
                    ->icon('heroicon-o-chat-bubble-bottom-center-text')
                    ->url(fn ($record): string => \App\Filament\Resources\ForumThreadResource::getUrl('edit', ['record' => $record])), // Arahkan ke halaman edit ForumThreadResource untuk melihat posts
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('last_reply_at', 'desc');
    }
}