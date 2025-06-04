<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class EnrollmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'enrollments';

    public function form(Form $form): Form // Form ini mungkin tidak terlalu sering dipakai di sini
    {
        return $form
            ->schema([
                // Biasanya enrollment terjadi otomatis setelah pembayaran atau manual di EnrollmentResource
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('course.title')->label('Course')->searchable()->sortable(),
                TextColumn::make('enrolled_at')->dateTime()->sortable(),
                TextColumn::make('progress_percentage')->suffix('%')->sortable(),
                IconColumn::make('completed_at')->label('Completed')->boolean()->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(), // Enroll manual lebih baik di EnrollmentResource
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->url(fn ($record) => \App\Filament\Resources\EnrollmentResource::getUrl('view', ['record' => $record])),
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}