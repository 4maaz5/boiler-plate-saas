<?php

namespace App\Filament\Widgets;

use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class TenantRecentActivity extends BaseWidget
{
    protected static ?int $sort = 3;

    protected static ?string $heading = 'Recent Activity';

    protected function getTableQuery(): Builder
    {
        return \App\Models\User::query()->whereRaw('1 = 0');
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')->label('User'),
            TextColumn::make('action')->label('Action'),
            TextColumn::make('date')->label('Date'),
        ];
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        return 'No recent activity.';
    }
}
