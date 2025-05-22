<div class="mx-2">
    <div class="bg-white border-gray-200 rounded-xl shadow-xl mt-4 p-3 flex justify-between items-center">
        <ul class="flex justify-around gap-5 items-center">
            <li
                class="{{ is_null($categoryActive) ? 'bg-blue-500 text-white' : 'text-blue-500' }} px-3 py-2 rounded-full"
                onmouseover="this.style.background='#3B82F6'; this.style.color='white';"
                onmouseout="this.style.background='white'; this.style.color='#3B82F6';"
            >
                <a href="/dashboard">All Notes</a>
            </li>
            @foreach ($categories as $category)
                <li class="px-3 py-2 rounded-full"
                    style="
                        background: {{ $categoryActive == $category->id ? $category->color : '' }};
                        color: {{ $categoryActive == $category->id ? 'white' : $category->color }}
                    "
                    onmouseover="this.style.background='{{ $category->color }}'; this.style.color='white';"
                    onmouseout="this.style.background='white'; this.style.color='{{ $category->color }}';"
                >
                    <a href="{{ route('dashboard.category', $category->id) }}">
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
