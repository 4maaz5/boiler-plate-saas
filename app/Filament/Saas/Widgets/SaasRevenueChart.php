<?php

namespace App\Filament\Saas\Widgets;

use Filament\Widgets\LineChartWidget;

class SaasRevenueChart extends LineChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Revenue Overview';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => [0, 0, 0, 0, 0, 0, 0],
                    'fill' => 'start',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
        ];
    }
}
