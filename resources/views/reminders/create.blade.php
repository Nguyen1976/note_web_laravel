<x-app-layout>
    <div class="flex justify-center mt-10">
        <div class="w-full max-w-md">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="post"
                action="{{ route('reminders.store') }}">
                @csrf

                <p class="text-3xl font-black text-blue-500 text-center">New Reminder</p>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="reminder_at">
                        Date Time
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="reminder_at" name="reminder_at" type="datetime-local" placeholder="reminder_at"
                        value="{{ old('reminder_at') }}">
                    @error('reminder_at')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="note_id" class="block text-gray-700 text-sm font-bold mb-2">Chọn nhiều ghi chú</label>

                    <select id="note_id" name="note_id[]" multiple
                        data-hs-select='{
                            "placeholder": "Chọn nhiều ghi chú...",
                            "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                            "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-hidden focus:ring-2 focus:ring-blue-500",
                            "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300",
                            "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100",
                            "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                            "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                        }'
                        class="hidden">
                        @foreach ($notes as $note)
                            <option value="{{ $note->id }}"
                                {{ collect(old('note_id'))->contains($note->id) ? 'selected' : '' }}>
                                {{ $note->title }}
                            </option>
                        @endforeach
                    </select>

                    @error('note_id')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>




                <div class="flex items-center justify-between">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Create Reminder
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
