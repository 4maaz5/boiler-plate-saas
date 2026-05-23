<x-filament-panels::page>
    {{ $this->form }}

    <div style="margin-top: 8px; display: flex; justify-content: flex-end;">
        <x-filament::button wire:click="save" color="primary">
            Apply Filters
        </x-filament::button>
    </div>

    <div style="margin-top: 20px; display: grid; gap: 10px;">
        @php
            $tenants = [
                ['name' => 'Acme Corp', 'domain' => 'acme.example.com', 'plan' => 'Pro', 'status' => 'active', 'users' => 12, 'created' => '2026-01-15'],
                ['name' => 'TechStart Inc', 'domain' => 'techstart.example.com', 'plan' => 'Enterprise', 'status' => 'active', 'users' => 45, 'created' => '2026-02-20'],
                ['name' => 'GlobalTech Ltd', 'domain' => 'globaltech.example.com', 'plan' => 'Starter', 'status' => 'trial', 'users' => 5, 'created' => '2026-05-01'],
                ['name' => 'StartupXYZ', 'domain' => 'startupxyz.example.com', 'plan' => 'Free', 'status' => 'expired', 'users' => 2, 'created' => '2025-11-10'],
                ['name' => 'DataFlow Systems', 'domain' => 'dataflow.example.com', 'plan' => 'Pro', 'status' => 'active', 'users' => 28, 'created' => '2026-03-08'],
            ];
        @endphp

        @foreach ($tenants as $tenant)
            <div style="display: flex; align-items: center; gap: 14px; padding: 14px 16px; border-radius: 10px; border: 1px solid rgba(148, 163, 184, 0.16);">
                <div style="display: flex; width: 40px; height: 40px; flex: 0 0 auto; align-items: center; justify-content: center; border-radius: 10px; background: rgba(99, 102, 241, 0.1); color: var(--primary-600); font-weight: 700; font-size: 14px;">
                    {{ substr($tenant['name'], 0, 2) }}
                </div>

                <div style="flex: 1; min-width: 0;">
                    <p style="margin: 0; font-size: 14px; font-weight: 600; color: rgb(15, 23, 42);">{{ $tenant['name'] }}</p>
                    <p style="margin: 2px 0 0; font-size: 12px; color: rgb(148, 163, 184);">{{ $tenant['domain'] }}</p>
                </div>

                <div style="text-align: right; font-size: 12px; color: rgb(100, 116, 139);">
                    {{ $tenant['users'] }} users
                </div>

                <div>
                    <span style="display: inline-flex; padding: 2px 8px; border-radius: 999px; font-size: 11px; font-weight: 600; {{ $tenant['status'] === 'active' ? 'background: rgba(34, 197, 94, 0.12); color: rgb(22, 163, 74);' : ($tenant['status'] === 'trial' ? 'background: rgba(234, 179, 8, 0.12); color: rgb(161, 98, 7);' : 'background: rgba(239, 68, 68, 0.12); color: rgb(220, 38, 38);') }}">
                        {{ ucfirst($tenant['status']) }}
                    </span>
                </div>

                <span style="font-size: 12px; color: rgb(148, 163, 184);">{{ $tenant['created'] }}</span>
            </div>
        @endforeach
    </div>
</x-filament-panels::page>
