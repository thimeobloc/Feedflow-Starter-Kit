<x-app-layout>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body>

    <!-- Vérifier s'il y a des questions à afficher -->
    @if (isset($questions) && count($questions) < 0)
        <p>Il n'y a pas de questions pour ce sondage.</p>
    @else
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
                <button type="submit">Envoyer mes réponses</button>
            </form>
        </div>
    @endif

    </body>
    </html>
</x-app-layout>
