@extends('layouts.app')
<head>
    <title>Survey Statistics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

@section('content')
    <div class="container">
        <h1>Survey Statistics</h1>
        <canvas id="myChart" width="400" height="200"></canvas>
    </div>
@endsection

<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'circle',
    data: {
      labels: ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimaanche'],
      datasets: [{
        label: 'Nombre de réponses par jour',
        data: [78, 56, 23, 8, 2, 3],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>