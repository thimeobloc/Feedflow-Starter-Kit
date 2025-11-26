<x-app-layout>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body>
        <div>
            <div>
                <h1>{{ $survey->title }}</h1>
                <p>{{ $survey->description }}</p>
            </div>

            <div class="container">
                <div class="text-center">
                    <p>Début</p>
                    <p>{{ $survey->start_date }}</p>
                </div>
                <div class="text-center">
                    <p>Fin</p>
                    <p>{{ $survey->end_date }}</p>
                </div>
                <div class="col-span-2 text-center">
                    <span>
                        {{ $survey->is_anonymous ? '🔒 Anonyme' : '👤 Non Anonyme' }}
                    </span>
                </div>
            </div>
        </div>
    </body>

    </html>
</x-app-layout>
