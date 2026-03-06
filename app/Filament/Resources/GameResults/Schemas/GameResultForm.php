<?php

namespace App\Filament\Resources\GameResults\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class GameResultForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('fixture_id')
                    ->required()
                    ->numeric(),
                TextInput::make('home_score')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('away_score')
                    ->required()
                    ->numeric()
                    ->default(0),
                Textarea::make('match_summary')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
