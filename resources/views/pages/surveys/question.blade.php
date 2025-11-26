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
                                @if($question->question_type === "text")
                                    <form method="POST" action="{{route('question', [$token, "text"])}}">
                                        @csrf
                                        @method("PATCH")
                                        <h2 class="text-xl font-bold">Question : {{ $question->title }} ET Type de réponse: text</h2>
                                        <input type="hidden" value="text">
                                        <button style="margin-left: 1130px">Valider la question</button>
                                    </form>
                                @endif

                                @if($question->question_type === "unique")
                                <form method="POST" action="{{route('question', [$token, "A FAIRE URGEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEENT"])}}">
                                    @csrf
                                    @method("PATCH")
                                    <h2 class="text-xl font-bold">{{ $question->title}} Type de réponse: choix unique</h2>
                                    <input value="Choix 1" type="text" name="option1" style="border:2px solid black; margin-left:5px;">

                                    <input value="Choix 2" type="text" name="option2" style="border:2px solid black; margin-left:5px;">

                                    <input value="Choix 3" type="text" name="option3" style="border:2px solid black; margin-left:5px;">

                                    <input value="Choix 4" type="text" name="option4" style="border:2px solid black; margin-left:5px;">
                                    <button style="margin-left: 1340px">Valider la question</button>
                                </form>
                                @endif

                                @if($question->question_type === "scale")
                                    <form method="POST" action="{{route('question', [$token, "scale"])}}">
                                        @csrf
                                        @method("PATCH")
                                    <h2 class="text-xl font-bold">{{ $question->title }} Type de réponse: échelle</h2>
                                    <label for="scaleId">Notez de 1 à 10 :</label>
                                    <input type="range" id="scaleId" name="scale" min="1" max="10" step="1" value="5">
                                    <span id="scaleValue">5</span>
                                    <script>
                                        const slider = document.getElementById('scaleId');
                                        const output = document.getElementById('scaleValue');
                                        slider.addEventListener('input', function() {
                                            output.textContent = this.value;
                                        });
                                    </script>
                                    <button style="margin-left: 1000px">Valider la question</button>
                                    </form>
                                @endif
                        </div>
                @endforeach
            @endif
        </div>

    <div>
    </div>

    </body>
    </html>

</x-app-layout>


