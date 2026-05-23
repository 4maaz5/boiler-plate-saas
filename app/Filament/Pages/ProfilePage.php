<?php

namespace App\Filament\Pages;

use App\Notifications\PasswordChangeOtp;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Pages\PageConfiguration;
use Filament\Panel;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfilePage extends Page
{
    protected string $view = 'filament.pages.profile-page';

    protected static bool $isDiscovered = false;

    public bool $otpSent = false;

    public bool $otpVerified = false;

    public string $otpInput = '';

    public string $newPassword = '';

    public string $newPasswordConfirmation = '';

    public static function getLabel(): string
    {
        return __('custom.profile');
    }

    public function getTitle(): string | Htmlable
    {
        return static::getLabel();
    }

    public static function getSlug(?Panel $panel = null): string
    {
        return 'profile';
    }

    public static function registerRoutes(Panel $panel, ?PageConfiguration $configuration = null): void
    {
        static::routes($panel, $configuration);
    }

    public static function getRelativeRouteName(Panel $panel): string
    {
        return 'profile';
    }

    public static function getRouteName(?Panel $panel = null): string
    {
        $panel ??= Filament::getCurrentOrDefaultPanel();

        return $panel->generateRouteName('auth.' . static::getRelativeRouteName($panel));
    }

    public static function isTenantSubscriptionRequired(Panel $panel): bool
    {
        return false;
    }

    public function sendOtp(): void
    {
        $user = Filament::auth()->user();
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Cache::put('password_otp_' . $user->getKey(), $code, now()->addMinutes(10));

        $user->notify(new PasswordChangeOtp($code));

        $this->otpSent = true;
        $this->otpVerified = false;
        $this->otpInput = '';
        $this->newPassword = '';
        $this->newPasswordConfirmation = '';

        Notification::make()
            ->success()
            ->title(__('custom.otp_sent'))
            ->send();
    }

    public function verifyOtp(): void
    {
        $this->validate([
            'otpInput' => ['required', 'string', 'regex:/^[0-9]{6}$/'],
        ], attributes: [
            'otpInput' => __('custom.otp_code'),
        ]);

        $user = Filament::auth()->user();
        $cached = Cache::get('password_otp_' . $user->getKey());

        if (! $cached || $cached !== $this->otpInput) {
            Notification::make()
                ->danger()
                ->title(__('custom.otp_invalid'))
                ->send();

            return;
        }

        Cache::forget('password_otp_' . $user->getKey());

        $this->otpVerified = true;
        $this->otpSent = false;
        $this->otpInput = '';

        Notification::make()
            ->success()
            ->title(__('custom.otp_verified'))
            ->send();
    }

    public function save(): void
    {
        if (! $this->otpVerified) {
            Notification::make()
                ->danger()
                ->title(__('custom.verification_required'))
                ->send();

            return;
        }

        $this->validate([
            'newPassword' => ['required', 'string', Password::default(), 'confirmed:newPasswordConfirmation'],
        ], attributes: [
            'newPassword' => __('custom.new_password'),
            'newPasswordConfirmation' => __('custom.confirm_password'),
        ]);

        $user = Filament::auth()->user();
        $user->update([
            'password' => Hash::make($this->newPassword),
        ]);

        $this->otpVerified = false;
        $this->otpSent = false;
        $this->otpInput = '';
        $this->newPassword = '';
        $this->newPasswordConfirmation = '';

        Notification::make()
            ->success()
            ->title(__('custom.password_updated'))
            ->send();
    }

    public function restartPasswordChange(): void
    {
        $this->otpVerified = false;
        $this->otpSent = false;
        $this->otpInput = '';
        $this->newPassword = '';
        $this->newPasswordConfirmation = '';
    }
}
