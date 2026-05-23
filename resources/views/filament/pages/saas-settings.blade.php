<x-filament-panels::page>
    {{ $this->form }}

    <div style="margin-top: 8px; display: flex; justify-content: flex-end;">
        <x-filament::button wire:click="save" color="primary">
            Save Settings
        </x-filament::button>
    </div>
</x-filament-panels::page>
