<x-frontend-layout>
    <div class="bg-white py-16 sm:py-24">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Blog của chúng tôi</h1>
                <p class="mt-2 text-lg leading-8 text-gray-600">
                    Khám phá những câu chuyện, hướng dẫn và cập nhật mới nhất từ Lanvitura.
                </p>
            </div>
            <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                @foreach ($posts as $post)
                    <article class="flex flex-col items-start justify-between">
                        <div class="relative w-full">
                            <img src="{{ $post->image_path }}" alt="" class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                            <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
                        </div>
                        <div class="max-w-xl">
                            <div class="mt-8 flex items-center gap-x-4 text-xs">
                                <time datetime="{{ $post->created_at->toDateString() }}" class="text-gray-500">{{ $post->created_at->format('d M, Y') }}</time>
                            </div>
                            <div class="group relative">
                                <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                                    <a href="#">
                                        <span class="absolute inset-0"></span>
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600">{{ $post->excerpt }}</p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-16">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-frontend-layout>