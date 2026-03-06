<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fixtures', function (Blueprint $table) {
            $table->id();
            $table->dateTime('match_date');
    $table->string('stadium');
    // Menggunakan foreignId agar relasi ke tabel tim kuat
    $table->foreignId('home_team_id')->constrained('customers')->onDelete('cascade');
    $table->foreignId('away_team_id')->constrained('customers')->onDelete('cascade');
    $table->enum('status', ['scheduled', 'live', 'finished', 'postponed'])->default('scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixtures');
    }
};
