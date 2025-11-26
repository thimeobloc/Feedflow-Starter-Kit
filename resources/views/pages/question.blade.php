<x-app-layout>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <title>Sondage</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body>
        <div
            class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 flex items-center justify-center">
            <div class="max-w-2xl w-full bg-white rounded-2xl shadow-2xl p-8 md:p-12">
                <div class="grid grid-cols-2 gap-4 mb-8 bg-gray-50 rounded-xl p-6">
                    <h1 class="text-5xl font-bold text-gray-900 mb-3">{{ $survey->title }}</h1>
                    <p class="text-gray-600 text-lg leading-relaxed">{{ $survey->description }}</p>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-8 bg-gray-50 rounded-xl p-6">
                    <div class="text-center">
                        <p class="text-gray-500 text-sm font-semibold mb-1">Début</p>
                        <p class="text-gray-900 font-medium">{{ $survey->start_date }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-gray-500 text-sm font-semibold mb-1">Fin</p>
                        <p class="text-gray-900 font-medium">{{ $survey->end_date }}</p>
                    </div>
                    <div class="col-span-2 text-center">
                        <span
                            class="inline-block bg-indigo-100 text-indigo-800 px-4 py-2 rounded-full text-sm font-semibold">
                            {{ $survey->is_anonymous ? '🔒 Anonyme' : '👤 Non Anonyme' }}
                        </span>
                    </div>
                </div>  
            </div>
        </div>
    </body>

    </html>
</x-app-layout>
