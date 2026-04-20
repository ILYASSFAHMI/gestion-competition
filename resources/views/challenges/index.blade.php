<x-app-layout>
<div class="page-container">

    <!-- Header -->
    <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:2rem;">
        <div>
            <h1 class="page-title">🚩 CHALLENGES</h1>
            <p class="page-subtitle">Résolvez les défis, soumettez les flags, grimpez au classement</p>
        </div>
        @if(!auth()->user()->hasTeam())
        <div class="card" style="padding:1rem 1.25rem;border-color:rgba(251,191,36,0.3);">
            <p style="color:#fbbf24;font-size:0.85rem;">⚠️ Rejoignez ou créez une équipe pour soumettre des flags</p>
            <div style="display:flex;gap:0.5rem;margin-top:0.75rem;">
                <a href="{{ route('teams.create') }}" class="btn btn-primary btn-sm">Créer une équipe</a>
                <a href="{{ route('teams.join') }}" class="btn btn-secondary btn-sm">Rejoindre</a>
            </div>
        </div>
        @else
        <div class="card" style="padding:1rem 1.25rem;text-align:center;">
            <div class="stat-value" style="font-size:1.8rem;">{{ auth()->user()->team->score }}</div>
            <div class="stat-label">points — {{ auth()->user()->team->name }}</div>
        </div>
        @endif
    </div>

    <!-- Category Filter -->
    <div style="display:flex;gap:0.5rem;flex-wrap:wrap;margin-bottom:2rem;" id="category-filters">
        <button class="btn btn-secondary btn-sm active-filter" onclick="filterCategory('all')" id="filter-all">Tous</button>
        @foreach($categories as $cat)
        <button class="btn btn-secondary btn-sm" onclick="filterCategory('{{ $cat }}')" id="filter-{{ $cat }}">
            {{ strtoupper($cat) }}
        </button>
        @endforeach
    </div>

    <!-- Challenges Grid -->
    @if($challenges->isEmpty())
    <div class="card" style="text-align:center;padding:4rem;color:#5a7a9a;">
        <div style="font-size:3rem;">🔒</div>
        <p style="margin-top:1rem;">Aucun challenge disponible pour le moment.</p>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('challenges.create') }}" class="btn btn-primary" style="margin-top:1rem;">Créer le premier challenge</a>
        @endif
    </div>
    @else
    <div class="grid-3" id="challenges-grid">
        @foreach($challenges as $challenge)
        @php $isSolved = in_array($challenge->id, $solvedIds); @endphp
        <div class="card {{ $isSolved ? 'solved-card' : '' }}" data-category="{{ $challenge->category }}"
             style="position:relative;transition:all 0.2s;">
            @if($isSolved)
            <div class="solved-badge">✅ SOLVED</div>
            @endif

            <!-- Category & Points -->
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.75rem;">
                <span class="badge badge-{{ $challenge->category }}">{{ $challenge->category }}</span>
                <span class="mono" style="color: var(--neon-green); font-weight:600;">+{{ $challenge->points }} pts</span>
            </div>

            <!-- Title -->
            <h3 style="font-family:'Rajdhani',sans-serif;font-size:1.1rem;font-weight:600;color:#e2eaf5;margin-bottom:0.5rem;">
                {{ $challenge->title }}
            </h3>

            <!-- Difficulty -->
            <div style="margin-bottom:0.75rem;">
                <span class="badge badge-{{ $challenge->difficulty }}">{{ $challenge->difficulty }}</span>
            </div>

            <!-- Description -->
            <p style="font-size:0.82rem;color:#5a7a9a;margin-bottom:1rem;line-height:1.6;">
                {{ Str::limit($challenge->description, 100) }}
            </p>

            <!-- Solves count -->
            <div style="font-size:0.75rem;color:#3d5a7a;margin-bottom:1rem;">
                🏴 {{ $challenge->solves->count() }} équipe(s) ont résolu
            </div>

            <!-- File download -->
            @if($challenge->file_url)
            <div style="margin-bottom:1rem;">
                <a href="{{ $challenge->file_url }}" target="_blank"
                   style="color: var(--neon-cyan); font-size:0.8rem; text-decoration:none;">
                    📎 Télécharger le fichier
                </a>
            </div>
            @endif

            <!-- Flag submission -->
            @if(auth()->user()->hasTeam() && !$isSolved)
            <form method="POST" action="{{ route('challenges.submit', $challenge) }}">
                @csrf
                <div style="display:flex;gap:0.5rem;">
                    <input type="text" name="flag" placeholder="CTF{votre_flag}" 
                           style="font-family:'JetBrains Mono',monospace;font-size:0.8rem;flex:1;"
                           autocomplete="off" required>
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </div>
                @error('flag')<div class="form-error">{{ $message }}</div>@enderror
            </form>
            @elseif(!auth()->user()->hasTeam())
            <div style="font-size:0.78rem;color:#3d5a7a;">Rejoignez une équipe pour soumettre</div>
            @endif
        </div>
        @endforeach
    </div>
    @endif
</div>

<script>
function filterCategory(cat) {
    document.querySelectorAll('#challenges-grid .card').forEach(card => {
        if (cat === 'all' || card.dataset.category === cat) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
    document.querySelectorAll('#category-filters .btn').forEach(b => {
        b.style.borderColor = '';
        b.style.color = '';
    });
    const active = document.getElementById('filter-' + cat);
    if (active) {
        active.style.borderColor = 'var(--neon-green)';
        active.style.color = 'var(--neon-green)';
    }
}
</script>
</x-app-layout>
