<?php

namespace App\Filament\Resources\EquipmentRentalQuoteResource\Pages;

use App\Filament\Resources\EquipmentRentalQuoteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEquipmentRentalQuotes extends ListRecords
{
    protected static string $resource = EquipmentRentalQuoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
