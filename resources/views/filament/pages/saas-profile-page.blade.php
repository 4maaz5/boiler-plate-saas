@php
    $user = filament()->auth()->user();
    $initials = collect(explode(' ', trim($user?->name ?? '')))
        ->filter()
        ->map(fn (string $part): string => mb_substr($part, 0, 1))
        ->take(2)
        ->implode('');

    $initials = filled($initials) ? mb_strtoupper($initials) : 'U';
@endphp

<x-filament-panels::page>
    @once
        <style>
            .s-profile-layout {
                display: grid;
                gap: 20px;
            }

            .s-profile-summary {
                display: flex;
                align-items: center;
                gap: 16px;
            }

            .s-profile-avatar {
                display: flex;
                width: 58px;
                height: 58px;
                flex: 0 0 auto;
                align-items: center;
                justify-content: center;
                border-radius: 18px;
                background: var(--primary-600);
                color: white;
                font-size: 18px;
                font-weight: 800;
                letter-spacing: 0;
                box-shadow: 0 10px 22px rgba(15, 23, 42, 0.14);
            }

            .s-profile-title {
                margin: 0;
                color: rgb(15, 23, 42);
                font-size: 18px;
                font-weight: 700;
                line-height: 1.25;
            }

            .s-profile-meta {
                margin: 4px 0 0;
                color: rgb(100, 116, 139);
                font-size: 14px;
                line-height: 1.45;
            }

            .s-password-flow {
                display: grid;
                gap: 18px;
            }

            .s-password-steps {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 10px;
            }

            .s-password-step {
                display: flex;
                align-items: center;
                gap: 10px;
                border: 1px solid rgba(148, 163, 184, 0.28);
                border-radius: 12px;
                padding: 10px 12px;
                color: rgb(100, 116, 139);
                background: rgba(248, 250, 252, 0.72);
                font-size: 13px;
                font-weight: 650;
            }

            .s-password-step__number {
                display: flex;
                width: 24px;
                height: 24px;
                flex: 0 0 auto;
                align-items: center;
                justify-content: center;
                border-radius: 999px;
                background: white;
                color: rgb(71, 85, 105);
                font-size: 12px;
                font-weight: 800;
                box-shadow: inset 0 0 0 1px rgba(148, 163, 184, 0.4);
            }

            .s-password-step.is-active {
                border-color: color-mix(in srgb, var(--primary-500) 58%, transparent);
                color: rgb(15, 23, 42);
                background: color-mix(in srgb, var(--primary-50) 85%, white);
            }

            .s-password-step.is-active .s-password-step__number,
            .s-password-step.is-complete .s-password-step__number {
                background: var(--primary-600);
                color: white;
                box-shadow: none;
            }

            .s-password-step.is-complete {
                color: var(--primary-700);
            }

            .s-profile-panel {
                border: 1px solid rgba(148, 163, 184, 0.24);
                border-radius: 14px;
                padding: 16px;
                background: rgba(248, 250, 252, 0.64);
            }

            .s-profile-panel__title {
                margin: 0;
                color: rgb(15, 23, 42);
                font-size: 15px;
                font-weight: 700;
            }

            .s-profile-panel__text {
                margin: 6px 0 0;
                color: rgb(100, 116, 139);
                font-size: 14px;
                line-height: 1.55;
            }

            .s-profile-field-grid {
                display: grid;
                gap: 14px;
            }

            .s-profile-field-label {
                display: block;
                margin-bottom: 6px;
                color: rgb(51, 65, 85);
                font-size: 13px;
                font-weight: 650;
            }

            .s-profile-actions {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                gap: 10px;
            }

            .dark .s-profile-title,
            .dark .s-profile-panel__title,
            .dark .s-password-step.is-active,
            .dark .s-profile-field-label {
                color: rgb(248, 250, 252);
            }

            .dark .s-profile-meta,
            .dark .s-profile-panel__text {
                color: rgb(148, 163, 184);
            }

            .dark .s-password-step,
            .dark .s-profile-panel {
                border-color: rgba(148, 163, 184, 0.18);
                background: rgba(15, 23, 42, 0.32);
            }

            .dark .s-password-step__number {
                background: rgba(15, 23, 42, 0.7);
                color: rgb(203, 213, 225);
                box-shadow: inset 0 0 0 1px rgba(148, 163, 184, 0.26);
            }

            .dark .s-password-step.is-active {
                background: color-mix(in srgb, var(--primary-900) 36%, rgba(15, 23, 42, 0.54));
            }

            @media (max-width: 640px) {
                .s-profile-summary {
                    align-items: flex-start;
                }

                .s-password-steps {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    @endonce

    <div class="s-profile-layout">
        <x-filament::section>
            <div class="s-profile-summary">
                <div class="s-profile-avatar" aria-hidden="true">
                    {{ $initials }}
                </div>

                <div>
                    <h2 class="s-profile-title">{{ $user?->name }}</h2>
                    <p class="s-profile-meta">{{ $user?->email }}</p>
                    <p class="s-profile-meta">
                        Member since {{ $user?->created_at?->translatedFormat('M j, Y') }}
                    </p>
                </div>
            </div>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">
                Password Security
            </x-slot>

            <x-slot name="description">
                Update your password using the steps below.
            </x-slot>

            <div class="s-password-flow">
                <div class="s-password-steps" aria-label="Password change steps">
                    <div @class(['s-password-step', 'is-active' => ! $otpSent && ! $otpVerified, 'is-complete' => $otpSent || $otpVerified])>
                        <span class="s-password-step__number">1</span>
                        <span>Send Code</span>
                    </div>

                    <div @class(['s-password-step', 'is-active' => $otpSent && ! $otpVerified, 'is-complete' => $otpVerified])>
                        <span class="s-password-step__number">2</span>
                        <span>Verify Code</span>
                    </div>

                    <div @class(['s-password-step', 'is-active' => $otpVerified])>
                        <span class="s-password-step__number">3</span>
                        <span>Update Password</span>
                    </div>
                </div>

                @if (! $otpSent && ! $otpVerified)
                    <div class="s-profile-panel">
                        <h3 class="s-profile-panel__title">Verification Required</h3>
                        <p class="s-profile-panel__text">A verification code will be sent to your email address on file.</p>
                    </div>

                    <div class="s-profile-actions">
                        <x-filament::button wire:click="sendOtp" wire:loading.attr="disabled" wire:target="sendOtp" color="primary">
                            Send Verification Code
                        </x-filament::button>
                    </div>
                @endif

                @if ($otpSent && ! $otpVerified)
                    <div class="s-profile-panel">
                        <h3 class="s-profile-panel__title">Check Your Email</h3>
                        <p class="s-profile-panel__text">Enter the 6-digit verification code sent to your email.</p>
                    </div>

                    <div class="s-profile-field-grid">
                        <div>
                            <label class="s-profile-field-label" for="otpInput">Verification Code</label>
                            <x-filament::input.wrapper>
                                <x-filament::input
                                    id="otpInput"
                                    type="text"
                                    inputmode="numeric"
                                    wire:model="otpInput"
                                    maxlength="6"
                                    placeholder="000000"
                                />
                            </x-filament::input.wrapper>
                            @error('otpInput')
                                <p class="mt-2 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="s-profile-actions">
                        <x-filament::button wire:click="verifyOtp" wire:loading.attr="disabled" wire:target="verifyOtp" color="primary">
                            Verify Code
                        </x-filament::button>

                        <x-filament::button wire:click="sendOtp" wire:loading.attr="disabled" wire:target="sendOtp" color="gray">
                            Resend Code
                        </x-filament::button>
                    </div>
                @endif

                @if ($otpVerified)
                    <div class="s-profile-panel">
                        <h3 class="s-profile-panel__title">Code Verified</h3>
                        <p class="s-profile-panel__text">Enter your new password below.</p>
                    </div>

                    <div class="s-profile-field-grid">
                        <div>
                            <label class="s-profile-field-label" for="newPassword">New Password</label>
                            <x-filament::input.wrapper>
                                <x-filament::input
                                    id="newPassword"
                                    type="password"
                                    wire:model="newPassword"
                                    autocomplete="new-password"
                                />
                            </x-filament::input.wrapper>
                            @error('newPassword')
                                <p class="mt-2 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="s-profile-field-label" for="newPasswordConfirmation">Confirm New Password</label>
                            <x-filament::input.wrapper>
                                <x-filament::input
                                    id="newPasswordConfirmation"
                                    type="password"
                                    wire:model="newPasswordConfirmation"
                                    autocomplete="new-password"
                                />
                            </x-filament::input.wrapper>
                        </div>
                    </div>

                    <div class="s-profile-actions">
                        <x-filament::button wire:click="save" wire:loading.attr="disabled" wire:target="save" color="primary">
                            Save Password
                        </x-filament::button>

                        <x-filament::button wire:click="restartPasswordChange" color="gray">
                            Restart
                        </x-filament::button>
                    </div>
                @endif
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
