<x-app-layout>
    <div class="container">

        <h2>Répondre au sondage</h2>

        {{-- MESSAGE SI DÉJÀ RÉPONDU --}}
        @if($alreadyAnswered)
            <p class="already-answered">Vous avez déjà répondu à ce sondage.</p>
        @endif

        {{-- Message success si on vient d'envoyer --}}
        @if(session('success'))
            <p style="color: green; font-weight: bold;">{{ session('success') }}</p>
        @endif


        @php
            $disabled = $alreadyAnswered ? 'disabled' : '';
        @endphp

        <form method="POST" action="{{ route('answer.store') }}">
            @csrf
            <input type="hidden" name="survey_id" value="{{ $survey->id }}">

            @foreach ($questions as $question)

                @php
                    $saved = $existingAnswers[$question->id]->answer ?? null;
                @endphp

                <div class="question-block">
                    <label>{{ $question->title }}</label>

                    {{-- TEXT --}}
                    @if ($question->question_type === 'text')
                        <input type="text"
                               name="answers[{{ $question->id }}]"
                               value="{{ $saved[0] ?? '' }}"
                               {{ $disabled }}>

                    {{-- UNIQUE --}}
                    @elseif ($question->question_type === 'unique')
                        @foreach ($question->options as $option)
                            <div class="option">
                                <input type="radio"
                                       name="answers[{{ $question->id }}]"
                                       value="{{ $option }}"
                                       @checked($saved && $saved[0] === $option)
                                       {{ $disabled }}>
                                <span>{{ $option }}</span>
                            </div>
                        @endforeach

                    {{-- MULTIPLE --}}
                    @elseif ($question->question_type === 'multiple')
                        @foreach ($question->options as $option)
                            <div class="option">
                                <input type="checkbox"
                                       name="answers[{{ $question->id }}][]"
                                       value="{{ $option }}"
                                       @checked($saved && in_array($option, $saved))
                                       {{ $disabled }}>
                                <span>{{ $option }}</span>
                            </div>
                        @endforeach

                    {{-- SCALE --}}
                    @elseif ($question->question_type === 'scale')
                        @php
                            $value = $saved[0] ?? 5;
                        @endphp

                        <input type="range"
                               name="answers[{{ $question->id }}]"
                               min="1" max="10"
                               value="{{ $value }}"
                               oninput="this.nextElementSibling.textContent = this.value"
                               {{ $disabled }}>

                        <span>{{ $value }}</span>
                    @endif
                </div>

            @endforeach


            {{-- BOUTON --}}
            @if ($alreadyAnswered)
                <a href="{{ route('survey', ['organization' => $survey->organization_id, 'survey' => $survey->id]) }}"
                   class="btn-return">Retour a la liste des sondages</a>
            @else
                <button type="submit">Envoyer mes réponses</button>
            @endif

        </form>
    </div>

    <style>
        body { font-family: Arial, sans-serif; background: #f4f6fb; margin: 0; padding: 0; }
        .container { max-width: 800px; margin: 40px auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }

        h2 { text-align: center; font-size: 28px; color: #2b6cb0; margin-bottom: 10px; }

        .already-answered {
            text-align: center;
            padding: 12px;
            font-weight: bold;
            background: #ffe8e8;
            color: #c70000;
            border: 1px solid #ffbfbf;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .question-block { margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid #e5e5e5; }
        .question-block label { display: block; font-weight: bold; margin-bottom: 10px; }

        input[type="text"], input[type="number"] {
            width: 100%; padding: 12px; border-radius: 8px;
            border: 1px solid #ccc; font-size: 15px;
        }

        .option { display: flex; align-items: center; margin: 6px 0; }
        .option input { margin-right: 8px; }

        button {
            width: 100%; padding: 15px; font-size: 16px; font-weight: bold;
            color: white; background-color: #2b6cb0; border: none;
            border-radius: 10px; cursor: pointer; transition: 0.3s;
        }
        button:hover { background-color: #245a94; }

        .btn-return {
            display: block; text-align: center; padding: 15px;
            background: #6c757d; color: white; font-weight: bold;
            border-radius: 10px; text-decoration: none; margin-top: 20px;
            transition: 0.3s;
        }
        .btn-return:hover { background: #5a6268; }

        input:disabled {
            background: #e9ecef; cursor: not-allowed;
        }
    </style>
</x-app-layout>
