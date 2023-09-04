<section class="text-gray-600 body-font border-b border-gray-100" style="background-image: url('https://media.gettyimages.com/id/1314415203/photo/always-smile.jpg?s=612x612&w=0&k=20&c=5Khv1DGOjBLVolv1561s5I9BMU3_U2Uvn0dT9yjfje8='); background-size: cover; background-blend-mode: screen;">
    <div class="container mx-auto flex flex-col px-5 pt-16 pb-8 justify-center items-center">
        <div class="w-full md:w-2/3 flex flex-col items-center text-center">
            <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-blue-500">Top des services et Lieux</h1>
            <p class="mb-8 leading-relaxed  text-white">Que vous cherchiez un lieu ou simplement à voir un service qui est disponible, nous avons rassemblé cette liste complète des services et des lieux issus de diverses entreprises et régions parmi lesquels vous pouvez choisir.</p>
            <form class="flex w-full text-white-100 justify-center items-end" action="{{ route('listings.index') }}" method="get">
                <div class="relative mr-4 w-full lg:w-1/2 text-left">
                    <input type="text" id="s" placeholder="Hotel, Garage, Mosque, Eglise" name="s" value="{{ request()->get('s') }}" class="w-full bg-gray-100 bg-opacity-50 rounded focus:ring-2 focus:ring-indigo-200 focus:bg-transparent border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                </div>
                <button class="inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">Recherche</button>
            </form>

        </div>
    </div>
</section>