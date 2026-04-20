<x-app-layout>
<div class="page-container" style="max-width:640px;">

    <div style="margin-bottom:2rem;">
        <h1 class="page-title">➕ CRÉER UNE ÉQUIPE</h1>
        <p class="page-subtitle">Vous serez le leader — partagez le mot de passe avec vos coéquipiers</p>
    </div>

    <div class="card">
        <div class="card-header">⚙️ Configuration de l'équipe</div>

        <form method="POST" action="{{ route('teams.store') }}">
            @csrf

            <div class="form-group">
                <label for="name">Nom de l'équipe</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                       placeholder="HackersUnited, 0x1337..." required maxlength="50">
                @error('name')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="description">Description (optionnel)</label>
                <textarea id="description" name="description" rows="2"
                          placeholder="Présentez votre équipe...">{{ old('description') }}</textarea>
                @error('description')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="password">Mot de passe de l'équipe</label>
                <input type="password" id="password" name="password"
                       placeholder="Min. 6 caractères" required minlength="6">
                <div style="font-size:0.75rem;color:#5a7a9a;margin-top:0.3rem;">
                    Ce mot de passe sera demandé aux personnes qui souhaitent rejoindre votre équipe.
                </div>
                @error('password')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       placeholder="Répétez le mot de passe" required>
            </div>

            <div style="background:rgba(0,212,255,0.05);border:1px solid rgba(0,212,255,0.2);border-radius:8px;padding:0.9rem;margin-bottom:1.25rem;">
                <p style="font-size:0.82rem;color:#8ca0c0;">
                    ℹ️ Maximum <strong style="color: var(--neon-cyan);">4 membres</strong> par équipe.
                    Vous ne pouvez créer qu'<strong style="color: var(--neon-cyan);">une seule équipe</strong>.
                </p>
            </div>

            <div style="display:flex;gap:0.75rem;">
                <button type="submit" class="btn btn-primary">⚡ Créer l'équipe</button>
                <a href="{{ route('teams.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
