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
    Schema::table('clubs', function (Blueprint $table) {
        // Default status adalah pending saat mendaftar dari React
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('name');
        // Kolom untuk menyimpan file PDF/ZIP dokumen legalitas
        $table->string('legal_document')->nullable()->after('logo'); 
    });
}

public function down(): void
{
    Schema::table('clubs', function (Blueprint $table) {
        $table->dropColumn(['status', 'legal_document']);
    });
}
};
