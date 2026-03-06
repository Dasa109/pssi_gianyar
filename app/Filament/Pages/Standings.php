<?php

namespace App\Filament\Pages;

use App\Models\Customers;
use App\Models\GameResult;
use Filament\Pages\Page;
use Illuminate\Support\Collection;
use BackedEnum;

class Standings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-table-cells';

    protected string $view = 'filament.pages.standings';

    protected static ?string $navigationLabel = 'Klasemen Liga';

    protected static ?string $title = 'Klasemen PSSI Gianyar';

    public function getStandings(): Collection
    {
        // Gunakan Eager Loading 'fixture' agar loading halaman cepat
        $teams = Customers::all();
        $standings = collect();

        foreach ($teams as $team) {
            $results = GameResult::with('fixture')
                ->whereHas('fixture', function ($query) use ($team) {
                    $query->where('home_team_id', $team->id)
                          ->orWhere('away_team_id', $team->id);
                })
                ->orderByDesc('id') // Mengambil hasil terbaru terlebih dahulu
                ->get();

            $played = $results->count();
            $won = 0; $draw = 0; $lost = 0; $points = 0;
            $goalsFor = 0; $goalsAgainst = 0;
            $form = []; 

            foreach ($results as $res) {
                if (!$res->fixture) continue;

                $isHome = $res->fixture->home_team_id === $team->id;
                $homeScore = $res->home_score;
                $awayScore = $res->away_score;

                // Hitung Gol
                $goalsFor     += $isHome ? $homeScore : $awayScore;
                $goalsAgainst += $isHome ? $awayScore : $homeScore;

                // Logika Poin & Huruf Form
                if ($homeScore === $awayScore) {
                    $draw++;
                    $points += 1;
                    $formLetter = 'S';
                } elseif (($isHome && $homeScore > $awayScore) || (!$isHome && $awayScore > $homeScore)) {
                    $won++;
                    $points += 3;
                    $formLetter = 'M';
                } else {
                    $lost++;
                    $formLetter = 'K';
                }

                // Ambil 5 hasil terakhir saja
                if (count($form) < 5) {
                    $form[] = $formLetter;
                }
            }

            $standings->push([
                'name'   => $team->name,
                'logo'   => $team->logo, // Pastikan ini dikirim sebagai 'logo'
                'p'      => $played,
                'w'      => $won,
                'd'      => $draw,
                'l'      => $lost,
                'gf'     => $goalsFor,
                'ga'     => $goalsAgainst,
                'gd'     => $goalsFor - $goalsAgainst,
                'pts'    => $points,
                'form'   => array_reverse($form), // Dibalik agar hasil paling baru ada di posisi paling kanan
            ]);
        }

        // Urutan klasemen: Poin > Selisih Gol > Gol Masuk
        return $standings->sort(function ($a, $b) {
            if ($a['pts'] !== $b['pts']) return $b['pts'] <=> $a['pts'];
            if ($a['gd']  !== $b['gd'])  return $b['gd']  <=> $a['gd'];
            return $b['gf'] <=> $a['gf'];
        })->values();
    }
}