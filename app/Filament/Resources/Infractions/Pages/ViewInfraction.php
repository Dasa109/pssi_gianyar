<?php

namespace App\Filament\Resources\Infractions\Pages;

use App\Filament\Resources\Infractions\InfractionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewInfraction extends ViewRecord
{
    protected static string $resource = InfractionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
