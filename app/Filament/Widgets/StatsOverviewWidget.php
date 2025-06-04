<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Order; // Jika ingin menampilkan info order

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1; // Urutan widget di dashboard

    protected function getStats(): array
    {
        $totalStudents = User::where('role', 'student')->count();
        $totalCourses = Course::count();
        $totalPublishedCourses = Course::where('is_published', true)->count();
        $totalEnrollments = Enrollment::count();
        // $totalSales = Order::where('payment_status', 'paid')->sum('total_amount'); // Contoh jika ada sales

        return [
            Stat::make('Total Students', $totalStudents)
                ->description('All registered students')
                ->descriptionIcon('heroicon-m-users')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]), // Contoh data chart, bisa diganti data dinamis
            Stat::make('Total Courses', $totalCourses)
                ->description($totalPublishedCourses . ' published')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('info')
                ->chart([10, 5, 12, 8, 15, 10, 20]),
            Stat::make('Total Enrollments', $totalEnrollments)
                ->description('Student course enrollments')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning')
                ->chart([5, 10, 8, 12, 7, 15, 10]),
            // Stat::make('Total Sales', 'Rp ' . number_format($totalSales, 0, ',', '.'))
            //     ->description('From paid orders')
            //     ->descriptionIcon('heroicon-m-currency-dollar')
            //     ->color('primary'),
        ];
    }
}
