<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class NewUsersChartWidget extends ChartWidget
{
    protected static ?string $heading = 'New Student Registrations';
    protected static ?int $sort = 3;
    protected static string $color = 'primary'; // Warna chart
    // protected int | string | array $columnSpan = 'full'; // Uncomment jika ingin lebar penuh

    protected function getData(): array
    {
        // Anda perlu menginstal package: composer require flowframe/laravel-trend
        // Buat query builder Eloquent yang sudah difilter
        $query = User::query()->where('role', 'student');

        $data = Trend::query($query) // Gunakan Trend::query() dengan builder yang sudah difilter
            ->between(
                start: now()->subMonth(),
                end: now(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'New Students',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#36A2EB', // Warna garis
                    'backgroundColor' => '#9BD0F5', // Warna area bawah garis
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Tipe chart: line, bar, pie, doughnut, radar, polarArea, bubble
    }
}


