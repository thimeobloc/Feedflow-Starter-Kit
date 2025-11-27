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
                <p>Aucune question trouvée.</p>
            @else
                @foreach ($questions as $question)
                    <div class="question-card">
                        <form method="POST" action="{{ route('question.update', [$survey->id, $question->id]) }}">
                            @csrf
                            @method('PATCH')

                            <h2>{{ $question->title }} ({{ ucfirst($question->question_type) }})</h2>

                            <input type="hidden" name="question_type" value="{{ $question->question_type }}">

                            @if(in_array($question->question_type,['unique','multiple']))
                                @foreach($question->options as $idx => $option)
                                    <label>Option {{ $idx+1 }}:</label>
                                    <input type="text" name="options[]" value="{{ $option }}" class="option-input">
                                @endforeach
                            <button>Valider</button>
                            @endif
                        </form>
                    </div>
                @endforeach
            @endif
        </div>
    </body>
    </html>
</x-app-layout>