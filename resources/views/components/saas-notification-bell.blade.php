@php
    $panelId = filament()->getId();
    $notificationsUrl = $panelId === 'saas' ? '/saas-admin/notifications' : '/admin/notifications';
@endphp

<div
    x-data="{ open: false }"
    x-on:click.outside="open = false"
    style="position: relative;"
>
    <button
        type="button"
        x-on:click="open = ! open"
        style="position: relative; display: inline-flex; align-items: center; justify-content: center; width: 38px; height: 38px; border: none; border-radius: 10px; background: transparent; color: rgb(100, 116, 139); cursor: pointer;"
        aria-label="Notifications"
    >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
        </svg>

        <span style="position: absolute; top: 6px; right: 6px; width: 8px; height: 8px; border-radius: 999px; background: var(--primary-500); border: 2px solid white;"></span>
    </button>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        style="position: absolute; right: 0; top: calc(100% + 8px); width: 360px; border-radius: 12px; border: 1px solid rgba(148, 163, 184, 0.2); background: white; box-shadow: 0 10px 40px rgba(15, 23, 42, 0.12); z-index: 50; overflow: hidden;"
        x-cloak
    >
        <div style="padding: 12px 14px; border-bottom: 1px solid rgba(148, 163, 184, 0.16);">
            <span style="font-size: 14px; font-weight: 650; color: rgb(15, 23, 42);">Notifications</span>
        </div>

        <div style="max-height: 300px; overflow-y: auto;">
            @php
                $items = [
                    ['title' => 'New tenant registered', 'time' => '5m ago', 'unread' => true],
                    ['title' => 'Subscription renewed', 'time' => '1h ago', 'unread' => true],
                    ['title' => 'Payment received', 'time' => '3h ago', 'unread' => false],
                ];
            @endphp

            @foreach ($items as $item)
                <div style="display: flex; align-items: flex-start; gap: 10px; padding: 10px 14px; cursor: pointer; {{ ! $item['unread'] ? '' : 'background: rgba(99, 102, 241, 0.04);' }}">
                    @if ($item['unread'])
                        <div style="width: 8px; height: 8px; flex: 0 0 auto; margin-top: 5px; border-radius: 999px; background: var(--primary-500);"></div>
                    @else
                        <div style="width: 8px; height: 8px; flex: 0 0 auto; margin-top: 5px; border-radius: 999px; background: rgb(203, 213, 225);"></div>
                    @endif

                    <div style="flex: 1; min-width: 0;">
                        <p style="margin: 0; font-size: 13px; font-weight: 500; color: rgb(15, 23, 42); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $item['title'] }}</p>
                        <p style="margin: 2px 0 0; font-size: 11px; color: rgb(148, 163, 184);">{{ $item['time'] }}</p>
                    </div>

                    @if ($item['unread'])
                        <button
                            type="button"
                            onclick="event.stopPropagation(); alert('Marked as read (UI only)')"
                            style="display: inline-flex; align-items: center; gap: 3px; padding: 4px 8px; border: none; border-radius: 6px; font-size: 11px; font-weight: 500; background: transparent; color: rgb(100, 116, 139); cursor: pointer; flex: 0 0 auto;"
                        >
                            Read
                        </button>
                    @endif
                </div>
            @endforeach
        </div>

        <a
            href="{{ url($notificationsUrl) }}"
            style="display: block; padding: 10px 14px; border-top: 1px solid rgba(148, 163, 184, 0.16); text-align: center; font-size: 13px; font-weight: 500; color: var(--primary-600); text-decoration: none;"
        >
            View All Notifications
        </a>
    </div>
</div>
