<x-app-layout>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Sondage</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <style>
            body {
                font-family: Arial, sans-serif;
                background: #f4f6fb;
                margin: 0;
                padding: 0;
                color: #333;
            }
            .container {
                max-width: 900px;
                margin: 40px auto;
                background: white;
                padding: 30px;
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            }
            h1 {
                text-align: center;
                color: #2b6cb0;
                margin-bottom: 30px;
            }
            form div {
                margin-bottom: 15px;
            }
            label {
                display: block;
                font-weight: bold;
                margin-bottom: 5px;
            }
            input[type="text"], input[type="date"], select {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 8px;
                font-size: 14px;
            }
            button {
                padding: 12px 20px;
                font-size: 15px;
                font-weight: bold;
                color: white;
                background-color: #2b6cb0;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                transition: 0.3s;
            }
            button:hover {
                background-color: #245a94;
            }
            .survey-list h2 {
                font-size: 20px;
                margin-bottom: 5px;
                color: #2b6cb0;
            }
            .survey-card {
                background: #fff;
                border-radius: 10px;
                padding: 20px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.05);
                margin-bottom: 20px;
            }
            .survey-card p {
                margin: 5px 0;
            }
            .survey-actions a, .survey-card form button {
                display: inline-block;
                margin-top: 10px;
                margin-right: 10px;
                padding: 6px 12px;
                font-size: 14px;
                background-color: #2b6cb0;
                color: white;
                border-radius: 6px;
                text-decoration: none;
                transition: 0.3s;
            }
            .survey-actions a:hover, .survey-card form button:hover {
                background-color: #245a94;
            }
            .survey-card form {
                display: inline;
            }
        </style>
    </head>
    <body>
    <div class="container">
        <h1>{{ $survey ? "Modifier" : "Créer un nouveau" }} Sondage</h1>

        <form id="surveyForm" method="POST" action="{{ $survey ? route('survey.update', $survey) : route('survey.store', $organizationId) }}">
            @csrf
            @if($survey)
                @method('PATCH')
            @endif

            <div>
                <label for="title">Titre :</label>
                <input type="text" name="title" id="title" value="{{ $survey->title ?? null }}" required>
            </div>

            <div>
                <label for="description">Description :</label>
                <input type="text" name="description" id="description" value="{{ $survey->description ?? null }}" required>
            </div>

            <div>
                <label for="start_date">Date de début :</label>
                <input type="date" name="start_date" id="start_date" value="{{ $survey ? \Carbon\Carbon::parse($survey->start_date)->format('Y-m-d') : ''}}" required>
            </div>

            <div>
                <label for="end_date">Date de fin :</label>
                <input type="date" name="end_date" id="end_date" value="{{ $survey ? \Carbon\Carbon::parse($survey->end_date)->format('Y-m-d') : ''}}" required>
            </div>

            <div>
                <label for="anonymous">Anonyme :</label>
                <select name="anonymous" id="anonymous" required>
                    <option value="1" {{ ($survey && $survey->is_anonymous) ? 'selected' : '' }}>Oui</option>
                    <option value="0" {{ ($survey && !$survey->is_anonymous) ? 'selected' : '' }}>Non</option>
                </select>
            </div>

            <button type="submit">{{ $survey ? 'Modifier' : 'Créer' }} le sondage</button>
        </form>

        <div id="response" style="margin-top:20px;"></div>

        <div class="survey-list">
            <h1>Liste des sondages</h1>
            @if($surveys->isEmpty())
                <p>Aucun sondage trouvé.</p>
            @else
                @foreach ($surveys as $survey)
                    <div class="survey-card">
                        <h2>{{ $survey->title }}</h2>
                        <p>{{ $survey->description }}</p>
                        <p>Début : {{ $survey->start_date }} | Fin : {{ $survey->end_date }} | Anonyme : {{ $survey->is_anonymous ? 'Oui' : 'Non' }}</p>

                        @if(is_null($survey?->token))
                            <p>Sondage Inactif</p>
                        @endif

                        <div class="survey-actions">
                            <a href="{{ route('answer', ['token' => $survey->token]) }}">Répondre</a>
                            <a href="{{ route('question', $survey->token) }}">Ajouter questions</a>
                            <a href="{{ route('survey', [ $organizationId,$survey->id]) }}">Modifier</a>

                            <form action="{{ route('survey.destroy', $survey) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Supprimer</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    </body>
    </html>
</x-app-layout>
