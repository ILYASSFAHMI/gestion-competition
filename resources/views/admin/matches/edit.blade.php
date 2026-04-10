<x-app-layout>
@section('title', 'Modifier le match')
<div class="page-container" style="max-width:600px;">
    <div class="page-header">
        <a href="{{ route('admin.matches.index') }}" style="color:var(--muted);font-size:0.85rem;">← Retour aux matchs</a>
        <h1 class="page-title" style="margin-top:0.5rem;">✏️ Gérer le match</h1>
    </div>

    <div class="card" style="margin-bottom:1.5rem;">
        <h2 style="font-size:1.1rem;font-weight:bold;margin-bottom:1rem;">Informations du match</h2>
        <form method="POST" action="{{ route('admin.matches.update', $match) }}">
            @csrf @method('PUT')

            <div style="font-weight:600;font-size:1.2rem;text-align:center;margin-bottom:1rem;">
                {{ $match->team1->name }} <span style="color:var(--muted);font-size:0.9rem;">VS</span> {{ $match->team2->name }}
                <div style="font-size:0.8rem;color:var(--primary);margin-top:0.3rem;">Domaine: {{ $match->field }}</div>
            </div>

            <div class="form-group">
                <label for="match_date">DATE ET HEURE *</label>
                <input id="match_date" name="match_date" type="datetime-local" value="{{ old('match_date', $match->match_date->format('Y-m-d\TH:i')) }}" required>
                @error('match_date') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="status">STATUT *</label>
                <select id="status" name="status" required>
                    <option value="upcoming" {{ old('status', $match->status) == 'upcoming' ? 'selected' : '' }}>À venir</option>
                    <option value="live" {{ old('status', $match->status) == 'live' ? 'selected' : '' }}>En cours</option>
                    <option value="finished" {{ old('status', $match->status) == 'finished' ? 'selected' : '' }}>Terminé</option>
                </select>
                @error('status') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div style="display:flex;gap:0.75rem;margin-top:1.5rem;">
                <button type="submit" class="btn btn-secondary" style="flex:1;">Mettre à jour la date/statut</button>
            </div>
        </form>
    </div>

    <div class="card" style="border-color:rgba(16,185,129,0.3);background:rgba(16,185,129,0.03);">
        <h2 style="font-size:1.1rem;font-weight:bold;color:#10b981;margin-bottom:1rem;">Valider le résultat du match</h2>
        <p style="font-size:0.85rem;color:var(--muted);margin-bottom:1rem;">Définissez qui a gagné, perdu ou s'il y a égalité. Le statut passera automatiquement à "Terminé" et les points (+3, +1, 0) seront attribués.</p>
        <form method="POST" action="{{ route('admin.matches.resolve', $match) }}">
            @csrf

            <div class="form-group" style="margin-bottom:1.5rem;">
                <label for="match_result">RÉSULTAT DU MATCH *</label>
                <select id="match_result" name="match_result" required style="font-size:1rem;padding:0.8rem;">
                    <option value="">— Sélectionnez le résultat —</option>
                    <option value="team1_wins">🏆 Victoire de {{ $match->team1->name }} (+3 pts)</option>
                    <option value="draw">🤝 Égalité (+1 pt chacun)</option>
                    <option value="team2_wins">🏆 Victoire de {{ $match->team2->name }} (+3 pts)</option>
                </select>
                @error('match_result') <div class="form-error" style="margin-top:0.5rem;color:red;">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn" style="width:100%;background:#10b981;color:white;font-size:1rem;">✅ Valider le match et attribuer les points</button>
        </form>
    </div>
</div>
</x-app-layout>
