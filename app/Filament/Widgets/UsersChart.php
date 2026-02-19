<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class UsersChart extends ChartWidget
{
    protected static ?string $heading = 'Tren Pertumbuhan Pengguna';
    protected static ?int $sort = 2; // Agar muncul di bawah Stats Overview

    protected function getData(): array
    {
        // Tips: Untuk UAS, kamu bisa menggunakan data dummy atau data asli
        // Di sini kita ambil data pendaftaran user 6 bulan terakhir
        $data = [
            'datasets' => [
                [
                    'label' => 'User Baru',
                    'data' => [0, 10, 5, 2, 21, 32, 45], // Ganti dengan logika query asli jika sudah ada datanya
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgb(54, 162, 235)',
                    'fill' => 'start',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'],
        ];

        return $data;
    }

    protected function getType(): string
    {
        return 'line';
    }
}
