<?php

namespace App\Filament\Resources\Fixtures;

use App\Filament\Resources\Fixtures\Pages;
use App\Models\Fixture;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Forms;

class FixtureResource extends Resource
{
    protected static ?string $model = Fixture::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Jadwal Pertandingan';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\DateTimePicker::make('match_date')
                ->label('Waktu Kick-off')
                ->required(),

            Forms\Components\TextInput::make('stadium')
                ->label('Stadion')
                ->required(),

            Forms\Components\Select::make('home_team_id')
                ->label('Tim Tuan Rumah')
                ->relationship('homeTeam', 'name')
                ->preload()
                ->required(),

            Forms\Components\Select::make('away_team_id')
                ->label('Tim Tamu')
                ->relationship('awayTeam', 'name')
                ->preload()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('match_date')
                    ->label('Jadwal')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('homeTeam.name')
                    ->label('Home'),
                Tables\Columns\TextColumn::make('awayTeam.name')
                    ->label('Away'),
                Tables\Columns\TextColumn::make('stadium')
                    ->label('Stadion'),
                // BAGIAN WARNA-WARNI STATUS
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'scheduled' => 'gray',
                        'live' => 'info',
                        'finished' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'scheduled' => 'Direncanakan',
                        'live' => 'Berjalan',
                        'finished' => 'Selesai',
                        default => $state,
                    }),
            ])
            ->actions([]) // Tetap kosongkan jika ingin aman
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFixtures::route('/'),
            'create' => Pages\CreateFixture::route('/create'),
            'edit' => Pages\EditFixture::route('/{record}/edit'),
        ];
    }
}
