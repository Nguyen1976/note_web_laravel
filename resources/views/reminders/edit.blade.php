<x-app-layout>
    <div class="flex justify-center mt-10">
        <div class="w-full max-w-md">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="post"
                action="{{ route('reminders.update', $reminder->id) }}">
                @csrf
                @method('PUT')

                <p class="text-3xl font-black text-blue-500 text-center">Update Reminder</p>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="reminder_at">
                        Date Time
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="reminder_at" name="reminder_at" type="datetime-local" placeholder="reminder_at"
                        value="{{ old('reminder_at', $reminder->reminder_at) }}">
                    @error('reminder_at')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Update Reminder
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
