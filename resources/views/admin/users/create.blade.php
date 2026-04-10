<x-app-layout>
@section('title', 'Créer un utilisateur')
<div class="page-container" style="max-width:600px;">

    <div class="page-header">
        <a href="{{ route('admin.users.index') }}" style="color:var(--muted);font-size:0.85rem;">← Retour aux utilisateurs</a>
        <h1 class="page-title" style="margin-top:0.5rem;">👤 Nouvel utilisateur</h1>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="form-group">
                <label for="name">NOM COMPLET *</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus placeholder="ex: Ahmed Benali">
                @error('name') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="email">ADRESSE EMAIL *</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required placeholder="ex: ahmed@ecole.dz">
                @error('email') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label for="password">MOT DE PASSE *</label>
                    <input id="password" name="password" type="password" required placeholder="Min. 6 caractères">
                    @error('password') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">CONFIRMER MDP *</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label for="role">RÔLE *</label>
                    <select id="role" name="role" required>
                        <option value="user"  {{ old('role','user') === 'user'  ? 'selected' : '' }}>Participant</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrateur</option>
                    </select>
                    @error('role') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="team_id">ÉQUIPE <span style="font-weight:400;color:var(--muted);">(optionnel)</span></label>
                    <select id="team_id" name="team_id">
                        <option value="">— Sans équipe —</option>
                        @foreach($teams as $team)
                        <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}
                            {{ $team->isFull() ? 'disabled' : '' }}>
                            {{ $team->name }} ({{ $team->membersCount() }}/{{ $team->max_members }}){{ $team->isFull() ? ' — Complet' : '' }}
                        </option>
                        @endforeach
                    </select>
                    @error('team_id') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="display:flex;gap:0.75rem;margin-top:1.5rem;">
                <button type="submit" class="btn btn-primary" style="flex:1;padding:0.75rem;">✅ Créer l'utilisateur</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>

</div>
</x-app-layout>
