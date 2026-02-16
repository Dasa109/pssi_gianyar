<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Role: 'admin' (PSSI Pusat) atau 'operator' (Manajer Klub)
            $table->string('role')->default('admin')->after('email'); 
            
            // Relasi ke Klub (Boleh NULL jika dia Admin Pusat)
            $table->foreignId('club_id')->nullable()->constrained('clubs')->nullOnDelete()->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['club_id']);
            $table->dropColumn(['role', 'club_id']);
        });
    }
};