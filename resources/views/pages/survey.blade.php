<x-app-layout>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
<<<<<<< HEAD
        <title>Sondage</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
    <h1>{{ $survey ? "Modifier" : "Créer un nouveau" }} Sondage</h1>

    <div class="refresh">
        <a href="{{ route('survey') }}">Refresh</a>
    </div>

    <form id="surveyForm" method="POST" action="{{ $survey ? route('survey.update', $survey) : route('survey.store') }}">
=======
        <title>Test création de sondage</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
    <h1>Tester la création d'un sondage</h1>

    <form id="surveyForm" method="POST" action="{{ route('survey.add') }}">
>>>>>>> 82495b513c26eb0bb5072cbf1dfba5ad22ebb5f5
        @csrf

        <div>
            <label for="title">Titre :</label>
<<<<<<< HEAD
            <input type="text" name="title" id="title" value="{{ $survey->title ?? null }}" required>
=======
            <input type="text" name="title" id="title" required>
>>>>>>> 82495b513c26eb0bb5072cbf1dfba5ad22ebb5f5
        </div>

        <div>
            <label for="description">Description :</label>
<<<<<<< HEAD
            <input name="description" id="description" value="{{ $survey->description ?? null }}" required></input>
=======
            <textarea name="description" id="description" required></textarea>
>>>>>>> 82495b513c26eb0bb5072cbf1dfba5ad22ebb5f5
        </div>

        <div>
            <label for="start_date">Date de début :</label>
<<<<<<< HEAD
            <input type="date" name="start_date" id="start_date" value="{{ $survey ? \Carbon\Carbon::parse($survey->start_date)->format('Y-m-d') : ''}}" required>
=======
            <input type="date" name="start_date" id="start_date" required>
>>>>>>> 82495b513c26eb0bb5072cbf1dfba5ad22ebb5f5
        </div>

        <div>
            <label for="end_date">Date de fin :</label>
<<<<<<< HEAD
            <input type="date" name="end_date" id="end_date" value="{{ $survey ? \Carbon\Carbon::parse($survey->end_date)->format('Y-m-d') : ''}}" required>
=======
            <input type="date" name="end_date" id="end_date" required>
>>>>>>> 82495b513c26eb0bb5072cbf1dfba5ad22ebb5f5
        </div>

        <div>
            <label for="anonymous">Anonyme :</label>
            <select name="anonymous" id="anonymous" required>
                <option value="1">Oui</option>
                <option value="0">Non</option>
            </select>
        </div>

<<<<<<< HEAD
        <button type="submit">{{ $survey ? 'Modifier' : 'Créer' }} le sondage</button>
=======
        <button type="submit">Créer le sondage</button>
>>>>>>> 82495b513c26eb0bb5072cbf1dfba5ad22ebb5f5
    </form>
    <div id="response" style="margin-top:20px;"></div>

    <div class="max-w-6xl mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6">Liste des sondages</h1>

        @if($surveys->isEmpty())
            <p class="text-gray-600">Aucun sondage trouvé.</p>
        @else
            @foreach ($surveys as $survey)
                <div class="border rounded p-4 mb-4 bg-white shadow">
                    <h2 class="text-xl font-bold">{{ $survey->title }}</h2>
                    <p>{{ $survey->description }}</p>

                    <div class="text-sm text-gray-600 mt-2">
                        Début : {{ $survey->start_date }}
                        <br>
                        Fin : {{ $survey->end_date }}
                        <br>
                        Anonyme : {{ $survey->anonymous }}
                    </div>
<<<<<<< HEAD
                    <a href="{{ route('survey', $survey) }}">Modifier</a>
                    <form action="{{ route('survey.destroy', $survey) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button>Supprimer</button>
                    </form>
=======
>>>>>>> 82495b513c26eb0bb5072cbf1dfba5ad22ebb5f5
                </div>
            @endforeach
        @endif

    </div>

    </body>
    </html>

</x-app-layout>
