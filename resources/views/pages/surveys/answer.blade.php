<x-app-layout>
    <div class="container">
        @if (!isset($questions) || $questions->isEmpty())
            <p>Il n'y a pas de questions pour ce sondage.</p>
        @else
            <h2>Répondre au sondage</h2>

            @if(session('success'))
                <p style="color: green; font-weight: bold;">{{ session('success') }}</p>
            @endif

            <form method="POST" action="{{ route('answer.store') }}">
                @csrf
                <input type="hidden" name="survey_id" value="{{ $survey->id }}">

                @foreach ($questions as $question)
                    <div class="question-block">
                        <label>{{ $question->title }}</label>

                        @if ($question->question_type === 'text')
                            <input type="text" name="answers[{{ $question->id }}]">

                        @elseif ($question->question_type === 'unique')
                            @foreach ($question->options as $option)
                                <div class="option">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}">
                                    <span>{{ $option }}</span>
                                </div>
                            @endforeach

                        @elseif ($question->question_type === 'multiple')
                            @foreach ($question->options as $option)
                                <div class="option">
                                    <input type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $option }}">
                                    <span>{{ $option }}</span>
                                </div>
                            @endforeach

                        @elseif ($question->question_type === 'scale')
                            <input type="range" name="answers[{{ $question->id }}]" min="1" max="10" step="1" value="5" oninput="this.nextElementSibling.textContent = this.value">
                            <span>5</span>
                        @endif
                    </div>
                @endforeach

                <button type="submit">Envoyer mes réponses</button>
            </form>
        @endif
    </div>

    <style>
        body { font-family: Arial, sans-serif; background: #f4f6fb; margin: 0; padding: 0; }
        .container { max-width: 800px; margin: 40px auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { text-align: center; font-size: 28px; color: #2b6cb0; margin-bottom: 25px; }
        .question-block { margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid #e5e5e5; }
        .question-block label { display: block; font-weight: bold; margin-bottom: 10px; }
        input[type="text"], input[type="number"] { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 15px; margin-top: 6px; }
        .option { display: flex; align-items: center; margin: 6px 0; }
        .option input { margin-right: 8px; }
        button { width: 100%; padding: 15px; font-size: 16px; font-weight: bold; color: white; background-color: #2b6cb0; border: none; border-radius: 10px; cursor: pointer; transition: 0.3s; }
        button:hover { background-color: #245a94; }
        p { text-align: center; font-size: 18px; }
    </style>
</x-app-layout>
