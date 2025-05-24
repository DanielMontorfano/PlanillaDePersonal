<?php

namespace App\Filament\Resources\PlanillaIngresoResource\Pages;

use App\Filament\Resources\PlanillaIngresoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePlanillaIngreso extends CreateRecord
{
    protected static string $resource = PlanillaIngresoResource::class;

    protected function afterCreate(): void
{
    $this->record->numero = str_pad($this->record->id, 4, '0', STR_PAD_LEFT); // Ej: 0007
    $this->record->save();
}

}
