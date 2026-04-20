<x-app-layout>
<div class="page-container">

    <div style="margin-bottom:2rem;">
        <h1 class="page-title">🏆 CLASSEMENT</h1>
        <p class="page-subtitle">Classement des équipes en temps réel</p>
    </div>

    @if($teams->isEmpty())
    <div class="card" style="text-align:center;padding:4rem;color:#5a7a9a;">
        <div style="font-size:3rem;">🏆</div>
        <p style="margin-top:1rem;">Aucune équipe encore enregistrée.</p>
    </div>
    @else
    <!-- Top 3 Podium -->
    @if($teams->count() >= 1)
    <div style="display:flex;align-items:flex-end;justify-content:center;gap:1rem;margin-bottom:2.5rem;flex-wrap:wrap;">
        @foreach([1, 0, 2] as $pos)
        @if(isset($teams[$pos]))
        @php
            $team = $teams[$pos];
            $rank = $pos + 1;
            $colors = [
                1 => ['var(--neon-green)', '#0d1526', '1.5rem', '7rem'],
                2 => ['#fbbf24',            '#0d1526', '1.2rem', '5.5rem'],
                3 => ['#fb923c',            '#0d1526', '1rem',   '4.5rem'],
            ];
            [$color, $bg, $fontSize, $height] = $colors[$rank];
        @endphp
        <div class="card" style="text-align:center;border-color:{{ $color }};background:linear-gradient(180deg, rgba({{
            $rank==1?'0,255,136':($rank==2?'251,191,36':'251,146,60')
        }},0.05), transparent);min-width:180px;padding-bottom:0;">
            <div style="font-size:2rem;">{{ $rank === 1 ? '🥇' : ($rank === 2 ? '🥈' : '🥉') }}</div>
            <div style="height:{{ $height }};"></div>
            <div style="font-family:'Rajdhani',sans-serif;font-size:{{ $fontSize }};font-weight:700;color:#e2eaf5;">
                {{ $team->name }}
            </div>
            <div class="mono" style="font-size:1.3rem;color:{{ $color }};font-weight:700;margin:0.25rem 0;">
                {{ number_format($team->score) }} pts
            </div>
            <div style="font-size:0.75rem;color:#5a7a9a;padding-bottom:1rem;">
                {{ $team->solves->count() }} challenges
            </div>
        </div>
        @endif
        @endforeach
    </div>
    @endif

    <!-- Full Table -->
    <div class="card" style="padding:0;overflow:hidden;">
        <table>
            <thead>
                <tr>
                    <th>Rang</th>
                    <th>Équipe</th>
                    <th>Leader</th>
                    <th>Membres</th>
                    <th>Challenges résolus</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teams as $i => $team)
                <tr style="{{ auth()->check() && auth()->user()->team_id === $team->id ? 'background:rgba(0,255,136,0.03);' : '' }}">
                    <td>
                        <span class="mono" style="font-weight:700;color:{{ $i===0?'#fbbf24':($i===1?'#9ca3af':($i===2?'#fb923c':'#5a7a9a')) }};">
                            #{{ $i + 1 }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('teams.show', $team) }}"
                           style="font-family:'Rajdhani',sans-serif;font-size:1rem;font-weight:600;color:#e2eaf5;text-decoration:none;">
                            {{ $team->name }}
                        </a>
                        @if(auth()->check() && auth()->user()->team_id === $team->id)
                        <span class="badge" style="color:var(--neon-green);border-color:var(--neon-green);background:rgba(0,255,136,0.08);margin-left:0.4rem;">YOU</span>
                        @endif
                    </td>
                    <td style="color:#8ca0c0;">{{ $team->leader?->name ?? '—' }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:0.5rem;">
                            @for($m = 0; $m < 4; $m++)
                            <div style="width:8px;height:8px;border-radius:50%;background:{{ $m < $team->users_count ? 'var(--neon-green)' : 'rgba(90,122,154,0.3)' }};"></div>
                            @endfor
                            <span class="mono" style="font-size:0.75rem;color:#5a7a9a;">{{ $team->users_count }}</span>
                        </div>
                    </td>
                    <td class="mono" style="color:#8ca0c0;">{{ $team->solves->count() }}</td>
                    <td>
                        <span class="mono" style="color:var(--neon-green);font-size:1rem;font-weight:700;">
                            {{ number_format($team->score) }}
                        </span>
                        <span style="color:#3d5a7a;font-size:0.75rem;"> pts</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
</x-app-layout>
