<?php

namespace App\Filament\Resources\Customers\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo Klub')
                    ->getStateUsing(fn ($record) => $record->logo
                        ? asset('storage/' . $record->logo)
                        : null
                    )
                    ->square()
                    ->height(40),

                TextColumn::make('name')
                    ->label('Nama Tim')
                    ->searchable()
                    ->sortable(),
            ])
            ->actions([])
            ->bulkActions([]);
    }
}