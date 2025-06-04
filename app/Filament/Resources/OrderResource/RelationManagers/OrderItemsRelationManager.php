<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use App\Models\Course;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderItems';
    // protected static ?string $recordTitleAttribute = 'course.title'; // Tidak bisa langsung, perlu custom

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('course_id')
                    ->label('Course')
                    ->options(Course::pluck('title', 'id'))
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set) => $set('price_at_purchase', Course::find($state)?->price ?? 0))
                    ->required(),
                TextInput::make('price_at_purchase')
                    ->numeric()
                    ->prefix('Rp')
                    ->required()
                    ->disabled(), // Harga diambil otomatis dari kursus
                TextInput::make('quantity')
                    ->numeric()
                    ->default(1)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            // ->recordTitleAttribute('course.title')
            ->columns([
                TextColumn::make('course.title')->label('Course')->searchable()->sortable(),
                TextColumn::make('quantity'),
                TextColumn::make('price_at_purchase')->money('IDR'),
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
            ]);
    }
}