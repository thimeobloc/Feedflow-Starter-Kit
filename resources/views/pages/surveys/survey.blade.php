<x-app-layout>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Sondage</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
    <h1>{{ $survey ? "Modifier" : "Créer un nouveau" }} Sondage</h1>

    <div class="refresh">
        <a href="{{ route('survey', $organization->id) }}">Refresh</a>
    </div>

    <form id="surveyForm" method="POST"
          action="{{ $survey ? route('survey.update', $survey) : route('survey.store', $organizationId) }}">
        @csrf
        @if($survey)
            @method('PATCH')
        @endif
        {{--        <meta name="csrf-token" content="{{ csrf_token() }}">--}}

        <div>
            <label for="title">Titre :</label>
            <input type="text" name="title" id="title" value="{{ $survey->title ?? null }}" required>
        </div>

        <div>
            <label for="description">Description :</label>
            <input name="description" id="description" value="{{ $survey->description ?? null }}" required>
        </div>

        <div>
            <label for="start_date">Date de début :</label>
            <input type="date" name="start_date" id="start_date"
                   value="{{ $survey ? \Carbon\Carbon::parse($survey->start_date)->format('Y-m-d') : ''}}" required>
        </div>

        <div>
            <label for="end_date">Date de fin :</label>
            <input type="date" name="end_date" id="end_date"
                   value="{{ $survey ? \Carbon\Carbon::parse($survey->end_date)->format('Y-m-d') : ''}}" required>
        </div>

        <div>
            <label for="anonymous">Anonyme :</label>
            <select name="anonymous" id="anonymous" required>
                <option value="1">Oui</option>
                <option value="0">Non</option>
            </select>
        </div>

        <button type="submit">{{ $survey ? 'Modifier' : 'Créer' }} le sondage</button>
    </form>
    <div id="response" style="margin-top:20px;"></div>

    <div class="max-w-6xl mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6">Liste des sondages</h1>
        @if($surveys->isEmpty())
            <p class="text-gray-600">Aucun sondage trouvé.</p>
        @else
            @foreach ($surveys as $survey)
                <a href="{{ route('question', $survey->token) }}" target="_blank" class="text-blue-600 underline">
                    <div class="border rounded p-4 mb-4 bg-white shadow">
                        <h2 class="text-xl font-bold">{{ $survey->title }}</h2>
                        <p>{{ $survey->description }}</p>

                        <div class="text-sm text-gray-600 mt-2">
                            Début : {{ $survey->start_date }}
                            <br>
                            Fin : {{ $survey->end_date }}
                            <br>
                            Anonyme : {{ $survey->is_anonymous }}
                        </div>
                        <a href="{{ route('survey', $survey) }}">Modifier</a>
                        <form action="{{ route('survey.destroy', $survey) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button>Supprimer</button>
                        </form>
                    </div>
                </a>
            @endforeach
        @endif
    </div>
    </body>
    </html>

</x-app-layout>
