<x-app-layout>
@section('title', 'Mon Espace')
<div class="page-container">

    <div class="page-header" style="display:flex;align-items:center;justify-content:space-between;">
        <div>
            <h1 class="page-title">👋 Bonjour, {{ auth()->user()->name }}</h1>
            <p class="page-subtitle">Bienvenue sur votre espace de compétition</p>
        </div>
    </div>

    @if(!auth()->user()->hasTeam())
    {{-- Pas encore dans une équipe --}}
    <div class="card" style="text-align:center;padding:3rem;max-width:500px;margin:0 auto;border-style:dashed;">
        <div style="font-size:3rem;margin-bottom:1rem;">🔑</div>
        <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.3rem;font-weight:700;margin:0 0 0.5rem;">
            Rejoignez votre équipe
        </h2>
        <p style="color:var(--muted);margin:0 0 1.5rem;font-size:0.9rem;">
            Saisissez le code fourni par votre établissement pour rejoindre votre équipe.
        </p>
        <a href="{{ route('teams.join') }}" class="btn btn-primary" style="font-size:1rem;padding:0.75rem 2rem;">
            Entrer le code de mon école
        </a>
    </div>

    @else
    {{-- Membre d'une équipe --}}
    @php $team = auth()->user()->team; @endphp

    <div class="stat-grid" style="grid-template-columns:repeat(auto-fill,minmax(200px,1fr));">
        <div class="stat-box">
            <div class="stat-value" style="color:var(--primary);">{{ number_format($team->score) }}</div>
            <div class="stat-label">Points de l'équipe</div>
        </div>
        <div class="stat-box">
            <div class="stat-value">{{ $team->membersCount() }}/{{ $team->max_members }}</div>
            <div class="stat-label">Membres</div>
        </div>
        <div class="stat-box">
            <div class="stat-value">{{ $team->availableSlots() }}</div>
            <div class="stat-label">Places restantes</div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;max-width:900px;">

        {{-- Infos équipe --}}
        <div class="card">
            <div style="font-size:1.1rem;font-weight:700;margin-bottom:1rem;display:flex;align-items:center;justify-content:space-between;gap:0.5rem;">
                <span>🏫 {{ $team->name }}</span>
                <span style="font-size:0.75rem;background:rgba(99,102,241,0.1);color:var(--primary);padding:0.2rem 0.5rem;border-radius:6px;text-transform:uppercase;">{{ $team->field }}</span>
            </div>
            @if($team->description)
            <p style="color:var(--muted);font-size:0.875rem;margin:0 0 1rem;">{{ $team->description }}</p>
            @endif
            <div style="background:rgba(99,102,241,0.06);border:1px solid rgba(99,102,241,0.2);border-radius:10px;padding:1rem;text-align:center;">
                <div style="font-size:0.7rem;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:0.3rem;">Score actuel</div>
                <div style="font-family:'Space Grotesk',sans-serif;font-size:2rem;font-weight:700;color:var(--primary);">{{ number_format($team->score) }} pts</div>
            </div>
            <div style="margin-top:1rem;">
                <form method="POST" action="{{ route('teams.leave') }}" onsubmit="return confirm('Quitter l\'équipe ?')">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm" style="width:100%;">🚪 Quitter l'équipe</button>
                </form>
            </div>
        </div>

        {{-- Membres --}}
        <div class="card">
            <div style="font-size:1.1rem;font-weight:700;margin-bottom:1rem;">👥 Membres de l'équipe</div>
            @foreach($team->members as $member)
            <div style="display:flex;align-items:center;gap:0.75rem;padding:0.6rem 0;{{ !$loop->last ? 'border-bottom:1px solid var(--border);' : '' }}">
                <div style="width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,var(--primary),#8b5cf6);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.8rem;color:white;">
                    {{ strtoupper(substr($member->name, 0, 2)) }}
                </div>
                <div>
                    <div style="font-weight:600;font-size:0.875rem;">{{ $member->name }}</div>
                    <div style="font-size:0.75rem;color:var(--muted);">{{ $member->email }}</div>
                </div>
                @if($member->id === auth()->id())
                <span style="margin-left:auto;font-size:0.7rem;color:var(--primary);background:rgba(99,102,241,0.1);padding:0.1rem 0.5rem;border-radius:4px;">vous</span>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
</x-app-layout>
