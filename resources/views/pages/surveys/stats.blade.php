@extends('layouts.app')

@section('content')

<h1>{{ $stats->surveyTitle }}</h1>

@foreach($stats->questions as $i => $question)
    <div class="mt-6">
        <h2 class="text-lg font-bold">{{ $question->title }}</h2>

        <canvas id="chart{{ $i }}" width="600" height="300"></canvas>

        <script>
            const ctx{{ $i }} = document.getElementById('chart{{ $i }}');

            new Chart(ctx{{ $i }}, {
                type: '{{ $i === 0 ? "bar" : "pie" }}',
                data: {
                    labels: @json($question->labels),
                    datasets: [{
                        label: "Réponses",
                        data: @json($question->values),
                        borderWidth: 1
                    }]
                }
            });
        </script>
    </div>
@endforeach

@endsection
