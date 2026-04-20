<x-app-layout>
<div class="page-container">

    <!-- Team Header -->
    <div class="card" style="margin-bottom:1.5rem;background:linear-gradient(135deg, rgba(13,21,38,1), rgba(0,255,136,0.04));">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
            <div>
                <h1 style="font-family:'Rajdhani',sans-serif;font-size:2.2rem;font-weight:700;color:#e2eaf5;letter-spacing:2px;">
                    🛡️ {{ $team->name }}
                </h1>
                @if($team->description)
                <p style="color:#5a7a9a;margin-top:0.4rem;">{{ $team->description }}</p>
                @endif
                <div style="margin-top:0.5rem;font-size:0.8rem;color:#3d5a7a;">
                    Leader: <span style="color: var(--neon-cyan);">{{ $team->leader?->name ?? 'N/A' }}</span>
                    &nbsp;·&nbsp;Créée le {{ $team->created_at->format('d/m/Y') }}
                </div>
            </div>
            <div style="text-align:center;">
                <div class="stat-value">{{ number_format($team->score) }}</div>
                <div class="stat-label">points totaux</div>
            </div>
        </div>

        @if($isMember)
        <div style="margin-top:1.5rem;padding-top:1rem;border-top:1px solid var(--bg-border);display:flex;gap:0.75rem;flex-wrap:wrap;">
            <span class="badge" style="color:var(--neon-green);border-color:var(--neon-green);background:rgba(0,255,136,0.08);">
                ✅ Vous êtes membre
            </span>
            <form method="POST" action="{{ route('teams.leave') }}"
                  onsubmit="return confirm('Quitter cette équipe ?')">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">🚪 Quitter l'équipe</button>
            </form>
        </div>
        @endif
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;flex-wrap:wrap;">

        <!-- Members -->
        <div class="card">
            <div class="card-header">
                👥 Membres
                <span class="mono" style="margin-left:auto;font-size:0.8rem;color:#5a7a9a;">
                    {{ $team->users->count() }}/4
                </span>
            </div>

            <div class="progress-bar" style="margin-bottom:1rem;">
                <div class="progress-fill" style="width:{{ ($team->users->count() / 4) * 100 }}%;"></div>
            </div>

            @foreach($team->users as $member)
            <div style="display:flex;align-items:center;gap:0.75rem;padding:0.6rem 0;border-bottom:1px solid rgba(26,42,69,0.4);">
                <div class="avatar" style="width:30px;height:30px;font-size:0.7rem;">
                    {{ strtoupper(substr($member->name, 0, 2)) }}
                </div>
                <div>
                    <div style="font-size:0.9rem;color:#e2eaf5;">{{ $member->name }}</div>
                    @if($team->leader_id === $member->id)
                    <div style="font-size:0.7rem;color: var(--neon-green);">⭐ Leader</div>
                    @endif
                </div>
                <div style="margin-left:auto;font-size:0.75rem;color:#3d5a7a;">
                    {{ $member->solves->count() }} flags
                </div>
            </div>
            @endforeach

            @if($team->users->count() < 4)
            <div style="padding:0.75rem;text-align:center;color:#3d5a7a;font-size:0.8rem;margin-top:0.5rem;">
                {{ 4 - $team->users->count() }} place(s) disponible(s)
            </div>
            @else
            <div style="padding:0.75rem;text-align:center;font-size:0.8rem;color: var(--neon-red);">
                🔒 Équipe complète
            </div>
            @endif
        </div>

        <!-- Solved Challenges -->
        <div class="card">
            <div class="card-header">
                🚩 Challenges résolus
                <span class="mono" style="margin-left:auto;font-size:0.8rem;color: var(--neon-green);">
                    {{ $team->solves->count() }}
                </span>
            </div>

            @if($team->solves->isEmpty())
            <div style="text-align:center;padding:2rem;color:#3d5a7a;">
                <div style="font-size:2rem;">🔒</div>
                <p style="margin-top:0.5rem;font-size:0.85rem;">Aucun challenge résolu</p>
            </div>
            @else
            @foreach($team->solves as $solve)
            <div style="display:flex;align-items:center;gap:0.75rem;padding:0.6rem 0;border-bottom:1px solid rgba(26,42,69,0.4);">
                <span class="badge badge-{{ $solve->challenge->category }}">{{ $solve->challenge->category }}</span>
                <div>
                    <div style="font-size:0.85rem;color:#e2eaf5;">{{ $solve->challenge->title }}</div>
                    <div style="font-size:0.75rem;color:#3d5a7a;">par {{ $solve->user->name }}</div>
                </div>
                <div style="margin-left:auto;color: var(--neon-green);font-family:'JetBrains Mono',monospace;font-size:0.85rem;font-weight:600;">
                    +{{ $solve->challenge->points }}
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>

<style>
@media (max-width: 768px) {
    div[style*="grid-template-columns:1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
</x-app-layout>
