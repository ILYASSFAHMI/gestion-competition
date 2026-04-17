<!DOCTYPE html>
<html>
<head>
    <title>Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>👤 Gestion des utilisateurs</h2>

@foreach($users as $user)
    <div class="d-flex justify-content-between align-items-center mt-3 border p-2">

        <div>
            <strong>{{ $user->name }}</strong><br>
            <small>Team: {{ $user->team->name ?? 'Aucune' }}</small>
        </div>

        <form method="POST" action="/users/{{ $user->id }}/team">
            @csrf
            <select name="team_id" class="form-select">
                <option value="">Aucune</option>
                @foreach($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary btn-sm mt-1">Changer</button>
        </form>

    </div>
@endforeach

</body>
</html>