<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Playing as ' . $character->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <livewire:floor-map :all_rooms="$all_rooms" :current_room="$room" />
                    <livewire:character-panel :character="$character" />
                    <livewire:room-panel :room="$room" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>