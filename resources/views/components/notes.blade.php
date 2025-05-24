<div class="mx-auto container py-20 px-6">
    <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 gap-6">
        @foreach ($notes as $note)
            <div class="w-full h-64 flex flex-col justify-between bg-white rounded-lg border mb-6 py-5 px-4">
                <div class="border-l-2 pl-3 ml-1"
                    style="border-color: {{ $note->category ? $note->category->color : 'black' }}; color: {{ $note->category ? $note->category->color : 'black' }}">
                    <h4 class="font-bold mb-3">{{ $note->title }}</h4>
                    <p class="text-sm">{{ $note->content }}</p>
                </div>
                <div>
                    <div class="mb-3 flex items-center">
                        {{-- Reminder begin --}}
                        @if ($note->reminder)
                            <div class="border border-gray-300 rounded-full px-3 py-1 text-xs flex items-center"
                                aria-label="due on" role="contentinfo"
                                style="border-color: {{ $note->category ? $note->category->color : 'black' }}; color: {{ $note->category ? $note->category->color : 'black' }}">
                                <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/4-by-3-multiple-styled-cards-svg2.svg"
                                    alt="clock" />
                                <p class="ml-2">
                                    {{ $note->reminder->reminder_at->locale('en')->translatedFormat('F j, H:i') }}</p>
                            </div>
                        @endif
                        {{-- Reminder end --}}
                        {{-- <button class="p-1 rounded-full ml-2" aria-label="save in starred items" role="button">
                            <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/4-by-3-multiple-styled-cards-svg3.svg"
                                alt="star" />
                        </button> --}}
                    </div>
                    <div class="flex items-center justify-between"
                        style="color: {{ $note->category ? $note->category->color : 'black' }}">
                        <p class="text-sm">{{ $note->created_at->locale('en')->translatedFormat('F j, Y') }}</p>
                        <div class="flex items-center justify-center gap-3">

                            {{-- Model xóa begin --}}
                            <div x-data="{ showModal: false }">
                                <button @click="showModal = true">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                                <div class="relative z-10" aria-labelledby="modal-title" role="dialog"
                                    aria-modal="true" x-show="showModal">

                                    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true">
                                    </div>

                                    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                                        <div
                                            class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

                                            <div
                                                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                    <div class="sm:flex sm:items-start">
                                                        <div
                                                            class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                                                            <svg class="size-6 text-red-600" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" aria-hidden="true"
                                                                data-slot="icon">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                                            </svg>
                                                        </div>
                                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                            <h3 class="text-base font-semibold text-gray-900"
                                                                id="modal-title">Delete note?</h3>
                                                            <div class="mt-2">
                                                                <p class="text-sm text-gray-500">Are you sure you want
                                                                    to delete this note? This action is permanent and
                                                                    cannot be undone.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                                    <form action="{{ route('notes.destroy', $note->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 sm:ml-3 sm:w-auto">Delete</button>
                                                        <button type="button" @click="showModal = false"
                                                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs ring-1 ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Model xóa end --}}

                            <button
                                class="w-8 h-8 rounded-full text-white flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-offset-2  focus:ring-black"
                                aria-label="edit note" role="button"
                                style="background: {{ $note->category ? $note->category->color : 'black' }}">
                                <a href="{{ route('notes.edit', ['note' => $note->id]) }}">
                                    <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/4-by-3-multiple-styled-cards-svg1.svg"
                                        alt="edit" />
                                </a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
