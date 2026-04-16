<x-app-layout>
@section('title', 'Accueil')
<div class="page-container">

    {{-- Hero --}}
    <div style="text-align:center; padding: 3rem 0 4rem;">
        <div style="display:inline-block;padding:0.3rem 1rem;border-radius:99px;background:rgba(99,102,241,0.1);border:1px solid rgba(99,102,241,0.3);color:var(--primary);font-size:0.78rem;font-weight:600;letter-spacing:1px;text-transform:uppercase;margin-bottom:1.5rem;">
            🏆 Compétition Inter-Écoles
        </div>
        <h1 style="font-family:'Space Grotesk',sans-serif;font-size:3rem;font-weight:800;letter-spacing:-1px;margin:0 0 1rem;line-height:1.1;">
            Qui décrochera la<br><span style="background:linear-gradient(90deg,var(--primary),#8b5cf6);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Première Place ?</span>
        </h1>
        <p style="color:var(--muted);font-size:1rem;max-width:480px;margin:0 auto 2rem;">
            Suivez les scores en direct et rejoignez l'équipe de votre école pour participer.
        </p>
        @guest
        <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('register') }}" class="btn btn-primary" style="padding:0.75rem 2rem;font-size:1rem;">
                ✨ Créer un compte
            </a>
            <a href="{{ route('login') }}" class="btn btn-secondary" style="padding:0.75rem 2rem;font-size:1rem;">
                Se connecter
            </a>
        </div>
        @endguest
        @auth
            @if(!auth()->user()->hasTeam() && !auth()->user()->isAdmin())
            <a href="{{ route('teams.join') }}" class="btn btn-primary" style="padding:0.75rem 2rem;font-size:1rem;">
                🔑 Rejoindre mon équipe
            </a>
            @endif
        @endauth
    </div>

    <div style="display:grid;grid-template-columns:1fr 350px;gap:2rem;">
        
        {{-- Left: Leaderboards --}}
        <div>
            @if($teamsByField->isEmpty())
                <div style="text-align:center;color:var(--muted);padding:3rem;">
                    <div style="font-size:3rem;margin-bottom:1rem;">🏫</div>
                    <p>Aucune équipe inscrite pour l'instant.</p>
                    @if(auth()->check() && auth()->user()->isAdmin())
                    <a href="{{ route('admin.teams.create') }}" class="btn btn-primary" style="margin-top:1rem;">Créer la première équipe</a>
                    @endif
                </div>
            @else
                @foreach($teamsByField as $field => $teams)
                <div style="margin-bottom:2.5rem;">
                    <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.3rem;font-weight:700;margin-bottom:1rem;display:flex;align-items:center;gap:0.5rem;">
                        @if($field == 'foot') ⚽ @elseif($field == 'baskett') 🏀 @elseif($field == 'volley ball') 🏐 @elseif($field == 'chess') ♟️ @elseif($field == 'Esport') 🎮 @else 🚩 @endif
                        Classement {{ ucfirst($field) }}
                    </h2>
                    <div class="card" style="padding:0;overflow:hidden;">
                        @foreach($teams as $i => $team)
                        @php
                            $rank = $i + 1;
                            $pct  = $teams->max('score') > 0 ? round($team->score / $teams->max('score') * 100) : 0;
                            $colors = ['#fbbf24','#94a3b8','#b45309'];
                            $medals = ['🥇','🥈','🥉'];
                        @endphp
                        <div style="padding:1.25rem 1.5rem; {{ !$loop->last ? 'border-bottom:1px solid var(--border);' : '' }} transition:background 0.2s;" onmouseover="this.style.background='rgba(99,102,241,0.03)'" onmouseout="this.style.background=''">
                            <div style="display:flex;align-items:center;gap:1rem;">
                                <div style="font-size:1.5rem;min-width:2rem;text-align:center;">
                                    {{ $rank <= 3 ? $medals[$rank-1] : $rank }}
                                </div>
                                <div style="flex:1;">
                                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.5rem;">
                                        <span style="font-weight:700;font-size:0.95rem;{{ $rank <= 3 ? 'color:'.$colors[$rank-1] : '' }}">{{ $team->name }}</span>
                                        <span style="font-family:'Space Grotesk',sans-serif;font-size:1.1rem;font-weight:700;color:var(--primary);">{{ number_format($team->score) }} pts</span>
                                    </div>
                                    <div style="display:flex;align-items:center;gap:0.75rem;">
                                        <div class="progress" style="flex:1;">
                                            <div class="progress-bar" style="width:{{ $pct }}%;{{ $rank==1?'background:linear-gradient(90deg,#fbbf24,#f59e0b);':'' }}"></div>
                                        </div>
                                        <span style="font-size:0.75rem;color:var(--muted);white-space:nowrap;">
                                            👥 {{ $team->members_count }}/{{ $team->max_members }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            @endif
        </div>
        
        {{-- Right: Upcoming Matches --}}
        <div>
            <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.3rem;font-weight:700;margin-bottom:1rem;display:flex;align-items:center;gap:0.5rem;">
                🗓️ Prochains matchs
            </h2>
            <div class="card" style="padding:0;overflow:hidden;">
                @if($upcomingMatches->isEmpty())
                <div style="padding:2rem;text-align:center;color:var(--muted);font-size:0.9rem;">
                    Aucun match à venir.
                </div>
                @else
                    @foreach($upcomingMatches as $match)
                    <div style="padding:1rem;{{ !$loop->last ? 'border-bottom:1px solid var(--border);' : '' }}">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.5rem;">
                            <span style="font-size:0.75rem;color:var(--primary);font-weight:600;text-transform:uppercase;background:rgba(99,102,241,0.1);padding:0.2rem 0.5rem;border-radius:4px;">
                                {{ $match->field }}
                            </span>
                            <span style="font-size:0.8rem;color:var(--muted);">
                                @if($match->status === 'live')
                                    <span style="color:#ef4444;font-weight:bold;animation:pulse 2s infinite;">🔴 En cours (Jouable)</span>
                                @else
                                    {{ $match->match_date->format('d/m à H:i') }}
                                @endif
                            </span>
                        </div>
                        <div style="text-align:center;margin-top:0.75rem;">
                            <div style="font-weight:600;font-size:0.95rem;">{{ $match->team1->name }}</div>
                            <div style="font-size:0.8rem;color:var(--muted);margin:0.2rem 0;">VS</div>
                            <div style="font-weight:600;font-size:0.95rem;">{{ $match->team2->name }}</div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
        
    </div>
</div>
</x-app-layout>
