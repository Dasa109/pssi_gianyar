<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Spatie\Activitylog\Models\Activity;

class LatestActivities extends BaseWidget
{
    protected static ?int $sort = 2; // Mengatur urutan di dashboard
    protected int | string | array $columnSpan = 'full'; // Agar memenuhi lebar layar

    public function table(Table $table): Table
    {
        return $table
            ->query(Activity::query()->latest()->limit(5))
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('causer.name')
                    ->label('Admin/User'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Aktivitas'),
                Tables\Columns\TextColumn::make('subject_type')
                    ->label('Target'),
            ]);
    }
}