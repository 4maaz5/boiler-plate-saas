@php
    $ticket = [
        'id' => request()->route('id'),
        'tenant' => 'Acme Corp',
        'subject' => 'Cannot access billing portal',
        'status' => 'open',
        'priority' => 'high',
    ];

    $messages = [
        ['from' => 'tenant', 'name' => 'John (Acme Corp)', 'avatar' => 'JC', 'text' => 'Hi, I cannot access the billing portal. It keeps saying "access denied" when I click on the billing link in the sidebar.', 'time' => '2h ago', 'images' => []],
        ['from' => 'agent', 'name' => 'You (Support)', 'avatar' => 'SU', 'text' => 'Hello John, sorry for the issue. Let me check your account permissions. Can you try clearing your cache and logging in again?', 'time' => '1h 45m ago', 'images' => []],
        ['from' => 'tenant', 'name' => 'John (Acme Corp)', 'avatar' => 'JC', 'text' => 'I already tried that, still the same issue. Here is a screenshot of what I see:', 'time' => '1h 30m ago', 'images' => ['https://placehold.co/400x250/6366f1/ffffff?text=Screenshot']],
        ['from' => 'agent', 'name' => 'You (Support)', 'avatar' => 'SU', 'text' => 'Thank you for the screenshot. I can see the issue — your role permissions need to be updated. I have fixed it on our end. Please try again now.', 'time' => '1h ago', 'images' => []],
        ['from' => 'tenant', 'name' => 'John (Acme Corp)', 'avatar' => 'JC', 'text' => 'It works now! Thank you for the quick help.', 'time' => '45m ago', 'images' => []],
    ];
@endphp

