<!DOCTYPE html>
<html>
<head>
    <title>Classement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>🏆 Classement des équipes</h2>

<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>Équipe</th>
            <th>Points</th>
            <th>Buts marqués</th>
            <th>Buts encaissés</th>
            <th>Différence</th>
        </tr>
    </thead>

    <tbody>
        @foreach($ranking as $r)
        <tr>
            <td>{{ $r['team'] }}</td>
            <td>{{ $r['points'] }}</td>
            <td>{{ $r['goalsFor'] }}</td>
            <td>{{ $r['goalsAgainst'] }}</td>
            <td>{{ $r['diff'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>