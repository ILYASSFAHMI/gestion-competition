<x-app-layout>
    <div class="min-h-screen bg-[#0a0a0c] text-[#e0e0e0] font-sans antialiased pb-12">
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h2 class="font-black text-4xl text-white tracking-tighter uppercase italic">
                    <span class="text-red-500 mr-2">//</span> Leaderboard
                </h2>
                <div class="text-xs font-bold text-gray-500 uppercase tracking-widest bg-gray-900 px-4 py-2 rounded-full border border-gray-800">
                    Season 01 <span class="text-red-500 ml-2">Live</span>
                </div>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
                
                <div class="relative group">
                    <!-- Neon Border Effect -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-red-600 to-blue-600 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                    
                    <div class="relative bg-[#111114] shadow-2xl rounded-2xl overflow-hidden border border-gray-800">
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="bg-[#1a1a1e] border-b border-gray-800">
                                        <th scope="col" class="px-8 py-5 text-left text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Rank</th>
                                        <th scope="col" class="px-8 py-5 text-left text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Squad / Team</th>
                                        <th scope="col" class="px-8 py-5 text-center text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Points</th>
                                        <th scope="col" class="px-8 py-5 text-center text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Wins</th>
                                        <th scope="col" class="px-8 py-5 text-center text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Losses</th>
                                        <th scope="col" class="px-8 py-5 text-center text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Ratio</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-900">
                                    @foreach($ranking as $index => $r)
                                    @php
                                        $rank = $index + 1;
                                        $isTop1 = $rank === 1;
                                        $isTop2 = $rank === 2;
                                        $isTop3 = $rank === 3;
                                    @endphp
                                    <tr class="hover:bg-white/[0.02] transition-colors {{ $isTop1 ? 'bg-red-500/5' : '' }}">
                                        <!-- Rank -->
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($isTop1)
                                                    <span class="text-2xl font-black text-red-500 italic">#01</span>
                                                @elseif($isTop2)
                                                    <span class="text-xl font-black text-gray-300 italic">#02</span>
                                                @elseif($isTop3)
                                                    <span class="text-xl font-black text-orange-400 italic">#03</span>
                                                @else
                                                    <span class="text-lg font-bold text-gray-600 italic">#{{ sprintf('%02d', $rank) }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        
                                        <!-- Team -->
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <div class="flex items-center gap-4">
                                                <div class="w-10 h-10 rounded-lg bg-gray-900 border border-gray-800 flex items-center justify-center font-black text-red-500">
                                                    {{ substr($r['team'], 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="font-black text-xl text-white tracking-tight uppercase italic">{{ $r['team'] }}</div>
                                                    <div class="text-[10px] text-gray-600 font-bold uppercase tracking-widest">Verified Competitor</div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Points -->
                                        <td class="px-8 py-6 whitespace-nowrap text-center">
                                            <div class="text-2xl font-black text-white tabular-nums">
                                                {{ number_format($r['points']) }}
                                            </div>
                                            <div class="text-[9px] text-gray-600 font-black uppercase tracking-tighter">Total Score</div>
                                        </td>

                                        <!-- Wins/Losses -->
                                        <td class="px-8 py-6 whitespace-nowrap text-center text-lg font-bold text-emerald-500 tabular-nums">
                                            {{ $r['goalsFor'] }}
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap text-center text-lg font-bold text-red-500 tabular-nums">
                                            {{ $r['goalsAgainst'] }}
                                        </td>
                                        
                                        <!-- Ratio -->
                                        <td class="px-8 py-6 whitespace-nowrap text-center">
                                            <span class="px-4 py-1.5 rounded-md font-black text-xs {{ $r['diff'] >= 0 ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-red-500/10 text-red-400 border border-red-500/20' }}">
                                                {{ $r['diff'] > 0 ? '+' : '' }}{{ $r['diff'] }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if(count($ranking) === 0)
                        <div class="text-center py-24">
                            <svg class="w-16 h-16 text-gray-800 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            <p class="text-gray-600 font-black uppercase tracking-[0.3em]">No Data Available</p>
                            <p class="text-gray-800 text-xs mt-2 italic">Scanning for active competitors...</p>
                        </div>
                        @endif
                        
                    </div>
                </div>

                <!-- Footer Note -->
                <div class="text-center">
                    <p class="text-[10px] text-gray-700 font-bold uppercase tracking-[0.5em]">
                        Encryption: AES-256 // System Status: <span class="text-emerald-500">Nominal</span>
                    </p>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Auto-refresh leaderboard every 20 seconds
        setInterval(() => {
            window.location.reload();
        }, 20000);
    </script>
</x-app-layout>