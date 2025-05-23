<x-app-layout>
    <div class="flex justify-center mt-10">
        <div class="w-full max-w-md">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="post"
                action="{{ route('categories.store') }}">
                @csrf

                <p class="text-3xl font-black text-blue-500 text-center">New Category</p>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        Name
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="name" name="name" type="text" placeholder="Name" value="{{ old('name') }}">
                    @error('name')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Color:</label>
                    <!-- Button để hiển thị Pickr -->
                    <button type="button" id="color-picker-btn"
                        class="w-full border border-gray-300 rounded px-3 py-2 text-left">
                        Select color
                    </button>
                    <!-- Input ẩn để lưu giá trị màu gửi về Laravel -->
                    <input type="hidden" name="color" id="selected-color" />
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const pickr = Pickr.create({
            el: '#color-picker-btn',
            theme: 'classic',
            default: '#3490dc',
            components: {
                preview: true,
                opacity: true,
                hue: true,
                interaction: {
                    hex: true,
                    rgba: true,
                    input: true,
                    save: true
                }
            }
        });

        pickr.on('save', (color) => {
            const hex = color.toHEXA().toString();
            document.getElementById('selected-color').value = hex;
            document.getElementById('color-picker-btn').style.backgroundColor = hex;
            pickr.hide(); // Ẩn picker sau khi chọn
        });
    });
</script>
