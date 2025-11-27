<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Organization
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 rounded shadow bg-gray-50 text-gray-900">

                <!-- Display validation errors -->
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Organization creation form -->
                <form method="POST" action="{{ route('organizations.store') }}">
                    @csrf

                    <!-- Organization name -->
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Organization Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Create
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
