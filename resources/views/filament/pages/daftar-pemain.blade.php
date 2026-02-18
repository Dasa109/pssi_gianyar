<x-filament-panels::page>
    {{-- Tab Navigation with counts --}}
    <x-filament::tabs>
        <x-filament::tabs.item
            :active="$activeTab === 'official'"
            wire:click="$set('activeTab', 'official')"
            icon="heroicon-o-shield-check"
        >
            Pemain Official ({{ $this->getStats()['official'] }})
        </x-filament::tabs.item>

        <x-filament::tabs.item
            :active="$activeTab === 'pending'"
            wire:click="$set('activeTab', 'pending')"
            icon="heroicon-o-clock"
        >
            Menunggu Verifikasi ({{ $this->getStats()['pending'] }})
        </x-filament::tabs.item>

        <x-filament::tabs.item
            :active="$activeTab === 'rejected'"
            wire:click="$set('activeTab', 'rejected')"
            icon="heroicon-o-x-circle"
        >
            Ditolak / Kurang ({{ $this->getStats()['rejected'] }})
        </x-filament::tabs.item>
    </x-filament::tabs>

    {{-- Table Content --}}
    <div class="mt-6">
        {{ $this->table }}
    </div>
</x-filament-panels::page>