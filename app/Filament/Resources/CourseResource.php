<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers;
use App\Models\Course;
use App\Models\User; // Untuk relasi instruktur
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\RichEditor; // Untuk deskripsi
use Filament\Forms\Components\Toggle; // Untuk is_published
use Filament\Forms\Components\Select; // Untuk instructor_id
use Filament\Forms\Components\TextInput; // Untuk price dan category
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn; // Untuk is_published

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap'; // Ikon untuk kursus

    protected static ?string $recordTitleAttribute = 'title'; // Menampilkan title di breadcrumbs

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan('full'), // Mengambil lebar penuh
                RichEditor::make('description')
                    ->nullable()
                    ->columnSpan('full'),
                Forms\Components\TextInput::make('category')
                    ->nullable()
                    ->maxLength(255)
                    ->helperText('Contoh: SNBT, Mandiri, Matematika, Fisika'),
                Select::make('instructor_id')
                    ->label('Instructor')
                    ->options(User::whereIn('role', ['admin', 'mentor'])->pluck('name', 'id')) // Hanya user dengan role admin/mentor
                    ->searchable()
                    ->nullable(),
                TextInput::make('price')
                    ->numeric()
                    ->prefix('Rp')
                    ->required()
                    ->default(0.00),
                Toggle::make('is_published')
                    ->label('Published')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('category')->searchable()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('instructor.name') // Menampilkan nama instruktur dari relasi
                    ->label('Instructor')
                    ->searchable()
                    ->sortable()
                    ->default('N/A'),
                TextColumn::make('price')
                    ->money('IDR') // Format sebagai mata uang Rupiah
                    ->sortable(),
                IconColumn::make('is_published')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('instructor_id')
                    ->relationship('instructor', 'name') // Perbaiki ini jika sebelumnya salah
                    ->searchable()
                    ->preload()
                    ->label('Instructor'),
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(), // Tambahkan action View
                Tables\Actions\DeleteAction::make(),
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
            RelationManagers\ModulesRelationManager::class,
            RelationManagers\QuizzesRelationManager::class,
            CourseResource\RelationManagers\EnrollmentsRelationManager::class, // Relasi untuk enrollments
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
            'view' => Pages\ViewCourse::route('/{record}'), // Tambahkan route View
        ];
    }
}