<?php

namespace App\Filament\Saas\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ManageSubscriptions extends Page
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationLabel = 'Subscriptions';

    protected static ?string $title = 'Subscriptions';

    protected static ?string $slug = 'subscriptions';

    protected static ?int $navigationSort = 3;

    protected string $view = 'filament.pages.saas-subscriptions';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->components([
                Section::make('Filter Subscriptions')
                    ->components([
                        Grid::make(4)
                            ->schema([
                                Select::make('status')
                                    ->options([
                                        'active' => 'Active',
                                        'trialing' => 'Trialing',
                                        'past_due' => 'Past Due',
                                        'canceled' => 'Canceled',
                                        'expired' => 'Expired',
                                    ])->placeholder('All Statuses'),
                                Select::make('plan')
                                    ->options([
                                        'free' => 'Free',
                                        'starter' => 'Starter',
                                        'pro' => 'Pro',
                                        'enterprise' => 'Enterprise',
                                    ])->placeholder('All Plans'),
                                Select::make('payment_method')
                                    ->options([
                                        'credit_card' => 'Credit Card',
                                        'paypal' => 'PayPal',
                                        'bank_transfer' => 'Bank Transfer',
                                    ])->placeholder('All Methods'),
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
