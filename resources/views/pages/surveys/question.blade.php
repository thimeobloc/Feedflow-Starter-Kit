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

    <form method="POST" action="{{ route('question.store', $survey->id) }}">
        @csrf

        <label>Question :</label>
        <input type="text" name="title" required>

        <label>Type de question :</label>
        <select name="question_type" id="typeSelect">
            <option value="text">Texte</option>
            <option value="unique">Choix unique</option>
            <option value="multiple">Choix multiple</option>
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
        <h1 class="text-3xl font-bold mb-6">Liste des questions</h1>

        @if($questions->isEmpty())
            <p class="text-gray-600">Aucune question trouvée.</p>
        @else

            @foreach ($questions as $question)
                <div class="border rounded p-4 mb-4 bg-white shadow">
                    @csrf

                    {{-- QUESTION TEXTE --}}
                    @if($question->question_type === "text")
                        <form method="POST" action="{{ route('question.update', [$survey->id, $question->id]) }}">
                            @csrf
                            @method("PATCH")

                            <h2 class="text-xl font-bold">Question : {{ $question->title }} (Réponse texte)</h2>

                            <input type="hidden" name="question_type" value="text">

                            <button style="margin-left:1300px">Valider</button>
                        </form>
                    @endif

                    {{-- QUESTION CHOIX UNIQUE --}}
                    @if($question->question_type === "unique")
                        <form method="POST" action="{{ route('question.update', [$survey->id, $question->id]) }}">
                            @csrf
                            @method("PATCH")

                            <h2 class="text-xl font-bold">{{ $question->title }} (Choix unique)</h2>

                            <input type="hidden" name="question_type" value="unique">
                            <input type="text" name="title" value="{{ $question->title }}" class="hidden">

                            <label>Options 1 :</label>
                            <input type="text" name="options[]" value="{{ $question->options[0] ?? '' }}" style="border:2px solid black; margin-left:5px;">
                            <label>Options 2 :</label>
                            <input type="text" name="options[]" value="{{ $question->options[1] ?? '' }}" style="border:2px solid black; margin-left:5px;">
                            <label>Options 3 :</label>
                            <input type="text" name="options[]" value="{{ $question->options[2] ?? '' }}" style="border:2px solid black; margin-left:5px;">
                            <label>Options 4 :</label>
                            <input type="text" name="options[]" value="{{ $question->options[3] ?? '' }}" style="border:2px solid black; margin-left:5px;">

                            <button style="margin-left:1300px">Valider</button>
                        </form>
                    @endif

                    {{-- QUESTION ÉCHELLE --}}
                    @if($question->question_type === "scale")
                        <form method="POST" action="{{ route('question.update', [$survey->id, $question->id]) }}">
                            @csrf
                            @method("PATCH")

                            <h2 class="text-xl font-bold">Question : {{ $question->title }} (Réponse échelle de 1 à 10)</h2>

                            <input type="hidden" name="question_type" value="scale">

                            <button style="margin-left:1300px">Valider</button>
                        </form>
                    @endif

                </div>
            @endforeach

        @endif
    </div>

    </body>
    </html>
</x-app-layout>
