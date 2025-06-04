<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\StatsOverviewWidget; // Import widget Anda
use App\Filament\Widgets\LatestEnrollmentsWidget; // Import widget Anda
use App\Filament\Widgets\NewUsersChartWidget; // Import widget Anda

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home'; // Ikon dashboard

    protected static string $view = 'filament.pages.dashboard'; // View default Filament

    /**
     * @return array<class-string<Widget> | WidgetConfiguration>
     */
    public function getWidgets(): array // Modifikasi metode ini
    {
        return [
            StatsOverviewWidget::class,
            LatestEnrollmentsWidget::class,
            NewUsersChartWidget::class, // Widget ini memerlukan `composer require flowframe/laravel-trend`
        ];
    }

    /**
     * @return array<int, class-string<Widget> | WidgetConfiguration>
     */
    public function getVisibleWidgets(): array // Modifikasi metode ini
    {
        return $this->getWidgets();
    }

    public function getColumns(): int | string | array // Modifikasi metode ini
    {
        return 2; // Jumlah kolom di dashboard, bisa juga ['md' => 2, 'lg' => 3] untuk responsif
    }

    public function getTitle(): string // Modifikasi metode ini
    {
        return static::$title ?? __('filament::pages/dashboard.title');
    }
}