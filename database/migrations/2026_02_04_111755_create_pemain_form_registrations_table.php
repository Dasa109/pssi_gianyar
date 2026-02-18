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
        Schema::create('pemain_form_registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('added_by');
            $table->foreign("added_by")->references("id")->on("users")->cascadeOnUpdate();
            $table->tinyInteger("status")->default(0);
            $table->unsignedBigInteger("club_id");
            $table->foreign("club_id")->references("id")->on("clubs")->cascadeOnUpdate();
            $table->string("keterangan")->nullable();
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
            $table->dateTime("verified_at")->nullable();
            $table->unsignedBigInteger("verified_by")->nullable();
            $table->foreign("verified_by")->references("id")->on("users");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemain_form_registrations');
    }
};
