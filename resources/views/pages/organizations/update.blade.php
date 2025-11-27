<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Organization
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 rounded shadow bg-gray-50 text-gray-900">

                <!-- Validation errors -->
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Organization update form -->
                <form method="POST" action="{{ route('organizations.update', $organization) }}">
                    @csrf
                    @method('PATCH')

                    <!-- Organization name -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Organization Name</label>
                        <input type="text" name="name" value="{{ old('name', $organization->name) }}" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <!-- Members and roles -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Members</label>

                        @foreach($users as $user)
                            @php
                                $member = $organization->members->firstWhere('id', $user->id);
                                $role = $member?->pivot?->role ?? null;
                            @endphp

                            <div class="flex items-center mb-2 space-x-3">
                                <!-- Member checkbox -->
                                <input type="checkbox"
                                       name="members[{{ $user->id }}][id]"
                                       value="{{ $user->id }}"
                                       {{ $member ? 'checked' : '' }}
                                       {{ $user->id == $organization->user_id ? 'checked disabled' : '' }}
                                       class="mr-2">

                                <!-- Member info -->
                                <span class="mr-2">
                                    {{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})
                                </span>

                                <!-- Role selector -->
                                <select name="members[{{ $user->id }}][role]"
                                        class="border rounded px-2 py-1"
                                        {{ $user->id == $organization->user_id ? 'disabled' : '' }}
                                        {{ $member ? '' : 'required' }}>
                                    <option value="" {{ $role === null ? 'selected' : '' }}>Not set</option>
                                    <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="member" {{ $role === 'member' ? 'selected' : '' }}>Member</option>
                                </select>

                                <!-- Current role display -->
                                <span class="ml-2 text-gray-600">
                                    Current role: <strong>{{ $role ?? 'None' }}</strong>
                                </span>

                                <!-- Hidden input for owner role -->
                                @if($user->id == $organization->user_id)
                                    <input type="hidden" name="members[{{ $user->id }}][role]" value="admin">
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="bg-blue-600 px-4 py-2 rounded hover:bg-blue-700">
                        Save Changes
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
