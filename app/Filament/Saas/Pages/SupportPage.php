<?php

namespace App\Filament\Saas\Pages;

use Filament\Pages\Page;

class SupportPage extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-lifebuoy';

    protected static ?string $navigationLabel = 'Support';

    protected static ?string $title = 'Support Tickets';

    protected static ?string $slug = 'support';

    protected static ?int $navigationSort = 4;

    protected string $view = 'filament.pages.saas-support';
}
