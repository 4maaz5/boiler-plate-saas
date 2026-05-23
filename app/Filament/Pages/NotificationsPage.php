<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class NotificationsPage extends Page
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $title = 'Notifications';

    protected static ?string $slug = 'notifications';

    protected string $view = 'filament.pages.saas-notifications';
}
