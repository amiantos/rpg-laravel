<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="mb-5 font-extrabold text-2xl">Characters</h1>
                    @foreach ($characters as $character)
                        <x-character-card :character="$character" />
                    @endforeach

                    <div x-data="{ show: true }">
                        <div @click="show = !show" class='bg-gray-100 p-5 font-extrabold'>
                            ➕&nbsp;&nbsp;Create Character
                        </div>
                        <div x-show="show" class="bg-gray-100 p-5 pt-2">
                            <form method="POST" action="{{url('character-form')}}">
                                @csrf
                                <div class="flex items-center">
                                    <input id="name" name="name" type="text" placeholder="Character Name" class='w-full mr-5'/>
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
