<?php

namespace App\Filament\Resources\TrainingScheduleResource\Pages;

use App\Filament\Resources\TrainingScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrainingSchedule extends EditRecord
{
    protected static string $resource = TrainingScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
