<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier l'organisation
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 rounded shadow bg-gray-50 text-gray-900">

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('organizations.update', $organization) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Nom de l'organisation</label>
                        <input type="text" name="name" value="{{ old('name', $organization->name) }}" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Membres</label>

                        @foreach($users as $user)
                            @php
                                $member = $organization->members->firstWhere('id', $user->id);
                                $role = $member?->pivot?->role ?? null; // Met null si pas de rôle
                            @endphp

                            <div class="flex items-center mb-2 space-x-3">
                                <input type="checkbox"
                                       name="members[{{ $user->id }}][id]"
                                       value="{{ $user->id }}"
                                       {{ $member ? 'checked' : '' }}
                                       {{ $user->id == $organization->user_id ? 'checked disabled' : '' }}
                                       class="mr-2">

                                <span class="mr-2">
                                    {{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})
                                </span>

                                <select name="members[{{ $user->id }}][role]"
                                        class="border rounded px-2 py-1"
                                        {{ $user->id == $organization->user_id ? 'disabled' : '' }}
                                        {{ $member ? '' : 'required' }}>

                                    <option value="" {{ $role === null ? 'selected' : '' }}>Non choisi</option>
                                    <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="member" {{ $role === 'member' ? 'selected' : '' }}>Membre</option>
                                </select>

                                {{-- Affichage du rôle actuel --}}
                                <span class="ml-2 text-gray-600">
                                    Role actuel : <strong>{{ $role ?? 'Aucun' }}</strong>
                                </span>

                                @if($user->id == $organization->user_id)
                                    <input type="hidden" name="members[{{ $user->id }}][role]" value="admin">
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="bg-blue-600 px-4 py-2 rounded hover:bg-blue-700">
                        Enregistrer les modifications
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
