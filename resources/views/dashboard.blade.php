<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 text-center">
                <h3 class="text-2xl font-semibold mb-6">
                    Bonjour, {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} !
                </h3>

                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('organizations.index') }}" class="block bg-green-100 hover:bg-green-200 px-6 py-4 rounded-lg font-semibold text-gray-900 text-lg text-center transition">
                        Page Organisations
                    </a>
                    <a href="/surveys" class="block bg-blue-100 hover:bg-blue-200 px-6 py-4 rounded-lg font-semibold text-gray-900 text-lg text-center transition">
                        Page Sondages
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
