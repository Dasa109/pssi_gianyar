<?php

namespace App\Filament\Resources\Fixtures\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class FixtureInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('match_date')
                    ->dateTime(),
                TextEntry::make('stadium'),
                TextEntry::make('home_team_id')
                    ->numeric(),
                TextEntry::make('away_team_id')
                    ->numeric(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
