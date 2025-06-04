<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnrollmentResource\Pages;
use App\Filament\Resources\EnrollmentResource\RelationManagers;
use App\Filament\Resources\EnrollmentResource\RelationManagers\UserModuleProgressesRelationManager; // Tambahkan ini
use App\Models\Enrollment;
use App\Models\User;
use App\Models\Course;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
// use Filament\Forms\Components\Slider; // Removed because Slider does not exist in Filament
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class EnrollmentResource extends Resource
{
    protected static ?string $model = Enrollment::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Course Management';
    protected static ?int $navigationSort = 3; // Urutan setelah Quiz

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('course_id')
                    ->relationship('course', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('order_id')
                    ->label('Associated Order (Optional)')
                    ->options(function (callable $get) {
                        $userId = $get('user_id');
                        if ($userId) {
                            // Tampilkan order milik user yang dipilih
                            return Order::where('user_id', $userId)->pluck('id', 'id')->mapWithKeys(fn ($id) => [$id => "Order #{$id}"]);
                        }
                        return Order::pluck('id', 'id')->mapWithKeys(fn ($id) => [$id => "Order #{$id}"]);
                    })
                    ->searchable()
                    ->preload()
                    ->nullable(),
                DateTimePicker::make('enrolled_at')
                    ->default(now())
                    ->required(),
                TextInput::make('progress_percentage')
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->maxValue(100)
                    ->step(1),
                DateTimePicker::make('completed_at')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('user.name')->label('Student')->searchable()->sortable(),
                TextColumn::make('course.title')->label('Course')->searchable()->sortable(),
                TextColumn::make('order_id')->label('Order #')->sortable()->default('N/A'),
                TextColumn::make('enrolled_at')->dateTime()->sortable(),
                TextColumn::make('progress_percentage')->suffix('%')->sortable(),
                IconColumn::make('completed_at')->label('Completed')->boolean()->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Student'),
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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            UserModuleProgressesRelationManager::class, // Untuk progress modul
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEnrollments::route('/'),
            'create' => Pages\CreateEnrollment::route('/create'), // Admin bisa enroll manual
            'edit' => Pages\EditEnrollment::route('/{record}/edit'),
            'view' => Pages\ViewEnrollment::route('/{record}'),
        ];
    }
}