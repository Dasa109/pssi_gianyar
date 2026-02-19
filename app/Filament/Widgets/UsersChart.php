<?php

namespace App\Filament\Widgets;

use App\Models\User; // <--- PASTIKAN INI ADA
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend; // <--- PASTIKAN INI ADA
use Flowframe\Trend\TrendValue; // <--- PASTIKAN INI ADA

class UsersChart extends ChartWidget
{
    protected static ?string $heading = 'Tren Pertumbuhan Pengguna';
    
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // Mengambil data pendaftaran user 6 bulan terakhir
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
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate)->toArray(),
                    'borderColor' => 'rgb(16, 185, 129)',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => 'start',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date)->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
