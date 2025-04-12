<?php

namespace App\Filament\Resources\RegionDeliveryResource\Pages;

use App\Filament\Resources\RegionDeliveryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRegionDeliveries extends ListRecords
{
    protected static string $resource = RegionDeliveryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
