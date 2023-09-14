<x-app-layout>
    <style>
        .bodyclass {
            background: linear-gradient(135deg, #4a90e2 0%, #ff70a6 100%);

        }
    </style>

    <section class="text-gray-600 body-font overflow-hidden   from-blue-300 via-purple-300 to-pink-300">
        <div class="w-full md:w-1/2 py-24 mx-auto">
            <div class="mb-4">
                <h2 class="text-2xl font-medium text-gray-900 title-font">
                    Créer une nouvelle annonce sur votre service ou lieu (3650 FCFA)
                </h2>
            </div>
            @if($errors->any())
            <div class="mb-4 p-4 bg-red-200 text-red-800">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{ route('listings.store') }}" id="payment_form" method="post" enctype="multipart/form-data" class="bg-gray-100 p-4 rounded-lg shadow-lg">
                @guest
                <div class="flex mb-4">
                    <div class="flex-1 mx-2">
                        <x-label for="email" value="Adresse e-mail" />
                        <x-input class="block mt-1 w-full" id="email" type="email" name="email" :value="old('email')" required autofocus />
                    </div>
                    <div class="flex-1 mx-2">
                        <x-label for="name" value="Nom complet" />
                        <x-input class="block mt-1 w-full" id="name" type="text" name="name" :value="old('name')" required />
                    </div>
                </div>
                <div class="flex mb-4">
                    <div class="flex-1 mx-2">
                        <x-label for="password" value="Mot de passe" />
                        <x-input class="block mt-1 w-full" id="password" type="password" name="password" required />
                    </div>
                    <div class="flex-1 mx-2">
                        <x-label for="password_confirmation" value="Confirmer le mot de passe" />
                        <x-input class="block mt-1 w-full" id="password_confirmation" type="password" name="password_confirmation" required />
                    </div>
                </div>
                @endguest
                <div class="mb-4 mx-2">
                    <x-label for="title" value="nom du lieu ou service" />
                    <x-input id="title" class="block mt-1 w-full" type="text" name="title" required />
                </div>
                <div class="mb-4 mx-2">
                    <x-label for="company" value="Nom du compagnie ou du responsable" />
                    <x-input id="company" class="block mt-1 w-full" type="text" name="compagny" required />
                </div>
                <div class="mb-4 mx-2">
                    <x-label for="logo" value="une image du lieu ou logo du service" />
                    <x-input id="logo" class="block mt-1 w-full" type="file" name="logo" />
                </div>
                <div class="mb-4 mx-2">
                    <x-label for="location" value="Emplacement (par exemple, à distance, Burkina faso)" />
                    <x-input id="location" class="block mt-1 w-full" type="text" name="location" required />
                </div>
                <div class="mb-4 mx-2">
                    <x-label for="apply_link" value="Lien whatsapp pour être contacter" />
                    <x-input id="apply_link" class="block mt-1 w-full" type="text" placeholder="exemple https://wa.me/22674696090" name="lien" required />
                </div>
                <div class="mb-4 mx-2">
                    <x-label for="tags" value="Mots-clés pour trouvez le coin (séparés par des virgules)" />
                    <x-input id="tags" class="block mt-1 w-full" type="text" name="tags" />
                </div>
                <div class="mb-4 mx-2">
                    <x-label for="content" value="Description du Lieu ou du service  " />
                    <textarea id="content" rows="8" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" name="content"></textarea>
                </div>
                <div class="mb-4 mx-2">
                    <label for="tres_recherche" class="inline-flex items-center font-medium text-sm text-gray-700">
                        <input type="checkbox" id="tres_recherche" name="tres_recherche" value="Oui" sclass="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50">
                        <span class="ml-2">Mettre en avant le lieu ou service (supplément de 1250 FCFA)</span>
                    </label>
                </div>
                <div class="mb-6 mx-2">
                    <div id="card-element"></div>
                </div>
                <div class="mb-2 mx-2">
                    @csrf
                    <input type="hidden" id="payment_method_id" name="payment_method_id" value="">
                    <button type="submit" id="form_submit" class="block w-full items-center bg-indigo-500 text-white border-0 py-2 focus:outline-none hover:bg-indigo-600 rounded text-base mt-4 md:mt-0">Payer + Continuer</button>
                </div>
            </form>
        </div>
    </section>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe("{{ env('STRIPE_KEY') }}");
        const elements = stripe.elements();
        const cardElement = elements.create('card', {
            classes: {
                base: 'StripeElement rounded-md shadow-sm bg-white px-2 py-3 border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full'
            }
        });

        cardElement.mount('#card-element');

        document.getElementById('form_submit').addEventListener('click', async (e) => {
            // empêcher la soumission du formulaire immédiatement
            e.preventDefault();

            const {
                paymentMethod,
                error
            } = await stripe.createPaymentMethod(
                'card', cardElement, {}
            );

            if (error) {
                alert(error.message);
            } else {
                // la carte est valide, créer l'ID de méthode de paiement et soumettre le formulaire
                document.getElementById('payment_method_id').value = paymentMethod.id;
                document.getElementById('payment_form').submit();
            }
        })
    </script>
</x-app-layout>