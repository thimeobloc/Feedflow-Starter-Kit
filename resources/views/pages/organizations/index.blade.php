<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Organizations') }}
            </h2>

            <!-- Link to create a new organization -->
            <a href="{{ route('organizations.create') }}"
               class="px-4 py-2 bg-blue-600 rounded-md hover:bg-blue-700">
                Add Organization
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 rounded shadow bg-gray-50 text-gray-900">
                <h3 class="text-lg font-semibold mb-4">Organization List</h3>

                <!-- Success message -->
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Organization table -->
                @if(isset($organizations) && count($organizations) > 0)
                    <table class="w-full border border-gray-200">
                        <thead class="bg-gray-100 text-left">
                            <tr>
                                <th class="px-4 py-2 border-b">Name</th>
                                <th class="px-4 py-2 border-b">Role</th>
                                <th class="px-4 py-2 border-b">Created At</th>
                                <th class="px-4 py-2 border-b">Updated At</th>
                                <th class="px-4 py-2 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($organizations as $org)
                                <tr>
                                    <td class="px-4 py-2 border-b">{{ $org->name }}</td>
                                    <td class="px-4 py-2 border-b">{{ $org->pivot->role ?? 'Not set' }}</td>
                                    <td class="px-4 py-2 border-b">{{ $org->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 py-2 border-b">{{ $org->updated_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 py-2 border-b">
                                        @if($org->pivot->role === 'admin')
                                            <!-- Edit organization -->
                                            <a href="{{ route('organizations.updateForm', $org->id) }}" class="px-3 py-1 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                                                Edit
                                            </a>

                                            <!-- Delete organization -->
                                            <form action="{{ route('organizations.destroy', $org->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this organization?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                                    Delete
                                                </button>
                                            </form>

                                            <!-- Link to surveys -->
                                            <a href="{{ route('survey', $org->id) }}" class="px-3 py-1 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                                                Surveys
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>You don’t have any organizations yet.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
