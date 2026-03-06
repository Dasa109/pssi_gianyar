<?php

namespace App\Filament\Resources\GameResults\Pages;

use App\Filament\Resources\GameResults\GameResultResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewGameResult extends ViewRecord
{
    protected static string $resource = GameResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
