<!DOCTYPE html>
<html>
<head>
    <title>Matches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>🎮 Gestion des matchs</h2>

<!-- CREATE MATCH -->
<form method="POST" action="/matches">
    @csrf

    <div class="row">
        <div class="col">
            <select name="team1_id" class="form-control">
                @foreach($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col">
            <select name="team2_id" class="form-control">
                @foreach($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col">
            <button class="btn btn-primary">Créer match</button>
        </div>
    </div>
</form>

<hr>

<!-- LIST MATCHES -->
@foreach($matches as $match)
    <div class="border p-3 mt-3">

        <h5>
            {{ $match->team1->name }} VS {{ $match->team2->name }}
        </h5>

        <p>Score : {{ $match->score_team1 }} - {{ $match->score_team2 }}</p>

        <form method="POST" action="/matches/{{ $match->id }}/score">
            @csrf
            <input type="number" name="score_team1" value="{{ $match->score_team1 }}" class="form-control mb-1">
            <input type="number" name="score_team2" value="{{ $match->score_team2 }}" class="form-control mb-1">
            <button class="btn btn-success btn-sm">Update score</button>
        </form>

    </div>
@endforeach

</body>
</html>