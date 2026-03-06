<?php

namespace App\Livewire;

use App\Models\Infraction; // Penting: Tambahkan ini agar sistem kenal tabel pelanggaran
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TopInfractions extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            // Menghitung total kartu kuning yang sudah diinput
            Stat::make('Total Kartu Kuning', Infraction::where('type', 'yellow')->count())
                ->description('Peringatan kedisiplinan pemain')
                ->descriptionIcon('heroicon-m-stop')
                ->color('warning'),

            // Menghitung total kartu merah yang sudah diinput
            Stat::make('Total Kartu Merah', Infraction::where('type', 'red')->count())
                ->description('Pelanggaran berat/pengusiran')
                ->descriptionIcon('heroicon-m-stop')
                ->color('danger'),
        ];
    }
}