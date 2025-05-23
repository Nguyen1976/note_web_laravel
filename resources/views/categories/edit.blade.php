<x-app-layout>
    <div class="flex justify-center mt-10">
        <div class="w-full max-w-md">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="post"
                action="{{ route('categories.update', $category->id) }}">
                @csrf
                @method('PUT')

                <p class="text-3xl font-black text-blue-500 text-center">Update Category</p>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        Name
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="name" name="name" type="text" placeholder="Name"
                        value="{{ old('name', $category->name) }}">
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
                    <input type="hidden" name="color" id="selected-color"
                        value="{{ old('color', $category->color ?? '#3490dc') }}" />
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const initialColor = document.getElementById('selected-color').value;
        const colorPickerButton = document.getElementById('color-picker-btn');

        if (initialColor) {
            colorPickerButton.style.backgroundColor = initialColor;
           
        }

        const pickr = Pickr.create({
            el: '#color-picker-btn',
            theme: 'classic',
            default: initialColor,
            swatches: [ 
                'rgba(244, 67, 54, 1)',
                'rgba(233, 30, 99, 1)',
                'rgba(156, 39, 176, 1)',
                'rgba(103, 58, 183, 1)',
                'rgba(63, 81, 181, 1)',
                'rgba(33, 150, 243, 1)',
                'rgba(3, 169, 244, 1)',
                'rgba(0, 188, 212, 1)',
                'rgba(0, 150, 136, 1)',
                'rgba(76, 175, 80, 1)',
                'rgba(139, 195, 74, 1)',
                'rgba(205, 220, 57, 1)',
                'rgba(255, 235, 59, 1)',
                'rgba(255, 193, 7, 1)'
            ],

            components: {
                preview: true,
                opacity: true,
                hue: true,

                interaction: {
                    hex: true,
                    rgba: true,
                    input: true,
                    clear: false, 
                    save: true
                }
            },
            strings: {
                save: 'Apply', 
                clear: 'Clear selection',
            }
        });

        pickr.on('save', (color, instance) => {
            const hexColor = color ? color.toHEXA().toString() :
            ''; 
            document.getElementById('selected-color').value = hexColor;
            colorPickerButton.style.backgroundColor = hexColor ||
            'transparent'; 
        });

       
    });
</script>
