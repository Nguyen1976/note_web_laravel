<div class="mx-auto container py-20 px-6">
    <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 gap-6">
        @foreach ($notes as $note)
            <div
                class="w-full h-64 flex flex-col justify-between dark:bg-gray-800 bg-white dark:border-gray-700 rounded-lg border border-gray-400 mb-6 py-5 px-4">
                <div>
                    <h4 class="text-gray-800 dark:text-gray-100 font-bold mb-3">{{ $note->title }}</h4>
                    <p class="text-gray-800 dark:text-gray-100 text-sm">{{ $note->content }}</p>
                </div>
                <div>
                    <div class="mb-3 flex items-center">
                        <div class="border border-gray-300 dark:border-gray-700 rounded-full px-3 py-1 dark:text-gray-400 text-gray-600 text-xs flex items-center"
                            aria-label="due on" role="contentinfo">
                            <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/4-by-3-multiple-styled-cards-svg2.svg"
                                alt="clock" />
                            <p class="ml-2 dark:text-gray-400">7 Sept, 23:00</p>
                        </div>
                        <button
                            class="p-1 bg-gray-800 dark:bg-gray-100 rounded-full ml-2 text-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2  focus:ring-black"
                            aria-label="save in starred items" role="button">
                            <img src="https://tuk-cdn.s3.amazonaws.com/can-uploader/4-by-3-multiple-styled-cards-svg3.svg"
                                alt="star" />
                        </button>
                    </div>
                    <div class="flex items-center justify-between text-gray-800">
                        <p class="dark:text-gray-100 text-sm">March 28, 2020</p>
                        <button
                            class="w-8 h-8 rounded-full dark:bg-gray-100 dark:text-gray-800 bg-gray-800 text-white flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-offset-2  focus:ring-black"
                            aria-label="edit note" role="button">
                            <img class="dark:hidden"
                                src="https://tuk-cdn.s3.amazonaws.com/can-uploader/4-by-3-multiple-styled-cards-svg1.svg"
                                alt="edit" />
                            <img class="dark:block hidden"
                                src="https://tuk-cdn.s3.amazonaws.com/can-uploader/4-by-3-multiple-styled-cards-svg1dark.svg"
                                alt="edit" />
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
