<x-app-layout>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>
        <div>
            <h1>Répondre au sondage : {{ $survey->title }}</h1>
            <p>{{ $survey->description }}</p>
        </div>

        <form method="POST" action="{{ route('answer.store') }}">
            @csrf
            <input type="hidden" name="survey_id" value="{{ $survey->id }}">

            @foreach ($questions as $question)
                <div>
                    <label>{{ $question->question_text }}</label>

                    @if ($question->type === 'text')
                        <input type="text" name="answers[{{ $question->title }}]">
                    @elseif($question->type === 'radio')
                        @foreach ($question->options as $option)
                            <div>
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}">
                                <label>{{ $option }}</label>
                            </div>
                        @endforeach
                    @elseif($question->type === 'checkbox')
                        @foreach ($question->options as $option)
                            <div>
                                <input type="checkbox" name="answers[{{ $question->id }}][]"
                                    value="{{ $option }}">
                                <label>{{ $option }}</label>
                            </div>
                        @endforeach
                    @elseif($question->type === 'scale')
                        <input type="number" name="answers[{{ $question->id }}]" min="1" max="10">
                    @endif
                </div>
            @endforeach

            <button type="submit">Soumettre les réponses</button>
        </form>
    </body>

</html>
</x-app-layout>
