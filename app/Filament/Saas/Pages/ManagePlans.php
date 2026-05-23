<?php

namespace App\Filament\Saas\Pages;

use Filament\Pages\Page;

class ManagePlans extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Plans';

    protected static ?string $title = 'Pricing Plans';

    protected static ?string $slug = 'plans';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.saas-plans';
}
