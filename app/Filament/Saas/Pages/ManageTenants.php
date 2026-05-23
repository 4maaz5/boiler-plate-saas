<?php

namespace App\Filament\Saas\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ManageTenants extends Page
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationLabel = 'Tenants';

    protected static ?string $title = 'Tenants';

    protected static ?string $slug = 'tenants';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.saas-tenants';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->components([
                Section::make('Filter Tenants')
                    ->components([
                        Grid::make(4)
                            ->schema([
                                TextInput::make('search')->placeholder('Search by name or domain'),
                                Select::make('status')
                                    ->options([
                                        'active' => 'Active',
                                        'trial' => 'Trial',
                                        'expired' => 'Expired',
                                        'suspended' => 'Suspended',
                                    ])->placeholder('All Statuses'),
                                Select::make('plan')
                                    ->options([
                                        'free' => 'Free',
                                        'starter' => 'Starter',
                                        'pro' => 'Pro',
                                        'enterprise' => 'Enterprise',
                                    ])->placeholder('All Plans'),
                                Select::make('date_range')
                                    ->options([
                                        'today' => 'Today',
                                        'week' => 'This Week',
                                        'month' => 'This Month',
                                        'year' => 'This Year',
                                    ])->placeholder('Date Range'),
                            ]),
                    ]),
            ]);
    }

    public function save(): void
    {
        Notification::make()->success()->title('Filters applied (UI only)')->send();
    }
}
