@php
    $tickets = [
        ['id' => 1, 'tenant' => 'Acme Corp', 'subject' => 'Cannot access billing portal', 'status' => 'open', 'priority' => 'high', 'agent' => 'Unassigned', 'date' => '2h ago', 'replies' => 3],
        ['id' => 2, 'tenant' => 'TechStart Inc', 'subject' => 'Need help with API integration', 'status' => 'in_progress', 'priority' => 'medium', 'agent' => 'You', 'date' => '1d ago', 'replies' => 7],
        ['id' => 3, 'tenant' => 'GlobalTech Ltd', 'subject' => 'Feature request: custom domain', 'status' => 'open', 'priority' => 'low', 'agent' => 'Unassigned', 'date' => '3d ago', 'replies' => 0],
        ['id' => 4, 'tenant' => 'DataFlow Systems', 'subject' => 'Payment not processed', 'status' => 'resolved', 'priority' => 'critical', 'agent' => 'You', 'date' => '5d ago', 'replies' => 12],
    ];

    $statusStyles = [
        'open' => 'background: rgba(99, 102, 241, 0.1); color: var(--primary-600);',
        'in_progress' => 'background: rgba(234, 179, 8, 0.12); color: rgb(161, 98, 7);',
        'resolved' => 'background: rgba(34, 197, 94, 0.12); color: rgb(22, 163, 74);',
    ];

    $priorityStyles = [
        'critical' => 'background: rgba(239, 68, 68, 0.12); color: rgb(220, 38, 38);',
        'high' => 'background: rgba(249, 115, 22, 0.12); color: rgb(194, 65, 12);',
        'medium' => 'background: rgba(234, 179, 8, 0.12); color: rgb(161, 98, 7);',
        'low' => 'background: rgba(148, 163, 184, 0.16); color: rgb(100, 116, 139);',
    ];
@endphp

<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">All Tickets</x-slot>

        <div style="display: grid; gap: 4px;">
            <div style="display: grid; grid-template-columns: 2fr 4fr 1fr 1fr 1.5fr 1fr; gap: 8px; padding: 8px 12px; font-size: 11px; font-weight: 600; color: rgb(100, 116, 139); text-transform: uppercase; letter-spacing: 0.05em;">
                <span>Tenant</span>
                <span>Subject</span>
                <span>Status</span>
                <span>Priority</span>
                <span>Agent</span>
                <span style="text-align: right;">Date</span>
            </div>

            @foreach ($tickets as $ticket)
                <a href="{{ url('/saas-admin/support/ticket/' . $ticket['id']) }}" style="display: grid; grid-template-columns: 2fr 4fr 1fr 1fr 1.5fr 1fr; gap: 8px; align-items: center; padding: 10px 12px; border-radius: 8px; border: 1px solid rgba(148, 163, 184, 0.12); text-decoration: none; transition: background 0.15s;" onmouseover="this.style.background='rgba(99, 102, 241, 0.04)'" onmouseout="this.style.background=''">
                    <span style="font-size: 13px; font-weight: 500; color: rgb(15, 23, 42);">{{ $ticket['tenant'] }}</span>

                    <div style="min-width: 0;">
                        <span style="font-size: 13px; font-weight: 500; color: rgb(15, 23, 42);">{{ $ticket['subject'] }}</span>
                        @if ($ticket['replies'] > 0)
                            <span style="margin-left: 6px; font-size: 11px; color: rgb(148, 163, 184);">({{ $ticket['replies'] }})</span>
                        @endif
                    </div>

                    <div>
                        <span style="display: inline-flex; padding: 2px 8px; border-radius: 999px; font-size: 11px; font-weight: 600; {{ $statusStyles[$ticket['status']] }}">
                            {{ str_replace('_', ' ', ucfirst($ticket['status'])) }}
                        </span>
                    </div>

                    <div>
                        <span style="display: inline-flex; padding: 2px 8px; border-radius: 999px; font-size: 11px; font-weight: 600; {{ $priorityStyles[$ticket['priority']] }}">
                            {{ ucfirst($ticket['priority']) }}
                        </span>
                    </div>

                    <span style="font-size: 13px; color: rgb(100, 116, 139);">{{ $ticket['agent'] }}</span>

                    <span style="font-size: 12px; color: rgb(148, 163, 184); text-align: right;">{{ $ticket['date'] }}</span>
                </a>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-panels::page>
