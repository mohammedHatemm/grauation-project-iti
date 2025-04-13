<?php

namespace App\Filament\Resources\ShippingRateResource\Pages;

use App\Filament\Resources\ShippingRateResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListShippingRates extends ListRecords
{
  protected static string $resource = ShippingRateResource::class;

  protected function getHeaderActions(): array
  {
    return [
      CreateAction::make(),
    ];
  }
}
