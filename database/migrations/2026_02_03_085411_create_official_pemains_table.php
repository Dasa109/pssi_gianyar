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
        Schema::create('official_pemains', function (Blueprint $table) {
            $table->id();
            $table->string("nama_lengkap");
            $table->string("panggilan");
            $table->date("tanggal_lahir");
            $table->string("jenis_id");
            $table->string("no_id");
            $table->string("kewarganegaraan");
            $table->string("provinsi")->nullable();
            $table->string("kota")->nullable();
            $table->integer("tinggi_badan");
            $table->integer("berat_badan")->nullable();
            $table->string("alamat");
            $table->string("no_hp");
            $table->string("email")->nullable();
            $table->string("ijazah_file_path");
            $table->string("akta_file_path");
            $table->string("kartu_kelahiran_file_path");
            $table->string("identitas_file_path");
            $table->string("surat_kerjasama_file_path");
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign("user_id")->references("id")->on("users")->cascadeOnUpdate();
            $table->unsignedBigInteger('club_id')->nullable();
            $table->foreign("club_id")->references("id")->on("clubs")->cascadeOnUpdate();
            $table->tinyInteger("status")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemains');
    }
};
