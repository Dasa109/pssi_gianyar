<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat Akun Superadmin
        User::updateOrCreate(
            ['email' => 'admin@pssi.org'], // 1. Cek apakah email ini sudah ada?
            [
                'name' => 'Super Admin PSSI',   // 2. Jika belum, buat baru dengan data ini
                'password' => Hash::make('password123'), // Ganti password sesuai keinginan
                // 'role' => 'admin', // Buka komentar ini jika kamu punya kolom 'role' di tabel users
                // 'is_admin' => true, // Atau ini, tergantung struktur tabelmu
            ]
        );
        
        // Pesan di terminal biar tahu kalau sukses
        $this->command->info('Akun Superadmin berhasil dibuat!');
    }
}