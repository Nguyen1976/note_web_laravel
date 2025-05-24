<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8"> Categories Listing</h1>

        <!-- Search and Add User (Static) -->
        <div class="flex flex-col md:flex-row justify-end items-center mb-6">
            {{-- <div class="w-full md:w-1/3 mb-4 md:mb-0">
                <input type="text" placeholder="Search users..."
                    class="w-full px-4 py-2 rounded-md border border-gray-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div> --}}
            <button class="mr-2 text-white bg-blue-500 py-2 px-3 rounded-full">
                <a href="{{ route('categories.create') }}">
                    Add Category
                </a>
            </button>

        </div>

        <!-- User Table -->
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Name</th>
                        <th class="py-3 px-6 text-left">Color</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    @foreach ($categories as $category)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left">{{ $category->name }}</td>
                            <td class="py-3 px-6 text-left">
                                <button class="w-5 h-5 rounded-md" style="background: {{ $category->color }}"></button>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    <button class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110">
                                        <a href="{{ route('categories.edit', $category->id) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                    </button>

                                    {{-- Model xóa begin --}}
                                    <div x-data="{ showModal: false }" class="flex items-center">
                                        <button class="w-4 mr-2 transform hover:text-red-500 hover:scale-110"
                                            @click="showModal = true">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                        <div class="relative z-10" aria-labelledby="modal-title" role="dialog"
                                            aria-modal="true" x-show="showModal">

                                            <div class="fixed inset-0 bg-gray-500/75 transition-opacity"
                                                aria-hidden="true">
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
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                                                    </svg>
                                                                </div>
                                                                <div
                                                                    class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                                    <h3 class="text-base font-semibold text-gray-900"
                                                                        id="modal-title">
                                                                        Delete category</h3>
                                                                    <div class="mt-2">
                                                                        <p class="text-sm text-gray-500">Are you sure
                                                                            you want
                                                                            to deactivate your account? All of your data
                                                                            will be
                                                                            permanently removed. This action cannot be
                                                                            undone.
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                                            <form
                                                                action="{{ route('categories.destroy', $category->id) }}"
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
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Static Pagination -->
        {{-- <div class="flex justify-between items-center mt-6">
            <div>
                <span class="text-sm text-gray-700">
                    Showing 1 to 5 of 5 entries
                </span>
            </div>
            <div class="flex space-x-2">
                <a href="https://abhirajk.vercel.app/" target="blank">

                    <button class="px-3 py-1 rounded-md bg-gray-200 text-gray-700 opacity-50">
                        Previous
                    </button>
                </a>
                <a href="https://abhirajk.vercel.app/" target="blank">

                    <button class="px-3 py-1 rounded-md bg-gray-200 text-gray-700 opacity-50">
                        Next
                    </button>
                </a>
            </div>
        </div> --}}
    </div>
</x-app-layout>
