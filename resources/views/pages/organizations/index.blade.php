<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mes Organisations') }}
            </h2>

            <a href="{{ route('organizations.create') }}"
               class="px-4 py-2 bg-blue-600 rounded-md hover:bg-blue-700">
                Ajouter une organisation
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 rounded shadow bg-gray-50 text-gray-900">
                <h3 class="text-lg font-semibold mb-4">Liste des organisations</h3>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if(isset($organizations) && count($organizations) > 0)
                    <table class="w-full border border-gray-200">
                        <thead class="bg-gray-100 text-left">
                            <tr>
                                <th class="px-4 py-2 border-b">Nom</th>
                                <th class="px-4 py-2 border-b">Rôle</th>
                                <th class="px-4 py-2 border-b">Créé le</th>
                                <th class="px-4 py-2 border-b">Mis à jour le</th>
                                <th class="px-4 py-2 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($organizations as $org)
                                <tr>
                                    <td class="px-4 py-2 border-b">{{ $org->name }}</td>
                                    <td class="px-4 py-2 border-b">{{ $org->pivot->role ?? 'Non choisi' }}</td>
                                    <td class="px-4 py-2 border-b">{{ $org->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 py-2 border-b">{{ $org->updated_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 py-2 border-b">
                                        @if($org->pivot->role === 'admin')
                                            <a href="{{ route('organizations.updateForm', $org->id) }}" class="px-3 py-1 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                                                Modifier
                                            </a>
                                            <form action="{{ route('organizations.destroy', $org->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Supprimer cette organisation ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                                    Supprimer
                                                </button>
                                            </form>
                                            <a href="{{ route('survey', $org->id) }}" class="px-3 py-1 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                                                Sondages
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Vous n'avez pas encore d'organisation.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