<x-filament-panels::page>
    <div style="display: flex; flex-direction: column; height: calc(100vh - 200px); border-radius: 12px; border: 1px solid rgba(148, 163, 184, 0.16); overflow: hidden; background: white;">
        {{-- Header --}}
        <div style="display: flex; align-items: center; gap: 12px; padding: 14px 20px; border-bottom: 1px solid rgba(148, 163, 184, 0.16); background: rgba(248, 250, 252, 0.8); flex-shrink: 0;">
            <div style="flex: 1; min-width: 0;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <h2 style="margin: 0; font-size: 15px; font-weight: 600; color: rgb(15, 23, 42);">{{ $ticket['subject'] }}</h2>
                    <span style="display: inline-flex; padding: 1px 7px; border-radius: 999px; font-size: 10px; font-weight: 600; background: rgba(99, 102, 241, 0.1); color: var(--primary-600);">{{ ucfirst($ticket['status']) }}</span>
                    <span style="display: inline-flex; padding: 1px 7px; border-radius: 999px; font-size: 10px; font-weight: 600; background: rgba(249, 115, 22, 0.12); color: rgb(194, 65, 12);">{{ ucfirst($ticket['priority']) }}</span>
                </div>
                <p style="margin: 2px 0 0; font-size: 12px; color: rgb(100, 116, 139);">{{ $ticket['tenant'] }} • Ticket #{{ $ticket['id'] }}</p>
            </div>

            <div style="display: flex; gap: 6px;">
                <select style="padding: 5px 10px; border-radius: 6px; border: 1px solid rgba(148, 163, 184, 0.3); font-size: 12px; color: rgb(71, 85, 105); background: white; outline: none;">
                    <option>Open</option>
                    <option>In Progress</option>
                    <option>Resolved</option>
                    <option>Closed</option>
                </select>
            </div>
        </div>

        {{-- Messages --}}
        <div style="flex: 1; overflow-y: auto; padding: 20px; display: flex; flex-direction: column; gap: 16px;">
            @foreach ($messages as $msg)
                <div style="display: flex; flex-direction: {{ $msg['from'] === 'agent' ? 'row-reverse' : 'row' }}; align-items: flex-start; gap: 10px;">
                    <div style="display: flex; width: 34px; height: 34px; flex: 0 0 auto; align-items: center; justify-content: center; border-radius: 10px; {{ $msg['from'] === 'agent' ? 'background: var(--primary-600);' : 'background: rgba(148, 163, 184, 0.2);' }} color: {{ $msg['from'] === 'agent' ? 'white' : 'rgb(71, 85, 105)' }}; font-size: 12px; font-weight: 700;">
                        {{ $msg['avatar'] }}
                    </div>

                    <div style="max-width: 70%;">
                        <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 4px; {{ $msg['from'] === 'agent' ? 'justify-content: flex-end;' : '' }}">
                            <span style="font-size: 12px; font-weight: 600; color: rgb(15, 23, 42);">{{ $msg['name'] }}</span>
                            <span style="font-size: 11px; color: rgb(148, 163, 184);">{{ $msg['time'] }}</span>
                        </div>

                        <div style="padding: 10px 14px; border-radius: 12px; {{ $msg['from'] === 'agent' ? 'background: var(--primary-600); color: white;' : 'background: rgba(248, 250, 252, 0.9); border: 1px solid rgba(148, 163, 184, 0.16); color: rgb(15, 23, 42);' }} font-size: 13px; line-height: 1.5;">
                            <p style="margin: 0;">{{ $msg['text'] }}</p>

                            @if (count($msg['images']))
                                <div style="margin-top: 8px; display: flex; gap: 8px; flex-wrap: wrap;">
                                    @foreach ($msg['images'] as $img)
                                        <img src="{{ $img }}" alt="Screenshot" style="max-width: 220px; border-radius: 8px; border: 1px solid rgba(0,0,0,0.08);">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Rich Text Editor --}}
        <div style="flex-shrink: 0; border-top: 1px solid rgba(148, 163, 184, 0.16); background: white;">
            {{-- Toolbar --}}
            <div style="display: flex; align-items: center; gap: 2px; padding: 8px 14px; border-bottom: 1px solid rgba(148, 163, 184, 0.1); background: rgba(248, 250, 252, 0.6);">
                <button type="button" style="display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border: none; border-radius: 6px; background: transparent; color: rgb(71, 85, 105); cursor: pointer; font-weight: 700; font-size: 14px;" title="Bold"><strong>B</strong></button>
                <button type="button" style="display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border: none; border-radius: 6px; background: transparent; color: rgb(71, 85, 105); cursor: pointer; font-style: italic; font-size: 14px;" title="Italic"><em>I</em></button>
                <button type="button" style="display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border: none; border-radius: 6px; background: transparent; color: rgb(71, 85, 105); cursor: pointer; text-decoration: underline; font-size: 14px;" title="Underline"><u>U</u></button>
                <span style="width: 1px; height: 18px; background: rgba(148, 163, 184, 0.25); margin: 0 4px;"></span>
                <button type="button" style="display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border: none; border-radius: 6px; background: transparent; color: rgb(71, 85, 105); cursor: pointer; font-size: 16px;" title="Bullet List">•</button>
                <button type="button" style="display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border: none; border-radius: 6px; background: transparent; color: rgb(71, 85, 105); cursor: pointer; font-size: 16px;" title="Numbered List">1.</button>
                <span style="width: 1px; height: 18px; background: rgba(148, 163, 184, 0.25); margin: 0 4px;"></span>
                <button type="button" style="display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border: none; border-radius: 6px; background: transparent; color: rgb(71, 85, 105); cursor: pointer; font-size: 14px;" title="Heading">H</button>
                <button type="button" style="display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border: none; border-radius: 6px; background: transparent; color: rgb(71, 85, 105); cursor: pointer; font-size: 14px;" title="Link">🔗</button>
            </div>

            {{-- Editor Area --}}
            <div style="display: flex; align-items: flex-end; gap: 10px; padding: 10px 14px;">
                <div style="flex: 1; min-height: 60px; max-height: 120px; overflow-y: auto; padding: 8px 10px; border: 1px solid rgba(148, 163, 184, 0.25); border-radius: 8px; font-size: 13px; color: rgb(71, 85, 105); background: white; outline: none;" contenteditable="true" data-placeholder="Type your reply..."></div>

                <label style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border: none; border-radius: 8px; background: rgba(148, 163, 184, 0.1); color: rgb(100, 116, 139); cursor: pointer; flex-shrink: 0;" title="Attach Image">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; height: 18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Z" />
                    </svg>
                    <input type="file" accept="image/*" multiple style="display: none;">
                </label>

                <button type="button" style="display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 8px 18px; border: none; border-radius: 8px; background: var(--primary-600); color: white; font-size: 13px; font-weight: 600; cursor: pointer; flex-shrink: 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 16px; height: 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                    </svg>
                    Send
                </button>
            </div>
        </div>
    </div>
</x-filament-panels::page>
