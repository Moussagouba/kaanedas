<x-app-layout>
    <section class="text-gray-600 body-font overflow-hidden">
        <div class="container px-5 py-24 mx-auto">
            <div class="mb-12 md:flex"> <!-- Utilisation de md:flex pour la mise en page côte à côte sur les écrans de taille moyenne et plus grands -->
                <div class="w-full md:w-1/2 pr-4"> <!-- Première colonne pour l'image -->
                    <img src="/storage/{{ $listing->logo }}" alt="{{ $listing->compagny }} logo" class="max-w-full mb-4">
                </div>
                <div class="w-full md:w-1/2 pl-4"> <!-- Deuxième colonne pour le contenu -->
                    <h2 class="text-2xl font-medium text-gray-900 title-font">
                        {{ $listing->title }}
                    </h2>
                    <div class="md:flex-grow md:mt-2 md:flex md:items-center md:justify-start"> <!-- Déplacer la section des balises de tag à l'intérieur de la deuxième colonne -->
                        @foreach($listing->tags as $tag)
                        <span class="inline-block mr-2 tracking-wide text-indigo-500 text-xs font-medium title-font py-0.5 px-1.5 border border-indigo-500 uppercase">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                    {!! $listing->content !!}
                    <p class="leading-relaxed text-base">
                        <strong>Pays: </strong>{{ $listing->location }}<br>
                        <strong>Nom du Lieu ou service: </strong>{{ $listing->compagny }}
                    </p>
                    <a href="#pasencoreajoutersinoncestcomment" class="block text-center my-4 tracking-wide bg-white text-indigo-500 text-sm font-medium title-font py-2 border border-indigo-500 hover:bg-indigo-500 hover:text-white uppercase">Discuter Maintenant</a>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>