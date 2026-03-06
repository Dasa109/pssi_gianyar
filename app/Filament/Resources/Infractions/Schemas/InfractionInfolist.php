<?php

namespace App\Filament\Resources\Infractions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class InfractionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('fixture_id')
                    ->numeric(),
                TextEntry::make('customer_id')
                    ->numeric(),
                TextEntry::make('card_type')
                    ->badge(),
                TextEntry::make('minute')
                    ->numeric(),
                TextEntry::make('reason')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
