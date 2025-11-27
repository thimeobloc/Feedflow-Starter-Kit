<x-app-layout>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://unpkg.com/alpinejs" defer></script>
    </head>

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

    <!-- Vérifier s'il y a des questions à afficher -->
    @if (isset($questions) && count($questions) > 0)

        <!-- Alpine.js gère l'ouverture/fermeture de la modal -->
        <div x-data="{ open: false }">

            <!-- Bouton pour ouvrir la modal -->
            <button @click="open = true">Répondre au sondage</button>

            <!-- Modal de réponse au sondage -->
            <div x-show="open">
                <div>
                    <h2>Répondre au sondage</h2>

                    <!-- Formulaire d'envoi des réponses -->
                    <form method="POST" action="{{ route('answer.store') }}">
                        @csrf
                        <input type="hidden" name="survey_id" value="{{ $survey->id }}">

                        <!-- Afficher chaque question -->
                        @foreach ($questions as $question)
                            <div>
                                <label>{{ $question->question_text }}</label>

                                <!-- Adapter le champ selon le type de question -->
                                @if ($question->type === 'text')
                                    <input type="text" name="answers[{{ $question->id }}]"
                                        placeholder="Votre réponse ici…">
                                @elseif ($question->type === 'radio')
                                    @foreach ($question->options as $opt)
                                        <label>
                                            <input type="radio" name="answers[{{ $question->id }}]"
                                                value="{{ $opt }}">
                                            {{ $opt }}
                                        </label>
                                    @endforeach
                                @elseif ($question->type === 'checkbox')
                                    @foreach ($question->options as $opt)
                                        <label>
                                            <input type="checkbox" name="answers[{{ $question->id }}][]"
                                                value="{{ $opt }}">
                                            {{ $opt }}
                                        </label>
                                    @endforeach
                                @elseif ($question->type === 'scale')
                                    <input type="number" name="answers[{{ $question->id }}]" min="1"
                                        max="10" placeholder="1 à 10">
                                @endif
                            </div>
                            <br>
                        @endforeach

                        <button type="button" @click="open = false">Annuler</button>
                        <button type="submit">Envoyer mes réponses</button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <script>
        // Afficher/masquer les options selon le type de question sélectionné
        document.getElementById('typeSelect').addEventListener('change', function() {
            const container = document.getElementById('optionsContainer');
            this.value === 'radio' || this.value === 'checkbox' ?
                container.classList.remove('hidden') :
                container.classList.add('hidden');
        });

        // Ajouter une nouvelle option au formulaire
        function addOption() {
            const list = document.getElementById('optionsList');
            const input = document.createElement('input');
            input.type = "text";
            input.name = "options[]";
            input.placeholder = "Nouvelle option";
            input.className = "border p-2 w-full my-1";
            list.appendChild(input);
        }
    </script>



    </html>

</x-app-layout>
