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
    Schema::create('clubs', function (Blueprint $table) {
        $table->id();
        $table->string('name');             // Nama Klub (Cth: Perseden)
        $table->string('slug')->unique();   // URL (Cth: perseden)
        $table->string('short_name')->nullable(); // Singkatan (Cth: PSD)
        $table->string('logo')->nullable(); // Foto Logo
        $table->string('stadium_name')->nullable(); // Homebase
        $table->text('address')->nullable();
        $table->string('phone')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clubs');
    }
};
