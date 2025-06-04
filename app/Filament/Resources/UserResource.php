<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\RelationManagers\UserSimulationAttemptsRelationManager; // Tambahkan ini
use App\Filament\Resources\UserResource\RelationManagers\UserQuizAttemptsRelationManager; // Tambahkan ini
use App\Filament\Resources\UserResource\RelationManagers\OrdersRelationManager; 
use App\Filament\Resources\UserResource\RelationManagers\EnrollmentsRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\UserSchedulesRelationManager;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users'; // Ganti ikon jika perlu

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true), // Pastikan email unik kecuali untuk record saat ini
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required(fn (string $context): bool => $context === 'create') // Hanya required saat membuat user baru
                    ->dehydrated(fn ($state) => filled($state)) // Hanya simpan jika diisi (untuk update)
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)) // Hash password sebelum disimpan
                    ->maxLength(255),
                Forms\Components\Select::make('role')
                    ->options([
                        'student' => 'Student',
                        'admin' => 'Admin',
                        'mentor' => 'Mentor',
                    ])
                    ->required(),
                Forms\Components\DateTimePicker::make('email_verified_at')
                    ->label('Email Verified At')
                    ->nullable(), // Bisa dikosongkan
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('role')->badge()->sortable()
                    ->colors([
                        'primary' => 'student',
                        'success' => 'admin',
                        'warning' => 'mentor',
                    ]),
                Tables\Columns\TextColumn::make('email_verified_at')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'student' => 'Student',
                        'admin' => 'Admin',
                        'mentor' => 'Mentor',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            RelationManagers\OrdersRelationManager::class,
            RelationManagers\EnrollmentsRelationManager::class,
            RelationManagers\UserSchedulesRelationManager::class,
            RelationManagers\UserQuizAttemptsRelationManager::class,
            UserSimulationAttemptsRelationManager::class, // Tambahkan ini
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }
}
