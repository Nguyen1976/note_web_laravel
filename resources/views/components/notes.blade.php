<div class="mx-auto container py-20 px-6">
    <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 gap-6">
        @foreach ($notes as $note)
            <div class="w-full h-64 flex flex-col justify-between bg-white rounded-lg border mb-6 py-5 px-4">
                <div class="border-l-2 pl-3 ml-1"
                    style="border-color: {{ $note->category->color }}; color: {{ $note->category->color }}">
                    <h4 class="font-bold mb-3">{{ $note->title }}</h4>
                    <p class="text-sm">{{ $note->content }}</p>
                </div>
                <div>
                    <div class="mb-3 flex items-center">
                        <div class="border border-gray-300 rounded-full px-3 py-1 text-xs flex items-center"
                            aria-label="due on" role="contentinfo"
                            style="border-color: {{ $note->category->color }}; color: {{ $note->category->color }}">
                            <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/4-by-3-multiple-styled-cards-svg2.svg"
                                alt="clock" />
                            <p class="ml-2">7 Sept, 23:00</p>
                        </div>
                        <button class="p-1 rounded-full ml-2" aria-label="save in starred items" role="button">
                            <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/4-by-3-multiple-styled-cards-svg3.svg"
                                alt="star" />
                        </button>
                    </div>
                    <div class="flex items-center justify-between" style="color: {{ $note->category->color }}">
                        <p class="text-sm">March 28, 2020</p>
                        <button
                            class="w-8 h-8 rounded-full text-white flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-offset-2  focus:ring-black"
                            aria-label="edit note" role="button" style="background: {{ $note->category->color }}">
                            <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/4-by-3-multiple-styled-cards-svg1.svg"
                                alt="edit" />

                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
