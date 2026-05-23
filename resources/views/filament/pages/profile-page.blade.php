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
            .profile-layout {
                display: grid;
                gap: 20px;
            }

            .profile-summary {
                display: flex;
                align-items: center;
                gap: 16px;
            }

            .profile-avatar {
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

            .profile-title {
                margin: 0;
                color: rgb(15, 23, 42);
                font-size: 18px;
                font-weight: 700;
                line-height: 1.25;
            }

            .profile-meta {
                margin: 4px 0 0;
                color: rgb(100, 116, 139);
                font-size: 14px;
                line-height: 1.45;
            }

            .password-flow {
                display: grid;
                gap: 18px;
            }

            .password-steps {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 10px;
            }

            .password-step {
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

            .password-step__number {
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

            .password-step.is-active {
                border-color: color-mix(in srgb, var(--primary-500) 58%, transparent);
                color: rgb(15, 23, 42);
                background: color-mix(in srgb, var(--primary-50) 85%, white);
            }

            .password-step.is-active .password-step__number,
            .password-step.is-complete .password-step__number {
                background: var(--primary-600);
                color: white;
                box-shadow: none;
            }

            .password-step.is-complete {
                color: var(--primary-700);
            }

            .profile-panel {
                border: 1px solid rgba(148, 163, 184, 0.24);
                border-radius: 14px;
                padding: 16px;
                background: rgba(248, 250, 252, 0.64);
            }

            .profile-panel__title {
                margin: 0;
                color: rgb(15, 23, 42);
                font-size: 15px;
                font-weight: 700;
            }

            .profile-panel__text {
                margin: 6px 0 0;
                color: rgb(100, 116, 139);
                font-size: 14px;
                line-height: 1.55;
            }

            .profile-field-grid {
                display: grid;
                gap: 14px;
            }

            .profile-field-label {
                display: block;
                margin-bottom: 6px;
                color: rgb(51, 65, 85);
                font-size: 13px;
                font-weight: 650;
            }

            .profile-actions {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                gap: 10px;
            }

            .dark .profile-title,
            .dark .profile-panel__title,
            .dark .password-step.is-active,
            .dark .profile-field-label {
                color: rgb(248, 250, 252);
            }

            .dark .profile-meta,
            .dark .profile-panel__text {
                color: rgb(148, 163, 184);
            }

            .dark .password-step,
            .dark .profile-panel {
                border-color: rgba(148, 163, 184, 0.18);
                background: rgba(15, 23, 42, 0.32);
            }

            .dark .password-step__number {
                background: rgba(15, 23, 42, 0.7);
                color: rgb(203, 213, 225);
                box-shadow: inset 0 0 0 1px rgba(148, 163, 184, 0.26);
            }

            .dark .password-step.is-active {
                background: color-mix(in srgb, var(--primary-900) 36%, rgba(15, 23, 42, 0.54));
            }

            @media (max-width: 640px) {
                .profile-summary {
                    align-items: flex-start;
                }

                .password-steps {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    @endonce

    <div class="profile-layout">
        <x-filament::section>
            <div class="profile-summary">
                <div class="profile-avatar" aria-hidden="true">
                    {{ $initials }}
                </div>

                <div>
                    <h2 class="profile-title">{{ $user?->name }}</h2>
                    <p class="profile-meta">{{ $user?->email }}</p>
                    <p class="profile-meta">
                        @lang('custom.member_since')
                        {{ $user?->created_at?->translatedFormat('M j, Y') }}
                    </p>
                </div>
            </div>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">
                @lang('custom.password_security')
            </x-slot>

            <x-slot name="description">
                @lang('custom.password_security_description')
            </x-slot>

            <div class="password-flow">
                <div class="password-steps" aria-label="@lang('custom.password_change')">
                    <div @class(['password-step', 'is-active' => ! $otpSent && ! $otpVerified, 'is-complete' => $otpSent || $otpVerified])>
                        <span class="password-step__number">1</span>
                        <span>@lang('custom.send_otp')</span>
                    </div>

                    <div @class(['password-step', 'is-active' => $otpSent && ! $otpVerified, 'is-complete' => $otpVerified])>
                        <span class="password-step__number">2</span>
                        <span>@lang('custom.verify_otp')</span>
                    </div>

                    <div @class(['password-step', 'is-active' => $otpVerified])>
                        <span class="password-step__number">3</span>
                        <span>@lang('custom.update_password')</span>
                    </div>
                </div>

                @if (! $otpSent && ! $otpVerified)
                    <div class="profile-panel">
                        <h3 class="profile-panel__title">@lang('custom.verification_required')</h3>
                        <p class="profile-panel__text">@lang('custom.verification_required_description')</p>
                    </div>

                    <div class="profile-actions">
                        <x-filament::button wire:click="sendOtp" wire:loading.attr="disabled" wire:target="sendOtp" color="primary">
                            @lang('custom.send_otp')
                        </x-filament::button>
                    </div>
                @endif

                @if ($otpSent && ! $otpVerified)
                    <div class="profile-panel">
                        <h3 class="profile-panel__title">@lang('custom.otp_code')</h3>
                        <p class="profile-panel__text">@lang('custom.otp_code_description')</p>
                    </div>

                    <div class="profile-field-grid">
                        <div>
                            <label class="profile-field-label" for="otpInput">@lang('custom.otp_code')</label>
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

                    <div class="profile-actions">
                        <x-filament::button wire:click="verifyOtp" wire:loading.attr="disabled" wire:target="verifyOtp" color="primary">
                            @lang('custom.verify_otp')
                        </x-filament::button>

                        <x-filament::button wire:click="sendOtp" wire:loading.attr="disabled" wire:target="sendOtp" color="gray">
                            @lang('custom.resend_code')
                        </x-filament::button>
                    </div>
                @endif

                @if ($otpVerified)
                    <div class="profile-panel">
                        <h3 class="profile-panel__title">@lang('custom.otp_verified')</h3>
                        <p class="profile-panel__text">@lang('custom.new_password_description')</p>
                    </div>

                    <div class="profile-field-grid">
                        <div>
                            <label class="profile-field-label" for="newPassword">@lang('custom.new_password')</label>
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
                            <label class="profile-field-label" for="newPasswordConfirmation">@lang('custom.confirm_password')</label>
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

                    <div class="profile-actions">
                        <x-filament::button wire:click="save" wire:loading.attr="disabled" wire:target="save" color="primary">
                            @lang('custom.save_password')
                        </x-filament::button>

                        <x-filament::button wire:click="restartPasswordChange" color="gray">
                            @lang('custom.restart_password_change')
                        </x-filament::button>
                    </div>
                @endif
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
