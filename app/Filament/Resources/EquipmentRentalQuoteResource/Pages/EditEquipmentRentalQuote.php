<?php

namespace App\Filament\Resources\EquipmentRentalQuoteResource\Pages;

use App\Filament\Resources\EquipmentRentalQuoteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEquipmentRentalQuote extends EditRecord
{
    protected static string $resource = EquipmentRentalQuoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
