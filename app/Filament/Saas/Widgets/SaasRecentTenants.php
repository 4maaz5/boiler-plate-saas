<?php

namespace App\Filament\Saas\Widgets;

use App\Models\User;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class SaasRecentTenants extends BaseWidget
{
    protected static ?int $sort = 3;

    protected static ?string $heading = 'Recent Tenants';

    protected function getTableQuery(): Builder
    {
        return User::query()->whereRaw('1 = 0');
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')->label('Tenant'),
            TextColumn::make('domain')->label('Domain'),
            TextColumn::make('created_at')->label('Registered')->date(),
            TextColumn::make('status')->label('Status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'active' => 'success',
                    'trial' => 'warning',
                    'expired' => 'danger',
                    default => 'gray',
                }),
        ];
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        return 'No tenants registered yet.';
    }
}
