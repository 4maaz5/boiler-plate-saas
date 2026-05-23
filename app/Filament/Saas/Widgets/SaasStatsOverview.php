<?php

namespace App\Filament\Saas\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SaasStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Tenants', '0')
                ->description('Active tenants')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->chart([7, 3, 10, 5, 15, 8, 12])
                ->color('success'),

            Stat::make('Total Revenue', '$0')
                ->description('Monthly recurring revenue')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->chart([2, 4, 3, 8, 5, 10, 7])
                ->color('warning'),

            Stat::make('Active Users', '0')
                ->description('Across all tenants')
                ->descriptionIcon('heroicon-m-users')
                ->chart([1, 2, 1, 3, 5, 4, 6])
                ->color('info'),
        ];
    }
}
