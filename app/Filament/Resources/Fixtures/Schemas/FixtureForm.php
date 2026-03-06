<?php

namespace App\Filament\Resources\Fixtures\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FixtureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DateTimePicker::make('match_date')
                    ->required(),
                TextInput::make('stadium')
                    ->required(),
                TextInput::make('home_team_id')
                    ->required()
                    ->numeric(),
                TextInput::make('away_team_id')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->options([
            'scheduled' => 'Scheduled',
            'live' => 'Live',
            'finished' => 'Finished',
            'postponed' => 'Postponed',
        ])
                    ->default('scheduled')
                    ->required(),
            ]);
    }
}
