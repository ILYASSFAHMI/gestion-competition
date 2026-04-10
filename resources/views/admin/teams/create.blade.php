<x-app-layout>
@section('title', 'Créer une équipe')
<div class="page-container" style="max-width:640px;">

    <div class="page-header">
        <a href="{{ route('admin.teams.index') }}" style="color:var(--muted);font-size:0.85rem;">← Retour aux équipes</a>
        <h1 class="page-title" style="margin-top:0.5rem;">🏫 Nouvelle équipe</h1>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('admin.teams.store') }}">
            @csrf

            <div class="form-group">
                <label for="name">NOM DE L'ÉCOLE / ÉQUIPE *</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="ex: Lycée Ibn Khaldoun" required autofocus>
                @error('name') <div class="form-error">{{ $message }}</div> @enderror
            </div>

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
                <label for="join_code">CODE D'ACCÈS * <span style="color:var(--muted);font-weight:400;">(les participants utiliseront ce code)</span></label>
                <div style="display:flex;gap:0.75rem;">
                    <input id="join_code" name="join_code" type="text" value="{{ old('join_code', strtoupper(Str::random(6))) }}"
                        placeholder="ex: IBKH24" style="letter-spacing:3px;font-weight:700;text-transform:uppercase;" required>
                    <button type="button" class="btn btn-secondary" style="white-space:nowrap;" onclick="document.getElementById('join_code').value = Math.random().toString(36).substring(2,8).toUpperCase()">🔄 Générer</button>
                </div>
                <div style="font-size:0.75rem;color:var(--muted);margin-top:0.4rem;">Minimum 4 caractères. Sera saisi par les participants pour rejoindre l'équipe.</div>
                @error('join_code') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="max_members">NOMBRE MAX DE MEMBRES *</label>
                <input id="max_members" name="max_members" type="number" value="{{ old('max_members', 4) }}" min="1" max="20" required>
                @error('max_members') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="description">DESCRIPTION <span style="font-weight:400;color:var(--muted);">(optionnel)</span></label>
                <textarea id="description" name="description" placeholder="Informations sur l'école...">{{ old('description') }}</textarea>
                @error('description') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div style="display:flex;gap:0.75rem;margin-top:1.5rem;">
                <button type="submit" class="btn btn-primary" style="flex:1;padding:0.75rem;">✅ Créer l'équipe</button>
                <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>

</div>
</x-app-layout>
