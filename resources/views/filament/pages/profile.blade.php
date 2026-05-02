<x-filament::page>

    <x-filament::section
        heading="Profile Information"
        description="Update your account details"
    >
        {{ $this->form }}
    </x-filament::section>

    <div class="flex justify-end mt-4">
        <x-filament::button wire:click="update" size="lg">
            Save Changes
        </x-filament::button>
    </div>

</x-filament::page>
