<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Club;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pengguna', User::count())
                ->description('Total akun terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary')
                ->chart([7, 2, 10, 3, 15, 4, 17]), // Contoh grafik fluktuasi

            Stat::make('Total Klub', Club::count())
                ->description('Klub sepak bola aktif')
                ->descriptionIcon('heroicon-m-trophy')
                ->color('success'),

            Stat::make('Role Super Admin', User::where('role', 'super_admin')->count())
                ->description('Akses tingkat tinggi')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('danger'),
        ];
    }
}