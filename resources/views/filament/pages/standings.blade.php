<x-filament-panels::page>

<style>
    .zone-promotion  { border-left: 4px solid #3b82f6; }
    .zone-playoff    { border-left: 4px solid #f59e0b; }
    .zone-relegation { border-left: 4px solid #ef4444; }
    .zone-none       { border-left: 4px solid transparent; }

    .form-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px; height: 22px;
        border-radius: 50%;
        font-size: 10px; font-weight: 700; color: #fff;
        flex-shrink: 0;
    }
    .form-M { background: #22c55e; }
    .form-S { background: #6b7280; }
    .form-K { background: #ef4444; }

    .rank-num {
        display: inline-flex; align-items: center; justify-content: center;
        width: 26px; height: 26px; border-radius: 6px;
        font-size: 12px; font-weight: 700;
    }
    .rank-top    { background: rgba(59,130,246,.15); color: #3b82f6; }
    .rank-mid    { color: #6b7280; }
    .rank-bottom { background: rgba(239,68,68,.12); color: #ef4444; }

    .gd-pos { color: #22c55e; font-weight: 700; }
    .gd-neg { color: #ef4444; font-weight: 700; }
    .gd-zero{ color: #9ca3af; }

    .standings-row:hover { background: rgba(99,102,241,0.05) !important; }

    /* Thicker row separator */
    .standings-table tbody tr {
        border-bottom: 2px solid #e5e7eb;
    }
    .dark .standings-table tbody tr {
        border-bottom: 2px solid rgba(255,255,255,0.08);
    }

    /* KEY FIX: prevent wrapping in all cells */
    .standings-table th,
    .standings-table td { white-space: nowrap; }
</style>

<div class="space-y-3">

    {{-- Legend --}}
    <div class="flex flex-wrap gap-x-5 gap-y-1 px-1">
        @foreach([['#3b82f6','Promosi / Juara'],['#f59e0b','Zona Playoff'],['#ef4444','Zona Degradasi']] as [$color,$label])
        <div class="flex items-center gap-2">
            <span style="width:10px;height:10px;border-radius:2px;background:{{ $color }};display:inline-block"></span>
            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $label }}</span>
        </div>
        @endforeach
    </div>

    {{-- Table container --}}
    <div class="border border-gray-200 dark:border-white/10 shadow-sm rounded-xl overflow-hidden bg-white dark:bg-gray-900">
        <div class="overflow-x-auto">
            <table class="standings-table w-full divide-y divide-gray-100 dark:divide-white/5">

                <thead class="bg-gray-50 dark:bg-white/5">
                    <tr>
                        <th style="width:48px"   class="px-3 py-3 text-center text-xs font-bold text-gray-400 uppercase">NO</th>
                        <th style="min-width:180px" class="px-3 py-3 text-left text-xs font-bold text-gray-400 uppercase">Klub</th>
                        <th style="width:40px"   class="px-2 py-3 text-center text-xs font-bold text-gray-400 uppercase">T</th>
                        <th style="width:40px"   class="px-2 py-3 text-center text-xs font-bold text-gray-400 uppercase">M</th>
                        <th style="width:40px"   class="px-2 py-3 text-center text-xs font-bold text-gray-400 uppercase">S</th>
                        <th style="width:40px"   class="px-2 py-3 text-center text-xs font-bold text-gray-400 uppercase">K</th>
                        <th style="width:46px"   class="px-2 py-3 text-center text-xs font-bold text-gray-400 uppercase">GM</th>
                        <th style="width:46px"   class="px-2 py-3 text-center text-xs font-bold text-gray-400 uppercase">GK</th>
                        <th style="width:50px"   class="px-2 py-3 text-center text-xs font-bold text-gray-400 uppercase">SG</th>
                        <th style="width:56px"   class="px-2 py-3 text-center text-xs font-bold text-gray-900 dark:text-white uppercase bg-gray-100/60 dark:bg-white/5">Poin</th>
                        <th style="width:130px"  class="px-3 py-3 text-center text-xs font-bold text-gray-400 uppercase">5 Pertandingan Terakhir</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-white/10">
                    @php
                        $standings  = $this->getStandings();
                        $total      = $standings->count();
                        $promoTop   = 2;
                        $playoffTop = 4;
                    @endphp

                    @foreach($standings as $index => $team)
                        @php
                            $rank = $index + 1;
                            if      ($rank <= $promoTop)                           $zone = 'promotion';
                            elseif  ($rank <= $playoffTop)                         $zone = 'playoff';
                            elseif  ($rank > $total - 2 && $total > 4)             $zone = 'relegation';
                            else                                                    $zone = 'none';

                            $rankClass = match(true) {
                                $rank <= $promoTop      => 'rank-top',
                                $rank > $total - 2      => 'rank-bottom',
                                default                 => 'rank-mid',
                            };

                            $gdVal   = $team['gd'];
                            $gdClass = $gdVal > 0 ? 'gd-pos' : ($gdVal < 0 ? 'gd-neg' : 'gd-zero');
                            $gdText  = $gdVal > 0 ? '+' . $gdVal : $gdVal;

                            $logoPath = $team['logo'] ?? null;
                        @endphp

                        <tr class="standings-row zone-{{ $zone }} transition-colors duration-150">

                            <td class="px-3 py-5 text-center">
                                <span class="rank-num {{ $rankClass }}">{{ $rank }}</span>
                            </td>

                            <td class="px-3 py-5">
                                <div style="display:flex;align-items:center;gap:10px;flex-wrap:nowrap;">
                                    {{-- Logo --}}
                                    <div style="flex-shrink:0;width:32px;height:32px;">
                                        @if($team['logo'])
                                            <img src="{{ asset('storage/' . $team['logo']) }}"
                                                 style="width:32px;height:32px;object-fit:contain;display:block;"
                                                 alt="{{ $team['name'] }}">
                                        @else
                                            <div style="width:32px;height:32px;background:#f3f4f6;border-radius:6px;display:flex;align-items:center;justify-content:center;">
                                                <span style="font-size:9px;font-weight:900;color:#9ca3af;line-height:1;text-align:center;">
                                                    {{ strtoupper(substr($team['name'], 0, 3)) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    {{-- Nama --}}
                                    <span style="font-weight:600;font-size:14px;white-space:nowrap;color:inherit;">
                                        {{ $team['name'] }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-2 py-5 text-sm text-center text-gray-500">{{ $team['p'] }}</td>
                            <td class="px-2 py-5 text-sm text-center font-semibold text-green-600">{{ $team['w'] }}</td>
                            <td class="px-2 py-5 text-sm text-center text-gray-500">{{ $team['d'] }}</td>
                            <td class="px-2 py-5 text-sm text-center font-semibold text-red-500">{{ $team['l'] }}</td>
                            <td class="px-2 py-5 text-sm text-center text-gray-600">{{ $team['gf'] }}</td>
                            <td class="px-2 py-5 text-sm text-center text-gray-600">{{ $team['ga'] }}</td>
                            <td class="px-2 py-5 text-sm text-center {{ $gdClass }}">{{ $gdText }}</td>
                            <td class="px-2 py-5 text-base text-center font-black text-gray-900 dark:text-white
                                       bg-gray-50/50 dark:bg-white/5 border-l border-gray-100 dark:border-white/5">
                                {{ $team['pts'] }}
                            </td>

                            <td class="px-3 py-5">
                                <div class="flex items-center justify-center gap-1">
                                    @forelse($team['form'] as $f)
                                        <span class="form-badge form-{{ $f }}"
                                              title="{{ $f === 'M' ? 'Menang' : ($f === 'S' ? 'Seri' : 'Kalah') }}">{{ $f }}</span>
                                    @empty
                                        <span class="text-xs text-gray-400">-</span>
                                    @endforelse
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-4 py-2.5 border-t border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/5">
            <p class="text-xs text-gray-400 leading-relaxed">
                T = Tanding &nbsp;·&nbsp; M = Menang &nbsp;·&nbsp; S = Seri &nbsp;·&nbsp; K = Kalah &nbsp;·&nbsp;
                GM = Gol Masuk &nbsp;·&nbsp; GK = Gol Kemasukan &nbsp;·&nbsp; SG = Selisih Gol
            </p>
        </div>
    </div>
</div>

</x-filament-panels::page>