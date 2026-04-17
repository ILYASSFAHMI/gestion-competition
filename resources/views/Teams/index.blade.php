<!DOCTYPE html>
<html>
<head>
    <title>Teams</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>🏆 Gestion des équipes</h2>

<form method="POST" action="/teams">
    @csrf
    <input type="text" name="name" class="form-control" placeholder="Nom équipe">
    <button class="btn btn-primary mt-2">Ajouter</button>
</form>

<hr>

@if(isset($teams))
@foreach($teams as $team)
    <div class="d-flex justify-content-between mt-2">
        <span>{{ $team->name }}</span>

        <form method="POST" action="/teams/{{ $team->id }}">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm">Supprimer</button>
        </form>
    </div>
@endforeach
@endif

</body>
</html>