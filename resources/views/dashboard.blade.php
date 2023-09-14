<x-app-layout>
    <style>
        .bodyclass {
            background: linear-gradient(135deg, #4a90e2 0%, #ff70a6 100%);

        }
    </style>

    <section class="text-gray-600 body-font overflow-hidden">
        <div class="container px-5 py-12 mx-auto">
            <div class="mb-12 flex items-center">
                <!-- En-tête avec le titre "Vos annonces ({{ $listings->count() }})" -->
                <h2 class="text-2xl font-medium text-gray-900 title-font px-4">
                    Vos annonces ({{ $listings->count() }})
                </h2>


            </div>
            <div class="-my-6">
                <!-- Boucle pour afficher chaque annonce -->
                @foreach($listings as $listing)
                <a href="{{ route('listings.show', $listing->slug) }}" class="py-6 px-4 flex flex-wrap md:flex-nowrap border-b border-gray-100 {{ $listing->is_highlighted ? 'bg-yellow-100 hover:bg-yellow-200' : 'bg-white hover:bg-gray-100' }}">
                    <!-- Image du logo de l'annonce -->
                    <div class="md:w-16 md:mb-0 mb-6 mr-4 flex-shrink-0 flex flex-col">
                        <img src="/storage/{{ $listing->logo }}" class="w-16 h-16 rounded-full object-cover">
                    </div>
                    <!-- Détails de l'annonce -->
                    <div class="md:w-1/2 mr-8 flex flex-col items-start justify-center">
                        <!-- Titre de l'annonce -->
                        <h2 class="text-xl font-bold text-gray-900 title-font mb-1">{{ $listing->title }}</h2>
                        <!-- Nom de la société et emplacement -->
                        <p class="leading-relaxed text-gray-900">{{ $listing->compagny }} &mdash; <span class="text-gray-600">{{ $listing->location }}</span></p>
                    </div>
                    <!-- Balises (tags) associées à l'annonce -->
                    <div class="md:flex-grow mr-8 mt-2 flex items-center justify-start">
                        @foreach($listing->tags as $tag)
                        <span class="inline-block mr-2 tracking-wide text-indigo-500 text-xs font-medium title-font py-0.5 px-1.5 border border-indigo-500">{{ strtoupper($tag->name) }}</span>
                        @endforeach
                    </div>
                    <!-- Informations supplémentaires sur l'annonce -->
                    <span class="md:flex-grow flex flex-col items-end justify-center">
                        <!-- Date de création relative -->
                        <span>{{ $listing->created_at->diffForHumans() }}</span>
                        <!-- Nombre de clics sur le bouton "Consultez" -->
                        <span><strong class="text-bold">{{ $listing->clicks()->count() }}</strong> Clics sur le bouton Postuler</span>
                    </span>
                </a>
                @endforeach
            </div>
        </div>
    </section>
</x-app-layout>