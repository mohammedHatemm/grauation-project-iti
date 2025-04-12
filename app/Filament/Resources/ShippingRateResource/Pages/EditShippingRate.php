<?php

namespace App\Filament\Resources\ShippingRateResource\Pages;

use App\Filament\Resources\ShippingRateResource;
use Filament\Resources\Pages\EditRecord;

class EditShippingRate extends EditRecord
{
  protected static string $resource = ShippingRateResource::class;

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
