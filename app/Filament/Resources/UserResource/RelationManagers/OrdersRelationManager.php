<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\OrderResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    public function form(Form $form): Form // Form ini mungkin tidak terlalu sering dipakai di sini
    {
        return $form
            ->schema([
                // Biasanya order dibuat melalui proses checkout, bukan manual di sini
                // Tapi bisa ditambahkan jika perlu
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('id')->label('Order ID')->sortable(),
                TextColumn::make('total_amount')->money('IDR')->sortable(),
                BadgeColumn::make('payment_status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'failed',
                        'gray' => 'refunded',
                    ])->sortable(),
                TextColumn::make('order_date')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(), // Mungkin tidak perlu
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->url(fn ($record) => OrderResource::getUrl('view', ['record' => $record])), // Perbaiki di sini
                // Tables\Actions\EditAction::make(), // Edit order mungkin lebih baik di OrderResource
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
