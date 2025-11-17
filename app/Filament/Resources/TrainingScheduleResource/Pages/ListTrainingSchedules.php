<?php

namespace App\Filament\Resources\TrainingScheduleResource\Pages;

use App\Filament\Resources\TrainingScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrainingSchedules extends ListRecords
{
    protected static string $resource = TrainingScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
