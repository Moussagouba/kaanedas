<x-app-layout>
    <x-hero></x-hero>
    <section class="container px-5 py-12 mx-auto">
        <div class="mb-12">
            <div class="flex justify-center">
                @foreach($tags as $tag)
                <a href="{{ route('listings.index', ['tag' => $tag->slug]) }}" class="inline-block ml-2 tracking-wide text-xs font-medium title-font py-0.5 px-1.5 border border-indigo-500 uppercase {{ $tag->slug === request()->get('tag') ? 'bg-indigo-500 text-white' : 'bg-white text-indigo-500' }}">{{ $tag->name }}</a>
                @endforeach
            </div>
        </div>

        <div class="py-12">
            <div class="container m-auto px-6 text-gray-600 md:px-12 xl:px-6">
                <div class="mb-12 space-y-2 text-center">
                    <h2 class="text-3xl font-bold text-gray-800 md:text-4xl dark:text-white">Tous les services et lieux disponibles ({{ $listings->count() }})</h2>
                </div>

                <div class="lg:w-3/4 bg-dark xl:w-2/4 lg:mx-auto">
                    @foreach($listings as $listing)
                    <a href="{{ route('listings.show', $listing->slug) }}" class="group relative -mx-4 sm:-mx-8 p-6 sm:p-8 rounded-3xl bg-white dark:bg-transparent border border-transparent hover:border-gray-100 dark:shadow-none dark:hover:border-gray-700 dark:hover:bg-gray-800 shadow-2xl shadow-transparent hover:shadow-gray-600/10 sm:gap-8 sm:flex transition duration-300 hover:z-10">
                        <div class="sm:w-2/6 rounded-3xl overflow-hidden transition-all duration-500 group-hover:rounded-xl">

                            <div class="sm:w-2/6 rounded-3xl overflow-hidden transition-all duration-500 group-hover:rounded-xl">
                                <img src="/storage/{{ $listing->logo }}" alt="art cover" alt="{{ $listing->company }} logo" loading="lazy" width="1000" height="667" class="h-56 sm:h-full w-full object-cover object-top transition duration-500 group-hover:scale-105">
                            </div>
                        </div>
                        <div class="md:w-1/2 mr-8 flex flex-col items-start justify-center">
                            <h2 class="text-xl font-bold text-gray-900 title-font mb-1">{{ $listing->title }}</h2>
                            <p class="leading-relaxed text-gray-900">
                                {{ $listing->company }} &mdash; <span class="text-gray-600">{{ $listing->location }}</span>
                            </p>
                        </div>
                        <div class="md:flex-grow mr-8 flex items-center justify-start">
                            @foreach($listing->tags as $tag)
                            <span class="inline-block ml-2 tracking-wide text-xs font-medium title-font py-0.5 px-1.5 border border-indigo-500 uppercase {{ $tag->slug === request()->get('tag') ? 'bg-indigo-500 text-white' : 'bg-white text-indigo-500' }}">
                                {{ $tag->name }}
                            </span>
                            @endforeach
                        </div>
                        <span class="md:flex-grow flex items-center justify-end">
                            <span>{{ $listing->created_at->diffForHumans() }}</span>
                        </span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        <br>
    </section>
</x-app-layout>