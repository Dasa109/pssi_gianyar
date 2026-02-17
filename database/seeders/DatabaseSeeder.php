<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Club;
use App\Models\Player;
use App\Models\User; // Tambahkan ini agar bisa buat akun Admin

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Data Klub
        $club1 = Club::create([
            'name' => 'PS Gianyar',
            'slug' => 'ps-gianyar',
            'nickname' => 'Laskar Kuda Jingkrak',
            'stadium' => 'Stadion Dipta',
            'founded' => 2010,
            'history' => 'Klub kebanggaan masyarakat Gianyar.', // SUDAH DIUBAH KE HISTORY
            'logo' => null,
        ]);

        $club2 = Club::create([
            'name' => 'Perseden Denpasar',
            'slug' => 'perseden-denpasar',
            'nickname' => 'Laskar Catur Muka',
            'stadium' => 'Stadion Kompyang Sujana',
            'founded' => 1980,
            'history' => 'Rival abadi dari kota sebelah.', // SUDAH DIUBAH KE HISTORY
            'logo' => null,
        ]);

        // 2. Buat Data User (Admin PSSI)
        User::create([
            'name' => 'Admin PSSI',
            'email' => 'admin@pssi.org',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // 3. Buat Data Pemain (Akun Login Portal Pemain)
        Player::create([
            'name' => 'Wayan Budi',
            'email' => 'pemain@pssi.org',
            'password' => Hash::make('password123'),
            'position' => 'FWD',
            'club_id' => $club1->id,
            'club_dummy' => 'PS Gianyar',
            'number' => 10,
            'is_captain' => true,
        ]);
        
        Player::create([
            'name' => 'Made Kiper',
            'email' => 'kiper@pssi.org',
            'password' => Hash::make('password123'),
            'position' => 'GK',
            'club_id' => null,
            'club_dummy' => 'SSB Putra Dewata',
            'number' => 1,
        ]);
    }
}