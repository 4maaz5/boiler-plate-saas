<x-filament-panels::page>
    {{ $this->form }}

    <div style="margin-top: 8px; display: flex; justify-content: flex-end;">
        <x-filament::button wire:click="save" color="primary">
            Apply Filters
        </x-filament::button>
    </div>

    <div style="margin-top: 20px; display: grid; gap: 10px;">
        @php
            $subscriptions = [
                ['tenant' => 'Acme Corp', 'plan' => 'Pro', 'amount' => '$29.99', 'status' => 'active', 'next_billing' => '2026-06-15', 'method' => 'Credit Card'],
                ['tenant' => 'TechStart Inc', 'plan' => 'Enterprise', 'amount' => '$99.99', 'status' => 'active', 'next_billing' => '2026-06-20', 'method' => 'PayPal'],
                ['tenant' => 'GlobalTech Ltd', 'plan' => 'Starter', 'amount' => '$9.99', 'status' => 'trialing', 'next_billing' => '2026-06-01', 'method' => 'Credit Card'],
                ['tenant' => 'DataFlow Systems', 'plan' => 'Pro', 'amount' => '$29.99', 'status' => 'past_due', 'next_billing' => '2026-05-08', 'method' => 'Bank Transfer'],
                ['tenant' => 'StartupXYZ', 'plan' => 'Free', 'amount' => '$0', 'status' => 'expired', 'next_billing' => '-', 'method' => '-'],
            ];
        @endphp

        @foreach ($subscriptions as $sub)
            <div style="display: flex; align-items: center; gap: 14px; padding: 14px 16px; border-radius: 10px; border: 1px solid rgba(148, 163, 184, 0.16);">
                <div style="flex: 1; min-width: 0;">
                    <p style="margin: 0; font-size: 14px; font-weight: 600; color: rgb(15, 23, 42);">{{ $sub['tenant'] }}</p>
                    <p style="margin: 2px 0 0; font-size: 12px; color: rgb(148, 163, 184);">{{ $sub['plan'] }} • {{ $sub['method'] }}</p>
                </div>

                <span style="font-size: 14px; font-weight: 600; color: rgb(15, 23, 42);">{{ $sub['amount'] }}</span>

                <div>
                    <span style="display: inline-flex; padding: 2px 8px; border-radius: 999px; font-size: 11px; font-weight: 600; {{ $sub['status'] === 'active' ? 'background: rgba(34, 197, 94, 0.12); color: rgb(22, 163, 74);' : ($sub['status'] === 'trialing' ? 'background: rgba(234, 179, 8, 0.12); color: rgb(161, 98, 7);' : ($sub['status'] === 'past_due' ? 'background: rgba(249, 115, 22, 0.12); color: rgb(194, 65, 12);' : 'background: rgba(239, 68, 68, 0.12); color: rgb(220, 38, 38);')) }}">
                        {{ str_replace('_', ' ', ucfirst($sub['status'])) }}
                    </span>
                </div>

                <span style="font-size: 12px; color: rgb(148, 163, 184);">Next: {{ $sub['next_billing'] }}</span>
            </div>
        @endforeach
    </div>
</x-filament-panels::page>
