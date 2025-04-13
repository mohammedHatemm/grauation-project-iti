<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Region;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
            ->description('Users all over the site')
            ->descriptionIcon('heroicon-o-users')
            ->color('warning'),


            Stat::make('Total Clients', User::where('role', 'merchant')->count())
            ->description("Increase in Clients")
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('success')
            ->chart([5,9,15,20,27,30]),

            Stat::make('Total Orders', Order::count())
            ->description('Increase in orders')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('success')
            ->chart([20,19,5,17,36,40,10,25]),

            Stat::make('Covered governorate', Region::where('status', 'active')->count())
                ->description('Covering the country')
                ->descriptionIcon('heroicon-s-globe-europe-africa')
            ->color('primary')
        ];
    }
}
