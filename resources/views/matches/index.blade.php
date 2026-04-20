<x-app-layout>
    <div class="min-h-screen bg-[#0a0a0c] text-[#e0e0e0] font-sans antialiased pb-12">
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h2 class="font-black text-4xl text-white tracking-tighter uppercase italic">
                    <span class="text-red-500 mr-2">//</span> Battle Hub
                </h2>
                <div class="flex gap-4">
                    <div class="text-xs font-bold text-gray-500 uppercase tracking-widest bg-gray-900 px-4 py-2 rounded-full border border-gray-800">
                        Total Battles: <span class="text-white ml-1">{{ $matches->count() }}</span>
                    </div>
                </div>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
                
                <!-- LIVE BATTLES SECTION -->
                @php $liveMatches = $matches->where('status', 'live'); @endphp
                @if($liveMatches->count() > 0)
                <section>
                    <h3 class="text-xl font-black text-white uppercase tracking-wider mb-6 flex items-center">
                        <span class="relative flex h-3 w-3 mr-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                        </span>
                        Live Operations
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($liveMatches as $match)
                        <div class="relative group">
                            <div class="absolute -inset-0.5 bg-gradient-to-r from-red-600 to-orange-600 rounded-2xl blur opacity-20 group-hover:opacity-40 transition"></div>
                            <div class="relative bg-[#111114] border border-red-500/30 rounded-2xl p-6">
                                <div class="flex items-center justify-between gap-8">
                                    <div class="flex flex-col items-center flex-1 text-center">
                                        <div class="w-16 h-16 rounded-xl bg-gray-900 border border-gray-800 flex items-center justify-center text-2xl font-black text-white mb-3">
                                            {{ substr($match->team1->name, 0, 1) }}
                                        </div>
                                        <div class="font-black text-sm uppercase tracking-tight text-gray-300">{{ $match->team1->name }}</div>
                                    </div>
                                    
                                    <div class="flex flex-col items-center">
                                        <div class="text-5xl font-black text-white italic tracking-tighter tabular-nums mb-1">
                                            {{ $match->score_team1 }} - {{ $match->score_team2 }}
                                        </div>
                                        <div class="px-3 py-1 rounded bg-red-500/10 border border-red-500/20 text-[10px] font-black text-red-500 uppercase tracking-widest">
                                            Engaged
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-center flex-1 text-center">
                                        <div class="w-16 h-16 rounded-xl bg-gray-900 border border-gray-800 flex items-center justify-center text-2xl font-black text-white mb-3">
                                            {{ substr($match->team2->name, 0, 1) }}
                                        </div>
                                        <div class="font-black text-sm uppercase tracking-tight text-gray-300">{{ $match->team2->name }}</div>
                                    </div>
                                </div>
                                @if(auth()->user()->isAdmin())
                                <div class="mt-6 flex justify-end">
                                    <form action="{{ route('matches.destroy', $match->id) }}" method="POST" onsubmit="return confirm('ABORT OPERATION?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-[9px] font-black text-red-500/50 hover:text-red-500 uppercase tracking-widest border border-red-500/20 px-4 py-2 rounded transition">
                                            [ Abort Operation ]
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
                @endif

                <!-- UPCOMING BATTLES SECTION -->
                @php $upcomingMatches = $matches->where('status', 'upcoming')->sortBy('match_date'); @endphp
                <section>
                    <h3 class="text-xl font-black text-white uppercase tracking-wider mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Incoming Deployments
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($upcomingMatches as $match)
                        <div class="bg-[#111114] border border-gray-800 rounded-2xl p-6 hover:border-blue-500/50 transition duration-300 flex flex-col justify-between">
                            <div>
                                <div class="text-center mb-6">
                                    <span class="text-[10px] font-black text-blue-500 uppercase tracking-[0.3em] bg-blue-500/5 px-3 py-1 rounded border border-blue-500/10">
                                        {{ $match->match_date ? \Carbon\Carbon::parse($match->match_date)->format('M d // H:i') : 'TBD' }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between gap-4">
                                    <div class="text-center flex-1">
                                        <div class="font-black text-lg text-white uppercase tracking-tighter truncate">{{ $match->team1->name }}</div>
                                    </div>
                                    <div class="font-black text-gray-700 italic">VS</div>
                                    <div class="text-center flex-1">
                                        <div class="font-black text-lg text-white uppercase tracking-tighter truncate">{{ $match->team2->name }}</div>
                                    </div>
                                </div>
                            </div>
                            @if(auth()->user()->isAdmin())
                            <div class="mt-6 pt-4 border-t border-gray-900 flex justify-center">
                                <form action="{{ route('matches.destroy', $match->id) }}" method="POST" onsubmit="return confirm('CANCEL DEPLOYMENT?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[9px] font-black text-gray-600 hover:text-red-500 uppercase tracking-widest transition">
                                        Cancel Deployment
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                        @empty
                        <p class="text-gray-600 italic">No incoming deployments scheduled.</p>
                        @endforelse
                    </div>
                </section>

                <!-- PAST BATTLES SECTION -->
                @php $finishedMatches = $matches->where('status', 'finished')->sortByDesc('updated_at'); @endphp
                <section>
                    <h3 class="text-xl font-black text-white uppercase tracking-wider mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Archived Results
                    </h3>
                    <div class="bg-[#111114] border border-gray-800 rounded-2xl overflow-hidden shadow-2xl">
                        <table class="min-w-full">
                            <tbody class="divide-y divide-gray-900">
                                @forelse($finishedMatches as $match)
                                <tr class="hover:bg-white/[0.01] transition-colors">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-12 justify-between">
                                            <div class="flex items-center gap-4 flex-1">
                                                <span class="font-black text-xl text-white uppercase italic tracking-tighter {{ $match->score_team1 > $match->score_team2 ? 'text-emerald-500' : 'text-gray-400' }}">
                                                    {{ $match->team1->name }}
                                                </span>
                                            </div>
                                            
                                            <div class="flex flex-col items-center">
                                                <div class="text-3xl font-black text-white tabular-nums tracking-widest bg-gray-900 px-6 py-2 rounded-lg border border-gray-800 shadow-inner">
                                                    {{ $match->score_team1 }} - {{ $match->score_team2 }}
                                                </div>
                                                <div class="text-[9px] text-gray-600 font-bold uppercase tracking-widest mt-2">Mission Complete</div>
                                            </div>

                                            <div class="flex items-center gap-4 flex-1 justify-end">
                                                <span class="font-black text-xl text-white uppercase italic tracking-tighter {{ $match->score_team2 > $match->score_team1 ? 'text-emerald-500' : 'text-gray-400' }}">
                                                    {{ $match->team2->name }}
                                                </span>
                                                @if(auth()->user()->isAdmin())
                                                <form action="{{ route('matches.destroy', $match->id) }}" method="POST" class="ml-6" onsubmit="return confirm('PERMANENTLY DELETE ARCHIVED RESULT?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-[9px] font-black text-gray-700 hover:text-red-500 uppercase tracking-widest border border-gray-800 hover:border-red-500/50 px-3 py-1 rounded transition">
                                                        DELETE
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="px-8 py-12 text-center text-gray-600 italic">No missions archived yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

            </div>
        </div>
    </div>

    <script>
        // Auto-refresh the page every 15 seconds to update live scores
        @if($matches->where('status', 'live')->count() > 0)
            setInterval(() => {
                window.location.reload();
            }, 15000);
        @endif
    </script>
</x-app-layout>