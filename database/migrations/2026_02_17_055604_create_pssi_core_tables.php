<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi untuk struktur inti PSSI.
     */
    public function up(): void
    {
        // 1. Tabel KLUB (Induk)
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('nickname')->nullable();
            $table->string('logo')->nullable();
            $table->string('stadium')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->longText('history')->nullable(); // Menyatukan sejarah klub
            $table->year('founded')->nullable();
            $table->timestamps();
        });

        // 2. Tautkan Relasi Users ke Clubs (Foreign Key)
        // Dilakukan di sini karena tabel 'clubs' baru saja dibuat
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('club_id')->references('id')->on('clubs')->onDelete('set null');
        });

        // 3. Tabel PEMAIN (Otentikasi Portal Pemain)
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            // Relasi Pemain ke Klub
            $table->foreignId('club_id')->nullable()->constrained('clubs')->onDelete('set null');
            
            // Data Akun (Wajib untuk login portal pemain)
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            
            // Profil Teknis
            $table->string('position')->nullable(); 
            $table->integer('number')->nullable();
            $table->boolean('is_captain')->default(false);
            $table->string('club_dummy')->nullable(); // Menampung input klub manual saat daftar
            $table->string('photo')->nullable();
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Balikkan migrasi secara berurutan.
     */
    public function down(): void
    {
        // Lepaskan foreign key di users sebelum menghapus tabel induk
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['club_id']);
        });
        
        Schema::dropIfExists('players');
        Schema::dropIfExists('clubs');
    }
};