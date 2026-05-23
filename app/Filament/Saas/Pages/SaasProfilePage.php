<?php

namespace App\Filament\Saas\Pages;

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

class SaasProfilePage extends Page
{
    protected string $view = 'filament.pages.saas-profile-page';

    protected static bool $isDiscovered = false;

    public bool $otpSent = false;

    public bool $otpVerified = false;

    public string $otpInput = '';

    public string $newPassword = '';

    public string $newPasswordConfirmation = '';

    public static function getLabel(): string
    {
        return 'Profile';
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

        Cache::put('saas_password_otp_' . $user->getKey(), $code, now()->addMinutes(10));

        $user->notify(new PasswordChangeOtp($code));

        $this->otpSent = true;
        $this->otpVerified = false;
        $this->otpInput = '';
        $this->newPassword = '';
        $this->newPasswordConfirmation = '';

        Notification::make()
            ->success()
            ->title('Verification code sent to your email')
            ->send();
    }

    public function verifyOtp(): void
    {
        $this->validate([
            'otpInput' => ['required', 'string', 'regex:/^[0-9]{6}$/'],
        ], attributes: [
            'otpInput' => 'verification code',
        ]);

        $user = Filament::auth()->user();
        $cached = Cache::get('saas_password_otp_' . $user->getKey());

        if (! $cached || $cached !== $this->otpInput) {
            Notification::make()
                ->danger()
                ->title('Invalid verification code')
                ->send();

            return;
        }

        Cache::forget('saas_password_otp_' . $user->getKey());

        $this->otpVerified = true;
        $this->otpSent = false;
        $this->otpInput = '';

        Notification::make()
            ->success()
            ->title('Code verified successfully')
            ->send();
    }

    public function save(): void
    {
        if (! $this->otpVerified) {
            Notification::make()
                ->danger()
                ->title('Verification required')
                ->send();

            return;
        }

        $this->validate([
            'newPassword' => ['required', 'string', Password::default(), 'confirmed:newPasswordConfirmation'],
        ], attributes: [
            'newPassword' => 'new password',
            'newPasswordConfirmation' => 'confirm password',
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
            ->title('Password updated successfully')
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
