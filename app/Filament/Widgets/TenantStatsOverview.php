<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TenantStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', '24')
                ->description('Active users this month')
                ->descriptionIcon('heroicon-m-users')
                ->chart([12, 15, 18, 20, 22, 24, 24])
                ->color('success'),

            Stat::make('Projects', '8')
                ->description('3 in progress, 5 completed')
                ->descriptionIcon('heroicon-m-folder')
                ->chart([2, 4, 3, 5, 6, 7, 8])
                ->color('warning'),

            Stat::make('Revenue', '$12,450')
                ->description('Monthly recurring revenue')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->chart([8900, 9500, 10200, 11000, 11500, 12000, 12450])
                ->color('info'),
        ];
    }
}
