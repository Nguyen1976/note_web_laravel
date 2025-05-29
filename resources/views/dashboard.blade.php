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
    {{-- 
    @include('components.categories', ['categories' => $categories])
    @include('components.notes', ['notes' => $notes]) --}}
    <div class="mx-2 xl:px-36 sm:px-6 px-4 ">
        <div class="bg-white border-gray-200 rounded-xl shadow-xl mt-4 p-3 flex justify-between items-center">
            <ul class="flex justify-around gap-5 items-center">
                <li class="px-3 py-2 rounded-xl category-item" data-id="all" data-color="#3b82f6">
                    All Notes
                </li>
                @foreach ($categories as $category)
                    <li class="px-3 py-3 rounded-xl flex items-center gap-3 category-item" data-id="{{ $category->id }}"
                        data-color="{{ $category->color }}">
                        {{ $category->name }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="container py-20 xl:px-36 sm:px-6 px-6">
        <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 gap-6" id="notes-container">

        </div>
    </div>

</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', function() { // Đảm bảo DOM đã tải
        const categoryItems = document.querySelectorAll('.category-item');
        const notesContainer = document.getElementById('notes-container');
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute(
            'content'); // Lấy CSRF token

        function activateCategory(selectedItem) {
            categoryItems.forEach(item => {
                const color = item.getAttribute('data-color');
                const isSelected = (item === selectedItem);

                item.style.backgroundColor = isSelected ? color : 'transparent';
                item.style.color = isSelected ? 'white' :
                    color; // Giả sử màu chữ mặc định là màu của category
                // Hoặc bạn có thể đặt màu chữ mặc định khác
                if (!isSelected && !item.style.color) { // Nếu màu category rỗng, đặt màu chữ mặc định
                    item.style.color = '#333'; // Ví dụ màu xám đậm
                }
            });
        }

        function displayNotes(notesData) {
            let html = ''; // Sử dụng let thay vì const
            (notesData || []).forEach(note => {
                const categoryColor = note.category ? note.category.color :
                    '#333333'; // Màu mặc định nếu không có category
                const reminderHtml = note.reminder ? `
                <div class="border border-gray-300 rounded-full px-3 py-1 text-xs flex items-center"
                     aria-label="due on" role="contentinfo"
                     style="border-color: ${categoryColor}; color: ${categoryColor}">
                    <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/4-by-3-multiple-styled-cards-svg2.svg"
                         alt="clock" class="mr-1 w-4 h-4" />
                    <p class="ml-1">
                        ${new Date(note.reminder.reminder_at).toLocaleString('en-US', {
                            month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
                        })}
                    </p>
                </div>
            ` : '';

                html += `
            <div class="w-full h-64 flex flex-col justify-between bg-white rounded-lg border mb-6 py-5 px-4 shadow-md note-card-item">
                <div class="border-l-2 pl-3 ml-1" style="border-color: ${categoryColor};">
                    <h4 class="font-bold mb-3 text-gray-800">${note.title}</h4>
                    <p class="text-sm text-gray-600">${note.content ? note.content.substring(0, 100) + (note.content.length > 100 ? '...' : '') : ''}</p>
                </div>
                <div>
                    <div class="mb-3 flex items-center">
                        ${reminderHtml}
                    </div>
                    <div class="flex items-center justify-between" style="color: ${categoryColor}">
                        <p class="text-xs">
                            ${new Date(note.created_at).toLocaleString('en-US', {
                                month: 'short', day: 'numeric', year: 'numeric'//, hour: '2-digit', minute: '2-digit'
                            })}
                        </p>
                        <div class="flex items-center justify-center gap-3">
                            <div x-data="{ showModal: false }" @keydown.escape.window="showModal = false">
                                <button @click="showModal = true" aria-label="Delete note" class="text-gray-500 hover:text-red-500">
                                    {{-- SVG trash icon (bạn cần đặt SVG của bạn vào đây) --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                </button>
                                <div class="relative z-50" aria-labelledby="modal-title" role="dialog"
                                     aria-modal="true" x-show="showModal" x-cloak
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                     x-transition:leave="transition ease-in duration-200"
                                     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="showModal = false"></div>
                                    <div class="fixed inset-0 z-50 w-screen overflow-y-auto">
                                        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                                            <div @click.stop class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                    <div class="sm:flex sm:items-start">
                                                        <div class="mx-auto flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:size-10">
                                                            {{-- SVG warning icon (bạn cần đặt SVG của bạn vào đây) --}}
                                                             <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                                                        </div>
                                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                            <h3 class="text-base font-semibold text-gray-900" id="modal-title">Delete note?</h3>
                                                            <div class="mt-2">
                                                                <p class="text-sm text-gray-500">Are you sure you want to delete this note? This action cannot be undone.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                                    <form action="/notes/${note.id}" method="post" class="inline-block">
                                                        ${csrfToken ? `<input type="hidden" name="_token" value="${csrfToken}">` : ''}
                                                        <input type="hidden" name="_method" value="DELETE"> {{-- Giả định dùng Route::delete --}}
                                                        <button type="submit"
                                                                class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Delete</button>
                                                    </form>
                                                    <button type="button" @click="showModal = false"
                                                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="/notes/${note.id}/edit" aria-label="Edit note" class="text-gray-500 hover:text-blue-500">
                                {{-- SVG edit icon (bạn cần đặt SVG của bạn vào đây) --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>`;
            });
            notesContainer.innerHTML = html;

            if (window.Alpine) {
                notesContainer.querySelectorAll('[x-data]').forEach(el => {
                    if (!el._x_dataStack) {
                        window.Alpine.initTree(el);
                    }
                });
            }
        }

        categoryItems.forEach(item => {
            item.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-id');
                activateCategory(this);

                notesContainer.innerHTML =
                    '<p class="fixed left-0 right-0 translate-x-1/2"><img src="https://res.cloudinary.com/dcnfkcsln/image/upload/v1748531580/Infinity_1x-1.0s-200px-200px_1_iuv0sf.gif" class="h-20 w-20" alt=""></p>';

                fetch(`/notes/category/${categoryId}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin'
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.text().then(text => {
                                throw new Error(
                                    `Server error: ${response.status} ${response.statusText} - ${text}`
                                );
                            })
                        }
                        return response.json();
                    })
                    .then(data => {
                        displayNotes(data.notes ||
                            data
                        ); // Giả sử data trả về có dạng { notes: [...] } hoặc trực tiếp là [...]
                    })
                    .catch(error => {
                        console.error('Error fetching notes:', error);
                        notesContainer.innerHTML =
                            `<p class="text-center text-red-500">Failed to load notes. ${error.message}</p>`;
                    });
            });
        });

        // Tự động click vào category đầu tiên (hoặc 'All Notes') khi trang tải xong
        const firstCategoryItem = document.querySelector('.category-item[data-id="all"]') || document
            .querySelector('.category-item');
        if (firstCategoryItem) {
            firstCategoryItem.click();
        }
    });
</script>
