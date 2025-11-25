<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test création de sondage</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<h1>Tester la création d'un sondage</h1>

<form id="surveyForm" method="POST" action="{{ route('survey.store') }}">
    @csrf

    <div>
        <label for="title">Titre :</label>
        <input type="text" name="title" id="title" required>
    </div>

    <div>
        <label for="description">Description :</label>
        <textarea name="description" id="description" required></textarea>
    </div>

    <div>
        <label for="start_date">Date de début :</label>
        <input type="date" name="start_date" id="start_date" required>
    </div>

    <div>
        <label for="end_date">Date de fin :</label>
        <input type="date" name="end_date" id="end_date" required>
    </div>

    <div>
        <label for="anonymous">Anonyme :</label>
        <select name="anonymous" id="anonymous" required>
            <option value="1">Oui</option>
            <option value="0">Non</option>
        </select>
    </div>

    <button type="submit">Créer le sondage</button>
</form>

<div id="response" style="margin-top:20px;"></div>
</body>
</html>
