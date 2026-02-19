<?php

namespace App\Filament\Widgets;

use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\User;

protected function getData(): array
{
    // Mengambil data pendaftaran user 6 bulan terakhir secara otomatis
    $data = Trend::model(User::class)
        ->between(
            start: now()->startOfMonth()->subMonths(6),
            end: now()->endOfMonth(),
        )
        ->perMonth()
        ->count();

    return [
        'datasets' => [
            [
                'label' => 'User Baru Mendaftar',
                // Mengambil angka (aggregate) dari hasil query trend
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                'borderColor' => 'rgb(16, 185, 129)', // Warna Emerald agar match dengan tema dashboard
                'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                'fill' => 'start',
            ],
        ],
        // Mengambil label bulan (Jan, Feb, dst) secara otomatis
        'labels' => $data->map(fn (TrendValue $value) => $value->date),
    ];
}
