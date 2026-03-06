<?php

namespace App\Filament\Resources\Infractions\Pages;

use App\Filament\Resources\Infractions\InfractionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditInfraction extends EditRecord
{
    protected static string $resource = InfractionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
