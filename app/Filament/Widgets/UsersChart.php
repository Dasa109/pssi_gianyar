<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon; // <--- Kita gunakan bawaan Laravel saja

class UsersChart extends ChartWidget
{
    protected static ?string $heading = 'Tren Pertumbuhan Pengguna';
    
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        // Looping untuk mengambil data 6 bulan terakhir secara mundur
        for ($i = 5; $i >= 0; $i--) {
            // Ambil referensi bulan (misal: 5 bulan lalu, 4 bulan lalu, dst)
            $month = now()->subMonths($i);
            
            // Hitung jumlah user berdasarkan tahun dan bulan tersebut
            $count = User::whereYear('created_at', $month->year)
                         ->whereMonth('created_at', $month->month)
                         ->count();

            // Masukkan nama bulan (Contoh: 'Jan 2026') dan jumlah datanya ke array
            $labels[] = $month->translatedFormat('M Y'); 
            $data[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'User Baru Mendaftar',
                    'data' => $data,
                    'borderColor' => 'rgb(16, 185, 129)', // Warna Emerald PSSI Gianyar
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => 'start',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}