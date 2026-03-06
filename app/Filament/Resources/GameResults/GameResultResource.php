<?php

namespace App\Filament\Resources\GameResults;

use App\Filament\Resources\GameResults\Pages;
use App\Models\GameResult;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Forms; // Import Forms agar pemanggilan komponen lebih stabil

class GameResultResource extends Resource
{
    protected static ?string $model = GameResult::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationLabel = 'Hasil Pertandingan';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\Select::make('fixture_id')
                ->label('Pertandingan')
                ->relationship('fixture', 'id')
                ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->homeTeam->name} vs {$record->awayTeam->name}")
                ->searchable()
                ->preload()
                ->required(),

            Forms\Components\TextInput::make('home_score')
                ->label('Skor Tuan Rumah')
                ->numeric()
                ->required(),

            Forms\Components\TextInput::make('away_score')
                ->label('Skor Tamu')
                ->numeric()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fixture.homeTeam.name')
                    ->label('Home')
                    ->weight('bold') // Menebalkan nama tim
                    ->searchable(),

                // Menampilkan Skor dengan gaya Badge agar menonjol
                Tables\Columns\TextColumn::make('home_score')
                    ->label('Skor Home')
                    ->badge()
                    ->color('info')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('away_score')
                    ->label('Skor Away')
                    ->badge()
                    ->color('info')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('fixture.awayTeam.name')
                    ->label('Away')
                    ->weight('bold')
                    ->searchable(),

                Tables\Columns\TextColumn::make('fixture.match_date')
                    ->label('Tanggal Pertandingan')
                    ->dateTime('d M Y')
                    ->color('gray')
                    ->sortable(),
            ])
            ->actions([]) // Tetap dikosongkan agar aman dari error "Class Not Found"
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGameResults::route('/'),
            'create' => Pages\CreateGameResult::route('/create'),
            'edit' => Pages\EditGameResult::route('/{record}/edit'),
        ];
    }
}