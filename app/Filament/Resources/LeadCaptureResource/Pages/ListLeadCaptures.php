<?php

namespace App\Filament\Resources\LeadCaptureResource\Pages;

use App\Filament\Resources\LeadCaptureResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLeadCaptures extends ListRecords
{
    protected static string $resource = LeadCaptureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
