<x-app-layout>
@section('title', 'Programmer un match')
<div class="page-container" style="max-width:600px;">
    <div class="page-header">
        <a href="{{ route('admin.matches.index') }}" style="color:var(--muted);font-size:0.85rem;">← Retour aux matchs</a>
        <h1 class="page-title" style="margin-top:0.5rem;">🗓️ Programmer un match</h1>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('admin.matches.store') }}">
            @csrf

            <div class="form-group">
                <label for="field">DOMAINE / SPORT *</label>
                <select id="field" name="field" required>
                    <option value="">— Sélectionner le domaine —</option>
                    @foreach(['foot', 'ctf', 'baskett', 'chess', 'volley ball', 'Esport'] as $f)
                    <option value="{{ $f }}" {{ old('field') == $f ? 'selected' : '' }}>{{ ucfirst($f) }}</option>
                    @endforeach
                </select>
                @error('field') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="team1_id">ÉQUIPE 1 *</label>
                <select id="team1_id" name="team1_id" required>
                    <option value="">— Sélectionner —</option>
                    @foreach($teams as $team)
                    <option value="{{ $team->id }}" {{ old('team1_id') == $team->id ? 'selected' : '' }}>{{ $team->name }} ({{ $team->field }})</option>
                    @endforeach
                </select>
                @error('team1_id') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="team2_id">ÉQUIPE 2 *</label>
                <select id="team2_id" name="team2_id" required>
                    <option value="">— Sélectionner —</option>
                    @foreach($teams as $team)
                    <option value="{{ $team->id }}" {{ old('team2_id') == $team->id ? 'selected' : '' }}>{{ $team->name }} ({{ $team->field }})</option>
                    @endforeach
                </select>
                @error('team2_id') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="match_date">DATE ET HEURE *</label>
                <input id="match_date" name="match_date" type="datetime-local" value="{{ old('match_date') }}" required>
                @error('match_date') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div style="display:flex;gap:0.75rem;margin-top:1.5rem;">
                <button type="submit" class="btn btn-primary" style="flex:1;">✅ Programmer</button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
