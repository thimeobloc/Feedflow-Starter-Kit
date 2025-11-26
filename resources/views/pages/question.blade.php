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

        <form method="POST" action="{{ route('question', $survey->id) }}">
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
    </body>
    </html>
</x-app-layout>

