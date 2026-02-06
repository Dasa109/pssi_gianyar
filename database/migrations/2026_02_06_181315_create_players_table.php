<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            
            // Relasi: Pemain milik Club. Kalau Club dihapus, pemain ikut terhapus.
            $table->foreignId('club_id')->constrained('clubs')->cascadeOnDelete();
            
            $table->string('name');
            $table->integer('number');
            $table->string('position'); // GK, DF, MF, FW
            $table->string('photo')->nullable(); // Foto boleh kosong
            $table->boolean('is_captain')->default(false); // Default bukan kapten
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};