<?php

namespace App\Filament\Resources\Infractions\Pages;

use App\Filament\Resources\Infractions\InfractionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInfractions extends ListRecords
{
    protected static string $resource = InfractionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
