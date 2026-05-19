<x-filament::page>

    @if (! $this->accessGranted)

        <div class="max-w-md mx-auto mt-10">

            <x-filament::section>

                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold">
                        Archive Access
                    </h2>

                    <p class="text-sm text-gray-500 mt-2">
                        Please enter the archive password.
                    </p>
                </div>

                <div class="space-y-4">

                    <x-filament::input.wrapper>
                        <x-filament::input
                            type="password"
                            wire:model.defer="archivePassword"
                        />
                    </x-filament::input.wrapper>

                    <x-filament::button
                        wire:click="verifyPassword"
                        class="w-full"
                    >
                        Access Archive
                    </x-filament::button>

                </div>

            </x-filament::section>

        </div>

    @endif

    @if ($this->accessGranted)

        {{ $this->table }}

    @endif

</x-filament::page>
