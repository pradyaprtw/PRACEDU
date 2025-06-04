<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ModuleResource\Pages;
use App\Filament\Resources\ModuleResource\RelationManagers;
use App\Models\Module;
use App\Models\Course; // Untuk pilihan course
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload; // Untuk upload PDF
use Filament\Tables\Columns\TextColumn;

class ModuleResource extends Resource
{
    protected static ?string $model = Module::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text'; // Ikon untuk modul
    protected static ?string $navigationGroup = 'Course Management'; // Grup navigasi

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('course_id')
                    ->relationship('course', 'title') // Ambil title dari relasi course
                    ->searchable()
                    ->preload() // Muat opsi saat halaman dimuat
                    ->required(),
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Select::make('module_type')
                    ->options([
                        'video' => 'Video',
                        'pdf' => 'PDF',
                        'text' => 'Text',
                    ])
                    ->required()
                    ->reactive() // Agar form berubah berdasarkan pilihan ini
                    ->afterStateUpdated(fn (callable $set) => $set('content_url', null) & $set('text_content', null) & $set('pdf_file', null)), // Reset field lain saat tipe berubah
                TextInput::make('content_url')
                    ->label('Video URL or External PDF URL')
                    ->url()
                    ->nullable()
                    ->visible(fn (callable $get) => in_array($get('module_type'), ['video', 'pdf'])), // Tampilkan jika tipe video atau pdf (eksternal)
                FileUpload::make('content_url') // Menggunakan field yang sama untuk path file
                    ->label('Upload PDF File')
                    ->disk('public') // Simpan di disk 'public' (storage/app/public)
                    ->directory('course_modules/pdfs') // Subdirektori penyimpanan
                    ->acceptedFileTypes(['application/pdf'])
                    ->nullable()
                    ->visible(fn (callable $get) => $get('module_type') === 'pdf') // Tampilkan hanya jika tipe PDF
                    ->helperText('Jika diisi, ini akan menggantikan URL eksternal PDF.'),
                RichEditor::make('text_content')
                    ->label('Text Content')
                    ->nullable()
                    ->columnSpan('full')
                    ->visible(fn (callable $get) => $get('module_type') === 'text'), // Tampilkan hanya jika tipe text
                TextInput::make('order_in_course')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('course.title')->label('Course')->searchable()->sortable(),
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('module_type')->badge()->sortable(),
                TextColumn::make('order_in_course')->sortable()->label('Order'),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('course_id')
                    ->label('Course')
                    ->relationship('course', 'title')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('module_type')
                    ->options([
                        'video' => 'Video',
                        'pdf' => 'PDF',
                        'text' => 'Text',
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListModules::route('/'),
            'create' => Pages\CreateModule::route('/create'),
            'edit' => Pages\EditModule::route('/{record}/edit'),
            'view' => Pages\ViewModule::route('/{record}'),
        ];
    }
}
