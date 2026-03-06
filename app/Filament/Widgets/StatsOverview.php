<?php

namespace App\Filament\Widgets;

use App\Models\Customers;
use App\Models\Fixture;
use App\Models\Infraction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Tim', Customers::count())
                ->description('Semua klub yang terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('Jadwal Pertandingan', Fixture::count())
                ->description('Total agenda liga')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('success'),

            Stat::make('Total Pelanggaran', Infraction::count())
                ->description('Catatan kartu kuning/merah')
                ->descriptionIcon('heroicon-m-no-symbol')
                ->color('danger'),
        ];
    }
}