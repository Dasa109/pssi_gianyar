<?php

namespace App\Filament\Resources\Infractions\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn; // Tambahkan import ini agar aman

class InfractionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fixture.homeTeam.name')
                    ->label('Home')
                    ->searchable(),

                TextColumn::make('fixture.awayTeam.name')
                    ->label('Away')
                    ->searchable(),

                TextColumn::make('customer.name')
                    ->label('Pemain')
                    ->description(fn ($record) => "Menit ke-{$record->minute}")
                    ->searchable(),

                TextColumn::make('card_type')
                    ->label('Kartu')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'yellow' => 'warning',
                        'red' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'yellow' => 'Kuning',
                        'red' => 'Merah',
                        default => $state,
                    }),

                TextColumn::make('reason')
                    ->label('Alasan')
                    ->limit(30),
            ])
            ->actions([])
            ->bulkActions([]);
    }
}