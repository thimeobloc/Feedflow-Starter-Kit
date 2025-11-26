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
                        {{ $survey->is_anonymous ? '👤 Non Anonyme' : '🔒 Anonyme' }}
                    </span>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('question.store', $survey) }}">
            @csrf

            <label>Question :</label>
            <input type="text" name="question" required>

            <label>Type de question :</label>
            <select name="type" id="typeSelect">
                <option value="text">Texte</option>
                <option value="radio">Choix unique</option>
                <option value="checkbox">Choix multiple</option>
                <option value="scale">Échelle 1-10</option>
            </select>

            <div id="optionsContainer" style="display:none;">
                <label>Options :</label>
                <input type="text" name="options[]" placeholder="Option 1">
                <input type="text" name="options[]" placeholder="Option 2">

                <button type="button" onclick="addOption()">Ajouter option</button>
            </div>

            <button type="submit">Ajouter la question</button>
        </form>

        <div class="max-w-6xl mx-auto py-8">
            <h1 class="text-3xl font-bold mb-6">Liste des sondages</h1>
            @if($questions->isEmpty())
                <p class="text-gray-600">Aucune question trouvée.</p>
            @else
                @foreach ($questions as $question)
                        <div class="border rounded p-4 mb-4 bg-white shadow">
                            <h2 class="text-xl font-bold">{{ $question->title }}</h2>
                        </div>
                @endforeach
            @endif
        </div>

    <div>


    </div>

    </body>
    </html>
</x-app-layout>

