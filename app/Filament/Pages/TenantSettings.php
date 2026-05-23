<?php

namespace App\Filament\Pages;

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

class TenantSettings extends Page
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Settings';

    protected static ?string $title = 'Settings';

    protected static ?string $slug = 'settings';

    protected static string | \UnitEnum | null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.tenant-settings';

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
                                    ->placeholder('My App'),
                                TextInput::make('support_email')
                                    ->label('Support Email')
                                    ->email()
                                    ->placeholder('support@example.com'),
                                Toggle::make('registration_open')
                                    ->label('Allow registration'),
                                Select::make('timezone')
                                    ->label('Timezone')
                                    ->options([
                                        'UTC' => 'UTC',
                                        'US/Eastern' => 'US/Eastern',
                                        'Asia/Riyadh' => 'Asia/Riyadh',
                                        'Europe/London' => 'Europe/London',
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
                Section::make('Mail')
                    ->components([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('mail_host')->label('SMTP Host'),
                                TextInput::make('mail_port')->label('SMTP Port')->numeric(),
                                TextInput::make('mail_username')->label('Username'),
                                TextInput::make('mail_password')->label('Password')->password(),
                            ]),
                    ]),

            ]);
    }

    public function save(): void
    {
        Notification::make()->success()->title('Settings saved (UI only)')->send();
    }
}
