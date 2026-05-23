<?php

namespace App\Filament\Saas\Pages;

use Filament\Pages\Page;

class TicketChatPage extends Page
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $title = 'Ticket';

    protected static ?string $slug = 'support/ticket/{id}';

    protected string $view = 'filament.pages.saas-ticket-chat';
}
