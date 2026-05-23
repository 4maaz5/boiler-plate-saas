<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            Notifications
        </x-slot>

        <x-slot name="description">
            All your recent notifications
        </x-slot>

        <div style="display: grid; gap: 8px;">
            @php
                $sampleNotifications = [
                    ['title' => 'New tenant registered', 'description' => 'Acme Corp has joined the platform.', 'time' => '5 minutes ago', 'read' => false],
                    ['title' => 'Subscription renewed', 'description' => 'TechStart Inc renewed their Pro plan.', 'time' => '1 hour ago', 'read' => false],
                    ['title' => 'Payment received', 'description' => '$299.00 payment from GlobalTech Ltd.', 'time' => '3 hours ago', 'read' => false],
                    ['title' => 'Trial ending soon', 'description' => 'StartupXYZ trial expires in 3 days.', 'time' => '1 day ago', 'read' => true],
                    ['title' => 'System update', 'description' => 'Platform upgraded to version 2.4.0.', 'time' => '2 days ago', 'read' => true],
                ];
            @endphp

            @forelse ($sampleNotifications as $notif)
                <div style="display: flex; align-items: flex-start; gap: 12px; padding: 14px 16px; border-radius: 10px; border: 1px solid {{ $notif['read'] ? 'rgba(148, 163, 184, 0.16)' : 'rgba(99, 102, 241, 0.2)' }}; background: {{ $notif['read'] ? 'transparent' : 'rgba(99, 102, 241, 0.04)' }};">
                    <div style="display: flex; width: 10px; height: 10px; flex: 0 0 auto; margin-top: 6px; border-radius: 999px; background: {{ $notif['read'] ? 'rgb(203, 213, 225)' : 'var(--primary-500)' }};"></div>

                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-size: 14px; font-weight: 600; color: rgb(15, 23, 42);">{{ $notif['title'] }}</span>

                            @if (! $notif['read'])
                                <span style="display: inline-flex; padding: 1px 7px; border-radius: 999px; font-size: 11px; font-weight: 600; background: var(--primary-100); color: var(--primary-700);">New</span>
                            @endif
                        </div>

                        <p style="margin: 2px 0 0; font-size: 13px; color: rgb(100, 116, 139);">{{ $notif['description'] }}</p>

                        <p style="margin: 4px 0 0; font-size: 12px; color: rgb(148, 163, 184);">{{ $notif['time'] }}</p>
                    </div>

                    <div style="display: flex; gap: 4px; flex: 0 0 auto;">
                        @if (! $notif['read'])
                            <button type="button" style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 10px; border: none; border-radius: 6px; font-size: 12px; font-weight: 500; background: transparent; color: rgb(100, 116, 139); cursor: pointer;" onclick="alert('Marked as read (UI only)')">
                                Mark read
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 40px; color: rgb(148, 163, 184);">
                    <p style="font-size: 15px;">No notifications yet.</p>
                </div>
            @endforelse
        </div>
    </x-filament::section>
</x-filament-panels::page>
