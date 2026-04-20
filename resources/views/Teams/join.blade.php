<x-app-layout>
@section('title', "Rejoindre une équipe")
<div class="page-container" style="max-width:500px;margin:0 auto;padding-top:3rem;">

    <div style="text-align:center;margin-bottom:2rem;">
        <div style="font-size:3rem;margin-bottom:1rem;">🔑</div>
        <h1 class="page-title">Rejoindre votre équipe</h1>
        <p style="color:var(--muted);font-size:0.9rem;margin-top:0.5rem;">
            Entrez le code secret fourni par votre établissement.
        </p>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('teams.join.post') }}">
            @csrf
            <div class="form-group">
                <label for="field">DOMAINE / SPORT</label>
                <select id="field" name="field" required style="font-size:1.1rem;text-align:center;padding:0.75rem;">
                    <option value="">— Sélectionnez le sport —</option>
                    @foreach(['foot', 'ctf', 'baskett', 'chess', 'volley ball', 'Esport'] as $f)
                    <option value="{{ $f }}" {{ old('field') == $f ? 'selected' : '' }}>{{ ucfirst($f) }}</option>
                    @endforeach
                </select>
                @error('field') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group" style="margin-top:1.5rem;">
                <label for="join_code">CODE D'ÉQUIPE</label>
                <input
                    id="join_code"
                    name="join_code"
                    type="text"
                    value="{{ old('join_code') }}"
                    placeholder="ex: ECOLE2024"
                    autocomplete="off"
                    style="font-size:1.2rem;text-align:center;letter-spacing:4px;text-transform:uppercase;font-weight:700;"
                    autofocus
                >
                @error('join_code')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;padding:0.8rem;font-size:1rem;margin-top:0.5rem;">
                ✅ Rejoindre l'équipe
            </button>
        </form>

        <div style="text-align:center;margin-top:1.25rem;">
            <a href="{{ route('home') }}" style="color:var(--muted);font-size:0.85rem;">← Retour à l'accueil</a>
        </div>
    </div>

    <div class="card" style="margin-top:1rem;border-color:rgba(245,158,11,0.2);background:rgba(245,158,11,0.03);">
        <div style="display:flex;gap:0.75rem;align-items:flex-start;">
            <span style="font-size:1.3rem;">💡</span>
            <p style="color:var(--muted);font-size:0.85rem;margin:0;line-height:1.6;">
                Le code vous a été communiqué par votre responsable d'établissement ou par l'administrateur de la compétition. Si vous ne l'avez pas, contactez-les.
            </p>
        </div>
    </div>

</div>
</x-app-layout>
