<?php

namespace App\Filament\Resources\Infractions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InfractionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('fixture_id')
                    ->required()
                    ->numeric(),
                TextInput::make('customer_id')
                    ->required()
                    ->numeric(),
                Select::make('card_type')
                    ->options(['yellow' => 'Yellow', 'red' => 'Red'])
                    ->required(),
                TextInput::make('minute')
                    ->required()
                    ->numeric(),
                TextInput::make('reason')
                    ->default(null),
            ]);
    }
}
