<?php

namespace App\Filament\Resources\RegionDeliveryResource\Pages;

use App\Filament\Resources\RegionDeliveryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRegionDelivery extends EditRecord
{
    protected static string $resource = RegionDeliveryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
