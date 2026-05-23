@php
    $plans = [
        ['name' => 'Free', 'price' => '0 SAR', 'billing' => 'Forever', 'features' => ['1 user', '1 project', '100MB storage'], 'popular' => false, 'color' => 'rgb(148, 163, 184)'],
        ['name' => 'Starter', 'price' => '49 SAR', 'billing' => '/month', 'features' => ['5 users', '10 projects', '1GB storage', 'Email support'], 'popular' => false, 'color' => 'rgb(99, 102, 241)'],
        ['name' => 'Pro', 'price' => '149 SAR', 'billing' => '/month', 'features' => ['Unlimited users', 'Unlimited projects', '10GB storage', 'Priority support', 'API access'], 'popular' => true, 'color' => 'rgb(99, 102, 241)'],
    ];
@endphp

<x-filament-panels::page>
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; align-items: stretch;">
        @foreach ($plans as $plan)
            <div style="position: relative; display: flex; flex-direction: column; border-radius: 16px; border: 2px solid {{ $plan['popular'] ? 'var(--primary-500)' : 'rgba(148, 163, 184, 0.2)' }}; padding: 32px 28px 28px; background: {{ $plan['popular'] ? 'rgba(99, 102, 241, 0.04)' : 'transparent' }}; box-shadow: {{ $plan['popular'] ? '0 8px 30px rgba(99, 102, 241, 0.1)' : 'none' }};">
                @if ($plan['popular'])
                    <span style="position: absolute; top: -12px; left: 50%; transform: translateX(-50%); display: inline-flex; padding: 4px 16px; border-radius: 999px; font-size: 11px; font-weight: 700; background: var(--primary-600); color: white; letter-spacing: 0.03em; text-transform: uppercase;">Most Popular</span>
                @endif

                <div style="text-align: center; margin-bottom: 20px;">
                    <div style="width: 12px; height: 12px; border-radius: 999px; background: {{ $plan['color'] }}; margin: 0 auto 8px;"></div>
                    <h3 style="margin: 0; font-size: 18px; font-weight: 700; color: rgb(15, 23, 42);">{{ $plan['name'] }}</h3>
                </div>

                <div style="text-align: center; padding-bottom: 20px; border-bottom: 1px solid rgba(148, 163, 184, 0.15); margin-bottom: 20px;">
                    <p style="margin: 0; font-size: 36px; font-weight: 800; color: rgb(15, 23, 42); letter-spacing: -0.03em; line-height: 1;">
                        {{ $plan['price'] }}
                        <span style="font-size: 14px; font-weight: 400; color: rgb(100, 116, 139); letter-spacing: 0;">{{ $plan['billing'] }}</span>
                    </p>
                </div>

                <ul style="margin: 0; padding: 0; list-style: none; display: grid; gap: 10px; flex: 1;">
                    @foreach ($plan['features'] as $feature)
                        <li style="display: flex; align-items: center; gap: 10px; font-size: 13px; color: rgb(71, 85, 105); padding: 2px 0;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="var(--primary-500)" style="width: 18px; height: 18px; flex-shrink: 0;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            {{ $feature }}
                        </li>
                    @endforeach
                </ul>

                <div style="margin-top: 24px;">
                    <button type="button" style="width: 100%; padding: 10px 0; border-radius: 10px; border: none; font-size: 14px; font-weight: 600; cursor: pointer; {{ $plan['popular'] ? 'background: var(--primary-600); color: white; box-shadow: 0 2px 8px rgba(99, 102, 241, 0.25);' : 'background: rgba(148, 163, 184, 0.1); color: rgb(71, 85, 105);' }}">
                        {{ $plan['popular'] ? 'Subscribe Now' : 'Get Started' }}
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</x-filament-panels::page>
