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

                <form method="POST" action="{{ route('organizations.update', $organization->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Nom de l'organisation</label>
                        <input type="text" name="name" value="{{ old('name', $organization->name) }}" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Membres</label>

                        @foreach($users as $user)
                            <div class="flex items-center mb-1">

                                <input type="checkbox"
                                       name="members[{{ $user->id }}][id]"
                                       value="{{ $user->id }}"
                                       {{ $organization->members->contains($user) ? 'checked' : '' }}
                                       {{ auth()->id() == $user->id ? 'checked disabled' : '' }}
                                       class="mr-2">

                                <span class="mr-2">
                                    {{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})
                                </span>

                                @php
                                    $member = $organization->members->firstWhere('id', $user->id);
                                    $role = $member?->pivot?->role;
                                @endphp

                                <select name="members[{{ $user->id }}][role]"
                                        class="border rounded px-2 py-1"
                                        {{ auth()->id() == $user->id ? 'disabled' : '' }}
                                        {{ $organization->members->contains($user) ? '' : 'required' }}>

                                    @if(!$role)
                                        <option value="" selected disabled>Non choisi</option>
                                    @endif

                                    <option value="Admin"
                                        {{ auth()->id() == $user->id ? 'selected' : ($role === 'Admin' ? 'selected' : '') }}>
                                        Admin
                                    </option>

                                    <option value="Manager" {{ $role === 'Manager' ? 'selected' : '' }}>Manager</option>

                                    <option value="Membre" {{ $role === 'Membre' ? 'selected' : '' }}>Membre</option>
                                </select>

                                @if(auth()->id() == $user->id)
                                    <input type="hidden" name="members[{{ $user->id }}][role]" value="Admin">
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
