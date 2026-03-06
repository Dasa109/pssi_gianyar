<?php

namespace App\Filament\Resources\GameResults\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class GameResultInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('fixture_id')
                    ->numeric(),
                TextEntry::make('home_score')
                    ->numeric(),
                TextEntry::make('away_score')
                    ->numeric(),
                TextEntry::make('match_summary')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
