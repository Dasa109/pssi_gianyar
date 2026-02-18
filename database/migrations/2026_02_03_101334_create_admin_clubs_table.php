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
        Schema::create('admin_clubs', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")->references("id")->on("users")->cascadeOnUpdate()->cascadeOnDelete(null);
            $table->unsignedBigInteger("club_id");
            $table->foreign("club_id")->references("id")->on("clubs")->cascadeOnUpdate()->cascadeOnDelete(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_clubs');
    }
};
