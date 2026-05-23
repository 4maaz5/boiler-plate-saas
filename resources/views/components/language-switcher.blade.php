@php
    $currentLocale = app()->getLocale();
    $locales = [
        'en' => 'EN',
        'ar' => 'AR',
    ];
@endphp

@once
    <style>
        .app-language-switcher {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px;
            border: 1px solid rgba(148, 163, 184, 0.35);
            border-radius: 999px;
            background: rgba(248, 250, 252, 0.92);
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.08);
        }

        .app-language-switcher__item {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 42px;
            min-height: 30px;
            padding: 0 12px;
            border-radius: 999px;
            color: rgb(71, 85, 105);
            font-size: 12px;
            font-weight: 700;
            line-height: 1;
            text-decoration: none;
            transition: background-color 150ms ease, color 150ms ease, box-shadow 150ms ease;
        }

        .app-language-switcher__item:hover {
            background: white;
            color: rgb(15, 23, 42);
        }

        .app-language-switcher__item[aria-current="true"] {
            color: white;
            background: var(--primary-600);
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.18);
        }

        .dark .app-language-switcher {
            border-color: rgba(148, 163, 184, 0.22);
            background: rgba(15, 23, 42, 0.65);
        }

        .dark .app-language-switcher__item {
            color: rgb(203, 213, 225);
        }

        .dark .app-language-switcher__item:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
        }
    </style>
@endonce

<div class="app-language-switcher">
    @foreach ($locales as $locale => $label)
        <a
            href="{{ route('locale.switch', $locale) }}"
            title="{{ __('custom.language_switcher_label') }}: {{ __($locale === 'en' ? 'custom.english' : 'custom.arabic') }}"
            class="app-language-switcher__item"
            @if ($currentLocale === $locale) aria-current="true" @endif
        >
            {{ $label }}
        </a>
    @endforeach
</div>
