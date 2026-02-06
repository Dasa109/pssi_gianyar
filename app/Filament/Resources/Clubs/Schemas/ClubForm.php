<?php

namespace App\Filament\Resources\Clubs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ClubForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('short_name')
                    ->default(null),
                TextInput::make('logo')
                    ->default(null),
                TextInput::make('stadium_name')
                    ->default(null),
                Textarea::make('address')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('phone')
                    ->tel()
                    ->default(null),
            ]);
    }
}
