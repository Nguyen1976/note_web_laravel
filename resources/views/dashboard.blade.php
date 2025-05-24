<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div class="flex items-center justify-between">
                <button class="mr-2 text-white bg-blue-500 py-2 px-3 rounded-full">
                    <a href="{{ route('notes.create') }}">
                        Add Note
                    </a>
                </button>
            </div>
        </div>
    </x-slot>

    @include('components.categories', ['categories' => $categories, 'categoryActive' => $categoryActive])
    @include('components.notes', ['notes' => $notes])
</x-app-layout>
