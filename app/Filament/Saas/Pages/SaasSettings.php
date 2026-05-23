<?php

namespace App\Filament\Saas\Pages;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SaasSettings extends Page
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Settings';

    protected static ?string $title = 'SaaS Settings';

    protected static ?string $slug = 'settings';

    protected static ?int $navigationSort = 5;

    protected string $view = 'filament.pages.saas-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->components([
                Section::make('General')
                    ->components([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('site_name')
                                    ->label('Site Name')
                                    ->placeholder('My SaaS Platform'),
                                TextInput::make('support_email')
                                    ->label('Support Email')
                                    ->email()
                                    ->placeholder('support@example.com'),
                                Toggle::make('registration_open')
                                    ->label('Allow new registrations'),
                                Select::make('default_plan')
                                    ->label('Default Plan for new tenants')
                                    ->options([
                                        'free' => 'Free',
                                        'starter' => 'Starter',
                                        'pro' => 'Pro',
                                    ]),
                            ]),
                    ]),
                Section::make('Branding')
                    ->components([
                        Grid::make(2)
                            ->schema([
                                FileUpload::make('logo')
                                    ->label('Logo')
                                    ->image()
                                    ->maxSize(1024),
                                FileUpload::make('favicon')
                                    ->label('Favicon')
                                    ->image()
                                    ->maxSize(512),
                            ]),
                    ]),
                Section::make('Social Links')
                    ->components([
                        Repeater::make('social_links')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('platform')
                                            ->label('Platform')
                                            ->placeholder('e.g. Twitter'),
                                        TextInput::make('url')
                                            ->label('URL')
                                            ->url()
                                            ->placeholder('https://twitter.com/...'),
                                    ]),
                            ])
                            ->addActionLabel('Add Link')
                            ->collapsible(false),
                    ]),
                Section::make('Mail Configuration')
                    ->components([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('mail_host')->label('SMTP Host'),
                                TextInput::make('mail_port')->label('SMTP Port')->numeric(),
                                TextInput::make('mail_username')->label('SMTP Username'),
                                TextInput::make('mail_password')->label('SMTP Password')->password(),
                                Select::make('mail_encryption')
                                    ->label('Encryption')
                                    ->options([
                                        'tls' => 'TLS',
                                        'ssl' => 'SSL',
                                        'none' => 'None',
                                    ]),
                            ]),
                    ]),
                Section::make('Maintenance')
                    ->components([
                        Grid::make(2)
                            ->schema([
                                Toggle::make('maintenance_mode')
                                    ->label('Maintenance Mode'),
                                Textarea::make('maintenance_message')
                                    ->label('Maintenance Message')
                                    ->rows(3)
                                    ->placeholder('Site is under maintenance...'),
                            ]),
                    ]),
            ]);
    }

    public function save(): void
    {
        Notification::make()->success()->title('Settings saved (UI only)')->send();
    }
}
