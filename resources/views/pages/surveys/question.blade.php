<x-app-layout>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <style>
            body {
                font-family: Arial, sans-serif;
                background: #f4f6fb;
                margin: 0;
                padding: 0;
            }
            .container {
                max-width: 900px;
                margin: 40px auto;
                background: white;
                padding: 30px;
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            }
            h1, h2 {
                color: #2b6cb0;
            }
            h1 {
                text-align: center;
                margin-bottom: 10px;
            }
            p {
                margin-bottom: 10px;
            }
            form {
                margin-top: 20px;
            }
            input[type="text"], select {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 8px;
                margin-bottom: 15px;
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
            .question-card {
                background: #fff;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.05);
                margin-bottom: 15px;
            }
            label {
                font-weight: bold;
                margin-top: 10px;
                display: block;
            }
            input.option-input {
                margin-left: 5px;
                margin-bottom: 5px;
            }
            .survey-info {
                display: flex;
                justify-content: space-around;
                margin-bottom: 40px; /* plus d'espace entre paramètres et questions */
            }
        </style>
        <script>
            function addOption() {
                const container = document.getElementById('optionsContainer');
                const input = document.createElement('input');
                input.type = 'text';
                input.name = 'options[]';
                input.placeholder = 'Nouvelle option';
                input.classList.add('option-input');
                container.appendChild(input);
            }
            document.getElementById('typeSelect')?.addEventListener('change', function() {
                document.getElementById('optionsContainer').style.display = ['unique','multiple'].includes(this.value) ? 'block' : 'none';
            });
        </script>
    </head>










    <body>
        <div class="container">
            <h1>{{ $survey->title }}</h1>
            <p>{{ $survey->description }}</p>

            <div class="survey-info">
                <div><p>Début</p><p>{{ $survey->start_date }}</p></div>
                <div><p>Fin</p><p>{{ $survey->end_date }}</p></div>
                <div><p>{{ $survey->is_anonymous ? '👤 Non Anonyme' : '🔒 Anonyme' }}</p></div>
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
                    <input type="text" name="options[]" placeholder="Option 1" class="option-input">
                    <input type="text" name="options[]" placeholder="Option 2" class="option-input">
                    <button type="button" onclick="addOption()">Ajouter option</button>
                </div>

                <button type="submit">Ajouter la question</button>
            </form>

            <h2>Liste des questions</h2>
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

                        {{-- QUESTION CHOIX MULTIPLE --}}
                        @if($question->question_type === "multiple")
                            <form method="POST" action="{{ route('question.update', [$survey->id, $question->id]) }}">
                                @csrf
                                @method("PATCH")

                                <h2 class="text-xl font-bold">{{ $question->title }} (Choix Multiple)</h2>

                                <input type="hidden" name="question_type" value="multiple">
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

