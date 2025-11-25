<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Bloc bienvenue -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6 text-center">
                <!-- Nom utilisateur connecté -->
                <h3 class="text-2xl font-semibold mb-2">
                    Bonjour, {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} !
                </h3>
                <p class="text-gray-700 mb-6">
                    Bienvenue sur <span class="font-bold">FeedFlow</span>, votre application de sondages.
                </p>

                <!-- Liste des organisations -->
                <div class="mb-6 text-left">
                    <h4 class="text-lg font-semibold mb-2">Vos organisations :</h4>
                    @if(Auth::user()->organizations->count() > 0)
                        <ul class="list-disc list-inside">
                            @foreach(Auth::user()->organizations as $org)
                                <li class="flex justify-between items-center">
                                    <span>{{ $org->name }}</span>
                                    <form action="{{ route('organizations.switch', $org->id) }}" method="POST" class="ml-2">
                                        @csrf
                                        <button type="submit" class="text-sm text-blue-600 hover:underline">
                                            Switch
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">Vous n’appartenez à aucune organisation pour le moment.</p>
                    @endif
                </div>

                <!-- Boutons pour accéder aux pages -->
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('organizations.index') }}" class="block bg-green-100 hover:bg-green-200 px-6 py-4 rounded-lg font-semibold transition text-gray-900 text-lg text-center">
                        Page Organisations
                    </a>
                    <a href="/surveys" class="block bg-blue-100 hover:bg-blue-200 px-6 py-4 rounded-lg font-semibold transition text-gray-900 text-lg text-center">
                        Page Sondages
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
