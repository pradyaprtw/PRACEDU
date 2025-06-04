<?php
namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;

class ModulesRelationManager extends RelationManager
{
    protected static string $relationship = 'modules'; // Nama relasi di model Course

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan('full'),
                Select::make('module_type')
                    ->options([
                        'video' => 'Video',
                        'pdf' => 'PDF',
                        'text' => 'Text',
                    ])
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('content_url', null) & $set('text_content', null)),
                TextInput::make('content_url')
                    ->label('Video URL or External PDF URL')
                    ->url()
                    ->nullable()
                    ->visible(fn (callable $get) => in_array($get('module_type'), ['video', 'pdf'])),
                FileUpload::make('content_url') // Menggunakan field yang sama untuk path file
                    ->label('Upload PDF File')
                    ->disk('public')
                    ->directory('course_modules/pdfs')
                    ->acceptedFileTypes(['application/pdf'])
                    ->nullable()
                    ->visible(fn (callable $get) => $get('module_type') === 'pdf')
                    ->helperText('Jika diisi, ini akan menggantikan URL eksternal PDF.'),
                RichEditor::make('text_content')
                    ->label('Text Content')
                    ->nullable()
                    ->columnSpan('full')
                    ->visible(fn (callable $get) => $get('module_type') === 'text'),
                TextInput::make('order_in_course')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            // ->recordTitleAttribute('title') // Tidak perlu jika sudah ada di Resource utama
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('module_type')->badge()->sortable(),
                TextColumn::make('order_in_course')->sortable()->label('Order'),
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
            ])
            ->reorderable('order_in_course'); // Aktifkan fitur reorder dengan drag-and-drop
    }
}