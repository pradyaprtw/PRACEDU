<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Enrollment;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\EnrollmentResource;

class LatestEnrollmentsWidget extends BaseWidget
{
    protected static ?int $sort = 2; // Urutan widget
    protected int | string | array $columnSpan = 'full'; // Widget ini mengambil lebar penuh

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Enrollment::query()->latest()->limit(5) // Ambil 5 pendaftaran terbaru
            )
            ->columns([
                TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('course.title')
                    ->label('Course')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                TextColumn::make('enrolled_at')
                    ->label('Enrolled Date')
                    ->since()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View Enrollment')
                    ->url(fn (Enrollment $record): string => EnrollmentResource::getUrl('view', ['record' => $record]))
                    ->icon('heroicon-s-eye'),
            ])
            ->paginated(false); // Tidak perlu paginasi untuk widget
    }
}
