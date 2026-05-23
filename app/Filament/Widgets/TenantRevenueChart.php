<?php

namespace App\Filament\Widgets;

use Filament\Widgets\LineChartWidget;

class TenantRevenueChart extends LineChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Revenue Overview';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => [8900, 9500, 10200, 11000, 11500, 12000, 12450],
                    'fill' => 'start',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
        ];
    }
}
